<?php

require_once MODEL_PATH . 'User/Invoice.php';
require_once MODEL_PATH . 'User/InvoiceVoided.php';
require_once MODEL_PATH . 'User/Business.php';

require_once CONTROLLER_PATH . 'Helper/BillingManager.php';
require_once CONTROLLER_PATH . 'Helper/DocumentManager.php';

class InvoiceVoidedController
{
    private $connection;
    private $param;
    private $saleVoidedModel;
    private $saleModel;
    private $businessModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;

        $this->saleVoidedModel = new InvoiceVoided($this->connection);
        $this->saleModel = new Invoice($this->connection);
        $this->businessModel = new Business($this->connection);
    }

    public function Exec(){
        try{
            $page = $_GET['page'] ?? 0;
            if (!$page){
                $page = 1;
            }

            $message = $_GET['message'] ?? '';
            $messageType = $_GET['messageType'] ?? '';
            $messageType = ($messageType == 'success') ? 'success' : ($messageType == 'error' ? 'danger' : '');

            $filter = $_GET['filter'] ?? [];
            $saleVoided = $this->saleVoidedModel->paginate(
                $page,
                10,
                $filter
            );

            $parameter['saleVoided'] = $saleVoided;
            $parameter['filter'] = $filter;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;

            $content = requireToVar(VIEW_PATH . "User/InvoiceVoidedded.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function GeneratePdf(array $voidedData ) {
        $sale = $voidedData['sale'];
        $voided = $voidedData['voided'];
        $business = $voidedData['business'];

        $business = array_merge($business,[
            'address' => 'AV. HUASCAR NRO. 224 DPTO. 303',
            'region' => 'CUSCO',
            'province' => 'CUSCO',
            'district' => 'WANCHAQ',
        ]);

        $invoice['headerContact'] = 'Teléfono: 084601425 | Celular: 979706609 | www.skynetcusco.com | info@skynetcusco.com';
        $invoice['businessRuc'] = $business['ruc'];
        $invoice['businessSocialReason'] = $business['social_reason'];
        $invoice['businessCommercialReason'] = $business['social_reason'];
        $invoice['businessAddress'] = $business['address'];
        $invoice['businessLocation'] = $business['district'] . ' ' . $business['province'] . ' ' . $business['region'];

        $invoice['documentCode'] = '01';
        $invoice['serie'] = 'NÚMERO';
        $invoice['documentType'] = 'COMUNICACIÓN DE BAJA';
        $invoice['correlative'] = $voided['correlative'];
        $invoice['dateOfIssue'] = $voided['date_of_issue'];
        $invoice['ticket'] = $voided['ticket'];

        $invoice['documentDateOfIssue'] = $sale['date_of_issue'];
        $invoice['documentDocumentCode'] = $sale['document_code'];
        $invoice['documentSerie'] = $sale['serie'];
        $invoice['documentCorrelative'] = $sale['correlative'];
        $invoice['reason'] = htmlspecialchars($voided['reason']);

        $documentManager = new DocumentManager();
        $resPdf = $documentManager->Voided($invoice,'A4',$_SESSION[ENVIRONMENT]);

        if ($resPdf->success){
            $this->saleVoidedModel->UpdateById($voided['sale_voided_id'],[
                'pdf_url'=> '..' . $resPdf->pdfPath
            ]);
        }
        return $resPdf;
    }

    private function GenerateXML(array $voidedData){
        $sale = $voidedData['sale'];
        $voided = $voidedData['voided'];
        $business = $voidedData['business'];

        $invoice = array();
        $invoice['issueDate'] = $voided['date_of_issue'];					// FECHA EMISION DE LA COMUNICAICON DE BAJA
        $invoice['correlativeNumber'] = $voided['correlative'];						// CORRELATIVO DE LA COMUNICACION DE BAJA
        $invoice['referenceDate'] = $sale['date_of_issue'];				// FECHA EMISION EL COMPROBANTE QUE SE QUIERE ANULAR
        $invoice['supplierRuc'] = $business['ruc'];
        $invoice['supplierName'] = $business['social_reason'];
        $invoice['defaultUrl'] = 'WWW.SKYFACT.COM';
        $invoice['supplierDocumentType'] = '6';					// TIPO DE DOCUMENTO EMISOR
        $invoice['documentTypeCode'] = $sale['document_code'];						// TIPO DE COMPROBANTE  QUE SE QUIERE  ANULAR
        $invoice['documentSerie'] = $sale['serie'];						// SERIE DEL COMPROBANTE  QUE SE QUIERE  ANULAR
        $invoice['documentNumber'] = $sale['correlative'];						// NUMERO DEL COMPROBANTE  QUE SE QUIERE  ANULAR
        $invoice['reason'] = htmlspecialchars($voided['reason']);						// MOTIVO DE LA ANULACION

        $billingManager = new BillingManager($this->connection);
        $directoryXmlPath = '..' . XML_FOLDER_PATH . date('Ym') . '/' . $business['ruc'] . '/';
        $fileName = $business['ruc'] . '-RA-' . date('Ymd') . '-' . $voided['correlative'] . '.xml';

        $res = new Result();
        $res->ticket = '';

        $resVoided = $billingManager->SendAvoidance($voided['sale_voided_id'], $invoice, $_SESSION[SESS]);
        if ($resVoided->success){
            $this->saleVoidedModel->UpdateById((int)$voided['sale_voided_id'],[
                'xml_url' => $directoryXmlPath . $fileName,
                'sunat_state' => 2,
            ]);
            $res->success = true;
        }else{
            $res->errorMessage .= $resVoided->errorMessage;
            $res->success = false;
            return $res;
        }

        if ($resVoided->sunatComunicationSuccess){
            $this->saleVoidedModel->UpdateById((int)$voided['sale_voided_id'],[
                'ticket' => $resVoided->ticket,
            ]);
            $res->ticket = $resVoided->ticket;
            $res->success = true;
        } else {
            $res->errorMessage .= $resVoided->sunatCommuniationError;
            $res->success = false;
        }

        return $res;
    }

    private function BuildVoided($voidedID){
        $res = new Result();
        $res->error = [];
        $res->saleId = 0;

        try{
            $business = $this->businessModel->GetByUserId($_SESSION[SESS]);
            $voided = $this->saleVoidedModel->GetById($voidedID);
            $sale = $this->saleModel->GetById((int)$voided['sale_id']);

            $voidedData = [
                'sale' => $sale,
                'voided' => $voided,
                'business' => $business,
            ];

            $resXml = $this->GenerateXML($voidedData);
            $res->errorMessage = $resXml->errorMessage;
            $res->success = $resXml->success;
            if (!$resXml->success){
                $this->saleModel->UpdateById($voided['sale_voided_id'],[
                    'sunat_error_message' =>  $resXml->errorMessage,
                ]);
            }

            $voidedData['voided']['ticket'] = $resXml->ticket;
            $resPdf = $this->GeneratePdf($voidedData);
            if (!$resPdf->success){
                throw new Exception($resPdf->errorMessage);
            }
        }catch (Exception $e){
            $res->errorMessage = $e->getMessage();
            $res->success = false;
        }

        return $res;
    }

    public function ResendSaleVoided(){
        try{
            $saleVoidedId = $_GET['SaleVoidedId'] ?? 0;
            if(!$saleVoidedId){
                header('Location: ' . FOLDER_NAME . '/InvoiceVoided');
            }

            $resRunDoc = $this->BuildVoided($saleVoidedId);
            if (!$resRunDoc->success){
                header('Location: ' . FOLDER_NAME . '/InvoiceVoided?&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
            } else{
                header('Location: ' . FOLDER_NAME . '/InvoiceVoided');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function NewSaleVoided(){
        $message = "";
        $error = [];
        $saleVoided = $_POST['saleVoided'] ?? [];

        // Query By Invoice
        $saleId = $_GET['SaleId'] ?? 0;
        if ($saleId && is_numeric($saleId) ){
            $data = $this->saleModel->GetByIdDocumentDescription($saleId);
            $saleVoided['sale'] = [
                'saleId' =>  $saleId,
                'description' => $data['description'],
            ];
        }

        // Build
        if (isset($_POST['commit'])) {
            try{
                $validateInput = $this->ValidateInput($saleVoided);
                if (!$validateInput->success){
                    $error = $validateInput->error;
                    throw new Exception($validateInput->errorMessage);
                }
                $saleVoidedId = $this->saleVoidedModel->Insert($saleVoided);

                $resRunDoc = $this->BuildVoided($saleVoidedId);
                if (!$resRunDoc->success){
                    header('Location: ' . FOLDER_NAME . '/InvoiceVoided?&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
                } else{
                    header('Location: ' . FOLDER_NAME . '/InvoiceVoided');
                }
                return;
            }catch (Exception $exception){
                $message = $exception->getMessage();

                $data = $this->saleModel->GetByIdDocumentDescription($saleVoided['saleId']);
                $saleVoided['sale'] = [
                    'saleId' =>  $saleVoided['saleId'],
                    'description' => $data['description'],
                ];
            }
        }

        // Render
        $parameter['message'] = $message;
        $parameter['error'] = $error;
        $parameter['saleVoided'] = $saleVoided;

        $content = requireToVar(VIEW_PATH . "User/NewSaleVoided.php", $parameter);
        require_once(VIEW_PATH. "User/Layout/main.php");
    }

    private function ValidateInput(array $saleVoided) {
        $collector = new ErrorCollector();
        if (trim($saleVoided['saleId'] ?? '') == ""){
            $collector->addError('saleId','No se especificó el documento');
        }
        if (trim($saleVoided['reason'] ?? '') == ""){
            $collector->addError('reason','Falta ingresar la rasón de la anulacion');
        }
        return $collector->getResult();
    }
}

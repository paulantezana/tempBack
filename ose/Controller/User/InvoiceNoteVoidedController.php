<?php

require_once MODEL_PATH . 'User/InvoiceNote.php';
require_once MODEL_PATH . 'User/InvoiceNoteVoided.php';
require_once MODEL_PATH . 'User/Business.php';

require_once CONTROLLER_PATH . 'Helper/BillingManager.php';
require_once CONTROLLER_PATH . 'Helper/DocumentManager.php';

class InvoiceNoteVoidedController
{
    private $connection;
    private $param;
    private $saleNoteVoidedModel;
    private $saleNoteModel;
    private $businessModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;

        $this->saleNoteVoidedModel = new InvoiceNoteVoided($this->connection);
        $this->saleNoteModel = new InvoiceNote($this->connection);
        $this->businessModel = new Business($this->connection);
    }

    public function Exec(){
        try{
            $page = $_GET['page'] ?? 0;
            if (!$page){
                $page = 1;
            }

            $filter = $_GET['filter'] ?? [];
            $saleNoteVoided = $this->saleNoteVoidedModel->paginate(
                $page,
                10,
                $filter
            );

            $parameter['saleNoteVoided'] = $saleNoteVoided;
            $parameter['filter'] = $filter;

            $content = requireToVar(VIEW_PATH . "User/InvoiceNoteVoidedded.php", $parameter);
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
        $invoice['reason'] = $voided['reason'];

        $documentManager = new DocumentManager();
        $resPdf = $documentManager->Voided($invoice,'A4',$_SESSION[ENVIRONMENT]);

        if ($resPdf->success){
            $this->saleNoteVoidedModel->UpdateById($voided['sale_voided_id'],[
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
            $this->saleNoteVoidedModel->UpdateById((int)$voided['sale_voided_id'],[
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
            $this->saleNoteVoidedModel->UpdateById((int)$voided['sale_voided_id'],[
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
        $res->saleNoteId = 0;

        try{
            $business = $this->businessModel->GetByUserId($_SESSION[SESS]);
            $voided = $this->saleNoteVoidedModel->GetById($voidedID);
            $sale = $this->saleNoteModel->GetById((int)$voided['sale_id']);

            $voidedData = [
                'sale' => $sale,
                'voided' => $voided,
                'business' => $business,
            ];

            $resXml = $this->GenerateXML($voidedData);
            $res->errorMessage = $resXml->errorMessage;
            $res->success = $resXml->success;
            if (!$resXml->success){
                $this->saleNoteModel->UpdateById($voided['sale_voided_id'],[
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

    public function ResendSaleNoteVoided(){
        try{
            $saleNoteVoidedId = $_GET['SaleNoteVoidedId'] ?? 0;
            if(!$saleNoteVoidedId){
                header('Location: ' . FOLDER_NAME . '/InvoiceNoteVoided');
            }

            $resRunDoc = $this->BuildVoided($saleNoteVoidedId);
            var_dump($resRunDoc);
//            if (!$resRunDoc->success){
//                header('Location: ' . FOLDER_NAME . '/InvoiceNoteVoided?&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
//            } else{
//                header('Location: ' . FOLDER_NAME . '/InvoiceNoteVoided');
//            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function NewSaleNoteVoided(){
        try{
            $message = "";
            $error = [];
            $saleNoteVoided = $_POST['saleNoteVoided'] ?? [];

            // Query By Invoice
            $saleNoteId = $_GET['SaleNoteId'] ?? 0;

            if ($saleNoteId && is_numeric($saleNoteId) ){
                $data = $this->saleNoteModel->GetByIdDocumentDescription($saleNoteId);
                $saleNoteVoided['saleNote'] = [
                    'saleNoteId' =>  $saleNoteId,
                    'description' => $data['description'],
                ];
            }

            // Build
            if (isset($_POST['commit'])) {
                try{
                    $validateInput = $this->ValidateInput($saleNoteVoided);
                    if (!$validateInput->success){
                        $error = $validateInput->error;
                        throw new Exception($validateInput->errorMessage);
                    }
                    $saleNoteVoidedId = $this->saleNoteVoidedModel->Insert($saleNoteVoided);

                    $resRunDoc = $this->BuildVoided($saleNoteVoidedId);
                    if (!$resRunDoc->success){
                        header('Location: ' . FOLDER_NAME . '/InvoiceNoteVoided?&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
                    } else{
                        header('Location: ' . FOLDER_NAME . '/InvoiceNoteVoided');
                    }
                    return;
                }catch (Exception $exception){
                    $message = $exception->getMessage();

                    $data = $this->saleNoteModel->GetByIdDocumentDescription($saleNoteVoided['saleNoteId']);
                    $saleNoteVoided['saleNote'] = [
                        'saleNoteId' =>  $saleNoteId,
                        'description' => $data['description'],
                    ];
                }
            }

            // Render
            $parameter['message'] = $message;
            $parameter['error'] = $error;
            $parameter['saleNoteVoided'] = $saleNoteVoided;

            $content = requireToVar(VIEW_PATH . "User/NewSaleNoteVoided.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function ValidateInput(array $saleNoteVoided) {
        $collector = new ErrorCollector();
        if (trim($saleNoteVoided['saleNoteId'] ?? '') == ""){
            $collector->addError('saleNoteId','No se especificó el documento');
        }
        if (trim($saleNoteVoided['reason'] ?? '') == ""){
            $collector->addError('reason','Falta ingresar la rasón de la anulacion');
        }
        return $collector->getResult();
    }
}

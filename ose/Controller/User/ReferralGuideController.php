<?php

require_once MODEL_PATH . 'User/Customer.php';
require_once MODEL_PATH . 'User/DocumentTypeCode.php';
require_once MODEL_PATH . 'User/TransferReasonCode.php';
require_once MODEL_PATH . 'User/TransportModeCode.php';
require_once MODEL_PATH . 'User/IdentityDocumentTypeCode.php';
require_once MODEL_PATH . 'User/ReferralGuide.php';
require_once MODEL_PATH . 'User/DetailReferralGuide.php';
require_once MODEL_PATH . 'User/GeographicalLocationCode.php';
require_once MODEL_PATH . 'User/Product.php';
require_once MODEL_PATH . 'User/Sale.php';
require_once MODEL_PATH . 'User/DetailSale.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/BusinessSerie.php';

require_once CONTROLLER_PATH . 'Helper/DocumentManager.php';
require_once CONTROLLER_PATH . 'Helper/BillingManager.php';

class ReferralGuideController
{
    private $connection;
    private $param;

    private $referralGuideModel;
    private $detailReferralGuideModel;
    private $customerModel;
    private $businessModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;

        $this->referralGuideModel = new ReferralGuide($this->connection);
        $this->detailReferralGuideModel = new DetailReferralGuide($this->connection);
        $this->customerModel = new Customer($this->connection);
        $this->businessModel = new Business($this->connection);
    }

    public function Exec()
    {
        try{
            $page = $_GET['page'] ?? 0;
            if (!$page) {
                $page = 1;
            }

            $message = $_GET['message'] ?? '';
            $messageType = $_GET['messageType'] ?? '';
            $messageType = ($messageType == 'success') ? 'success' : ($messageType == 'error' ? 'danger' : '');

            $filterCustomerId = $_GET['filterCustomerId'] ?? 0;
            $filterStartDate = $_GET['filterStartDate'] ?? '';
            $filterEndDate = $_GET['filterEndDate'] ?? '';
            $filterReferralGuideId = $_GET['filterReferralGuideId'] ?? 0;

            $referralGuideModel = new ReferralGuide($this->connection);
            $customerModel =  new Customer($this->connection);

            $customerDescription = '';
            if ($filterCustomerId){
                $data = $customerModel->GetById($filterCustomerId);
                $customerDescription = $data['document_number'] . ' ' . $data['social_reason'];
            }

            $filterReferralGuideDescription = '';
            if ($filterReferralGuideId){
                $data = $referralGuideModel->GetById($filterReferralGuideId);
                $filterReferralGuideDescription = $data['serie'] . ' - ' . $data['correlative'];
            }

            $filter = [
                'filterCustomer' => [
                    'customer_id' => $filterCustomerId,
                    'description' => $customerDescription,
                ],
                'filterStartDate' => $filterStartDate,
                'filterEndDate' => $filterEndDate,
                'filterReferralGuide' => [
                    'referral_guide_id' => $filterReferralGuideId,
                    'description' => $filterReferralGuideDescription,
                ]
            ];

            $referralGuides = $referralGuideModel->paginate(
                $page,
                10,
                [
                    'customer_id' => $filterCustomerId,
                    'start_date' => $filterStartDate,
                    'end_date' => $filterEndDate,
                    'referral_guide_id' => $filterReferralGuideId,
                ]
            );

            $parameter['referralGuide'] = $referralGuides;
            $parameter['filter'] = $filter;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;

            $content = requireToVar(VIEW_PATH . "User/ReferralGuide.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function GeneratePdf($guideData){
        $business = $guideData['business'];
        $referralGuide =  $guideData['referralGuide'];
        $detailReferralGuide =  $guideData['detailReferralGuide'];
        $customer =  $guideData['customer'];

        $business = array_merge($business,[
            'address' => 'AV. HUASCAR NRO. 224 DPTO. 303',
            'region' => 'CUSCO',
            'province' => 'CUSCO',
            'district' => 'WANCHAQ',
        ]);

        $invoice['headerContact'] = 'Teléfono: 084601425 | Celular: 979706609 | www.skynetcusco.com | info@skynetcusco.com';
//        $invoice['currencyTypeCodeSymbol'] = $referralGuide['currency_type_code_symbol'];
        $invoice['documentType'] = 'GUIA DE REMISIÓN REMITENTE';
        $invoice['documentCode'] = $referralGuide['document_code'];
        $invoice['serie'] = $referralGuide['serie'];
        $invoice['correlative'] = $referralGuide['correlative'];

        $invoice['customerDocumentNumber'] = $customer['document_number'];
//        $invoice['customerDocumentCode'] = $customer['document_number'];
        $invoice['customerSocialReason'] = $customer['social_reason'];
//        $invoice['customerFiscalAddress'] = $customer['fiscal_address'];

        $invoice['carrierDocumentNumber'] = $referralGuide['carrier_document_number'];
        $invoice['carrierDenomination'] = $referralGuide['carrier_denomination'];
        $invoice['driverDocumentNumber'] = $referralGuide['driver_document_number'];
        $invoice['driverFullName'] = $referralGuide['driver_full_name'];

        $invoice['carrierDocumentDescription'] = '';
        $invoice['driverDocumentDescription'] = '';

        $invoice['carrierPlateNumber'] = $referralGuide['carrier_plate_number'];

        $invoice['logo'] = $business['logo'];
        $invoice['businessRuc'] = $business['ruc'];
        $invoice['businessSocialReason'] = $business['social_reason'];
        $invoice['businessCommercialReason'] = $business['social_reason'];
        $invoice['businessAddress'] = $business['address'];
        $invoice['businessLocation'] = $business['district'] . ' ' . $business['province'] . ' ' . $business['region'];

        $invoice['customerSocialReason'] = $customer['social_reason'];
        $invoice['dateOfIssue'] = $referralGuide['date_of_issue'];
        $invoice['transferStartDate'] = $referralGuide['transfer_start_date'];
        $invoice['transferCode'] = $referralGuide['transfer_code'];
        $invoice['transportCode'] = $referralGuide['transport_code'];
        $invoice['totalGrossWeight'] = $referralGuide['total_gross_weight'];
        $invoice['numberPackages'] = $referralGuide['number_packages'];
        $invoice['locationStartingCode'] = $referralGuide['location_starting_code'];
        $invoice['addressStartingPoint'] = $referralGuide['address_starting_point'];
        $invoice['locationArrivalCode'] = $referralGuide['location_arrival_code'];
        $invoice['addressArrivalPoint'] = $referralGuide['address_arrival_point'];
        $invoice['observations'] = $referralGuide['observations'];
        $invoice['documentTypeCodeDescription'] = '';
        $invoice['customerDocumentNumber'] = $customer['document_number'];

        $invoice['itemList'] = [];
        foreach ($detailReferralGuide as $row){
            $item['quantity'] = $row['quantity'];
            $item['unitMeasure'] = $row['unit_measure'];
            $item['productCode'] = $row['product_code'];
            $item['description'] = $row['description'];
            array_push($invoice['itemList'], $item);
        }

        $documentManager = new DocumentManager();
        $resPdf = $documentManager->Guide($invoice,'A4',$_SESSION[ENVIRONMENT]);

        if ($resPdf->success){
            $this->referralGuideModel->UpdateById($referralGuide['referral_guide_id'],[
                'pdf_url'=> '..' . $resPdf->pdfPath
            ]);
        }
        return $resPdf;
    }

    private function GenerateXML($guideData){
        $business = $guideData['business'];
        $referralGuide =  $guideData['referralGuide'];
        $detailReferralGuide =  $guideData['detailReferralGuide'];
        $customer =  $guideData['customer'];

        $invoice = array();
         $invoice['serie'] = $referralGuide['serie'];
         $invoice['number'] = $referralGuide['correlative'];
         $invoice['issueDate'] = $referralGuide['date_of_issue'];
         $invoice['issueTime'] = $referralGuide['time_of_issue'];
         $invoice['invoiceTypeCode'] = '09';						// TIPO DE COMPROBANTE 09 para guia de remitente
         $invoice['supplierRuc'] = $business['ruc'];
         $invoice['defaultUrl'] = 'WWW.SKYFACT.COM';
         $invoice['supplierName'] = htmlentities($business['social_reason']);
         $invoice['supplierDocumentType'] = '6';					// TIPO DE DOCUMENTO EMISOR
         $invoice['customerDocumentType'] = $customer['identity_document_code'];					// TIPO DE DOCUMENTO CLIENTE
         $invoice['customerDocument'] = $customer['document_number'];			// DOCUMENTO DEL CLIENTE
         $invoice['customerName'] = htmlentities($customer['social_reason']);

         $invoice['transferReasonCode'] = $referralGuide['transfer_code'];						// CODIGO DEL Motivo de Traslado CAT 20
         $invoice['transferReason'] = htmlspecialchars($referralGuide['transfer_reason_description']);						// Motivo de Traslado CAT 20
         $invoice['grossWeightMeasure'] = 'KGM';						// UNIDAD DE MEDIDA DEL PESO TOTAL DEL ENVIO CAT 03(KGM = Kilogramo)
         $invoice['grossWeight'] = $referralGuide['total_gross_weight'];							// PESO
         $invoice['packageQuantity'] = $referralGuide['number_packages'];							// CANTIDAD DE PAQUETES
         $invoice['transferMethodCode'] = $referralGuide['transport_code'];						// CODIGO DEL METODO DE TRANSPORTE CAT 18
         $invoice['referralDate'] = $referralGuide['transfer_start_date'];						// FECHA DE REMISION O ENTREGA AL TRANSPORTISTA
         $invoice['carrierDocumentType'] = $referralGuide['carrier_document_code'];						// TIPO DE DOCUMENTO DEL TRANSPORTISTA
         $invoice['carrierRuc'] = $referralGuide['carrier_document_number'];						// NUMERO DE DOCUMENTO DEL TRANSPORTISTA
         $invoice['carrierName'] = htmlentities($referralGuide['carrier_denomination']);					// NOMBRE DEL TRANSPORTISTA
         $invoice['driverDocumentType'] = $referralGuide['driver_document_code'];						// TIPO DE DOCUMENTO DEL CONDUCTOR
         $invoice['driverDocument'] = $referralGuide['driver_document_number'];						// NUMERO DE DOCUMENTO DEL CONDUCTOR
         $invoice['licensePlate'] = $referralGuide['carrier_plate_number'];						// PLACA DEL VEHICULO
         $invoice['deliveryAdressCode'] = $referralGuide['location_arrival_code'];					// UBIGEO DE DESTINO
         $invoice['deliveryAdress'] = htmlentities($referralGuide['address_arrival_point']);						// DIRECCION DESTINO
         $invoice['originAdressCode'] = $referralGuide['location_starting_code'];						// UBIGEO DE ORIGEN
         $invoice['originAdress'] = htmlentities($referralGuide['address_starting_point']);							// DIRECCION ORIGEN

         $invoice['itemList'] = array();
         foreach ($detailReferralGuide as $row){
             $item = array();
             $item['itemUnitCode'] = $row['unit_measure'];							// CODIGO UNIDAD
             $item['itemCuantity'] = $row['quantity'];							// CANTIDAD
             $item['itemDescription'] = htmlentities($row['description']);		// DESCRIPCION DEL ITEM
             $item['itemCode'] = $row['detail_referral_guide_id'];									// CODIGO INTERNO DEL ITEM (ID)
             array_push($invoice['itemList'], $item);
         }

        $billingManager = new BillingManager($this->connection);
        $directoryXmlPath = '..' . XML_FOLDER_PATH . date('Ym') . '/' . $business['ruc'] . '/';
        $fileName = $business['ruc'] . '-' . '09' . '-' . $referralGuide['serie'] . '-' . $referralGuide['correlative'] . '.xml';

        $res = new Result();
        $res->digestValue = '';

        $resGuide = $billingManager->SendReferralGuide($referralGuide['referral_guide_id'], $invoice, $_SESSION[SESS]);

        if ($resGuide->success){
            $this->referralGuideModel->UpdateById($referralGuide['referral_guide_id'],[
                'xml_url' => $directoryXmlPath . $fileName,
                'sunat_state' => 2,
            ]);
            $res->digestValue = $resGuide->digestValue;
            $res->success = true;
        }else{
            $res->errorMessage .= $resGuide->errorMessage;
            $res->success = false;
            return $res;
        }

        if ($resGuide->sunatComunicationSuccess){
            $res->success = true;
        } else {
            $res->errorMessage .= $resGuide->sunatCommuniationError;
            $res->success = false;
            return $res;
        }

        if ($resGuide->readerSuccess){
            $this->referralGuideModel->UpdateById($referralGuide['referral_guide_id'],[
                'cdr_url' => $directoryXmlPath . 'R-' . $fileName,
                'sunat_state' => 3,
                'sunat_error_message' => '',
            ]);
            $res->success = true;
        } else {
            $res->errorMessage .= $resGuide->readerError;
            $res->success = false;
        }

        return $res;
    }

    private function BuildGuide($referralGuideId){
        $res = new Result();
        try{
            $business = $this->businessModel->GetByUserId($_SESSION[SESS]);
            $referralGuide = $this->referralGuideModel->GetByIdXML($referralGuideId);
            $detailReferralGuide = $this->detailReferralGuideModel->ByReferralGuideIdXML($referralGuideId);
            $customer = $this->customerModel->GetById($referralGuide['customer_id']);

            $guideData = [
                'business' => $business,
                'referralGuide' => $referralGuide,
                'detailReferralGuide' => $detailReferralGuide,
                'customer' => $customer,
            ];

            // XML
            $resXml = $this->GenerateXML($guideData);
            $res->errorMessage = $resXml->errorMessage;
            $res->success = $resXml->success;
            if (!$resXml->success){
                $this->referralGuideModel->UpdateById($referralGuideId,[
                    'sunat_error_message' =>  $resXml->errorMessage,
                ]);
            }

            // PDF
            $guideData['sale']['digestValue'] = '';
            if ($resXml->success){
                $guideData['sale']['digestValue'] = $resXml->digestValue;
            }

            $resPdf = $this->GeneratePdf($guideData);
            if (!$resPdf->success){
                throw new Exception($resPdf->errorMessage);
            }

            // Email
        }catch (Exception $e){
            $res->errorMessage = $e->getMessage() .  $e->getTraceAsString();
            $res->success = false;
        }

        return $res;
    }

    public function ResendReferralGuide(){
        try{
            $guideId = $_GET['GuideId'] ?? 0;
            if(!$guideId){
                header('Location: ' . FOLDER_NAME . '/ReferralGuide');
            }

            $resRunDoc = $this->BuildGuide($guideId);
            if (!$resRunDoc->success){
                header('Location: ' . FOLDER_NAME . '/ReferralGuide?&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
            } else {
                header('Location: ' . FOLDER_NAME . '/ReferralGuide');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function JsonSearch(){
        $search = $_POST['q'] ?? '';

        $voucherModel = new ReferralGuide($this->connection);
        $response = $voucherModel->searchBySerieCorrelative($search);

        echo json_encode([
            'success' => true,
            'data' => $response,
        ]);
    }

    public function NewGuide(){
        try{
            $message = '';
            $messageType = 'info';
            $error = [];

            $guide = $_POST['guide'] ?? [];

            // QUERY BY SALE ------
            $saleId = $_GET['SaleId'] ?? 0;
            $sale = null;
            if ($saleId && is_numeric($saleId) ) {
                $saleModel = new Sale($this->connection);
                $sale = $saleModel -> GetById($saleId);
                if ($sale){
                    $detailSaleModel = new DetailSale($this->connection);
                    $guide['item'] = $detailSaleModel->BySaleIdSummary($sale['sale_id']);
                }
            }

            // INSERT ------
            try{
                if (isset($_POST['commit'])) {
                    if (empty($guide)) {
                        throw new Exception('No hay ningun campo');
                    }

                    $validateInput = $this->ValidateInput($guide);
                    if (!$validateInput->success){
                        $error = $validateInput->error;
                        throw new Exception($validateInput->errorMessage);
                    }
                    $guideId = $this->referralGuideModel->insert($guide);

                    $resRunDoc = $this->BuildGuide($guideId);
//                    if (!$resRunDoc->success){
//                        header('Location: ' . FOLDER_NAME . '/ReferralGuide?&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
//                    }else{
//                        header('Location: ' . FOLDER_NAME . '/ReferralGuide');
//                    }
                    return;
                }
            } catch (Exception $exception){
                $message .= $exception->getMessage();
                $messageType = 'danger';

                if ((int)$guide['customer_id']){
                    $customerModel = new Customer($this->connection);
                    $customer = $customerModel->GetById($guide['customer_id']);
                    $guide['customer'] = [
                        'customer_id' => $customer['customer_id'],
                        'social_reason' => $customer['social_reason'],
                        'document_number' => $customer['document_number'],
                    ];
                }

                $customerModel = new GeographicalLocationCode($this->connection);
                if ((int)$guide['location_starting_code']){
                    $locationStarting = $customerModel->GetBy('code',$guide['location_starting_code']);
                    $guide['location_starting'] = [
                        'code' => $locationStarting['code'],
                        'description' => $locationStarting['code'] . ' - ' . $locationStarting['district'] . ' ' . $locationStarting['province'] . ' ' . $locationStarting['department'],
                    ];
                }

                if ((int)$guide['location_arrival_code']){
                    $locationExit = $customerModel->GetBy('code',$guide['location_arrival_code']);
                    $guide['location_arrival'] = [
                        'code' => $locationExit['code'],
                        'description' => $locationExit['code'] . ' - ' . $locationExit['district'] . ' ' . $locationExit['province'] . ' ' . $locationExit['department'],
                    ];
                }
            }

            $documentTypeCodeModel = new DocumentTypeCode($this->connection);
            $identityDocumentTypeCodeModel = new IdentityDocumentTypeCode($this->connection);
            $transferReasonCodeModel = new TransferReasonCode($this->connection);
            $transportModeCodeModel = new TransportModeCode($this->connection);

            $parameter['documentTypeCode'] = $documentTypeCodeModel->GetBy('code','09');
            $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->getAll();
            $parameter['transferReasonCode'] = $transferReasonCodeModel->getAll();
            $parameter['transportModeCode'] = $transportModeCodeModel->getAll();

            $documentCorrelativeModel = new BusinessSerie($this->connection);
            $correlative = $documentCorrelativeModel->GetNextCorrelative([
                'localId' => $_COOKIE['CurrentBusinessLocal'],
                'documentCode' => '09',
            ]);

            $parameter['correlative'] = $correlative['correlative'] + 1;
            $parameter['correlativeSerie'] = $correlative['serie'];
            $parameter['guide'] = $guide;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;
            $parameter['error'] = $error;

            $content = requireToVar(VIEW_PATH . "User/ReferralGuideForm.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e){
            echo $e->getMessage() . '\\n\\n' . $e->getTraceAsString();
        }
    }

    public function View(){
        $referralGuideId = $_GET['ReferralGuideId'] ?? 0;
        if(!$referralGuideId){
            return;
        }

        $referralGuideModel = new ReferralGuide($this->connection);
        $identityDocumentTypeCodeModel = new IdentityDocumentTypeCode($this->connection);

        $parameter['guide'] = $referralGuideModel->GetById($referralGuideId);
        $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->GetAll();

        $content = requireToVar(VIEW_PATH . "User/ReferralGuideView.php", $parameter);
        require_once(VIEW_PATH. "User/Layout/main.php");
    }

    private function ValidateInput($guide)  {
        $collector = new ErrorCollector();
        if (trim($guide['customer_id'] ?? '') == ""){
            $collector->addError('customer_id','Falta ingresar los datos del cliente');
        }
        if (trim($guide['serie'] ?? '') == ""){
            $collector->addError('serie','Falta ingresar la serie');
        }
        if (trim($guide['correlative'] ?? '') == ""){
            $collector->addError('correlative','Falta ingresar el correlativo de la guía');
        }
        if (trim($guide['transfer_code'] ?? '') == ""){
            $collector->addError('transfer_code','Falta especificar el motivo del traslado');
        }
        if (trim($guide['transport_code'] ?? '') == ""){
            $collector->addError('transport_code','Falta especificar el tipo de transporte');
        }
        if (trim($guide['total_gross_weight'] ?? '') == ""){
            $collector->addError('total_gross_weight','Falta ingresar el peso bruto total');
        }
        if (trim($guide['number_packages'] ?? '') == ""){
            $collector->addError('number_packages','Falta ingresar el número de bultos');
        }
        if (trim($guide['carrier_document_code'] ?? '') == ''){
            $collector->addError('carrier_document_code','Falta especificar el tipo de documento del transportista');
        }
        if (trim($guide['carrier_document_number'] ?? '') == ""){
            $collector->addError('carrier_document_number','Falta ingresar el número de documento del transportista');
        }
        if (trim($guide['carrier_denomination'] ?? '') == ""){
            $collector->addError('carrier_denomination','Falta ingresar la denominación del transportista');
        }
        if (trim($guide['carrier_plate_number'] ?? '') == ""){
            $collector->addError('carrier_plate_number','Falta ingresar la placa del transportista');
        }

        if (trim($guide['driver_document_code'] ?? '') == ''){
            $collector->addError('driver_document_code','Falta especificar el tipo de documento del conductor');
        }
        if (trim($guide['driver_document_number'] ?? '') == ""){
            $collector->addError('driver_document_number','Falta ingresar el número del documento del conductor');
        }
        if (trim($guide['driver_full_name'] ?? '') == ""){
            $collector->addError('driver_full_name','Falta ingresar el nombre completo del conductor');
        }
        if (trim($guide['location_starting_code'] ?? '') == ""){
            $collector->addError('location_starting_code','Falta especificar el Ubigeo de punto de partida');
        }
        if (trim($guide['address_starting_point'] ?? '') == ""){
            $collector->addError('address_starting_point','Falta ingresar la dirección de punto de partida');
        }
        if (trim($guide['location_arrival_code'] ?? '') == ""){
            $collector->addError('location_arrival_code','Falta especificar el Ubigeo de punto de llegada');
        }
        if (trim($guide['address_arrival_point'] ?? '') == ""){
            $collector->addError('address_arrival_point','Falta ingresar la dirección de punto de llegada');
        }
        if (empty($guide['item'])){
            $collector->addError('global','Debes agregar lineas al comprobante');
        }

        // Especial Validation
        $validateCarrierDocument = ValidateIdentityDocumentNumber($guide['carrier_document_number'], $guide['carrier_document_code']);
        if (!$validateCarrierDocument->success){
            $collector->addError('carrier_document_number',$validateCarrierDocument->errorMessage);
        }

        $validateDriverDocument = ValidateIdentityDocumentNumber($guide['driver_document_number'], $guide['driver_document_code']);
        if (!$validateDriverDocument->success){
            $collector->addError('driver_document_number',$validateDriverDocument->errorMessage);
        }

        return $collector->getResult();
    }
}

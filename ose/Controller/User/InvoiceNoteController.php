<?php

require_once MODEL_PATH . 'User/CatAffectationIgvTypeCode.php';
require_once MODEL_PATH . 'User/CatCurrencyTypeCode.php';
require_once MODEL_PATH . 'User/CatDocumentTypeCode.php';
require_once MODEL_PATH . 'User/CatIdentityDocumentTypeCode.php';
require_once MODEL_PATH . 'User/CatOperationTypeCode.php';
require_once MODEL_PATH . 'User/Invoice.php';
require_once MODEL_PATH . 'User/InvoiceNote.php';
require_once MODEL_PATH . 'User/Customer.php';
require_once MODEL_PATH . 'User/InvoiceItem.php';
require_once MODEL_PATH . 'User/InvoiceNoteItem.php';
require_once MODEL_PATH . 'User/Product.php';
require_once MODEL_PATH . 'User/CatCreditNoteTypeCode.php';
require_once MODEL_PATH . 'User/CatDebitNoteTypeCode.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/CatSystemIscTypeCode.php';
require_once MODEL_PATH . 'User/BusinessSerie.php';

require_once CONTROLLER_PATH . 'Helper/DocumentManager.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceTemplate.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceCalculate.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceValidate.php';

require_once CONTROLLER_PATH . 'Helper/BillingManager.php';

class InvoiceNoteController
{
    private $connection;
    private $param;
    private $saleNoteModel;
    private $detailSaleNoteModel;
    private $customerModel;
    private $businessModel;
    private $creditNoteTypeCodeModel;
    private $debitNoteTypeCodeModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;

        $this->saleNoteModel = new InvoiceNote($this->connection);
        $this->detailSaleNoteModel = new InvoiceNoteItem($this->connection);
        $this->customerModel = new Customer($this->connection);
        $this->businessModel = new Business($this->connection);

        $this->creditNoteTypeCodeModel = new CatCreditNoteTypeCode($this->connection);
        $this->debitNoteTypeCodeModel = new CatDebitNoteTypeCode($this->connection);
    }

    public function Exec(){
        try{
            $page = $_GET['page'] ?? 0;
            if (!$page){
                $page = 1;
            }

            $filterDocumentCode = $_GET['filter']['documentCode'] ?? '';
            $filterCustomer = $_GET['filter']['customer'] ?? 0;
            $filterStartDate = $_GET['filter']['startDate'] ?? '';
            $filterEndDate = $_GET['filter']['endDate'] ?? '';
            $filterSaleNoteSearch = $_GET['filter']['saleNoteSearch'] ?? 0;

            $saleNoteModel = new InvoiceNote($this->connection);
            $documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
            $customerModel = new Customer($this->connection);

            $documentTypeCode = $documentTypeCodeModel->ByInCodes(['07','08']);

            // Filter
            $customerDescription = '';
            if ($filterCustomer){
                $data = $customerModel->GetById($filterCustomer);
                $customerDescription = $data['document_number'] . ' ' . $data['social_reason'];
            }

            $saleDescription = '';
            if ($filterSaleNoteSearch){
                $data = $saleNoteModel->GetById($filterSaleNoteSearch);
                $index = array_search($data['document_code'], array_column($documentTypeCode, 'code'));
                $saleDescription = "{$data['serie']}-{$data['correlative']} ( {$documentTypeCode[$index]['description']} ) {$data['date_of_issue']}";
            }

            $parameter['filter'] = [
                'documentCode' => $filterDocumentCode,
                'customer' => [
                    'customer_id' => $filterCustomer,
                    'description' => $customerDescription,
                ],
                'startDate' => $filterStartDate,
                'endDate' => $filterEndDate,
                'saleSearch' => [
                    'sale_id' => $filterSaleNoteSearch,
                    'description' => $saleDescription,
                ]
            ];

            $parameter['saleNote'] = $saleNoteModel->paginate(
                $page,
                10,
                [
                    'documentCode' => $filterDocumentCode,
                    'customerID' => $filterCustomer,
                    'startDate' => $filterStartDate,
                    'endDate' => $filterEndDate,
                    'saleSearch' => $filterSaleNoteSearch,
                ]
            );
            $parameter['documentTypeCode'] = $documentTypeCode;

            $content = requireToVar(VIEW_PATH . "User/InvoiceNote.phpphp", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function GeneratePdf(array $documentData ) {
        $business = $documentData['business'];
        $sale =  $documentData['sale'];
        $detailSale =  $documentData['detailSale'];
        $customer =  $documentData['customer'];

        $business = array_merge($business,[
            'address' => 'AV. HUASCAR NRO. 224 DPTO. 303',
            'region' => 'CUSCO',
            'province' => 'CUSCO',
            'district' => 'WANCHAQ',
        ]);

        $invoice['headerContact'] = 'Teléfono: 084601425 | Celular: 979706609 | www.skynetcusco.com | info@skynetcusco.com';
        $invoice['documentType'] = $sale['document_type_code_description'];
        $invoice['documentCode'] = $sale['document_code'];
        $invoice['serie'] = $sale['serie'];
        $invoice['correlative'] = $sale['correlative'];
        $invoice['vehiclePlate'] = $sale['vehicle_plate'];
        $invoice['term'] = $sale['term'];
        $invoice['purchaseOrder'] = $sale['purchase_order'];
        $invoice['observation'] = $sale['observation'];
        $invoice['logo'] = $business['logo'];

        $invoice['businessRuc'] = $business['ruc'];
        $invoice['businessSocialReason'] = $business['social_reason'];
        $invoice['businessCommercialReason'] = $business['social_reason'];
        $invoice['businessAddress'] = $business['address'];
        $invoice['businessLocation'] = $business['district'] . ' ' . $business['province'] . ' ' . $business['region'];

        $invoice['customerDocumentNumber'] = $customer['document_number'];
        $invoice['customerDocumentCode'] = $customer['document_number'];
        $invoice['customerSocialReason'] = $customer['social_reason'];
        $invoice['customerFiscalAddress'] = $customer['fiscal_address'];
        $invoice['digestValue'] = $sale['digestValue'];
        $invoice['dateOfIssue'] = $sale['date_of_issue'];
        $invoice['dateOfDue'] = $sale['date_of_due'];
        $invoice['currencySymbol'] = $sale['currency_type_code_symbol'];
        $invoice['currencyDescription'] = $sale['currency_type_code_description'];
        $invoice['totalDiscount'] = $sale['total_discount'];
        $invoice['totalPrepayment'] = $sale['total_prepayment'];
        $invoice['totalExonerated'] = $sale['total_exonerated'];
        $invoice['totalUnaffected'] = $sale['total_unaffected'];
        $invoice['totalTaxed'] = $sale['total_taxed'];
        $invoice['totalIsc'] = $sale['total_isc'];
        $invoice['totalIgv'] = $sale['total_igv'];
        $invoice['totalFree'] = $sale['total_free'];
        $invoice['totalCharge'] = $sale['total_charge'];
        $invoice['totalPlasticBagTax'] = $sale['total_plastic_bag_tax'];
        $invoice['total'] = $sale['total'];
        $invoice['totalInWord'] = NumberFunction::StringFormat((int)$sale['total']) . ' ' .$sale['currency_type_code_description'];
        $invoice['percentageIgv'] = $sale['percentage_igv'];

        $invoice['reasonUpdate'] = $sale['reason_update_code'] . ' - ' . $sale['reason_update_code_description'];
        $invoice['reasonUpdateDocument'] = $sale['sale_document_code'] . '-' . $sale['sale_serie'] . '-' .$sale['sale_correlative'];

        $invoice['itemList'] = [];
        foreach ($detailSale as $row){
            $item['discount'] = $row['discount'];
            $item['quantity'] = $row['quantity'];
            $item['unitMeasureCode'] = $row['unit_measure'];
            $item['productCode'] = $row['product_code'];
            $item['productDescription'] = $row['description'];
            $item['unitValue'] = $row['unit_value'];
            $item['unitPrice'] = $row['unit_price'];
            $item['total'] = $row['total'];
            array_push($invoice['itemList'], $item);
        }

        $documentManager = new DocumentManager();
        $resPdf = $documentManager->InvoiceNCND($invoice,$sale['pdf_format'] !== '' ? $sale['pdf_format'] : 'A4',$_SESSION[ENVIRONMENT]);

        if ($resPdf->success){
            $this->saleNoteModel->UpdateById($sale['sale_note_id'],[
                'pdf_url'=> '..' . $resPdf->pdfPath
            ]);
        }
        return $resPdf;
    }

    private function GenerateXML(array $documentData)
    {
        $business = $documentData['business'];
        $saleNote =  $documentData['sale'];
        $detailSaleNote =  $documentData['detailSale'];
        $customer =  $documentData['customer'];

        $detailSaleNote = array_map(function ($item) use ($saleNote, $business){
            $discountBase = $item['total_value'] + $item['discount'];
            $discountPercentage = 0;
            if ($item['discount'] > 0){
                $discountPercentage = ($item['discount'] * 100) / $discountBase;
                $discountPercentage = $discountPercentage / 100;
            }

            // Percentage IGV
            $ac = $item['affectation_code'];
            if ($ac == '20' || $ac == '30' || $ac == '31' || $ac == '32' || $ac == '33' || $ac == '34' || $ac == '35' || $ac == '36'){
                $percentageIgv = 0;
            } else {
                $percentageIgv = $saleNote['percentage_igv'];
            }

            // Total base igv
            if ($ac == '11' || $ac == '12' || $ac == '13' || $ac == '14' || $ac == '15' || $ac == '16'){
                $percentageIgvDecimal = $saleNote['percentage_igv'] / 100;
                $item['total_base_igv'] = $item['total_value'] / (1 + $percentageIgvDecimal);
                $item['igv'] = $item['total_base_igv'] * $percentageIgvDecimal;
                $item['total'] = $item['igv'] + $item['total_value'];
            }

            $item['total_taxed'] = $item['igv'] + $item['isc'] + $item['other_taxed'];

            // Unit value
            if ($ac == '11' || $ac == '12' || $ac == '13' || $ac == '14' || $ac == '15' || $ac == '16' ||
                $ac == '31' || $ac == '32' || $ac == '33' || $ac == '34' || $ac == '35' || $ac == '36'){
                $item['unit_value'] = 0;
            }

            return array_merge($item,
                [
                    'percentage_igv' => $percentageIgv,
                    'discount_percentage' => $discountPercentage,
                    'discount_base' => $discountBase,
                    'total_taxed' => $item['total_taxed'],
                ]
            );
        },$detailSaleNote);
        $saleNote['guide'] = json_decode($saleNote['guide'],true);

        $saleNote['total_discount_base'] = 0;
        $saleNote['total_discount_percentage'] = 0;
        if($saleNote['total_discount'] > 0){
            $saleNote['total_discount_base'] = $saleNote['total_value'] + $saleNote['total_discount'];
            $saleNote['total_discount_percentage'] = ($saleNote['total_discount'] * 100 ) / $saleNote['total_discount_base'];
        }

        // NOTA DE CREDITO - DEBITO
        $invoice = array();
        $invoice['serie'] = $saleNote['serie'];
        $invoice['number'] = $saleNote['correlative'];
        $invoice['issueDate'] = $saleNote['date_of_issue'];
        $invoice['issueTime'] = $saleNote['time_of_issue'];

        $invoice['invoiceTypeCode'] = $saleNote['document_code']; //---------------- TEMP
        $invoice['operationTypeCode'] = $saleNote['operation_code'];	//---------------- TEMP

        $invoice['amounInWord'] = NumberFunction::StringFormat((int)$saleNote['total'] ?? 0);
        if ($saleNote['document_code'] === '07'){
            $invoice['creditNoteTypeCode'] = $saleNote['reason_update_code'];
            $invoice['creditNoteTypeDescription'] = $saleNote['reason_update_code_description'];
        }
        if ($saleNote['document_code'] === '08'){
            $invoice['debitNoteTypeCode'] = $saleNote['reason_update_code'];
            $invoice['debitNoteTypeDescription'] = htmlspecialchars($saleNote['reason_update_code_description']);
        }
        $invoice['supplierRuc'] = $business['ruc'];
        $invoice['defaultUrl'] = 'WWW.SKYFACT.COM';
        $invoice['supplierName'] = htmlspecialchars($business['social_reason']);
        $invoice['supplierDocumentType'] = '6';					// TIPO DE DOCUMENTO EMISOR
        $invoice['customerDocumentType'] = $customer['identity_document_code'];					// TIPO DE DOCUMENTO CLIENTE
        $invoice['customerDocument'] = $customer['document_number'];			// DOCUMENTO DEL CLIENTE
        $invoice['customerName'] =  htmlspecialchars($customer['social_reason']);
        $invoice['totalTaxAmount'] = RoundCurrency($saleNote['total_tax']);					// TOTAL DE IMPUESTOS
        $invoice['totalBaseAmount'] = RoundCurrency($saleNote['total_value']);					// VALOR TOTAL DE LA VENTA
        $invoice['totalSaleAmount'] = RoundCurrency($saleNote['total']);					// VALOR TOTAL DE LA VENTA + IMPUESTOS

        $invoice['totalDiscountAmount'] = RoundCurrency($saleNote['total_discount']);				// VALOR TOTAL DE LOS DESCUENTOS
        $invoice['globalDiscountPercent'] = RoundCurrency($saleNote['total_discount_percentage'] / 100,5);				// DESCUENTO EN PORCENTAJE
        $invoice['globalDiscountAmount'] = RoundCurrency($saleNote['total_discount']);				// VALOR TOTAL DE LOS DESCUENTOS                            // ---------------- Cambiar la variable  -- total_discount_base

        $invoice['totalExtraChargeAmount'] = RoundCurrency($saleNote['total_charge']);			// VALOR TOTAL DE LOS CARGOS EXTRA
        $invoice['totalPrepaidAmount'] = RoundCurrency($saleNote['total_prepayment']);				// VALOR TOTAL DE LOS MONTOS PAGADOS COMO ADELANTO
        $invoice['totalPayableAmount'] = RoundCurrency($saleNote['total']);				// MONTO TOTAL QUE SE COBRA

        $invoice['totalIgvAmount'] = RoundCurrency($saleNote['total_igv']);					// VALOR TOTAL DEL IGV
        $invoice['totalIgvTaxableAmount'] = RoundCurrency($saleNote['total_taxed']);			// VALOR TOTAL DE LA VENTA GRABADA
        $invoice['totalIscAmount'] = RoundCurrency($saleNote['total_isc']);				// VALOR TOTAL DEL ISC
        $invoice['totalIscTaxableAmount'] = 0.00;				// VALOR TOTAL AL CUAL SE APLICA EL ISC.
        $invoice['totalFreeAmount'] = RoundCurrency($saleNote['total_free']);				// VALOR TOTAL INAFECTO A INPUESTOS
        $invoice['totalExoneratedAmount'] = RoundCurrency($saleNote['total_exonerated']);				// VALOR TOTAL INAFECTO A INPUESTOS
        $invoice['totalInafectedAmount'] = RoundCurrency($saleNote['total_unaffected']);				// VALOR TOTAL INAFECTO A INPUESTOS
        $invoice['totalOtherTaxAmount'] = RoundCurrency($saleNote['total_other_taxed']);				// VALOR TOTAL DE otros impuestos
        $invoice['totalOtherTaxableAmount'] = RoundCurrency($saleNote['total_base_other_taxed']);				// VALOR TOTAL AL CUAL SE APLICA otros impuestos.

        $invoice['totalBagTaxAmount'] = RoundCurrency($saleNote['total_plastic_bag_tax']);				// VALOR TOTAL del impuesto a las bolsas
        $invoice['bagTaxAmountPerUnit'] = RoundCurrency($saleNote['percentage_plastic_bag_tax']);				// VALOR TOTAL del impuesto a las bolsas
        $invoice['bagTaxAmount'] = 0.00;				// Monto del impuesto a las bolsas

        $invoice['invoiceReferenceList'] = array();				//Array con la lista de facturas que afecta la nota de credito

        $referencedInvoice = array();
        $referencedInvoice['billingReferenceSerie'] = $saleNote['sale_serie'];				// Serie de la factura afectada
        $referencedInvoice['billingReferenceNumber'] = $saleNote['sale_correlative'];					// Numero de la factura afectada
        $referencedInvoice['billingReferenceTypeCode'] = $saleNote['sale_document_code'];				// Codigo del tipo de comprobante afectado | 01 para facturas

        array_push($invoice['invoiceReferenceList'], $referencedInvoice);

        $invoice['codigoMoneda'] = $saleNote['currency_code'];							// CODIGO DE LA MONEDA

        $invoice['amazoniaGoods'] = 1;							// BIENES EN LA AMAZONIA
        $invoice['amazoniaService'] = 1;						// SERVICIOS EN LA AMAZONIA
        $invoice['orderReference'] = $saleNote['purchase_order'];							// Referencia de la orden de compra o servicio

        //REFERENCIA A GUIAS DE REMISION
        $invoice['referenceDocumentList'] = array();
        foreach ($saleNote['guide'] as $row){
            $referencedDocument = array();
            $referencedDocument['referencedDocument'] = $row['serie'];							// SERIE Y NUMERO DEL DOCUMENTO
            $referencedDocument['referencedDocumentTypeCode'] = $row['document_code'];						// TIPO DOCUMENTO CAT 01
            array_push($invoice['referenceDocumentList'], $referencedDocument);
        }

        $invoice['itemList'] = array();
        foreach ($detailSaleNote as $row){
            $item = array();
            $item['itemUnitCode'] = $row['unit_measure'];			            // CODIGO UNIDAD
            $item['itemCuantity'] = $row['quantity'];							            // CANTIDAD
            $item['itemFinalBaseAmount'] = RoundCurrency($row['total_value']);					            // VALOR TOTAL DEL ITEM (CANTIDAD POR PRECIO UNITARIO menos descuentos)

            $item['itemTotalBaseAmount'] = RoundCurrency($row['discount_base']);		// base			    // VALOR TOTAL DEL ITEM (CANTIDAD POR PRECIO UNITARIO)
            $item['itemDiscountAmount'] = RoundCurrency($row['discount']);					                // Monto del descuento
            $item['itemDiscountPercent'] = RoundCurrency($row['discount_percentage']);                     // Porcentaje del descuento

            $item['singleItemPrice'] = RoundCurrency($row['unit_price']);					                // VALOR
            $item['onerous'] = $row['affectation_onerous'];								    // 1 = OPERACION ONEROSA | 2 = OPERACION NO ONEROSA
            $item['itemTotalTaxAmount'] = RoundCurrency($row['total_taxed']);					            // VALOR TOTAL DE IMPUESTOS DEL ITEM
            $item['itemIgvTaxableAmount'] = RoundCurrency($row['total_base_igv']);					        // VALOR en base AL CUAL SE CALCULA EL IGV
            $item['itemTotalIgvAmount'] = RoundCurrency($row['igv']);					                    // VALOR TOTAL DE IGV CORRESPONDIENTE AL ITEM
            $item['itemTaxPercent'] = RoundCurrency($row['percentage_igv']);						        // PORCENTAJE EN BASE AL CUAL SE ESTA CALCULANDO EL IMPUESTO
            $item['itemIgvTaxCode'] = $row['affectation_code'];							    // CODIGO DE TIPO DE IGV
            $item['itemTaxCode'] = $row['affectation_tribute_code'];					    // CODIGO DE IMPUESTO
            $item['itemTaxName'] = $row['affectation_name'];							    // NOMBRE DE IMPUESTO
            $item['itemTaxNamecode'] = $row['affectation_international_code'];			    // CODIGO DEL NOMBRE DE IMPUESTO
            $item['itemDescription'] = htmlspecialchars($row['description']);   // DESCRIPCION DEL ITEM
            $item['ItemClassificationCode'] = $row['product_code'];			                // CODGIO DE TIPO DE PRODUCTO
            $item['singleItemBasePrice'] = RoundCurrency($row['unit_value']);				                // VALOR BASE DEL ITEM (SIN IMPUESTOS)

            $item['itemBagCuantity'] = $row['quantity_plastic_bag'];							        // CANTIDAD DE BOLSAS PARA EL ITEM
            $item['bagTaxAmount'] = $row['plastic_bag_tax'];							        // CANTIDAD DE BOLSAS PARA EL ITEM
//            $item['itemBagCuantity'] = 0.0;							        // CANTIDAD DE BOLSAS PARA EL ITEM

            $item['itemIscAmount'] = RoundCurrency($row['isc']);							                // CANTIDAD DE BOLSAS PARA EL ITEM
            $item['itemIscTaxableAmount'] = RoundCurrency($row['total_base_isc']);						    // CANTIDAD DE BOLSAS PARA EL ITEM
            $item['itemIscTaxPercent'] = RoundCurrency($row['tax_isc']);							        // CANTIDAD DE BOLSAS PARA EL ITEM
            $item['itemIscSystemType'] = $row['system_isc_code'];							// CATALOGO 08 sistema de calculo del Isc

            array_push($invoice['itemList'], $item);
        }

        $billingManager = new BillingManager($this->connection);
        $directoryXmlPath = '..' . XML_FOLDER_PATH . date('Ym') . '/' . $business['ruc'] . '/';
        $fileName = $business['ruc'] . '-' . $saleNote['document_code'] . '-' . $saleNote['serie'] . '-' . $saleNote['correlative'] . '.xml';



        $res = new Result();
        $res->digestValue = '';

        $resInvoice = null;
        if ($saleNote['document_code'] === '07'){
            $resInvoice = $billingManager->SendCreditNote($saleNote['sale_note_id'], $invoice, $_SESSION[SESS]);
        }

        if ($saleNote['document_code'] === '08'){
            $resInvoice = $billingManager->SendDebitNote($saleNote['sale_note_id'], $invoice, $_SESSION[SESS]);
        }

        if ($resInvoice->success){
            $this->saleNoteModel->UpdateById($saleNote['sale_note_id'],[
                'xml_url' => $directoryXmlPath . $fileName,
                'sunat_state' => 2,
            ]);
            $res->digestValue = $resInvoice->digestValue;
            $res->success = true;
        }else{
            $res->errorMessage .= $resInvoice->errorMessage;
            $res->success = false;
            return $res;
        }

        if ($resInvoice->sunatComunicationSuccess){
            $res->success = true;
        } else {
            $res->errorMessage .= $resInvoice->sunatCommuniationError;
            $res->success = false;
            return $res;
        }

        if ($resInvoice->readerSuccess){
            $this->saleNoteModel->UpdateById($saleNote['sale_note_id'],[
                'cdr_url' => $directoryXmlPath . 'R-' . $fileName,
                'sunat_state' => 3,
                'sunat_error_message' => '',
            ]);
            $res->success = true;
        } else {
            $res->errorMessage .= $resInvoice->readerError;
            $res->success = false;
        }

        return $res;
    }

    private function BuildDocument($saleNoteId){
        $res = new Result();
        $res->error = [];
        $res->saleId = 0;

        try{
            $business = $this->businessModel->GetByUserId($_SESSION[SESS]);
            $saleNote = $this->saleNoteModel->summaryById($saleNoteId);
            $detailSale = $this->detailSaleNoteModel->BySaleNoteIdXML($saleNoteId);
            $customer = $this->customerModel->GetById($saleNote['customer_id']);

            if ($saleNote['sunat_state'] == '3'){
                throw new Exception('Este documento ya fue informado ante la sunat');
            } elseif (($saleNote['sunat_state'] == '4' && $saleNote['document_code'] == '01')){
                throw new Exception('Este documento esta anulado');
            }

            if ($saleNote['document_code'] === '07'){
                $creditNote = $this->creditNoteTypeCodeModel->GetBy('code',$saleNote['reason_update_code']);
                $saleNote['reason_update_code_description'] = $creditNote['description'];
            }
            if ($saleNote['document_code'] === '08'){
                $debitNote = $this->debitNoteTypeCodeModel->GetBy('code',$saleNote['reason_update_code']);
                $saleNote['reason_update_code_description'] = $debitNote['description'];
            }

            // XML
            $documentData = [
                'sale' => $saleNote,
                'detailSale' => $detailSale,
                'customer' => $customer,
                'business' => $business,
            ];

            $resXml = $this->GenerateXML($documentData);
            $res->errorMessage = $resXml->errorMessage;
            $res->success = $resXml->success;
            if (!$resXml->success){
                $this->saleNoteModel->UpdateById($saleNoteId,[
                    'sunat_error_message' =>  $resXml->errorMessage,
                ]);
            }

            // PDF
            $documentData['sale']['digestValue'] = '';
            if ($resXml->success){
                $documentData['sale']['digestValue'] = $resXml->digestValue;
            }
            $resPdf = $this->GeneratePdf($documentData);
            if (!$resPdf->success){
                throw new Exception($resPdf->errorMessage);
            }

            // Email
        }catch (Exception $e){
            $res->errorMessage = $e->getMessage() . $e->getTraceAsString();
            $res->success = false;
        }

        return $res;
    }

    public function ResendInvoice(){
        try{
            $saleNoteId = $_GET['SaleNoteId'] ?? 0;
            if(!$saleNoteId){
                header('Location: ' . FOLDER_NAME . '/InvoiceNote');
            }

            $resRunDoc = $this->BuildDocument($saleNoteId);
            if ($resRunDoc->success){
                header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?SaleNoteId=' . $saleNoteId . '&message=' . 'El documento se guardó y se envió a la SUNAT exitosamente' . '&messageType=success');
            }else{
                header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?SaleNoteId=' . $saleNoteId . '&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function JsonSearch(){
        $search = $_POST['q'] ?? '';

        $data = $this->saleNoteModel->searchBySerieCorrelative($search);

        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function NewCreditNote(){
        $errorMessage = "";
        $error = [];
        $invoice = $_POST['invoice'] ?? [];

        $saleModel = new Invoice($this->connection);
        $customerModel = new Customer($this->connection);

        // cuando se envia un parametro SaleId desde la url
        $saleId = $_GET['SaleId'] ?? 0;
        if ($saleId && is_numeric($saleId) ){
            $sale = $saleModel -> GetById($saleId);
            if ($sale){
                $saleId = $sale['sale_id'];
                $serie = $sale['serie'];
                $correlative = $sale['correlative'];
                $documentCode = $sale['document_code'];

                unset($sale['sale_id']);
                unset($sale['serie']);
                unset($sale['correlative']);
                unset($sale['document_code']);

                $invoice = $sale;
                $invoice['sale_update'] = [
                    'sale_id' => $saleId,
                    'serie' => $serie,
                    'correlative' => $correlative,
                    'document_code' => $documentCode,
                ];

                $invoice['guide'] = json_decode($invoice['guide'],true);

                $detailSaleModel = new InvoiceItem($this->connection);
                $invoice['item'] = $detailSaleModel->BySaleIdSummary($saleId);

                $customer = $customerModel->GetById($invoice['customer_id']);
                $invoice['customer'] = [
                    'customer_id' => $customer['customer_id'],
                    'social_reason' => $customer['social_reason'],
                    'document_number' => $customer['document_number'],
                ];
            }
        }

        if (isset($_POST['commit'])){
            try{
                if (empty($invoice)){
                    throw new Exception('No hay ningun campo');
                }

                $saleModel = new Invoice($this->connection);
                $saleId  = $saleModel -> ExistDocument(
                    $invoice['sale_update']['correlative'],
                    $invoice['sale_update']['serie'],
                    $invoice['sale_update']['document_code']
                );
                if (!$saleId){
                    throw new Exception('El documento que hace referecnia no existe');
                }

                $invoice['reason_update_code'] = $invoice['sale_update']['credit_note_code'];
                $invoice['sale_id'] = $saleId;

                $invoice['percentage_igv'] = 18.00;
                $invoice['total_value'] = $invoice['total_unaffected'] + $invoice['total_taxed'] + $invoice['total_exonerated'];

//                $validateInput = $this->ValidateInput($invoice);
//                $error = $validateInput->error;
//                if (!$validateInput->success){
//                    throw new Exception($validateInput->errorMessage);
//                }

                $saleNoteId = $this->saleNoteModel->Insert($invoice);

                $resRunDoc = $this->BuildDocument($saleNoteId);
                $error = $resRunDoc->error;
                if (!$resRunDoc->success){
                    throw new Exception($resRunDoc->errorMessage);
                }

                // ALL SUCCESS
                if ($saleNoteId >= 1 && $resRunDoc->errorMessage === ''){
                    header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?SaleNoteId=' . $saleNoteId . '&message=' . urlencode('El documento se guardó exitosamente') . '&messageType=success');
                    return;
                } else{
                    header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?SaleId=' . $saleNoteId . '&message=' . urlencode($resRunDoc->errorMessag) . '&messageType=error');
                    return;
                }
            }catch (Exception $exception){
                $errorMessage .= $exception->getMessage();

                if ((int)$invoice['customer_id']){
                    $customer = $customerModel->GetById($invoice['customer_id']);
                    $invoice['customer'] = [
                        'customer_id' => $customer['customer_id'],
                        'social_reason' => $customer['social_reason'],
                        'document_number' => $customer['document_number'],
                    ];
                }
            }
        }

        $affectationIgvTypeCodeModel = new CatAffectationIgvTypeCode($this->connection);
        $systemIscTypeCodeModel = new CatSystemIscTypeCode($this->connection);
        $currencyTypeCodeModel = new CatCurrencyTypeCode($this->connection);
        $documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
        $identityDocumentTypeCodeModel = new CatIdentityDocumentTypeCode($this->connection);
        $operationTypeCodeModel = new CatOperationTypeCode($this->connection);
        $creditNoteTypeModel = new CatCreditNoteTypeCode($this->connection);
        $businessModel = new Business($this->connection);

        $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->GetAll();
        $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();
        $parameter['documentTypeCode'] = $documentTypeCodeModel->GetBy('code','07');
        $parameter['currencyTypeCode'] = $currencyTypeCodeModel->getAll();
        $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->getAll();
        $parameter['operationTypeCode'] = $operationTypeCodeModel->getAll();
        $parameter['creditNoteType'] = $creditNoteTypeModel->getAll();
        $parameter['business'] = $businessModel->GetByUserId($_SESSION[SESS]);

        $documentCorrelativeModel = new BusinessSerie($this->connection);
        $correlative = $documentCorrelativeModel->GetNextCorrelative([
            'localId' => $_COOKIE['CurrentBusinessLocal'],
            'documentCode' => '07',
        ]);

        $parameter['correlative'] = $correlative['correlative'] + 1;
        $parameter['correlativePrefix'] = $correlative['serie'];
        $parameter['invoice'] = $invoice;
        $parameter['error'] = $error;
        $parameter['message'] = $errorMessage;
        $parameter['itemTemplate'] = InvoiceTemplate::Item($parameter['business'],$parameter['affectationIgvTypeCode']);
        $parameter['referralGuideTemplate'] = $this->GetReferralGuideTemplate();

        $content = requireToVar(VIEW_PATH . "User/SaleCreditNote.php", $parameter);
        require_once(VIEW_PATH. "User/Layout/main.php");
    }

    public function NewDebitNote(){
        $errorMessage = "";
        $error = [];
        $invoice = $_POST['invoice'] ?? [];

        $saleModel = new Invoice($this->connection);
        $customerModel = new Customer($this->connection);

        // cuando se envia un parametro SaleId desde la url
        $saleId = $_GET['SaleId'] ?? 0;
        if ($saleId && is_numeric($saleId) ){
            $sale = $saleModel -> GetById($saleId);
            if ($sale){
                $saleId = $sale['sale_id'];
                $serie = $sale['serie'];
                $correlative = $sale['correlative'];
                $voucherCode = $sale['document_code'];

                unset($sale['sale_id']);
                unset($sale['serie']);
                unset($sale['correlative']);
                unset($sale['document_code']);

                $invoice = $sale;
                $invoice['sale_update'] = [
                    'sale_id' => $saleId,
                    'serie' => $serie,
                    'correlative' => $correlative,
                    'document_code' => $voucherCode,
                ];

                $invoice['guide'] = json_decode($invoice['guide'],true);

                $detailSaleModel = new InvoiceItem($this->connection);
                $invoice['item'] = $detailSaleModel->BySaleIdSummary($saleId);

                $customer = $customerModel->GetById($invoice['customer_id']);
                $invoice['customer'] = [
                    'customer_id' => $customer['customer_id'],
                    'social_reason' => $customer['social_reason'],
                    'document_number' => $customer['document_number'],
                ];
            }
        }

        if (isset($_POST['commit'])){
            try{
                if (empty($invoice)){
                    throw new Exception('No hay ningun campo');
                }

                $saleModel = new Invoice($this->connection);
                $saleId  = $saleModel -> ExistDocument(
                    $invoice['sale_update']['correlative'],
                    $invoice['sale_update']['serie'],
                    $invoice['sale_update']['document_code']
                );
                if (!$saleId){
                    throw new Exception('El documento que hace referecnia no existe');
                }

                $invoice['reason_update_code'] = $invoice['sale_update']['credit_note_code'];
                $invoice['sale_id'] = $saleId;

                $invoice['percentage_igv'] = 18.00;
                $invoice['total_value'] = $invoice['total_unaffected'] + $invoice['total_taxed'] + $invoice['total_exonerated'];

//                $validateInput = $this->ValidateInput($invoice);
//                $error = $validateInput->error;
//                if (!$validateInput->success){
//                    throw new Exception($validateInput->errorMessage);
//                }

                $saleNoteId = $this->saleNoteModel->Insert($invoice);

                $resRunDoc = $this->BuildDocument($saleNoteId);
                $error = $resRunDoc->error;

                if (!$resRunDoc->success){
                    throw new Exception($resRunDoc->errorMessage);
                }

                // ALL SUCCESS
                if ($saleNoteId >= 1 && $resRunDoc->errorMessage === ''){
                    header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?SaleNoteId=' . $saleNoteId . '&message=' . urlencode('El documento se guardó exitosamente') . '&messageType=success');
                    return;
                } else{
                    header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?SaleId=' . $saleNoteId . '&message=' . urlencode($resRunDoc->errorMessag) . '&messageType=error');
                    return;
                }
            }catch (Exception $exception){
                $errorMessage .= $exception->getMessage();

                if ((int)$invoice['customer_id']){
                    $customer = $customerModel->GetById($invoice['customer_id']);
                    $invoice['customer'] = [
                        'customer_id' => $customer['customer_id'],
                        'social_reason' => $customer['social_reason'],
                        'document_number' => $customer['document_number'],
                    ];
                }
            }
        }

        $affectationIgvTypeCodeModel = new CatAffectationIgvTypeCode($this->connection);
        $systemIscTypeCodeModel = new CatSystemIscTypeCode($this->connection);
        $currencyTypeCodeModel = new CatCurrencyTypeCode($this->connection);
        $documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
        $identityDocumentTypeCodeModel = new CatIdentityDocumentTypeCode($this->connection);
        $operationTypeCodeModel = new CatOperationTypeCode($this->connection);
        $debitNoteTypeCodeModel = new CatDebitNoteTypeCode($this->connection);
        $businessModel = new Business($this->connection);

        $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->GetAll();
        $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();
        $parameter['documentTypeCode'] = $documentTypeCodeModel->GetBy('code','08');
        $parameter['currencyTypeCode'] = $currencyTypeCodeModel->getAll();
        $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->getAll();
        $parameter['operationTypeCode'] = $operationTypeCodeModel->getAll();
        $parameter['creditNoteType'] = $debitNoteTypeCodeModel->getAll();
        $parameter['business'] = $businessModel->GetByUserId($_SESSION[SESS]);

        $documentCorrelativeModel = new BusinessSerie($this->connection);
        $correlative = $documentCorrelativeModel->GetNextCorrelative([
            'localId' => $_COOKIE['CurrentBusinessLocal'],
            'documentCode' => '08',
        ]);

        $parameter['correlative'] = $correlative['correlative'] + 1;
        $parameter['correlativePrefix'] = $correlative['serie'];
        $parameter['invoice'] = $invoice;
        $parameter['error'] = $error;
        $parameter['message'] = $errorMessage;
        $parameter['itemTemplate'] = InvoiceTemplate::Item($parameter['business'],$parameter['affectationIgvTypeCode']);
        $parameter['referralGuideTemplate'] = $this->GetReferralGuideTemplate();

        $content = requireToVar(VIEW_PATH . "User/SaleDebitNote.php", $parameter);
        require_once(VIEW_PATH. "User/Layout/main.php");
    }

    public function View(){
        $saleNoteId = $_GET['SaleNoteId'] ?? 0;
        if(!$saleNoteId){
            return;
        }
        $message = $_GET['message'] ?? '';
        $messageType = $_GET['messageType'] ?? '';
        $messageType = ($messageType == 'success') ? 'success' : ($messageType == 'error' ? 'danger' : '');

        $invoice = $this->saleNoteModel->SummaryById($saleNoteId);
        $parameter['detailSaleNote'] = $this->detailSaleNoteModel->BySaleNoteIdSummary($saleNoteId);
        $parameter['customer'] = $this->customerModel->GetById($invoice['customer_id']);
        $parameter['invoice'] = $invoice;
        $parameter['message'] = $message;
        $parameter['messageType'] = $messageType;

        $content = requireToVar(VIEW_PATH . "User/SaleNoteView.php", $parameter);
        require_once(VIEW_PATH. "User/Layout/main.php");
    }

    private function ValidateInput(array $invoice) {
        $collector = new InvoiceValidate($invoice, $this->connection);
        return $collector->getResult();
    }

    private function GetReferralGuideTemplate(){
        return '<tr id="referralGuideItem${uniqueId}">
            <td>
                <label for="type${uniqueId}">Tipo</label>
                <select class="form-control form-control-sm" id="type${uniqueId}" name="invoice[guide][${uniqueId}][document_code]" required>
                    <option value="1">GUÍA DE REMISIÓN REMITENTE</option>
                    <option value="2">GUÍA DE REMISIÓN TRANSPORTISTA</option>
                </select>
            </td>
            <td>
                <label for="serie${uniqueId}">Serie - Número</label>
                <input type="text" class="form-control form-control-sm" id="serie${uniqueId}" name="invoice[guide][${uniqueId}][serie]" required>
            </td>
            <td>
                <div class="btn btn-danger btn-sm mt-4" onclick="ReferralGuidePhysical.removeItem(\'${uniqueId}\')">Quitar</div>
            </td>
        </tr>';
    }
}
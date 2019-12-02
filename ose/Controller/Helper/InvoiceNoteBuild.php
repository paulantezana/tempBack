<?php

require_once MODEL_PATH . 'User/InvoiceNote.php';
require_once MODEL_PATH . 'User/InvoiceNoteItem.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/CatSystemIscTypeCode.php';
require_once MODEL_PATH . 'User/CatPerceptionTypeCode.php';
require_once MODEL_PATH . 'User/CatCreditNoteTypeCode.php';
require_once MODEL_PATH . 'User/CatDebitNoteTypeCode.php';

require_once CONTROLLER_PATH . 'Helper/DocumentManager.php';
require_once CONTROLLER_PATH . 'Helper/BillingManager.php';

class InvoiceNoteBuild
{
    private $connection;
    private $invoiceNoteModel;
    private $detailInvoiceNoteModel;
    private $businessModel;
    private $creditNoteTypeCodeModel;
    private $debitNoteTypeCodeModel;

    public function __construct($connection)
    {
        $this->connection = $connection;

        $this->invoiceNoteModel = new InvoiceNote($this->connection);
        $this->detailInvoiceNoteModel = new InvoiceNoteItem($this->connection);
        $this->businessModel = new Business($this->connection);

        $this->creditNoteTypeCodeModel = new CatCreditNoteTypeCode($this->connection);
        $this->debitNoteTypeCodeModel = new CatDebitNoteTypeCode($this->connection);
    }

    private function GeneratePdf(array $documentData ) {
        $business = $documentData['business'];
        $invoiceNote =  $documentData['invoice'];
        $detailInvoice =  $documentData['detailInvoice'];

        $business = array_merge($business,[
            'address' => 'AV. HUASCAR NRO. 224 DPTO. 303',
            'region' => 'CUSCO',
            'province' => 'CUSCO',
            'district' => 'WANCHAQ',
        ]);

        $invoice['headerContact'] = 'Teléfono: 084601425 | Celular: 979706609 | www.skynetcusco.com | info@skynetcusco.com';
        $invoice['documentType'] = $invoiceNote['document_type_code_description'];
        $invoice['documentCode'] = $invoiceNote['document_code'];
        $invoice['serie'] = $invoiceNote['serie'];
        $invoice['correlative'] = $invoiceNote['correlative'];
        $invoice['vehiclePlate'] = $invoiceNote['vehicle_plate'];
        $invoice['term'] = $invoiceNote['term'];
        $invoice['purchaseOrder'] = $invoiceNote['purchase_order'];
        $invoice['observation'] = $invoiceNote['observation'];
        $invoice['logo'] = $business['logo'];

        $invoice['businessRuc'] = $business['ruc'];
        $invoice['businessSocialReason'] = $business['social_reason'];
        $invoice['businessCommercialReason'] = $business['social_reason'];
        $invoice['businessAddress'] = $business['address'];
        $invoice['businessLocation'] = $business['district'] . ' ' . $business['province'] . ' ' . $business['region'];

        $invoice['customerDocumentNumber'] = $invoiceNote['customer_document_number'];
        $invoice['customerDocumentCode'] = $invoiceNote['customer_document_number'];
        $invoice['customerSocialReason'] = $invoiceNote['customer_social_reason'];
        $invoice['customerFiscalAddress'] = $invoiceNote['customer_fiscal_address'];
        $invoice['digestValue'] = $invoiceNote['digestValue'];
        $invoice['dateOfIssue'] = $invoiceNote['date_of_issue'];
        $invoice['dateOfDue'] = $invoiceNote['date_of_due'];
        $invoice['currencySymbol'] = $invoiceNote['currency_type_code_symbol'];
        $invoice['currencyDescription'] = $invoiceNote['currency_type_code_description'];
        $invoice['totalDiscount'] = $invoiceNote['total_discount'];
        $invoice['totalPrepayment'] = $invoiceNote['total_prepayment'];
        $invoice['totalExonerated'] = $invoiceNote['total_exonerated'];
        $invoice['totalUnaffected'] = $invoiceNote['total_unaffected'];
        $invoice['totalTaxed'] = $invoiceNote['total_taxed'];
        $invoice['totalIsc'] = $invoiceNote['total_isc'];
        $invoice['totalIgv'] = $invoiceNote['total_igv'];
        $invoice['totalFree'] = $invoiceNote['total_free'];
        $invoice['totalCharge'] = $invoiceNote['total_charge'];
        $invoice['totalPlasticBagTax'] = $invoiceNote['total_plastic_bag_tax'];
        $invoice['total'] = $invoiceNote['total'];
        $invoice['totalInWord'] = NumberFunction::StringFormat((int)$invoiceNote['total']) . ' ' .$invoiceNote['currency_type_code_description'];
        $invoice['percentageIgv'] = $invoiceNote['percentage_igv'];

        $invoice['reasonUpdate'] = $invoiceNote['reason_update_code'] . ' - ' . $invoiceNote['reason_update_code_description'];
        $invoice['reasonUpdateDocument'] = $invoiceNote['invoice_document_code'] . '-' . $invoiceNote['invoice_serie'] . '-' .$invoiceNote['invoice_correlative'];

        $invoice['itemList'] = [];
        foreach ($detailInvoice as $row){
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
        $resPdf = $documentManager->InvoiceNCND($invoice,$invoiceNote['pdf_format'] !== '' ? $invoiceNote['pdf_format'] : 'A4',$_SESSION[ENVIRONMENT]);

        if ($resPdf->success){
            $this->invoiceNoteModel->UpdateById($invoiceNote['invoice_note_id'],[
                'pdf_url'=> '..' . $resPdf->pdfPath
            ]);
        }
        return $resPdf;
    }

    private function GenerateXML(array $documentData, int $userReferId)
    {
        $business = $documentData['business'];
        $invoiceNote =  $documentData['invoice'];
        $detailInvoiceNote =  $documentData['detailInvoice'];

        $detailInvoiceNote = array_map(function ($item) use ($invoiceNote, $business){
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
                $percentageIgv = $invoiceNote['percentage_igv'];
            }

            // Total base igv
            if ($ac == '11' || $ac == '12' || $ac == '13' || $ac == '14' || $ac == '15' || $ac == '16'){
                $percentageIgvDecimal = $invoiceNote['percentage_igv'] / 100;
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
        },$detailInvoiceNote);
        $invoiceNote['guide'] = json_decode($invoiceNote['guide'],true);

        $invoiceNote['total_discount_base'] = 0;
        $invoiceNote['total_discount_percentage'] = 0;
        if($invoiceNote['total_discount'] > 0){
            $invoiceNote['total_discount_base'] = $invoiceNote['total_value'] + $invoiceNote['total_discount'];
            $invoiceNote['total_discount_percentage'] = ($invoiceNote['total_discount'] * 100 ) / $invoiceNote['total_discount_base'];
        }

        // NOTA DE CREDITO - DEBITO
        $invoice = array();
        $invoice['serie'] = $invoiceNote['serie'];
        $invoice['number'] = $invoiceNote['correlative'];
        $invoice['issueDate'] = $invoiceNote['date_of_issue'];
        $invoice['issueTime'] = $invoiceNote['time_of_issue'];

        $invoice['invoiceTypeCode'] = $invoiceNote['document_code']; //---------------- TEMP
        $invoice['operationTypeCode'] = $invoiceNote['operation_code'];	//---------------- TEMP

        $invoice['amounInWord'] = NumberFunction::StringFormat((int)$invoiceNote['total'] ?? 0);
        if ($invoiceNote['document_code'] === '07'){
            $invoice['creditNoteTypeCode'] = $invoiceNote['reason_update_code'];
            $invoice['creditNoteTypeDescription'] = $invoiceNote['reason_update_code_description'];
        }
        if ($invoiceNote['document_code'] === '08'){
            $invoice['debitNoteTypeCode'] = $invoiceNote['reason_update_code'];
            $invoice['debitNoteTypeDescription'] = htmlspecialchars($invoiceNote['reason_update_code_description']);
        }
        $invoice['supplierRuc'] = $business['ruc'];
        $invoice['defaultUrl'] = 'WWW.SKYFACT.COM';
        $invoice['supplierName'] = htmlspecialchars($business['social_reason']);
        $invoice['supplierDocumentType'] = '6';					// TIPO DE DOCUMENTO EMISOR
        $invoice['customerDocumentType'] = $invoiceNote['customer_identity_document_code'];					// TIPO DE DOCUMENTO CLIENTE
        $invoice['customerDocument'] = $invoiceNote['customer_document_number'];			// DOCUMENTO DEL CLIENTE
        $invoice['customerName'] = htmlspecialchars($invoiceNote['customer_social_reason']);
        $invoice['totalTaxAmount'] = RoundCurrency($invoiceNote['total_tax']);					// TOTAL DE IMPUESTOS
        $invoice['totalBaseAmount'] = RoundCurrency($invoiceNote['total_value']);					// VALOR TOTAL DE LA VENTA
        $invoice['totalInvoiceAmount'] = RoundCurrency($invoiceNote['total']);					// VALOR TOTAL DE LA VENTA + IMPUESTOS

        $invoice['totalDiscountAmount'] = RoundCurrency($invoiceNote['total_discount']);				// VALOR TOTAL DE LOS DESCUENTOS
        $invoice['globalDiscountPercent'] = RoundCurrency($invoiceNote['total_discount_percentage'] / 100,5);				// DESCUENTO EN PORCENTAJE
        $invoice['globalDiscountAmount'] = RoundCurrency($invoiceNote['total_discount']);				// VALOR TOTAL DE LOS DESCUENTOS                            // ---------------- Cambiar la variable  -- total_discount_base

        $invoice['totalExtraChargeAmount'] = RoundCurrency($invoiceNote['total_charge']);			// VALOR TOTAL DE LOS CARGOS EXTRA
        $invoice['totalPrepaidAmount'] = RoundCurrency($invoiceNote['total_prepayment']);				// VALOR TOTAL DE LOS MONTOS PAGADOS COMO ADELANTO
        $invoice['totalPayableAmount'] = RoundCurrency($invoiceNote['total']);				// MONTO TOTAL QUE SE COBRA

        $invoice['totalIgvAmount'] = RoundCurrency($invoiceNote['total_igv']);					// VALOR TOTAL DEL IGV
        $invoice['totalIgvTaxableAmount'] = RoundCurrency($invoiceNote['total_taxed']);			// VALOR TOTAL DE LA VENTA GRABADA
        $invoice['totalIscAmount'] = RoundCurrency($invoiceNote['total_isc']);				// VALOR TOTAL DEL ISC
        $invoice['totalIscTaxableAmount'] = 0.00;				// VALOR TOTAL AL CUAL SE APLICA EL ISC.
        $invoice['totalFreeAmount'] = RoundCurrency($invoiceNote['total_free']);				// VALOR TOTAL INAFECTO A INPUESTOS
        $invoice['totalExoneratedAmount'] = RoundCurrency($invoiceNote['total_exonerated']);				// VALOR TOTAL INAFECTO A INPUESTOS
        $invoice['totalInafectedAmount'] = RoundCurrency($invoiceNote['total_unaffected']);				// VALOR TOTAL INAFECTO A INPUESTOS
        $invoice['totalOtherTaxAmount'] = RoundCurrency($invoiceNote['total_other_taxed']);				// VALOR TOTAL DE otros impuestos
        $invoice['totalOtherTaxableAmount'] = RoundCurrency($invoiceNote['total_base_other_taxed']);				// VALOR TOTAL AL CUAL SE APLICA otros impuestos.

        $invoice['totalBagTaxAmount'] = RoundCurrency($invoiceNote['total_plastic_bag_tax']);				// VALOR TOTAL del impuesto a las bolsas
        $invoice['bagTaxAmountPerUnit'] = RoundCurrency($invoiceNote['percentage_plastic_bag_tax']);				// VALOR TOTAL del impuesto a las bolsas
        $invoice['bagTaxAmount'] = 0.00;				// Monto del impuesto a las bolsas

        $invoice['invoiceReferenceList'] = array();				//Array con la lista de facturas que afecta la nota de credito

        $referencedInvoice = array();
        $referencedInvoice['billingReferenceSerie'] = $invoiceNote['invoice_serie'];				// Serie de la factura afectada
        $referencedInvoice['billingReferenceNumber'] = $invoiceNote['invoice_correlative'];					// Numero de la factura afectada
        $referencedInvoice['billingReferenceTypeCode'] = $invoiceNote['invoice_document_code'];				// Codigo del tipo de comprobante afectado | 01 para facturas

        array_push($invoice['invoiceReferenceList'], $referencedInvoice);

        $invoice['codigoMoneda'] = $invoiceNote['currency_code'];							// CODIGO DE LA MONEDA

        $invoice['amazoniaGoods'] = 1;							// BIENES EN LA AMAZONIA
        $invoice['amazoniaService'] = 1;						// SERVICIOS EN LA AMAZONIA
        $invoice['orderReference'] = $invoiceNote['purchase_order'];							// Referencia de la orden de compra o servicio

        //REFERENCIA A GUIAS DE REMISION
        $invoice['referenceDocumentList'] = array();
        foreach ($invoiceNote['guide'] as $row){
            $referencedDocument = array();
            $referencedDocument['referencedDocument'] = $row['serie'];							// SERIE Y NUMERO DEL DOCUMENTO
            $referencedDocument['referencedDocumentTypeCode'] = $row['document_code'];						// TIPO DOCUMENTO CAT 01
            array_push($invoice['referenceDocumentList'], $referencedDocument);
        }

        $invoice['itemList'] = array();
        foreach ($detailInvoiceNote as $row){
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
        $fileName = $business['ruc'] . '-' . $invoiceNote['document_code'] . '-' . $invoiceNote['serie'] . '-' . $invoiceNote['correlative'] . '.xml';



        $res = new Result();
        $res->digestValue = '';

        $resInvoice = null;
        if ($invoiceNote['document_code'] === '07'){
            $resInvoice = $billingManager->SendCreditNote($invoiceNote['invoice_note_id'], $invoice, $userReferId);
        }

        if ($invoiceNote['document_code'] === '08'){
            $resInvoice = $billingManager->SendDebitNote($invoiceNote['invoice_note_id'], $invoice, $userReferId);
        }

        if ($resInvoice->success){
            $this->invoiceNoteModel->UpdateById($invoiceNote['invoice_note_id'],[
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
            $this->invoiceNoteModel->UpdateById($invoiceNote['invoice_note_id'],[
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

    public function BuildDocument($invoiceNoteId, $userReferId){
        $res = new Result();
        $res->error = [];
        $res->invoiceId = 0;

        try{
            $business = $this->businessModel->GetByUserId($userReferId);
            $invoiceNote = $this->invoiceNoteModel->summaryById($invoiceNoteId);
            $detailInvoice = $this->detailInvoiceNoteModel->ByInvoiceNoteIdXML($invoiceNoteId);

            if ($invoiceNote['sunat_state'] == '3'){
                throw new Exception('Este documento ya fue informado ante la sunat');
            } elseif (($invoiceNote['sunat_state'] == '4' && $invoiceNote['document_code'] == '01')){
                throw new Exception('Este documento esta anulado');
            }

            if ($invoiceNote['document_code'] === '07'){
                $creditNote = $this->creditNoteTypeCodeModel->GetBy('code',$invoiceNote['reason_update_code']);
                $invoiceNote['reason_update_code_description'] = $creditNote['description'];
            }
            if ($invoiceNote['document_code'] === '08'){
                $debitNote = $this->debitNoteTypeCodeModel->GetBy('code',$invoiceNote['reason_update_code']);
                $invoiceNote['reason_update_code_description'] = $debitNote['description'];
            }

            // XML
            $documentData = [
                'invoice' => $invoiceNote,
                'detailInvoice' => $detailInvoice,
                'business' => $business,
            ];

            $resXml = $this->GenerateXML($documentData,$userReferId);
            $res->errorMessage = $resXml->errorMessage;
            $res->success = $resXml->success;
            if (!$resXml->success){
                $this->invoiceNoteModel->UpdateById($invoiceNoteId,[
                    'sunat_error_message' =>  $resXml->errorMessage,
                ]);
            }

            // PDF
            $documentData['invoice']['digestValue'] = '';
            if ($resXml->success){
                $documentData['invoice']['digestValue'] = $resXml->digestValue;
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
}

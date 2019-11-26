<?php

//require_once MODEL_PATH . 'User/CatAdditionalLegendCode.php';
require_once MODEL_PATH . 'User/CatAffectationIgvTypeCode.php';
require_once MODEL_PATH . 'User/CatSubjectDetractionCode.php';
require_once MODEL_PATH . 'User/CatTransferReasonCode.php';
require_once MODEL_PATH . 'User/CatTransportModeCode.php';
require_once MODEL_PATH . 'User/CatCurrencyTypeCode.php';
require_once MODEL_PATH . 'User/CatDocumentTypeCode.php';
require_once MODEL_PATH . 'User/CatIdentityDocumentTypeCode.php';
require_once MODEL_PATH . 'User/CatOperationTypeCode.php';
require_once MODEL_PATH . 'User/Invoice.php';
require_once MODEL_PATH . 'User/Customer.php';
require_once MODEL_PATH . 'User/InvoiceItem.php';
require_once MODEL_PATH . 'User/Product.php';
require_once MODEL_PATH . 'User/CatCreditNoteTypeCode.php';
require_once MODEL_PATH . 'User/CatDebitNoteTypeCode.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/CatSystemIscTypeCode.php';
require_once MODEL_PATH . 'User/BusinessSerie.php';
require_once MODEL_PATH . 'User/CatPerceptionTypeCode.php';
require_once MODEL_PATH . 'User/CatGeographicalLocationCode.php';

require_once CONTROLLER_PATH . 'Helper/DocumentManager.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceTemplate.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceCalculate.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceValidate.php';
require_once CONTROLLER_PATH . 'Helper/BillingManager.php';

class InvoiceController
{
    protected $connection;
    private $param;
    private $saleModel;
    private $detailSaleModel;
    private $customerModel;
    private $businessModel;

    public function __construct(PDO $connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;

        $this->saleModel = new Invoice($this->connection);
        $this->detailSaleModel = new InvoiceItem($this->connection);
        $this->customerModel = new Customer($this->connection);
        $this->businessModel = new Business($this->connection);
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
            $filterSaleSearch = $_GET['filter']['saleSearch'] ?? 0;

            $documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
            $documentTypeCode = $documentTypeCodeModel->ByInCodes(['01','03']);

            // Filter
            $customerDescription = '';
            if ($filterCustomer){
                $data = $this->customerModel->GetById($filterCustomer);
                $customerDescription = $data['document_number'] . ' ' . $data['social_reason'];
            }

            $saleDescription = '';
            if ($filterSaleSearch){
                $data = $this->saleModel->GetById($filterSaleSearch);
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
                    'invoice_id' => $filterSaleSearch,
                    'description' => $saleDescription,
                ]
            ];

            $parameter['sale'] = $this->saleModel->Paginate(
                $page,
                10,
                [
                    'documentCode' => $filterDocumentCode,
                    'customerID' => $filterCustomer,
                    'startDate' => $filterStartDate,
                    'endDate' => $filterEndDate,
                    'invoiceSearch' => $filterSaleSearch,
                ]
            );
            $parameter['documentTypeCode'] = $documentTypeCode;

            $content = requireToVar(VIEW_PATH . "User/Invoice.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function GeneratePdf(array $documentData ) {
        $business = $documentData['business'];
        $sale =  $documentData['sale'];
        $detailSale =  $documentData['detailSale'];

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

        $invoice['customerDocumentNumber'] = $sale['customer_document_number'];
        $invoice['customerDocumentCode'] = $sale['customer_document_number'];
        $invoice['customerSocialReason'] = $sale['customer_social_reason'];
        $invoice['customerFiscalAddress'] = $sale['customer_fiscal_address'];
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

        $invoice['perceptionCode'] = $sale['perception_code'];
        $invoice['perceptionPercentage'] = $sale['perception_percentage'];
        $invoice['perceptionAmount'] = $sale['perception_amount'];
        $invoice['perceptionBase'] = $sale['perception_base'];
        $invoice['totalWithPerception'] = $sale['total_with_perception'];

        $invoice['guide'] = json_decode($sale['guide'],true);
        $invoice['itemList'] = [];

        // Detraction
        $invoice['detractionCode'] = $sale['detraction_code'];
        $invoice['detractionPercentage'] = $sale['detraction_percentage'];
        $invoice['detractionAmount'] = $sale['detraction_amount'];

        $invoice['detractionLocationStartPoint'] = "{$sale['detraction_location_starting_code']} - {$sale['detraction_address_starting_point']}";
        $invoice['detractionLocationEndPoint'] = "{$sale['detraction_location_arrival_code']} - {$sale['detraction_address_arrival_point']}";
        $invoice['detractionReferralValue'] = $sale['detraction_referral_value'];
        $invoice['detractionEffectiveLoad'] = $sale['detraction_effective_load'];
        $invoice['detractionUsefulLoad'] = $sale['detraction_useful_load'];
        $invoice['detractionTravelDetail'] = $sale['detraction_travel_detail'];

        $invoice['detractionBoatRegistration'] = $sale['detraction_boat_registration'];
        $invoice['detractionBoatName'] = $sale['detraction_boat_name'];
        $invoice['detractionSpeciesKind'] = $sale['detraction_species_kind'];
        $invoice['detractionDeliveryAddress'] = $sale['detraction_delivery_address'];
        $invoice['detractionQuantity'] = $sale['detraction_quantity'];
        $invoice['detractionDeliveryDate'] = $sale['detraction_delivery_date'];

        // Referral guide
        $invoice['whitGuide'] = $sale['whit_guide'];
        $invoice['transferCode'] = $sale['transfer_code'];
        $invoice['transportCode'] = $sale['transport_code'];
        $invoice['totalGrossWeight'] = $sale['total_gross_weight'];
        $invoice['carrierDenomination'] = "{$sale['carrier_document_code']} - {$sale['carrier_document_number']} - {$sale['carrier_denomination']}";
        $invoice['carrierPlateNumber'] = $sale['carrier_plate_number'];
        $invoice['driverDenomination'] = "{$sale['driver_document_code']} - {$sale['driver_document_number']} - {$sale['driver_full_name']}";
        $invoice['locationEndPoint'] = "{$sale['location_arrival_code']} - {$sale['address_arrival_point']}";
        $invoice['locationStartPoint'] = "{$sale['location_starting_code']} - {$sale['address_starting_point']}";

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
        $resPdf = $documentManager->Invoice($invoice,$sale['pdf_format'] !== '' ? $sale['pdf_format'] : 'A4',$_SESSION[ENVIRONMENT]);

        if ($resPdf->success){
            $this->saleModel->UpdateInvoiceSunatByInvoiceId($sale['invoice_id'],[
                'pdf_url'=> '..' . $resPdf->pdfPath
            ]);
        }
        return $resPdf;
    }

    private function GenerateXML(array $documentData) {
        $business = $documentData['business'];
        $sale =  $documentData['sale'];
        $detailSale =  $documentData['detailSale'];

        $detailSale = array_map(function ($item) use ($sale, $business){
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
                $percentageIgv = $sale['percentage_igv'];
            }

            // Total base igv
            if ($ac == '11' || $ac == '12' || $ac == '13' || $ac == '14' || $ac == '15' || $ac == '16'){
                $percentageIgvDecimal = $sale['percentage_igv'] / 100;
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
        },$detailSale);

        // recalculate total
        $sale['total_discount_base'] = 0;
        $sale['total_discount_percentage'] = 0;
        if($sale['total_discount'] > 0){
//            $sale['total_discount_base'] = $sale['total_value'] + $sale['total_discount'];
            $sale['total_discount_base'] = $sale['total_value'];
            $sale['total_discount_percentage'] = ($sale['total_discount'] * 100 ) / ($sale['total_value'] + $sale['total_discount']);
        }
        $sale['guide'] = json_decode($sale['guide'],true);
        $sale['legend'] = json_decode($sale['legend'],true);
        $sale['related'] = json_decode($sale['related'],true);

        // Prepare Invoice
        $invoice['serie'] = $sale['serie'];
        $invoice['number'] = $sale['correlative'];
        $invoice['issueDate'] = $sale['date_of_issue'];
        $invoice['issueTime'] = $sale['time_of_issue'];
        $invoice['invoiceTypeCode'] = $sale['document_code'];
        $invoice['amounInWord'] = NumberFunction::StringFormat((int)$sale['total']) . ' ' .$sale['currency_type_code_description'];
        $invoice['supplierRuc'] = $business['ruc'];
        $invoice['defaultUrl'] = 'WWW.SKYFACT.COM';
        $invoice['supplierName'] = htmlspecialchars($business['social_reason']);
        $invoice['supplierDocumentType'] = '6';					// TIPO DE DOCUMENTO EMISOR
        $invoice['customerDocumentType'] = $sale['customer_identity_document_code'];					// TIPO DE DOCUMENTO CLIENTE
        $invoice['customerDocument'] = $sale['customer_document_number'];			// DOCUMENTO DEL CLIENTE
        $invoice['customerName'] = htmlspecialchars($sale['customer_social_reason']);
        $invoice['totalTaxAmount'] = RoundCurrency($sale['total_tax']);					// TOTAL DE IMPUESTOS
        $invoice['totalBaseAmount'] = RoundCurrency($sale['total_value']);					// VALOR TOTAL DE LA VENTA
        $invoice['totalSaleAmount'] = RoundCurrency($sale['total']);					// VALOR TOTAL DE LA VENTA + IMPUESTOS
        $invoice['totalDiscountAmount'] = RoundCurrency($sale['total_discount']);				// VALOR TOTAL DE LOS DESCUENTOS
        $invoice['totalExtraChargeAmount'] = RoundCurrency($sale['total_charge']);			// VALOR TOTAL DE LOS CARGOS EXTRA
        $invoice['totalPrepaidAmount'] = RoundCurrency($sale['total_prepayment']);				// VALOR TOTAL DE LOS MONTOS PAGADOS COMO ADELANTO
        $invoice['totalPayableAmount'] = RoundCurrency($sale['total']);				// MONTO TOTAL QUE SE COBRA

        $invoice['totalIgvAmount'] = RoundCurrency($sale['total_igv']);					// VALOR TOTAL DEL IGV
        $invoice['totalIgvTaxableAmount'] = RoundCurrency($sale['total_taxed']);			// VALOR TOTAL DE LA VENTA GRABADA
        $invoice['totalIscAmount'] = RoundCurrency($sale['total_isc']);				// VALOR TOTAL DEL ISC
        $invoice['totalIscTaxableAmount'] = '0.00';				// VALOR TOTAL AL CUAL SE APLICA EL ISC.
        $invoice['totalFreeAmount'] = RoundCurrency($sale['total_free']);				// VALOR TOTAL INAFECTO A INPUESTOS
        $invoice['totalExoneratedAmount'] = RoundCurrency($sale['total_exonerated']);				// VALOR TOTAL INAFECTO A INPUESTOS
        $invoice['totalInafectedAmount'] = RoundCurrency($sale['total_unaffected']);				// VALOR TOTAL INAFECTO A INPUESTOS
        $invoice['totalOtherTaxAmount'] = RoundCurrency($sale['total_other_taxed']);				// VALOR TOTAL DE otros impuestos
        $invoice['totalOtherTaxableAmount'] = RoundCurrency($sale['total_base_other_taxed']);				// VALOR TOTAL AL CUAL SE APLICA otros impuestos.

        $invoice['totalBagTaxAmount'] = RoundCurrency($sale['total_plastic_bag_tax']);	// total			    // VALOR TOTAL del impuesto a las bolsas
        $invoice['bagTaxAmountPerUnit'] = RoundCurrency($sale['percentage_plastic_bag_tax']); // percentage				// VALOR TOTAL del impuesto a las bolsas
        $invoice['operationTypeCode'] = $sale['operation_code'];				// Codigo del tipo de operacion (Venta interna : 0101 - Exportacion : 0102  Catalogo 25)
//        $invoice['operationTypeCode'] = '0401';				// Codigo del tipo de operacion (Venta interna : 0101 - Exportacion : 0102  Catalogo 25)

        $invoice['globalDiscountPercent'] = RoundCurrency($sale['total_discount_percentage'] / 100,5);				// DESCUENTO EN PORCENTAJE
        $invoice['bagTaxAmount'] = '1.00';							// CODIGO DE LA MONEDA
        $invoice['globalDiscountAmount'] = RoundCurrency($sale['total_discount']);				// VALOR TOTAL DE LOS DESCUENTOS                            // ---------------- Cambiar la variable  -- total_discount_base
        $invoice['codigoMoneda'] = $sale['currency_code'];							// CODIGO DE LA MONEDA
        $invoice['amazoniaGoods'] = array_search('2001', $sale['legend']) !== false ? 1 : 0;							// BIENES EN LA AMAZONIA
        $invoice['amazoniaService'] = array_search('2002', $sale['legend']) !== false ? 1 : 0;						// SERVICIOS EN LA AMAZONIA
        $invoice['orderReference'] = $sale['purchase_order'];							// Referencia de la orden de compra o servicio

        //REFERENCIA A GUIAS DE REMISION
        $invoice['referenceDocumentList'] = array();
        foreach ($sale['guide'] as $row){
            $referencedDocument = array();
            $referencedDocument['referencedDocument'] = $row['serie'];							// SERIE Y NUMERO DEL DOCUMENTO
            $referencedDocument['referencedDocumentTypeCode'] = $row['document_code'];						// TIPO DOCUMENTO CAT 01
            array_push($invoice['referenceDocumentList'], $referencedDocument);
        }
        $invoice['itemList'] = array();

        //PERCEPCION
        $invoice['totalAmountWithPerception'] = $sale['total_with_perception'];						// MONTO TOTAL DE LA VENTA MAS LA PERCEPCION
        $invoice['perceptionTypeCode'] = $sale['perception_code'];								// CODIGO DEL TIPO DE PERCEPCION CAT 53
        $invoice['perceptionPercent'] = $sale['perception_percentage'];								// MONTO TOTAL DE LA VENTA MAS LA PERCEPCION
        $invoice['perceptionAmount'] = $sale['perception_amount'];									// MONTO DE LA PERCEPCION
        $invoice['perceptionTaxableAmount'] = $sale['perception_base'];						// MONTO SOBRE EL CUAL SE CALCULA LA PERCEPCION

        //DETRACCION
//        $invoice['detractionAccount'] = $sale['detraction_bill'];						        // CODIGO DEL TIPO DE PERCEPCION CAT 53
        $invoice['detractionAccount'] = $business['detraction_bank_account'];						        // CODIGO DEL TIPO DE PERCEPCION CAT 53
        $invoice['detractionTypeCode'] = $sale['detraction_code'];								// CODIGO DEL TIPO DE PERCEPCION CAT 53
        $invoice['detractionPercent'] = $sale['detraction_percentage'];								// MONTO TOTAL DE LA VENTA MAS LA PERCEPCION
        $invoice['detractionAmount'] = $sale['detraction_amount'];									// MONTO DE LA PERCEPCION

        //DETRACCION - HIDROBIOLOGICO
        $invoice['boatLicensePlate'] = $sale['detraction_boat_registration'];						// placa de la embarcacion
        $invoice['boatName'] = $sale['detraction_boat_name'];						// placa de la embarcacion

        //DETRACCION - TRANSPORTE DE CARGA
        $invoice['despatchDetail'] = htmlspecialchars($sale['detraction_travel_detail']);						        // detalle del despacho
        $invoice['deliveryAdressCode'] = $sale['detraction_location_arrival_code'];					// UBIGEO DE DESTINO
        $invoice['deliveryAdress'] = $sale['detraction_address_arrival_point'];						// DIRECCION DESTINO
        $invoice['originAdressCode'] = $sale['detraction_location_starting_code'];					// UBIGEO DE ORIGEN
        $invoice['originAdress'] = $sale['detraction_address_starting_point'];						// DIRECCION ORIGEN

        //REGULACION PAGOS POR ADELANTADO				REGLA:		totalPrepaidAmount = sumatoria items prepaidPaymentList
        $invoice['prepaidPaymentList'] = array();
        foreach ($detailSale as $row){
            if ($row['prepayment_regulation']){
                $item = array();
                $item['documentSerieNumber'] = $row['prepayment_serie'] . '-' . $row['prepayment_correlative'];				// serie y numero del documento del anticipo
                $item['documentTypeCode'] = '02';						// codigo del tipo de documento CAT 12 (02 o 03)
                $item['prepaidAmount'] = $row['total_value'];						// monto del anticipo
                array_push($invoice['prepaidPaymentList'], $item);
            }
        }

        //FACTURA - GUIA 								REGLA: referalGuideIncluded = 1
        $invoice['referalGuideIncluded'] = $sale['transfer_code'] == '' ? 0 : 1;
        $invoice['transferReasonCode'] = $sale['transfer_code'];						// CODIGO DEL Motivo de Traslado CAT 20
        $invoice['grossWeightMeasure'] = 'KGM';						// UNIDAD DE MEDIDA DEL PESO TOTAL DEL ENVIO CAT 03(KGM = Kilogramo)
        $invoice['grossWeight'] = $sale['total_gross_weight'];							// PESO
        $invoice['transferMethodCode'] = $sale['transport_code'];						// CODIGO DEL METODO DE TRANSPORTE CAT 18
        $invoice['carrierDocumentType'] = $sale['carrier_document_code'];						// TIPO DE DOCUMENTO DEL TRANSPORTISTA
        $invoice['carrierRuc'] = $sale['carrier_document_number'];						// NUMERO DE DOCUMENTO DEL TRANSPORTISTA
        $invoice['carrierName'] = htmlspecialchars($sale['carrier_denomination']);					// NOMBRE DEL TRANSPORTISTA
        $invoice['licensePlate'] = $sale['carrier_plate_number'];						// PLACA DEL VEHICULO
        $invoice['driverDocumentType'] = $sale['driver_document_code'];						// TIPO DE DOCUMENTO DEL CONDUCTOR
        $invoice['driverDocument'] = $sale['driver_document_number'];						// NUMERO DE DOCUMENTO DEL CONDUCTOR

        //FACTURA - EMISOR ITINERANTE
        $invoice['itinerantSuplier'] = $sale['itinerant_enable'];							// 1/0 VENDEODR ITINERANTO = 1
        $invoice['itinerantAddressCode'] = $sale['itinerant_location'];							// VENTA ITINERANTE - UBIGEO
        $invoice['itinerantAddress'] = $sale['itinerant_address'];							// VENTA ITINERANTE - DIRECCION
        $invoice['itinerantUrbanization'] = $sale['itinerant_urbanization'];							//VENTA ITINERANTE - URBANIZACION
        $invoice['itinerantProvince'] = $sale['itinerant_province'];							// VENTA ITINERANTE - PROVINCIA
        $invoice['itinerantRegion'] = $sale['itinerant_department'];							// VENTA ITINERANTE - REGION O DEPARTAMENTO
        $invoice['itinerantDistrict'] = $sale['itinerant_district'];							// VENTA ITINERANTE - DISTRITO

        if (!$sale['whit_detraction']){
            $invoice['deliveryAdressCode'] = $sale['location_arrival_code'];					// UBIGEO DE DESTINO
            $invoice['deliveryAdress'] = $sale['address_arrival_point'];						// DIRECCION DESTINO
            $invoice['originAdressCode'] = $sale['location_starting_code'];						// UBIGEO DE ORIGEN
            $invoice['originAdress'] = $sale['address_starting_point'];							// DIRECCION ORIGEN
        }

        foreach ($detailSale as $row){
            if (!$row['prepayment_regulation']){
                $item = array();
                $item['itemUnitCode'] = $row['unit_measure'];			            // CODIGO UNIDAD
                $item['itemCuantity'] = $row['quantity'];							            // CANTIDAD
                $item['itemFinalBaseAmount'] = RoundCurrency($row['total_value']);					            // VALOR TOTAL DEL ITEM (CANTIDAD POR PRECIO UNITARIO menos descuentos)

                $item['itemTotalBaseAmount'] = RoundCurrency($row['discount_base']);		// base			    // VALOR TOTAL DEL ITEM (CANTIDAD POR PRECIO UNITARIO)
                $item['itemDiscountAmount'] = RoundCurrency($row['discount']);					                // Monto del descuento
                $item['itemDiscountPercent'] = RoundCurrency($row['discount_percentage']);                     // Porcentaje del descuento

                $item['singleItemPrice'] = RoundCurrency($row['unit_price']);					                // VALOR
                $item['onerous'] = $row['affectation_onerous'];								                    // 1 = OPERACION ONEROSA | 2 = OPERACION NO ONEROSA
                $item['itemTotalTaxAmount'] = RoundCurrency($row['total_taxed']);					            // VALOR TOTAL DE IMPUESTOS DEL ITEM
                $item['itemIgvTaxableAmount'] = RoundCurrency($row['total_base_igv']);					        // VALOR en base AL CUAL SE CALCULA EL IGV
                $item['itemTotalIgvAmount'] = RoundCurrency($row['igv']);					                    // VALOR TOTAL DE IGV CORRESPONDIENTE AL ITEM
                $item['itemTaxPercent'] = RoundCurrency($row['percentage_igv']);						        // PORCENTAJE EN BASE AL CUAL SE ESTA CALCULANDO EL IMPUESTO
                $item['itemIgvTaxCode'] = $row['affectation_code'];							                    // CODIGO DE TIPO DE IGV
                $item['itemTaxCode'] = $row['affectation_tribute_code'];					                    // CODIGO DE IMPUESTO
                $item['itemTaxName'] = $row['affectation_name'];							                    // NOMBRE DE IMPUESTO
                $item['itemTaxNamecode'] = $row['affectation_international_code'];			                    // CODIGO DEL NOMBRE DE IMPUESTO
                $item['itemDescription'] = htmlspecialchars($row['description']);                                   // DESCRIPCION DEL ITEM
                $item['ItemClassificationCode'] = $row['product_code'];			                                // CODGIO DE TIPO DE PRODUCTO
                $item['singleItemBasePrice'] = RoundCurrency($row['unit_value']);				                // VALOR BASE DEL ITEM (SIN IMPUESTOS)
                $item['itemBagCuantity'] = (int)$row['quantity_plastic_bag'];							        // CANTIDAD DE BOLSAS PARA EL ITEM
    //            $item['bagTaxAmount'] = $row['plastic_bag_tax'];							        // CANTIDAD DE BOLSAS PARA EL ITEM

                $item['itemIscAmount'] = RoundCurrency($row['isc']);							                // CANTIDAD DE BOLSAS PARA EL ITEM
                $item['itemIscTaxableAmount'] = RoundCurrency($row['total_base_isc']);						    // CANTIDAD DE BOLSAS PARA EL ITEM
                $item['itemIscTaxPercent'] = RoundCurrency($row['tax_isc']);							        // CANTIDAD DE BOLSAS PARA EL ITEM
                $item['itemIscSystemType'] = $row['system_isc_code'];							// CATALOGO 08 sistema de calculo del Isc

                if ($sale['whit_detraction']){
                    //DETRACCION - HIDROBIOLOGICO
                    $item['transportReferencialAmount'] = $sale['detraction_referral_value'];						// Valor referencial del servicio de transporte
                    $item['effectiveLoadReferencialAmount'] = $sale['detraction_effective_load'];					// Valor referencial sobre la carga efectiva
                    $item['payLoadReferencialAmount'] = $sale['detraction_useful_load'];						// Valor referencial sobre la carga útil nominal

                    //DETRACCION - TRANSPORTE DE CARGA
                    $item['speciesKind'] = $sale['detraction_species_kind'];								// tipo de ESPECIE
                    $item['deliveryAddress'] = $sale['detraction_delivery_address'];			// DIRECCION ENTREGA
                    $item['deliveryDate'] = $sale['detraction_delivery_date'];						// FECHA ENTREGA
                    $item['quantity'] = $sale['detraction_quantity'];
                } else {
                    //DETRACCION - HIDROBIOLOGICO
                    $item['transportReferencialAmount'] = 0;						// Valor referencial del servicio de transporte
                    $item['effectiveLoadReferencialAmount'] = 0;					// Valor referencial sobre la carga efectiva
                    $item['payLoadReferencialAmount'] = 0;						// Valor referencial sobre la carga útil nominal

                    //DETRACCION - TRANSPORTE DE CARGA
                    $item['speciesKind'] = '';								// tipo de ESPECIE
                    $item['deliveryAddress'] = '';			// DIRECCION ENTREGA
                    $item['deliveryDate'] = '';						// FECHA ENTREGA
                    $item['quantity'] = 0;
                }

                array_push($invoice['itemList'], $item);
            }
        }

        $billingManager = new BillingManager($this->connection);
        $directoryXmlPath = '..' . XML_FOLDER_PATH . date('Ym') . '/' . $business['ruc'] . '/';
        $fileName = $business['ruc'] . '-' . $sale['document_code'] . '-' . $sale['serie'] . '-' . $sale['correlative'] . '.xml';

        $res = new Result();
        $res->digestValue = '';

//        if ($sale['document_code'] === '01'){
            $resInvoice = $billingManager->SendInvoice($sale['invoice_id'], $invoice, $_SESSION[SESS]);
            if ($resInvoice->success){
                $this->saleModel->UpdateInvoiceSunatByInvoiceId($sale['invoice_id'],[
                    'xml_url' => $directoryXmlPath . $fileName,
                    'invoice_state_id' => 2,
                ]);
                $res->digestValue = $resInvoice->digestValue;
                $res->success = true;
            }else{
//                $this->saleModel->UpdateInvoiceSunatByInvoiceId($sale['invoice_id'],[
//                    'other_message' => $resInvoice->errorMessage,
//                ]);
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
                $this->saleModel->UpdateInvoiceSunatByInvoiceId($sale['invoice_id'],[
                    'cdr_url' => $directoryXmlPath . 'R-' . $fileName,
                    'invoice_state_id' => 3,
                    'response_message' => '',
                ]);
                $res->success = true;
            } else {
                $res->errorMessage .= $resInvoice->readerError;
                $res->success = false;
            }
//        }elseif ($sale['document_code'] === '03'){
//            $resInvoice = $billingManager->SaveTicketInvoice($sale['invoice_id'], $invoice, $_SESSION[SESS]);
//
//            if ($resInvoice->success){
//                $this->saleModel->UpdateInvoiceSunatByInvoiceId($sale['invoice_id'],[
//                    'xml_url' => $directoryXmlPath . $fileName,
//                    'invoice_state_id' => 2,
//                ]);
//                $res->digestValue = $resInvoice->digestValue;
//                $res->success = true;
//            }else{
//                $res->errorMessage .= $resInvoice->errorMessage;
//                $res->success = false;
//            }
//        }

        return $res;
    }

    private function BuildDocument($saleId){
        $res = new Result();
        $res->saleId = 0;

        try{
            $business = $this->businessModel->GetByUserId($_SESSION[SESS]);
            $sale = $this->saleModel->summaryById($saleId);
            $detailSale = $this->detailSaleModel->ByInvoiceIdXML($saleId);

            $perceptionTypeCodeModel = new CatPerceptionTypeCode($this->connection);
            $perceptionTypeCode = $perceptionTypeCodeModel->GetAll();

            if ($sale['invoice_state_id'] == '3'){
                throw new Exception('Este documento ya fue informado ante la sunat');
            } elseif (($sale['invoice_state_id'] == '4' && $sale['document_code'] == '01')){
                throw new Exception('Este documento esta anulado');
            }

            // PERCEPTION
            $perceptionCode = $sale['perception_code'];
            $perceptionPercentage = 0;
            $perceptionAmount = 0;
            $perceptionBase = 0;
            $totalWithPerception = 0;
            if ($sale['perception_code'] != ''){
                $index = array_search($perceptionCode, array_column($perceptionTypeCode, 'code'));
                $perceptionPercentage = $perceptionTypeCode[$index]['percentage'] / 100;
                $perceptionAmount = RoundCurrency($perceptionPercentage  * $sale['total']);
                $perceptionBase = $sale['total'];
                $totalWithPerception = $sale['total'] + $perceptionAmount;
            }
            $sale['perception_code'] = '51';
            $sale['perception_percentage'] = $perceptionPercentage;
            $sale['perception_amount'] = $perceptionAmount;
            $sale['perception_base'] = $perceptionBase;
            $sale['total_with_perception'] = $totalWithPerception;

            // Itinerant
            if ($sale['itinerant_enable']){
                $geographicalLocationCodeModel = new CatGeographicalLocationCode($this->connection);
                $itinerantLocation = $geographicalLocationCodeModel->GetBy('code',$sale['itinerant_location']);
                $itinerantProvince = $itinerantLocation['province'];
                $itinerantDepartment = $itinerantLocation['department'];
                $itinerantDistrict = $itinerantLocation['district'];
            }
            $sale['itinerant_province'] = $itinerantProvince ?? '';
            $sale['itinerant_department'] = $itinerantDepartment ?? '';
            $sale['itinerant_district'] = $itinerantDistrict ?? '';

            // XML
            $documentData = [
                'sale' => $sale,
                'detailSale' => $detailSale,
                'business' => $business,
            ];
            $resXml = $this->GenerateXML($documentData);
            $res->errorMessage = $resXml->errorMessage;
            $res->success = $resXml->success;
            if (!$resXml->success){
                $this->saleModel->UpdateInvoiceSunatByInvoiceId($saleId,[
                    'other_message' =>  $resXml->errorMessage,
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
            $saleId = $_GET['SaleId'] ?? 0;
            if(!$saleId){
                header('Location: ' . FOLDER_NAME . '/Invoice');
            }

            $resRunDoc = $this->BuildDocument($saleId);
            if ($resRunDoc->success){
                header('Location: ' . FOLDER_NAME . '/Invoice/View?SaleId=' . $saleId . '&message=' . 'El documento se guardó y se envió a la SUNAT exitosamente' . '&messageType=success');
            } else {
                header('Location: ' . FOLDER_NAME . '/Invoice/View?SaleId=' . $saleId . '&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function JsonSearch(){
        $search = $_POST['q'] ?? '';

        $saleModel = new Invoice($this->connection);
        $data = $saleModel->searchBySerieCorrelative($search);

        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function NewInvoice(){
        try{
            $error = [];
            $message = "";
            $messageType = "";
            $invoice = $_POST['invoice'] ?? [];

            if (isset($_POST['commit'])){
                try{
                    if (empty($invoice)){
                        throw new Exception('No hay ningun campo');
                    }

                    $jungleProduct = ($invoice['jungle_product'] ?? 0) === 'on' ? true : false;
                    $jungleService = ($invoice['jungle_service'] ?? 0) === 'on' ? true : false;
                    $detraction = ($invoice['detraction'] ?? 0) === 'on' ? true : false;

                    $legend = [];
                    if ($jungleProduct){
                        array_push($legend,2001);
                    }
                    if ($jungleService){
                        array_push($legend,2002);
                    }
                    if ($detraction){
                        array_push($legend,2006);
                    }

                    $invoice['percentage_igv'] = 18.00;
                    $invoice['legend'] = $legend;
                    $invoice['total_value'] = $invoice['total_unaffected'] + $invoice['total_taxed'] + $invoice['total_exonerated'];

                    $customer = $this->customerModel->GetById($invoice['customer_id']);
                    $invoice['customer']['document_number'] = $customer['document_number'];
                    $invoice['customer']['identity_document_code'] = $customer['identity_document_code'];
                    $invoice['customer']['social_reason'] = $customer['social_reason'];
                    $invoice['customer']['fiscal_address'] = $customer['fiscal_address'];
                    $invoice['customer']['email'] = $customer['main_email'];
                    $invoice['customer']['telephone'] = $customer['telephone'];

                    $invoice['itinerant_enable'] = ($invoice['itinerant_enable'] ?? false) == 'on' ? 1 : 0;
                    $invoice['prepayment_regulation'] = ($invoice['prepayment_regulation'] ?? false) == 'on' ? 1 : 0;

                    $invoice['guide_array'] = [];
                    if (isset($invoice['guide'])){
                        foreach ($invoice['guide'] as $key => $value){
                            array_push($invoice['guide_array'],$value);
                        }
                    }

//                    $validateInput = $this->ValidateInput($invoice);
//                    $error = $validateInput->error;
//                    if (!$validateInput->success){
//                        throw new Exception($validateInput->errorMessage);
//                    }
                    $saleId = $this->saleModel->Insert($invoice, $_SESSION[SESS], $_COOKIE['CurrentBusinessLocal']);

                       $resRunDoc = $this->BuildDocument($saleId);
                       if ($saleId >= 1 && $resRunDoc->success){
                           header('Location: ' . FOLDER_NAME . '/Invoice/View?SaleId=' . $saleId . '&message=' . urlencode('El documento se guardó y se envió a la SUNAT exitosamente') . '&messageType=success');
                       } else {
                           header('Location: ' . FOLDER_NAME . '/Invoice/View?SaleId=' . $saleId . '&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
                       }
                    return;
                }catch (Exception $exception){
                    $message = $exception->getMessage();
                    $messageType = 'danger';
                    if ((int)$invoice['customer_id']){
                        $customer = $this->customerModel->GetById($invoice['customer_id']);
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
            $perceptionTypeCodeModel = new CatPerceptionTypeCode($this->connection);
            $transferReasonCodeModel = new CatTransferReasonCode($this->connection);
            $transportModeCodeModel = new CatTransportModeCode($this->connection);
            $subjectDetractionCode = new CatSubjectDetractionCode($this->connection);

            $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->GetAll();
            $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();
            $parameter['documentTypeCode'] = $documentTypeCodeModel->GetBy('code','01');
            $parameter['currencyTypeCode'] = $currencyTypeCodeModel->getAll();
            $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->getAll();
            $parameter['operationTypeCode'] = $operationTypeCodeModel->getAll();
            $parameter['perceptionTypeCode'] = $perceptionTypeCodeModel->getAll();
            $parameter['transferReasonCode'] = $transferReasonCodeModel->getAll();
            $parameter['transportModeCode'] = $transportModeCodeModel->getAll();
            $parameter['subjectDetractionCode'] = $subjectDetractionCode->getAll();
            $parameter['business'] = $this->businessModel->GetByUserId($_SESSION[SESS]);

            $documentCorrelativeModel = new BusinessSerie($this->connection);
            $correlative = $documentCorrelativeModel->GetNextCorrelative([
                'localId' => $_COOKIE['CurrentBusinessLocal'],
                'documentCode' => '01',
            ]);

            $parameter['correlative'] = $correlative['correlative'] + 1;
            $parameter['correlativePrefix'] = $correlative['serie'];
            $parameter['invoice'] = $invoice;
            $parameter['error'] = $error;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;
            $parameter['itemTemplate'] = InvoiceTemplate::Item($parameter['business'],$parameter['affectationIgvTypeCode']);
            $parameter['referralGuideTemplate'] = $this->GetReferralGuideTemplate();

            $content = requireToVar(VIEW_PATH . "User/SaleInvoice.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function NewTicket(){
        try{
            $message = "";
            $error = [];
            $invoice = $_POST['invoice'] ?? [];

            if (isset($_POST['commit'])){
                try{
                    if (empty($invoice)){
                        throw new Exception('No hay ningun campo');
                    }

                    $jungleProduct = ($invoice['jungle_product'] ?? 0) === 'on' ? true : false;
                    $jungleService = ($invoice['jungle_service'] ?? 0) === 'on' ? true : false;
                    $detraction = ($invoice['detraction'] ?? 0) === 'on' ? true : false;

                    $legend = [];
                    if ($jungleProduct){
                        array_push($legend,2001);
                    }
                    if ($jungleService){
                        array_push($legend,2002);
                    }
                    if ($detraction){
                        array_push($legend,2006);
                    }

                    $invoice['percentage_igv'] = 18.00;
                    $invoice['legend'] = $legend;
                    $invoice['total_value'] = $invoice['total_unaffected'] + $invoice['total_taxed'] + $invoice['total_exonerated'];

                    $validateInput = $this->ValidateInput($invoice);
                    $error = $validateInput->error;
                    if (!$validateInput->success){
                        throw new Exception($validateInput->errorMessage);
                    }

                    $saleId = $this->saleModel->Insert($invoice);

                    $resRunDoc = $this->BuildDocument($saleId);

                   if ($saleId >= 1 && $resRunDoc->success){
                       header('Location: ' . FOLDER_NAME . '/Invoice/View?SaleId=' . $saleId . '&message=' . urlencode('El documento se guardó y se envió a la SUNAT exitosamente') . '&messageType=success');
                   } else {
                       header('Location: ' . FOLDER_NAME . '/Invoice/View?SaleId=' . $saleId . '&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
                   }
                   return;
                }catch (Exception $exception){
                    $message = $exception->getMessage();

                    if ((int)$invoice['customer_id']){
                        $customerModel = new Customer($this->connection);
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
            $perceptionTypeCodeModel = new CatPerceptionTypeCode($this->connection);

            $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->GetAll();
            $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();
            $parameter['documentTypeCode'] = $documentTypeCodeModel->GetBy('code','03');
            $parameter['currencyTypeCode'] = $currencyTypeCodeModel->getAll();
            $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->getAll();
            $parameter['operationTypeCode'] = $operationTypeCodeModel->getAll();
            $parameter['perceptionTypeCode'] = $perceptionTypeCodeModel->getAll();
            $parameter['business'] = $this->businessModel->GetByUserId($_SESSION[SESS]);

            $documentCorrelativeModel = new BusinessSerie($this->connection);
            $correlative = $documentCorrelativeModel->GetNextCorrelative([
                'localId' => $_COOKIE['CurrentBusinessLocal'],
                'documentCode' => '03',
            ]);

            $parameter['correlative'] = $correlative['correlative'] + 1;
            $parameter['correlativePrefix'] = $correlative['serie'];
            $parameter['invoice'] = $invoice;
            $parameter['error'] = $error;
            $parameter['message'] = $message;
            $parameter['itemTemplate'] = InvoiceTemplate::Item($parameter['business'],$parameter['affectationIgvTypeCode']);
            $parameter['referralGuideTemplate'] = $this->GetReferralGuideTemplate();

            $content = requireToVar(VIEW_PATH . "User/SaleTicket.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function View(){
        try{
            $saleId = $_GET['SaleId'] ?? 0;
            if(!$saleId){
                return;
            }
            $message = $_GET['message'] ?? '';
            $messageType = $_GET['messageType'] ?? '';
            $messageType = ($messageType == 'success') ? 'success' : ($messageType == 'error' ? 'danger' : '');

            $invoice = $this->saleModel->summaryById($saleId);
            $parameter['detailSale'] = $this->detailSaleModel->ByInvoiceIdSummary($saleId);
            $parameter['invoice'] = $invoice;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;

            $content = requireToVar(VIEW_PATH . "User/SaleView.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function ValidateInput(array $invoice) {
        $invoiceValidate = new InvoiceValidate($invoice, $this->connection);
        return $invoiceValidate->getResult();
    }

    private function GetReferralGuideTemplate(){
        return '<tr id="referralGuideItem${uniqueId}">
            <td>
                <label for="type${uniqueId}">Tipo</label>
                <select class="form-control form-control-sm" id="type${uniqueId}" name="invoice[guide][${uniqueId}][document_code]" required>
                    <option value="09">GUÍA DE REMISIÓN REMITENTE</option>
                    <option value="31">GUÍA DE REMISIÓN TRANSPORTISTA</option>
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

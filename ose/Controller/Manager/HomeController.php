<?php
class HomeController
{

    protected $connection;
    private $HomeClass;

    public function __construct($connection)
    {
        $this->connection = $connection;
        //$this->HomeClass = new userClass($DbConection);
    }

   public function Exec()
   {
       $parameter[0]='';
       require_once(CONTROLLER_PATH."Helper/BillingManager.php");

       $billingManager = new BillingManager($this->connection);

       // FACTURA - BOLETA
	       $invoice = array();
	       $invoice['serie'] = 'FPP1';
	       $invoice['number'] = '1';
	       $invoice['issueDate'] = '2019-08-01';
	       $invoice['issueTime'] = date('H:i:s');
	       $invoice['invoiceTypeCode'] = '01';						// TIPO DE COMPROBANTE
	       $invoice['amounInWord'] = 'CIENTO VEINTI NUEVE CON 80/100 SOLES';
	       $invoice['supplierRuc'] = '20490086278';
	       $invoice['defaultUrl'] = 'WWW.SKYFACT.COM';
	       $invoice['supplierName'] = 'SKYNETCUSCO E.I.R.L.';
	       $invoice['supplierDocumentType'] = '6';					// TIPO DE DOCUMENTO EMISOR
	       $invoice['customerDocumentType'] = '6';					// TIPO DE DOCUMENTO CLIENTE
	       $invoice['customerDocument'] = '10044294554';			// DOCUMENTO DEL CLIENTE
	       $invoice['customerName'] = 'CHAVEZ CONDORI DANUUVIA LOURDES';
	       $invoice['totalTaxAmount'] = '29.80';					// TOTAL DE IMPUESTOS
	       $invoice['totalBaseAmount'] = '100.00';					// VALOR TOTAL DE LA VENTA
	       $invoice['totalSaleAmount'] = '129.80';					// VALOR TOTAL DE LA VENTA + IMPUESTOS
	       $invoice['totalDiscountAmount'] = '0.00';				// VALOR TOTAL DE LOS DESCUENTOS
	       $invoice['totalExtraChargeAmount'] = '0.00';			// VALOR TOTAL DE LOS CARGOS EXTRA
	       $invoice['totalPrepaidAmount'] = 50.00;				// VALOR TOTAL DE LOS MONTOS PAGADOS COMO ADELANTO
	       $invoice['totalPayableAmount'] = '129.80';				// MONTO TOTAL QUE SE COBRA
	       $invoice['totalIgvAmount'] = '19.80';					// VALOR TOTAL DEL IGV
	       $invoice['totalIgvTaxableAmount'] = '110.00';			// VALOR TOTAL DE LA VENTA GRABADA
	       $invoice['totalIscAmount'] = '10.00';				// VALOR TOTAL DEL ISC
	       $invoice['totalIscTaxableAmount'] = '100.00';				// VALOR TOTAL AL CUAL SE APLICA EL ISC.
	       $invoice['totalFreeAmount'] = '0.00';				// VALOR TOTAL INAFECTO A INPUESTOS
	       $invoice['totalExoneratedAmount'] = '0.00';				// VALOR TOTAL INAFECTO A INPUESTOS
	       $invoice['totalInafectedAmount'] = '0.00';				// VALOR TOTAL INAFECTO A INPUESTOS
	       $invoice['totalOtherTaxAmount'] = '0.00';				// VALOR TOTAL DE otros impuestos
	       $invoice['totalOtherTaxableAmount'] = '0.00';				// VALOR TOTAL AL CUAL SE APLICA otros impuestos.
	       $invoice['totalBagTaxAmount'] = '0.00';				// VALOR TOTAL del impuesto a las bolsas
	       $invoice['bagTaxAmountPerUnit'] = '0.00';				// VALOR TOTAL del impuesto a las bolsas
	       $invoice['operationTypeCode'] = '1004';				// Codigo del tipo de operacion (Venta interna : 0101 - Exportacion : 0102  Catalogo 25)
	       $invoice['bagTaxAmount'] = '1.00';				// Monto del impuesto a las bolsas
	       $invoice['globalDiscountAmount'] = '0.00';				// Monto del impuesto a las bolsas
		   $invoice['codigoMoneda'] = 'PEN';							// CODIGO DE LA MONEDA

	       // LEYENDAS												// 1 = con leyenda
	       $invoice['amazoniaGoods'] = 0;							// BIENES EN LA AMAZONIA
	       $invoice['amazoniaService'] = 0;						// SERVICIOS EN LA AMAZONIA
	       $invoice['orderReference'] = '';							// Referencia de la orden de compra o servicio

	       $invoice['itemList'] = array();
	       $item = array();
	       $item['itemUnitCode'] = 'NIU';							// CODIGO UNIDAD
	       $item['itemCuantity'] = '1.0';							// CANTIDAD
	       $item['itemFinalBaseAmount'] = '100.00';					// VALOR TOTAL DEL ITEM (CANTIDAD POR PRECIO UNITARIO menos descuentos)
	       $item['itemTotalBaseAmount'] = '100.00';					// VALOR TOTAL DEL ITEM (CANTIDAD POR PRECIO UNITARIO)
	       $item['itemDiscountAmount'] = '4.00';					// Monto del descuento
	       $item['itemDiscountPercent'] = '2.00';					// Porcentaje del descuento
	       $item['singleItemPrice'] = '129.80';					// VALOR
	       $item['onerous'] = 1;									// 1 = OPERACION ONEROSA | 2 = OPERACION NO ONEROSA
	       $item['itemTotalTaxAmount'] = '29.80';					// VALOR TOTAL DE IMPUESTOS DEL ITEM
	       $item['itemIgvTaxableAmount'] = '110.00';					// VALOR en base AL CUAL SE CALCULA EL IGV
	       $item['itemTotalIgvAmount'] = '19.80';					// VALOR TOTAL DE IGV CORRESPONDIENTE AL ITEM
	       $item['itemTaxPercent'] = '18.00';						// PORCENTAJE EN BASE AL CUAL SE ESTA CALCULANDO EL IMPUESTO
	       $item['itemIgvTaxCode'] = '10';							// CODIGO DE TIPO DE IGV
	       $item['itemTaxCode'] = '1000';							// CODIGO DE IMPUESTO
	       $item['itemTaxName'] = 'IGV';							// NOMBRE DE IMPUESTO
	       $item['itemTaxNamecode'] = 'VAT';						// CODIGO DEL NOMBRE DE IMPUESTO
	       $item['itemDescription'] = '08001 item exonerado';		// DESCRIPCION DEL ITEM
	       $item['ItemClassificationCode'] = '10000000';			// CODGIO DE TIPO DE PRODUCTO
	       $item['singleItemBasePrice'] = '100.00';				// VALOR BASE DEL ITEM (SIN IMPUESTOS)
	       $item['itemBagCuantity'] = 0;							// CANTIDAD DE BOLSAS PARA EL ITEM
	       $item['itemIscAmount'] = '10.00';							// CANTIDAD DE BOLSAS PARA EL ITEM
	       $item['itemIscTaxableAmount'] = '100.00';							// CANTIDAD DE BOLSAS PARA EL ITEM
	       $item['itemIscTaxPercent'] = '10.00';							// CANTIDAD DE BOLSAS PARA EL ITEM
	       $item['itemIscSystemType'] = '01';							// CATALOGO 08 sistema de calculo del Isc

	       //DETRACCION - HIDROBIOLOGICO
	       $item['transportReferencialAmount'] = 15.00;						// Valor referencial del servicio de transporte
	       $item['effectiveLoadReferencialAmount'] = 20.00;					// Valor referencial sobre la carga efectiva
	       $item['payLoadReferencialAmount'] = 25.00;						// Valor referencial sobre la carga útil nominal

	       //DETRACCION - TRANSPORTE DE CARGA
	       $item['speciesKind'] = 'PRUEBA';								// tipo de ESPECIE
	       $item['deliveryAddress'] = 'DIRECCION DE PRUEBA';			// DIRECCION ENTREGA
	       $item['deliveryDate'] = '2019-12-31';						// FECHA ENTREGA
	       $item['quantity'] = 1;

	       array_push($invoice['itemList'], $item);


	       //REFERENCIA A GUIAS DE REMISION
	       $invoice['referenceDocumentList'] = array();
	       $referencedDocument = array();
	       $referencedDocument['referencedDocument'] = '0001';							// SERIE Y NUMERO DEL DOCUMENTO
	       $referencedDocument['referencedDocumentTypeCode'] = '09';						// TIPO DOCUMENTO CAT 01
	       array_push($invoice['referenceDocumentList'], $referencedDocument);

	       //PERCEPCION
	       // $invoice['totalAmountWithPerception'] = 132.40;						// MONTO TOTAL DE LA VENTA MAS LA PERCEPCION
	       // $invoice['perceptionTypeCode'] = '51';								// CODIGO DEL TIPO DE PERCEPCION CAT 53
	       // $invoice['perceptionPercent'] = 0.02;								// MONTO TOTAL DE LA VENTA MAS LA PERCEPCION
	       // $invoice['perceptionTaxableAmount'] = 129.80;						// MONTO SOBRE EL CUAL SE CALCULA LA PERCEPCION
	        $invoice['perceptionAmount'] = 0;									// MONTO DE LA PERCEPCION

	       //DETRACCION 							REGLA:		perceptionAmount = 0
	       $invoice['detractionAccount'] = '1544279243878';						// CUENTA DE LA DETRACCION
	       $invoice['detractionTypeCode'] = '027';								// CODIGO DEL TIPO DE PERCEPCION CAT 54
	       $invoice['detractionPercent'] = 50;								// PORCENTAJE DE LA DETRACCION
	       $invoice['detractionAmount'] = 64.90;									// MONTO DE LA DETRACCION

	       //DETRACCION - HIDROBIOLOGICO
	       $invoice['boatLicensePlate'] = 'placa123';						// placa de la embarcacion
	       $invoice['boatName'] = 'placa123';						// placa de la embarcacion

	       //DETRACCION - TRANSPORTE DE CARGA
	       $invoice['despatchDetail'] = 'TRANSPORTE DE bienes';						// detalle del despacho
	       $invoice['deliveryAdressCode'] = '070101';					// UBIGEO DE DESTINO
	       $invoice['deliveryAdress'] = 'CUSCO';						// DIRECCION DESTINO
	       $invoice['originAdressCode'] = '070101';						// UBIGEO DE ORIGEN
	       $invoice['originAdress'] = 'CUSCO';							// DIRECCION ORIGEN


	       //REGULACION PAGOS POR ADELANTADO				REGLA:		totalPrepaidAmount = sumatoria items prepaidPaymentList
	       $invoice['prepaidPaymentList'] = array();
	       $item = array();
	       $item['documentSerieNumber'] = 'F001-123';				// serie y numero del documento del anticipo
	       $item['documentTypeCode'] = '02';						// codigo del tipo de documento CAT 12 (02 o 03)
	       $item['prepaidAmount'] = '50.00';						// monto del anticipo
	       array_push($invoice['prepaidPaymentList'], $item);

	       //FACTURA - GUIA 								REGLA: referalGuideIncluded = 1
	       $invoice['referalGuideIncluded'] = 1;
	       $invoice['transferReasonCode'] = '01';						// CODIGO DEL Motivo de Traslado CAT 20
	       $invoice['grossWeightMeasure'] = 'KGM';						// UNIDAD DE MEDIDA DEL PESO TOTAL DEL ENVIO CAT 03(KGM = Kilogramo)
	       $invoice['grossWeight'] = '10.0';							// PESO
	       $invoice['transferMethodCode'] = '01';						// CODIGO DEL METODO DE TRANSPORTE CAT 18
	       $invoice['carrierDocumentType'] = '6';						// TIPO DE DOCUMENTO DEL TRANSPORTISTA
	       $invoice['carrierRuc'] = '10451329575';						// NUMERO DE DOCUMENTO DEL TRANSPORTISTA
	       $invoice['carrierName'] = 'TRANPORTES S.A.';					// NOMBRE DEL TRANSPORTISTA
	       $invoice['licensePlate'] = 'X4C-539';						// PLACA DEL VEHICULO
	       $invoice['driverDocumentType'] = '1';						// TIPO DE DOCUMENTO DEL CONDUCTOR
	       $invoice['driverDocument'] = '45132957';						// NUMERO DE DOCUMENTO DEL CONDUCTOR
	       $invoice['deliveryAdressCode'] = '070101';					// UBIGEO DE DESTINO
	       $invoice['deliveryAdress'] = 'CUSCO';						// DIRECCION DESTINO
	       $invoice['originAdressCode'] = '070101';						// UBIGEO DE ORIGEN
	       $invoice['originAdress'] = 'CUSCO';							// DIRECCION ORIGEN

	       //FACTURA - EMISOR ITINERANTE
	       $invoice['itinerantSuplier'] = 1;							// 1/0 VENDEODR ITINERANTO = 1
	       $invoice['itinerantAddressCode'] = '070101';							// VENTA ITINERANTE - UBIGEO
	       $invoice['itinerantAddress'] = 'CUSCO 22';							// VENTA ITINERANTE - DIRECCION
	       $invoice['itinerantUrbanization'] = 'CUSCO';							//VENTA ITINERANTE - URBANIZACION
	       $invoice['itinerantProvince'] = 'CUSCO';							// VENTA ITINERANTE - PROVINCIA
	       $invoice['itinerantRegion'] = 'CUSCO';							// VENTA ITINERANTE - REGION O DEPARTAMENTO
	       $invoice['itinerantDistrict'] = 'CUSCO';							// VENTA ITINERANTE - DISTRITO

	       $res = $billingManager->SendInvoice(1, $invoice, 999);


	   // // NOTA DE CREDITO - DEBITO
		  //      $invoice = array();
		  //      $invoice['serie'] = 'FPP1';
		  //      $invoice['number'] = '1';
		  //      $invoice['issueDate'] = '2019-08-01';
		  //      $invoice['issueTime'] = '11:09:05';
		  //      $invoice['amounInWord'] = 'CIENTO VEINTI NUEVE CON 80/100 SOLES';

		  //      // $invoice['creditNoteTypeCode'] = '01';
		  //      // $invoice['creditNoteTypeDescription'] = 'Anulación de la operación';
		  //      $invoice['debitNoteTypeCode'] = '01';
		  //      $invoice['debitNoteTypeDescription'] = 'Anulación de la operación';

		  //      $invoice['supplierRuc'] = '20490086278';
		  //      $invoice['defaultUrl'] = 'WWW.SKYFACT.COM';
		  //      $invoice['supplierName'] = 'SKYNETCUSCO E.I.R.L.';
		  //      $invoice['supplierDocumentType'] = '6';					// TIPO DE DOCUMENTO EMISOR
		  //      $invoice['customerDocumentType'] = '6';					// TIPO DE DOCUMENTO CLIENTE
		  //      $invoice['customerDocument'] = '10044294554';			// DOCUMENTO DEL CLIENTE
		  //      $invoice['customerName'] = 'CHAVEZ CONDORI DANUUVIA LOURDES';
		  //      $invoice['totalTaxAmount'] = '29.80';					// TOTAL DE IMPUESTOS
		  //      $invoice['totalBaseAmount'] = '100.00';					// VALOR TOTAL DE LA VENTA
		  //      $invoice['totalSaleAmount'] = '129.80';					// VALOR TOTAL DE LA VENTA + IMPUESTOS
		  //      $invoice['totalDiscountAmount'] = '0.00';				// VALOR TOTAL DE LOS DESCUENTOS
		  //      $invoice['totalExtraChargeAmount'] = '0.00';			// VALOR TOTAL DE LOS CARGOS EXTRA
		  //      $invoice['totalPrepaidAmount'] = '0.00';				// VALOR TOTAL DE LOS MONTOS PAGADOS COMO ADELANTO
		  //      $invoice['totalPayableAmount'] = '129.80';				// MONTO TOTAL QUE SE COBRA

		  //      $invoice['totalIgvAmount'] = '19.80';					// VALOR TOTAL DEL IGV
		  //      $invoice['totalIgvTaxableAmount'] = '110.00';			// VALOR TOTAL DE LA VENTA GRABADA
		  //      $invoice['totalIscAmount'] = '10.00';				// VALOR TOTAL DEL ISC
		  //      $invoice['totalIscTaxableAmount'] = '100.00';				// VALOR TOTAL AL CUAL SE APLICA EL ISC.
		  //      $invoice['totalFreeAmount'] = '0.00';				// VALOR TOTAL INAFECTO A INPUESTOS
		  //      $invoice['totalExoneratedAmount'] = '0.00';				// VALOR TOTAL INAFECTO A INPUESTOS
		  //      $invoice['totalInafectedAmount'] = '0.00';				// VALOR TOTAL INAFECTO A INPUESTOS
		  //      $invoice['totalOtherTaxAmount'] = '0.00';				// VALOR TOTAL DE otros impuestos
		  //      $invoice['totalOtherTaxableAmount'] = '0.00';				// VALOR TOTAL AL CUAL SE APLICA otros impuestos.
		  //      $invoice['totalBagTaxAmount'] = '0.00';				// VALOR TOTAL del impuesto a las bolsas
		  //      $invoice['bagTaxAmountPerUnit'] = '0.00';				// VALOR TOTAL del impuesto a las bolsas
		  //      $invoice['bagTaxAmount'] = '0.00';				// Monto del impuesto a las bolsas
		  //      $invoice['globalDiscountAmount'] = '0.00';				// Monto del impuesto a las bolsas
		  //  	   $invoice['codigoMoneda'] = 'PEN';							// CODIGO DE LA MONEDA

		  //      $invoice['invoiceReferenceList'] = array();				//Array con la lista de facturas que afecta la nota de credito
		  //      $referencedInvoice = array();
		  //      $referencedInvoice['billingReferenceSerie'] = 'F001';				// Serie de la factura afectada
		  //      $referencedInvoice['billingReferenceNumber'] = '1';					// Numero de la factura afectada
		  //      $referencedInvoice['billingReferenceTypeCode'] = '01';				// Codigo del tipo de comprobante afectado | 01 para facturas
		  //      array_push($invoice['invoiceReferenceList'], $referencedInvoice);

		  //      $invoice['itemList'] = array();
		  //      $item = array();
		  //      $item['itemUnitCode'] = 'NIU';							// CODIGO UNIDAD
		  //      $item['itemCuantity'] = '1.0';							// CANTIDAD
		  //      $item['itemFinalBaseAmount'] = '100.00';					// VALOR TOTAL DEL ITEM (CANTIDAD POR PRECIO UNITARIO menos descuentos)
		  //      $item['itemTotalBaseAmount'] = '100.00';					// VALOR TOTAL DEL ITEM (CANTIDAD POR PRECIO UNITARIO)
		  //      $item['itemDiscountAmount'] = '0.00';					// Monto del descuento
		  //      $item['itemDiscountPercent'] = '0.00';					// Porcentaje del descuento
		  //      $item['singleItemPrice'] = '129.80';					// VALOR
		  //      $item['onerous'] = 1;									// 1 = OPERACION ONEROSA | 2 = OPERACION NO ONEROSA
		  //      $item['itemTotalTaxAmount'] = '29.80';					// VALOR TOTAL DE IMPUESTOS DEL ITEM
		  //      $item['itemIgvTaxableAmount'] = '110.00';					// VALOR en base AL CUAL SE CALCULA EL IGV
		  //      $item['itemTotalIgvAmount'] = '19.80';					// VALOR TOTAL DE IGV CORRESPONDIENTE AL ITEM
		  //      $item['itemTaxPercent'] = '18.00';						// PORCENTAJE EN BASE AL CUAL SE ESTA CALCULANDO EL IMPUESTO
		  //      $item['itemIgvTaxCode'] = '10';							// CODIGO DE TIPO DE IGV
		  //      $item['itemTaxCode'] = '1000';							// CODIGO DE IMPUESTO
		  //      $item['itemTaxName'] = 'IGV';							// NOMBRE DE IMPUESTO
		  //      $item['itemTaxNamecode'] = 'VAT';						// CODIGO DEL NOMBRE DE IMPUESTO
		  //      $item['itemDescription'] = '08001 item exonerado';		// DESCRIPCION DEL ITEM
		  //      $item['ItemClassificationCode'] = '10000000';			// CODGIO DE TIPO DE PRODUCTO
		  //      $item['singleItemBasePrice'] = '100.00';				// VALOR BASE DEL ITEM (SIN IMPUESTOS)
		  //      $item['itemBagCuantity'] = 0;							// CANTIDAD DE BOLSAS PARA EL ITEM
		  //      $item['itemIscAmount'] = '10.00';							// CANTIDAD DE BOLSAS PARA EL ITEM
		  //      $item['itemIscTaxableAmount'] = '100.00';							// CANTIDAD DE BOLSAS PARA EL ITEM
		  //      $item['itemIscTaxPercent'] = '10.00';							// CANTIDAD DE BOLSAS PARA EL ITEM
		  //      $item['itemIscSystemType'] = '01';							// CATALOGO 08 sistema de calculo del Isc

		  //      array_push($invoice['itemList'], $item);

			 //       // LEYENDAS												// 1 = con leyenda
		  //      $invoice['amazoniaGoods'] = 1;							// BIENES EN LA AMAZONIA
		  //      $invoice['amazoniaService'] = 1;						// SERVICIOS EN LA AMAZONIA
		  //      $invoice['orderReference'] = 'fasdf';							// Referencia de la orden de compra o servicio

		  //      //REFERENCIA A GUIAS DE REMISION
		  //      $invoice['referenceDocumentList'] = array();
		  //      $referencedDocument = array();
		  //      $referencedDocument['referencedDocument'] = '0001-123456';							// SERIE Y NUMERO DEL DOCUMENTO
		  //      $referencedDocument['referencedDocumentTypeCode'] = '09';						// TIPO DOCUMENTO CAT 01

		  //      array_push($invoice['referenceDocumentList'], $referencedDocument);

		  //      $res = $billingManager->SendDebitNote(1, $invoice, 999);
		  //      // $res = $billingManager->SendCreditNote(1, $invoice, 999);



       // //GUIA DE REMISION
       // 	   $invoice = array();
	      //  $invoice['serie'] = 'TPP1';
	      //  $invoice['number'] = '1';
	      //  $invoice['issueDate'] = '2019-08-01';
	      //  $invoice['issueTime'] = '11:09:05';
	      //  $invoice['invoiceTypeCode'] = '09';						// TIPO DE COMPROBANTE 09 para guia de remitente
	      //  $invoice['supplierRuc'] = '20490086278';
	      //  $invoice['defaultUrl'] = 'WWW.SKYFACT.COM';
	      //  $invoice['supplierName'] = 'SKYNETCUSCO E.I.R.L.';
	      //  $invoice['supplierDocumentType'] = '6';					// TIPO DE DOCUMENTO EMISOR
	      //  $invoice['customerDocumentType'] = '6';					// TIPO DE DOCUMENTO CLIENTE
	      //  $invoice['customerDocument'] = '10044294554';			// DOCUMENTO DEL CLIENTE
	      //  $invoice['customerName'] = 'CHAVEZ CONDORI DANUUVIA LOURDES';

	      //  $invoice['transferReasonCode'] = '01';						// CODIGO DEL Motivo de Traslado CAT 20
	      //  $invoice['transferReason'] = 'VENTA';						// Motivo de Traslado CAT 20
	      //  $invoice['grossWeightMeasure'] = 'KGM';						// UNIDAD DE MEDIDA DEL PESO TOTAL DEL ENVIO CAT 03(KGM = Kilogramo)
	      //  $invoice['grossWeight'] = '10.0';							// PESO
	      //  $invoice['packageQuantity'] = '1';							// CANTIDAD DE PAQUETES
	      //  $invoice['transferMethodCode'] = '01';						// CODIGO DEL METODO DE TRANSPORTE CAT 18
	      //  $invoice['referralDate'] = '2019-08-01';						// FECHA DE REMISION O ENTREGA AL TRANSPORTISTA
	      //  $invoice['carrierDocumentType'] = '6';						// TIPO DE DOCUMENTO DEL TRANSPORTISTA
	      //  $invoice['carrierRuc'] = '10451329575';						// NUMERO DE DOCUMENTO DEL TRANSPORTISTA
	      //  $invoice['carrierName'] = 'TRANPORTES S.A.';					// NOMBRE DEL TRANSPORTISTA
	      //  $invoice['driverDocumentType'] = '1';						// TIPO DE DOCUMENTO DEL CONDUCTOR
	      //  $invoice['driverDocument'] = '45132957';						// NUMERO DE DOCUMENTO DEL CONDUCTOR
	      //  $invoice['licensePlate'] = 'X4C-539';						// PLACA DEL VEHICULO
	      //  $invoice['deliveryAdressCode'] = '070101';					// UBIGEO DE DESTINO
	      //  $invoice['deliveryAdress'] = 'CUSCO';						// DIRECCION DESTINO
	      //  $invoice['originAdressCode'] = '070101';						// UBIGEO DE ORIGEN
	      //  $invoice['originAdress'] = 'CUSCO';							// DIRECCION ORIGEN

	      //  $invoice['itemList'] = array();
	      //  $item = array();
	      //  $item['itemUnitCode'] = 'NIU';							// CODIGO UNIDAD
	      //  $item['itemCuantity'] = '1.0';							// CANTIDAD
	      //  $item['itemDescription'] = 'item exonerado';		// DESCRIPCION DEL ITEM
	      //  $item['itemCode'] = '1';									// CODIGO INTERNO DEL ITEM (ID)

	      //  array_push($invoice['itemList'], $item);

	      //  $res = $billingManager->SendReferralGuide(1, $invoice, 999);




     //   //RESUMEN DIARIO
	    //    $summary = array();
	    //    $summary['supplierRuc'] = '10739757551';
	    //    $summary['issueDate'] = '2019-09-17';				//fecha de envio
	    //    $summary['correlative'] = '1';
	    //    $summary['referenceDate'] = '2019-09-16';			//fecha emision documento
	    //    $summary['defaultUrl'] = 'WWW.SKYFACT.COM';
	    //    $summary['supplierName'] = 'SKYNETCUSCO E.I.R.L.';
	    //    $summary['supplierDocumentType'] = '6';				// TIPO DE DOCUMENTO EMISOR

	    //    $summary['invoiceList'] = array();
	    //    $invoice = array();
	    //    $invoice['documentTypeCode'] = '03';
	    //    $invoice['serie'] = 'BPP1';
	    //    $invoice['number'] = '1';
	    //    $invoice['customerDocument'] = '45132957';
	    //    $invoice['customerDocumentType'] = '1';
	    //    $invoice['statusCode'] = '1';
	    //    $invoice['totalSaleAmount'] = '100.00';
	    //    $invoice['totalTaxableAmount'] = '84.75';
	    //    $invoice['igvAmount'] = '15.25';
	    //    $invoice['exoneratedAmount'] = '0';
	    //    $invoice['unaffectedAmount'] = '0';
	    //    $invoice['freeAmount'] = '0';
	    //    $invoice['iscAmount'] = '0';
	    //    $invoice['otherTaxAmount'] = '0';
	    //    $invoice['perceptionAmount'] = '0';
		   // $invoice['codigoMoneda'] = 'USD';							// CODIGO DE LA MONEDA
	    //    array_push($summary['invoiceList'], $invoice);

	    //    $debitNote = array();
	    //    $debitNote['documentTypeCode'] = '08';
	    //    $debitNote['serie'] = 'BPP1';
	    //    $debitNote['number'] = '1';
	    //    $debitNote['customerDocument'] = '45132957';
	    //    $debitNote['customerDocumentType'] = '1';
	    //    $debitNote['statusCode'] = '1';
	    //    $debitNote['totalSaleAmount'] = '100.00';
	    //    $debitNote['totalTaxableAmount'] = '84.75';
	    //    $debitNote['igvAmount'] = '15.25';
	    //    $debitNote['exoneratedAmount'] = '0';
	    //    $debitNote['unaffectedAmount'] = '0';
	    //    $debitNote['freeAmount'] = '0';
	    //    $debitNote['iscAmount'] = '0';
	    //    $debitNote['otherTaxAmount'] = '0';
		   // $debitNote['codigoMoneda'] = 'PEN';							// CODIGO DE LA MONEDA

	    //    $debitNote['referencedInvoiceSerie'] = 'BPP1';			// serie de la boleta a la que hace referencia
	    //    $debitNote['referencedInvoiceNumber'] = '1';				// numero de la boleta a la que hace referencia
	    //    array_push($summary['invoiceList'], $debitNote);

	    //    $invoice = array();
	    //    $invoice['documentTypeCode'] = '03';
	    //    $invoice['serie'] = 'BPP1';
	    //    $invoice['number'] = '2';
	    //    $invoice['customerDocument'] = '45132957';
	    //    $invoice['customerDocumentType'] = '1';
	    //    $invoice['statusCode'] = '1';
	    //    $invoice['totalSaleAmount'] = '100.00';
	    //    $invoice['totalTaxableAmount'] = '84.75';
	    //    $invoice['igvAmount'] = '15.25';
	    //    $invoice['exoneratedAmount'] = '0';
	    //    $invoice['unaffectedAmount'] = '0';
	    //    $invoice['freeAmount'] = '0';
	    //    $invoice['iscAmount'] = '0';
	    //    $invoice['otherTaxAmount'] = '0';
		   // $invoice['codigoMoneda'] = 'PEN';							// CODIGO DE LA MONEDA

	    //    $invoice['perceptionSystemCode'] = '01';					// codigo del sistema de percepcion que se usa
	    //    $invoice['perceptionPercent'] = '2.0';					// porcentaje de la percepcion
	    //    $invoice['perceptionAmount'] = '2.00';					// monto de la percepcion
	    //    $invoice['totalAmountWithPerception'] = '102.00';		// monto de la venta mas percepcion
	    //    $invoice['perceptionTaxableAmount'] = '100.00';			// monto al cual se aplica la percepcion
	    //    array_push($summary['invoiceList'], $invoice);

	    //    $res = $billingManager->SendDailySummary(1, $summary, 999);

       // // COMUNICACION BAJA
	      //  $invoice = array();

	      //  $invoice['issueDate'] = '2019-08-01';					// FECHA EMISION DE LA COMUNICAICON DE BAJA
	      //  $invoice['correlativeNumber'] = '1';						// CORRELATIVO DE LA COMUNICACION DE BAJA
	      //  $invoice['referenceDate'] = '2019-08-01';				// FECHA EMISION EL COMPROBANTE QUE SE QUIERE ANULAR
	      //  $invoice['supplierRuc'] = '20490086278';
	      //  $invoice['supplierName'] = 'SKYNETCUSCO E.I.R.L.';
	      //  $invoice['defaultUrl'] = 'WWW.SKYFACT.COM';
	      //  $invoice['supplierDocumentType'] = '6';					// TIPO DE DOCUMENTO EMISOR
	      //  $invoice['documentTypeCode'] = '01';						// TIPO DE COMPROBANTE  QUE SE QUIERE  ANULAR
	      //  $invoice['documentSerie'] = 'FPP1';						// SERIE DEL COMPROBANTE  QUE SE QUIERE  ANULAR
	      //  $invoice['documentNumber'] = '1';						// NUMERO DEL COMPROBANTE  QUE SE QUIERE  ANULAR
	      //  $invoice['reason'] = 'ANULACION';						// MOTIVO DE LA ANULACION
	      //  $res = $billingManager->SendAvoidance(1, $invoice, 999);




       // CONSULTA ESTADO RESUMEN DIARIO
       // $res = $billingManager->GetStatus('20490086278', 3, 999);


       echo "<br>";
       print_r($res);
       require_once(VIEW_PATH."Manager/Home.php");
   }

     // public function Exec()
     // {
     //     $parameter[0]='';
     //     if (isset($_GET['error'])) {
     //         $parameter[0]=RetrieveMessageError($_GET['error']);
     //     }
     //     $content = requireToVar(VIEW_PATH."Manager/Home.php", $parameter);
     //  require_once(VIEW_PATH."Manager/Layout/main.php");
     // }

} ?>

<?php
    require_once MODEL_PATH . 'User/TicketSummary.php';
    require_once MODEL_PATH . 'User/DetailTicketSummary.php';
    require_once MODEL_PATH . 'User/Sale.php';
    require_once MODEL_PATH . 'User/Business.php';
    require_once MODEL_PATH . 'User/Customer.php';
    require_once MODEL_PATH . 'User/PerceptionTypeCode.php';

    require_once CONTROLLER_PATH . 'Helper/DocumentManager.php';
    require_once CONTROLLER_PATH . 'Helper/BillingManager.php';

    class SummaryManager {

        private $connection;

        private $ticketSummaryModel;
        private $detailTicketSummaryModel;
        private $saleModel;
        private $customerModel;
        private $businessModel;
        private $perceptionTypeCodeModel;

        public function __construct(PDO $connection)
        {
            $this->ticketSummaryModel = new TicketSummary($connection);
            $this->detailTicketSummaryModel = new detailTicketSummary($connection);
            $this->saleModel = new Sale($connection);
            $this->connection = $connection;

            $this->customerModel = new Customer($connection);
            $this->businessModel = new Business($connection);
            $this->perceptionTypeCodeModel = new PerceptionTypeCode($connection);
        }

        public function ByAllInvoice($dateOfIssue = null, $interval = 500){
            $res = new Result();
            $res->countSuccess = 0;
            $res->countError = 0;
            $res->countSummary = 0;
            $res->countCustomer = 0;

            if ($dateOfIssue == null){
                $dateOfIssue = date('Y-m-d',strtotime("-1 days"));
            }

            try{
                $validate = $this->ValidateDataSummary($dateOfIssue, $interval);
                if (!$validate->success){
                    throw new Exception($validate->errorMessage);
                }

                $notDailySummary = $this->saleModel->NotDailySummaryAll($dateOfIssue);
                if(count($notDailySummary) == 0){
                    throw new Exception(sprintf('No se encontro ningun documento con esta fecha %s',$dateOfIssue));
                }

                $notDailySummary = $this->ArrayGroupBy($notDailySummary,'user_id');
                foreach ($notDailySummary as $itemKey => $itemValue){
                    $itemValue = array_chunk($itemValue,$interval,true);

                    foreach ($itemValue as $key => $invoice){
                        if (count($invoice) === 0){
                            break;
                        }
                        $invoice = array_map(function($item){
                            return array_merge($item,[ 'summary_state_code' => '1' ]);
                        },$invoice);

                        $resInSummary = $this->GenerateSummary($invoice, $invoice[0]['user_id'], $_SESSION[SESS], $dateOfIssue);
                        if ($resInSummary->success){
                            $res->countSuccess += count($invoice);
                        }else{
                            $res->countError += count($invoice);
                        }
                        $res->countSummary++;
                    }

                    $res->countCustomer++;
                }

                $res->successMessage = sprintf(
                    "Se generó y se envió %d resúmenes diarios cada una con un máximo de %d comprobantes sumando un total de %s comprobantes enviados a la SUNAT de %d clientes",
                    $res->countSummary,
                    $interval,
                    $res->countSuccess,
                    $res->countCustomer
                );
                $res->success = true;
            } catch (Exception $e){
                $res->success = false;
                $res->errorMessage = $e->getMessage();
            }
            return $res;
        }

        public function ByUserInvoice($userReferenceId, $dateOfIssue = null,  $interval = 500){
            $res = new Result();
            $res->countSuccess = 0;
            $res->countError = 0;
            $res->countSummary = 0;

            if ($dateOfIssue == null){
                $dateOfIssue = date('Y-m-d',strtotime("-1 days"));
            }

            try {
                $validate = $this->ValidateDataSummary($dateOfIssue,$interval);
                if (!$validate->success) {
                    throw new Exception($validate->errorMessage);
                }

                $notDailySummary = $this->saleModel->NotDailySummaryByUserReferenceId($dateOfIssue, $userReferenceId);
                if(count($notDailySummary) == 0){
                    throw new Exception('No se encontro ningun documento');
                }

                $notDailySummary = array_chunk($notDailySummary,$interval,true);
                foreach ($notDailySummary as $key => $invoice){
                    $invoice = array_map(function($item){
                        return array_merge($item,[ 'summary_state_code' => '1' ]);
                    },$invoice);

                    $resInSummary = $this->GenerateSummary($invoice, $userReferenceId, $_SESSION[SESS], $dateOfIssue);
                    if ($resInSummary->success){
                        $res->countSuccess += count($invoice);
                    }else{
                        $res->countError += count($invoice);
                    }
                    $res->countSummary++;
                }
                $res->successMessage = sprintf(
                    "Se generó y se envió %d resúmenes diarios cada una con un máximo de %d comprobantes sumando un total de %s comprobantes enviados a la SUNAT",
                    $res->countSummary,
                    $interval,
                    $res->countSuccess
                );
                $res->success = true;
            } catch (Exception $e){
                $res->success = false;
                $res->errorMessage = $e->getMessage();
            }
            return $res;
        }

        public function ByInvoice($invoice, $userReferenceId){
            $res = new Result();
            try {
                $resInSummary = $this->GenerateSummary($invoice, $userReferenceId, $_SESSION[SESS], date('d.m.Y',strtotime("-1 days")));
                $res->success = $resInSummary->success;
                $res->errorMessage = $resInSummary->errorMessage;
            } catch (Exception $e){
                $res->success = false;
                $res->errorMessage = $e->getMessage();
            }
            return $res;
        }

        private function GenerateSummary($invoice, $localId, $userId, $dateOfIssue){
            $res = new Result();
            $res->summaryId = 0;
            try{
                // Save In Database
                $resSummary = $this->ticketSummaryModel->Insert($invoice, $localId, $userId, $dateOfIssue);
                if(!$resSummary->success){
                    throw new Exception($resSummary->errorMessage);
                }
                $res->summaryId = $resSummary->summaryId;

                // Query
                $business = $this->businessModel->GetByUserId($_SESSION[SESS]);
                $ticketSummary = $this->ticketSummaryModel->GetById($res->summaryId);
                $detailTicketSummary = $this->detailTicketSummaryModel->GetByTicketSummaryIdXML($res->summaryId);

                // Summary
                $perceptionTypeCode = $this->perceptionTypeCodeModel->GetAll();
                $detailTicketSummary =  array_map(function ($item) use ($perceptionTypeCode) {
                    $perceptionCode = $item['perception_code'];
                    $perceptionPercentage = 0;
                    $perceptionAmount = 0;
                    $perceptionBase = 0;
                    $totalWithPerception = 0;
                    if ($item['perception_code'] != ''){
                        $index = array_search($perceptionCode, array_column($perceptionTypeCode, 'code'));

                        $perceptionPercentage = $perceptionTypeCode[$index]['percentage'];
                        $perceptionAmount = RoundCurrency(($perceptionPercentage / 100) * $item['total']);
                        $perceptionBase = $item['total'];
                        $totalWithPerception = $item['total'] + $perceptionAmount;
                    }
                    return array_merge($item,[
                        'perception_code' => $perceptionCode,
                        'perception_percentage' => $perceptionPercentage,
                        'perception_amount' => $perceptionAmount,
                        'perception_base' => $perceptionBase,
                        'total_with_perception' => $totalWithPerception,
                    ]);
                },$detailTicketSummary);

                $documentData = [
                    'ticketSummary' => $ticketSummary,
                    'detailTicketSummary' => $detailTicketSummary,
                    'business' => $business,
                ];

                // XML
                $resXml = $this->GenerateXML($documentData);
                $res->errorMessage = $resXml->errorMessage;
                $res->success = $resXml->success;

                // PDF
                $this->GeneratePdf($documentData);
            }catch (Exception $e){
                $res->success = false;
                $res->errorMessage = $e->getMessage();
            }
            return $res;
        }

        private function GenerateXML(array $documentData){
            $ticketSummary = $documentData['ticketSummary'];
            $detailTicketSummary =  $documentData['detailTicketSummary'];
            $business =  $documentData['business'];

            $summary = array();
            $summary['supplierRuc'] = $business['ruc'];
            $summary['issueDate'] = $ticketSummary['date_of_issue'];;				//fecha de envio
            $summary['correlative'] = $ticketSummary['number'];
            $summary['referenceDate'] = $ticketSummary['date_of_reference'];			//fecha emision documento
            $summary['defaultUrl'] = 'WWW.SKYFACT.COM';
            $summary['supplierName'] = 'SKYNETCUSCO E.I.R.L.';
            $summary['supplierDocumentType'] = '6';				// TIPO DE DOCUMENTO EMISOR

            $invoice = array();
            $summary['invoiceList'] = array();
            foreach ($detailTicketSummary as $row){
                $invoice['documentTypeCode'] = $row['document_code'];
                $invoice['serie'] = $row['serie'];
                $invoice['number'] = $row['correlative'];
                $invoice['customerDocument'] = $row['customer_document_number'];
                $invoice['customerDocumentType'] = $row['customer_identity_document_code'];
                $invoice['statusCode'] = $row['summary_state_code'];
                $invoice['totalSaleAmount'] = $row['total'];
                $invoice['totalTaxableAmount'] = $row['total_taxed'];
                $invoice['igvAmount'] = $row['total_igv'];
                $invoice['exoneratedAmount'] = $row['total_exonerated'];
                $invoice['unaffectedAmount'] = $row['total_unaffected'];
                $invoice['freeAmount'] = $row['total_free'];
                $invoice['iscAmount'] = $row['total_isc'];
                $invoice['otherTaxAmount'] = $row['total_other_taxed'];

                $invoice['referencedInvoiceSerie'] = 'BPP1';			// serie de la boleta a la que hace referencia
                $invoice['referencedInvoiceNumber'] = '1';				// numero de la boleta a la que hace referencia

                $invoice['perceptionSystemCode'] = $row['perception_code'];			    // codigo del sistema de percepcion que se usa
                $invoice['perceptionPercent'] = $row['perception_percentage'];					// porcentaje de la percepcion
                $invoice['perceptionAmount'] = $row['perception_amount'];					// monto de la percepcion
                $invoice['totalAmountWithPerception'] = $row['total_with_perception'];		// monto de la venta mas percepcion
                $invoice['perceptionTaxableAmount'] = $row['perception_base'];			// monto al cual se aplica la percepcion

                array_push($summary['invoiceList'], $invoice);
            }

            $billingManager = new BillingManager($this->connection);
            $directoryXmlPath = '..' . XML_FOLDER_PATH . date('Ym') . '/' . $business['ruc'] . '/';
            $fileName = $business['ruc'] . '-RC-' . date('Ymd') . '-' . $ticketSummary['number'] . '.xml';

            $resSummary = $billingManager->SendDailySummary($ticketSummary['ticket_summary_id'], $summary, $_SESSION[SESS]);

            $res = new Result();
            if($resSummary->success){
                $this->ticketSummaryModel->UpdateById($ticketSummary['ticket_summary_id'],[
                    'xml_url' => $directoryXmlPath . $fileName,
                    'sunat_state' => 2,
                ]);
            }else{
                $res->errorMessage .= $resSummary->errorMessage;
                $res->success = false;
                return $res;
            }

            if ($resSummary->sunatComunicationSuccess){
                $this->ticketSummaryModel->UpdateById((int)$ticketSummary['ticket_summary_id'],[
                    'ticket' => $resSummary->ticket,
                ]);
                $res->success = true;
            } else {
                $res->errorMessage .= $resSummary->sunatCommuniationError;
                $res->success = false;
            }

            return $res;
        }

        private function GeneratePdf(array $documentData){
            $ticketSummary = $documentData['ticketSummary'];
            $detailTicketSummary =  $documentData['detailTicketSummary'];
            $business =  $documentData['business'];

            // Datos temporales => deberia consultar del local donde se emite el documento electronico
            $business = array_merge($business,[
                'address' => 'AV. HUASCAR NRO. 224 DPTO. 303',
                'region' => 'CUSCO',
                'province' => 'CUSCO',
                'district' => 'WANCHAQ',
                'telephone' => '084601425',
                'phone' => '979706609',
                'web_site' => 'www.skynetcusco.com',
            ]);

//            $generatePDF = new DocumentManager($ticketSummary, $business);
//            $resPdf = $generatePDF->Build();

//            var_dump($resPdf);

//            $response = $this->ticketSummaryModel->UpdateById($ticketSummary['ticket_summary_id'],[
//                'pdf_url'=> $directory
//            ]);
//
//            return $response;
        }

        private function ValidateDataSummary($lastDay, $interval){
            $collector = new ErrorCollector();

            // Validation
            function ValidateDate($date, $format = 'Y-m-d')
            {
                $d = DateTime::createFromFormat($format, $date);
                return $d && $d -> format($format) == $date;
            }

            if (!ValidateDate($lastDay)){
                $collector->addError('global','El formato de la fecha no es válido');
            }

            $yesterday = date('Y-m-d');
            if (!($lastDay < $yesterday)){
                $collector->addError('global','La fecha de documentos debe ser anterior al día de hoy');
            }

            $oldSevenDay = date('Y-m-d',strtotime("-7 days"));
            if (!($lastDay >= $oldSevenDay)){
                $collector->addError('global','Solo se permite generar comprobantes pasados los 7 días');
            }

            if ($interval > 500) {
                $collector->addError('global','The maximum number of vouchers in a daily summary is 500');
            }

            return $collector->getResult();
        }

        private function ArrayGroupBy($data, $key){
            $result = array();

            foreach($data as $val) {
                if(array_key_exists($key, $val)){
                    $result[$val[$key]][] = $val;
                } else {
                    $result[""][] = $val;
                }
            }

            return $result;
        }
    }

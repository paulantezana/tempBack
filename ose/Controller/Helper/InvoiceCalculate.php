<?php


require_once MODEL_PATH . 'User/CatAdditionalLegendCode.php';
require_once MODEL_PATH . 'User/CatPerceptionTypeCode.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/Sale.php';

class InvoiceCalculate
{
    private $invoice = [];
    private $connection;
    private $ICBPERYears = [
        '2019' => 0.1,
        '2020' => 0.2,
        '2021' => 0.3,
        '2022' => 0.4,
        '2023' => 0.5,
    ];

    public function __construct(array $invoice, $connection)
    {
        $this -> invoice = $invoice;
        $this -> connection = $connection;
    }

    private function CalculateHeader(){
        try {
            $this->invoice['user_id'] = 0;
            $this->invoice['time_of_issue'] = date('h:i:s', time());
            $this->invoice['sunat_state'] = 1;

            $additionalLegendCodeModel = new CatAdditionalLegendCode($this->connection);

            $jungleProduct = ($this->invoice['jungle_product'] ?? 0) === 'on' ? true : false;
            $jungleService = ($this->invoice['jungle_service'] ?? 0) === 'on' ? true : false;
            $detraction = ($this->invoice['detraction'] ?? 0) === 'on' ? true : false;
            $perceptionEnabled = ($this->invoice['perception_enabled'] ?? 0) === 'on' ? true : false;

            $legend = null;
            if ($jungleProduct){
                $additionalLegend = $additionalLegendCodeModel->GetBy('code','2001');
                $legend[] = [
                    'code' => $additionalLegend['code'],
                    'description' => $additionalLegend['description'],
                ];
            }
            if ($jungleService){
                $additionalLegend = $additionalLegendCodeModel->GetBy('code','2002');
                $legend[] = [
                    'code' => $additionalLegend['code'],
                    'description' => $additionalLegend['description'],
                ];
            }
            if ($detraction){
                $additionalLegend = $additionalLegendCodeModel->GetBy('code','2006');
                $legend[] = [
                    'code' => $additionalLegend['code'],
                    'description' => $additionalLegend['description'],
                ];
            }

            $guide = null;
            foreach ($this->invoice['guide'] ?? [] as $key => $value ){
                $guide[] = [
                    'document_code' => $value['document_code'],
                    'serie' => $value['serie'],
                ];
            }

            // Detraction
            $detractionObject = null;
            if ($detractionObject){
                $detractionPercentage = 10;
                $detractionAmount = ($this->invoice['total'] ?? 0) * ($detractionPercentage / 100);
                $detractionObject = [
                    'detraction_code' => '',
                    'percentage' => $detractionPercentage,
                    'amount' => $detractionAmount,
                    'payment_method' => '001',
                    'bank_account' => 'cuenta bancaria banco de la nacion',
                ];
            }

            $chargedArray = [];
//            $chargedArray[] = [
//                'code' => $data['code'],
//                'description' => $data['description'],
//                'percentage' => $data['percentage'],
//                'amount' => $data['amount'],
//                'base' => $data['base'],
//            ];

            $this->invoice['total_value'] = $this->invoice['total_unaffected'] + $this->invoice['total_taxed'] + $this->invoice['total_exonerated'];
            $this->invoice['total_tax'] = ($this->invoice['total_igv'] ?? 0) + ($this->invoice['total_isc'] ?? 0);

            // Calc ICBPER
            $this->invoice['percentage_plastic_bag_tax'] = $this->ICBPERYears[date('Y')] ?? 0.0;

            $this->invoice['charged_array'] = $chargedArray;
            $this->invoice['detraction_object'] = $detractionObject;
            $this->invoice['guide'] = $guide;
            $this->invoice['legend'] = $legend;
            $this->invoice['percentage_igv'] = 18.00;

            // Calculate Credit Note And Debit Note
            if ($this->invoice['document_code'] == '07' || $this->invoice['document_code'] == '08'){
                $this->CalculateHeaderNCND();
            }
        } catch (Exception $e){
            throw new Exception('Error in : ' .__FUNCTION__.' | '. $e->getMessage()."\n". $e->getTraceAsString());
        }
    }

    private function CalculateHeaderNCND(){
        try {

        } catch (Exception $e){
            throw new Exception('Error in : ' .__FUNCTION__.' | '. $e->getMessage()."\n". $e->getTraceAsString());
        }
    }

    private function RoundCurrency($amount, int $precision = 2) {
        $amountRound = round($amount, $precision,PHP_ROUND_HALF_EVEN);
        $amountFormat = number_format((float)$amountRound, $precision,'.','');
        return $amountFormat;
    }

    private function CalcIsc($row){
        $unitValue = (float)$row['unit_value'] ?? 0.0;
        $systemIscCode = $row['system_isc_code'] ?? '';
        $taxIsc = $row['tax_isc'] ?? '';
        switch ($systemIscCode){
            case '01';
                return ($unitValue * $taxIsc)/100;
            case '02';
                return $unitValue * $taxIsc;
            case '03';
                return 0;
//                             return $unitValue * ($quantity/($igvPercentage + 1 ));
            // Aun falta analizar
            default;
                return 0;
        }
    }

    private function  CalculateItem(){
       try{
           $businessModel = new Business($this->connection);
           $business = $businessModel->GetByUserId();
           $includeIgv = $business['include_igv'];

           foreach ($this->invoice['item'] ?? [] as $key => $row){
               $igvPercentage = 0.18;

               $quantity    = (float)$row['quantity'] ?? 0;
               $discount    = (float)$row['discount'] ?? 0;

               $taxIsc          = $row['tax_isc'] ?? '';
               $systemIscCode   = $row['system_isc_code'] ?? '';
               $isc             = (float)$row['isc'] ?? 0;

               $affectationCode = $row['affectation_code'] ?? '';
               $enabledPlasticBagTax = ($row['enabled_plastic_bag_tax'] ?? 0) === 'on' ? true : false;

               if ($includeIgv){
                   $unitPrice = (float)$row['unit_price'] ?? 0.0;

                   if ($affectationCode === "10"){
                       $unitValue = $unitPrice / (1 + $igvPercentage);
                       $totalValue = ($quantity * $unitValue) - $discount;
                       $totalBaseIgv = $totalValue;
                       $igv = $totalBaseIgv * $igvPercentage;
                       $total = $totalValue + $igv;
                   } elseif ($affectationCode === "11" || $affectationCode === "12" || $affectationCode === "13" || $affectationCode === "14" || $affectationCode === "15" || $affectationCode === "16") {
                       $unitValue = 0;
                       $totalValue = ($quantity * $unitPrice) - $discount;
                       $totalBaseIgv = $totalValue / ( 1 + $igvPercentage);
                       $igv = $totalBaseIgv * $igvPercentage;
                       $total = $totalValue + $igv;
                   } elseif ($affectationCode === "20" || $affectationCode === "30") {
                       $unitValue = $unitPrice;
                       $totalValue = ($quantity * $unitValue) - $discount;
                       $totalBaseIgv = $totalValue;
                       $igv = 0;
                       $total = $totalValue + $igv;
                   }
                   else {
                       $unitValue = $unitPrice;
                       $totalValue = ($quantity * $unitValue) - $discount;
                       $totalBaseIgv = $totalValue;
                       $igv = 0;
                       $total = $totalValue + $igv;
                       if ($affectationCode === "31" || $affectationCode === "32" || $affectationCode === "33" || $affectationCode === "34" || $affectationCode === "35" || $affectationCode === "36"){
                           $unitValue = 0;
                       }
                   }

                   $this->invoice['item'][$key]['unit_value'] = $this->RoundCurrency($unitValue);
                   $this->invoice['item'][$key]['unit_price'] = $this->RoundCurrency($unitPrice);

                   $this->invoice['item'][$key]['total_base_igv'] = $this->RoundCurrency($totalBaseIgv);
                   $this->invoice['item'][$key]['igv'] = $this->RoundCurrency($igv);

                   $this->invoice['item'][$key]['system_isc_code'] = $systemIscCode;
                   $this->invoice['item'][$key]['total_base_isc'] = $this->RoundCurrency($totalBaseIsc ?? 0);
                   $this->invoice['item'][$key]['tax_isc'] = $this->RoundCurrency($taxIsc);
                   $this->invoice['item'][$key]['isc'] = $this->RoundCurrency($isc);

                   $this->invoice['item'][$key]['total_value'] = $this->RoundCurrency($totalValue);
                   $this->invoice['item'][$key]['total'] = $this->RoundCurrency($total);
               } else {
                   $unitValue = (float)$row['unit_value'] ?? 0.0;

                   if ($affectationCode === "10" || $affectationCode === "11" || $affectationCode === "12" || $affectationCode === "13" || $affectationCode === "14" || $affectationCode === "15" || $affectationCode === "16"){
                       if ($taxIsc > 0){
                           $totalBaseIsc = $unitValue;
                           $isc = $this->CalcIsc($row);

                           $unitPrice = ($unitValue + $isc) * (1 + $igvPercentage);
                           $totalValue = ($quantity * $unitValue) - $discount;
                           $totalBaseIgv = ($totalValue + $isc);
                           $igv = $totalBaseIgv * $igvPercentage;
                           $total = $totalValue + $igv + $isc;
                       } else {
                           if ($affectationCode === "10"){
                               $unitPrice = $unitValue * (1 + $igvPercentage);
                               $totalValue = ($quantity * $unitValue) - $discount;
                               $totalBaseIgv = $totalValue;
                               $igv = $totalValue * $igvPercentage;
                               $total = $totalValue + $igv;
                           } else {
                               $unitPrice = $unitValue;
                               $totalValue = ($quantity * $unitValue) - $discount;
                               $totalBaseIgv = $totalValue / (1 + $igvPercentage);
                               $igv = $totalBaseIgv * $igvPercentage;
                               $total = $totalValue + $igv;

                               $unitValue = 0;
                           }
                       }
                   } else if($taxIsc > 0) {
                       $totalBaseIsc = $unitValue;
                       $isc = $this->CalcIsc($row);

                       $unitPrice = $unitValue + $isc;
//                       $unitPrice = $unitValue + ($unitValue * $iscValue);
                       $totalValue = ($quantity * $unitValue) - $discount;
                       $igv = 0;
                       $total = $totalValue + $igv;

                   } else if ($affectationCode === "20" || $affectationCode === "30"){
                       $unitPrice = $unitValue;
                       $totalValue = ($quantity * $unitValue) - $discount;
                       $totalBaseIgv = $totalValue;
                       $igv = 0;
                       $total = $totalValue + $igv;
                   } else {
                       $unitPrice = $unitValue;
                       $totalValue = ($quantity * $unitValue) - $discount;
                       $totalBaseIgv = $totalValue;
                       $igv = 0;
                       $total = $totalValue + $igv;
                       if ($affectationCode === "31" || $affectationCode === "32" || $affectationCode === "33" || $affectationCode === "34" || $affectationCode === "35" || $affectationCode === "36"){
                           $unitValue = 0;
                       }
                   }

                   $this->invoice['item'][$key]['unit_price'] = $this->RoundCurrency($unitPrice ?? 0);
                   $this->invoice['item'][$key]['unit_value'] = $this->RoundCurrency($unitValue ?? 0);

                   $this->invoice['item'][$key]['total_base_igv'] = $this->RoundCurrency($totalBaseIgv ?? 0);
                   $this->invoice['item'][$key]['igv'] = $this->RoundCurrency($igv ?? 0);

                   $this->invoice['item'][$key]['system_isc_code'] = $systemIscCode;
                   $this->invoice['item'][$key]['total_base_isc'] = $this->RoundCurrency($totalBaseIsc ?? 0);
                   $this->invoice['item'][$key]['tax_isc'] = $this->RoundCurrency($taxIsc ?? 0);
                   $this->invoice['item'][$key]['isc'] = $this->RoundCurrency($isc ?? 0);

                   $this->invoice['item'][$key]['total_value'] = $this->RoundCurrency($totalValue ?? 0);
                   $this->invoice['item'][$key]['total'] = $this->RoundCurrency($total ?? 0);
               }

               if ($enabledPlasticBagTax){
                   $this->invoice['item'][$key]['quantity_plastic_bag'] = $quantity;
                   $this->invoice['item'][$key]['plastic_bag_tax'] = $this->RoundCurrency(($this->ICBPERYears[date('Y')] ?? 0.0) * $quantity);
               } else {
                   $this->invoice['item'][$key]['quantity_plastic_bag'] = 0.00;
                   $this->invoice['item'][$key]['plastic_bag_tax'] = 0.00;
               }
           }

           return $this->invoice['item'];
       }catch (Exception $e){
           throw new Exception('Error in : ' .__FUNCTION__.' | '. $e->getMessage()."\n". $e->getTraceAsString());
       }
    }

    public function GetInvoice()
    {
        $res = new Result();
        try{
            $this->CalculateItem();
            $this->CalculateHeader();

            $res->success = true;
            $res->result = $this->invoice;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        return $res;
    }
}

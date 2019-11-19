<?php

require_once MODEL_PATH . 'User/Customer.php';

class InvoiceValidate extends ErrorCollector
{
    private $invoice = [];

    private $taxedCount = 0;
    private $freeCount = 0;
    private $exoneratedCount = 0;
    private $unaffectedCount = 0;
    private $exportCount = 0;
    private $itemCount = 0;
    private $connection;
    private $customer = null;

    public function __construct(array $invoice, PDO $connection)
    {
        $this->invoice = $invoice;
        $this->connection = $connection;

        $this->ValidateHeader();
        $this->ValidateItem();
    }

    private function ValidateHeader(){
        // Validate required
        if (empty($this->invoice['item'] ?? [])){
            $this->addError('global','No hay productos en la lista');
        }
        if (!$this->invoice['customer_id']){
            $this->addError('customer_id','No se seleccionó ningún cliente');
        }
        if (!$this->invoice['serie']){
            $this->addError('serie','No se seleccionó ningúna serie');
        }
        if (!$this->invoice['operation_code']){
            $this->addError('operation_code','No se seleccionó ningún código de operación');
        }
        if (!$this->invoice['currency_code']){
            $this->addError('currency_code','No se seleccionó el tipo de moneda');
        }

        foreach ($this->invoice['item'] as $index => $row){
            if ($row['affectation_code'] === "10"){
                $this -> taxedCount ++;
            }
            switch ($row['affectation_code']) {
                case "11":
                case "12":
                case "13":
                case "14":
                case "15":
                case "16":
                case "31":
                case "32":
                case "33":
                case "34":
                case "35":
                case "36":
                    $this->freeCount++;
                    break;
                default:
                    break;
            }
            if ($row['affectation_code'] === "20"){
                $this->exoneratedCount++;
            }
            if ($row['affectation_code'] === "30"){
                $this->unaffectedCount++;
            }
            if ($row['affectation_code'] === "40"){
                $this->exportCount++;
            }
            $this->itemCount++;
        }

        // Advanced Validate
        if (strlen($this->invoice['serie'] ?? '') !== 4 ){
            $this->addError('serie','La serie debe contener 4 dígitos');
        }
        if ($this->taxedCount >= 1){
            if ($this->invoice['total_taxed'] <= 0){
                $this->addError('total_taxed','Total GRAVADA debe ser mayor a cero');
            }
            if ($this->invoice['total'] <= 0){
                $this->addError('total','TOTAL debe ser mayor a cero');
            }
        }
        if ($this->freeCount >= 1){
            if ($this->invoice['total_free'] <= 0){
                $this->addError('total_free','Total GRATUITA debe ser mayor a cero');
            }
        }
        if ($this->exoneratedCount >= 1){
            if ($this->invoice['total_exonerated'] <= 0){
                $this->addError('total_exonerated','Total EXONERADA debe ser mayor a cero');
            }
        }
        if ($this->unaffectedCount >= 1){
            if ($this->invoice['total_unaffected'] <= 0){
                $this->addError('total_unaffected','Total INAFECTA debe ser mayor a cero');
            }
        }
        if ($this->exportCount >= 1){
            if ($this->invoice['total_exportation'] <= 0){
                $this->addError('total_exportation','Total EXPORTACION debe ser mayor a cero');
            }
        }

        // Database validate
        $customerModel = new Customer($this->connection);
        $this->customer = $customerModel->GetById($this->invoice['customer_id']);

        $identityDocValidate = ValidateIdentityDocumentNumber($this->customer['document_number'],$this->customer['identity_document_code']);
        if (!$identityDocValidate->success){
            $this->addError('customer_id',$identityDocValidate->errorMessage);
        }

        switch ($this->customer['identity_document_code']){
            case '-':
                if ($this->invoice['document_code'] == '01'){
                    $this->addError('customer_id','No puedes emitir Facturas a esta entidad');
                }
                if ($this->invoice['total'] > 700){
                    $this->addError('customer_id','la entidad no puede ser VARIOS por ser una venta mayor a S/700.00');
                }
                break;
            case '0': // No domiliado
                if ($this->invoice['operation_code'] !== '0200'){
                    $this->addError('operation_code','Sunat transaction Si el cliente es \'NO DOMICILIADO\' debe ser una operación de EXPORTACIÓN');
                }
                break;
            case '1': // DNI
                if ($this->invoice['document_code'] == '01'){
                    $this->addError('customer_id',sprintf("No puedes emitir Facturas a esta entidad \"%s\"",$this->customer['social_reason']));
                }
                break;
            case '6': // RUC
                break;
            case '4':
            case '7':
            case 'A':
            case 'B':
            case 'C':
            case 'D':
            default:
                break;
        }

        // Validate operation type
        switch ($this->invoice['operation_code']){
            case '0101': // internal sale
//                if (!($customer['identity_document_code'] === '6' ||  $customer['identity_document_code']) ){
//                    $this->addError('operation_code','SI el tipo de operación es una venta interna el tipo de documento debe ser RUC');
//                }
                break;
            case '0200': // Export
//                if (!($this->customer['identity_document_code'] === '0')){
//                    $this->addError('identity_document_code','Entidad Si es una operación de EXPORTACIÓN, el cliente debe tener como tipo de documento \'0\'=NO DOMICILIADO');
//                }
//                break;
            case '0104': // Prepayment
            case '0401': // No D. Export
            case '1001': // Detraction
            case '1004': // Detraction
        }

        // Validate Credit Note And Debit Note
        if ($this->invoice['document_code'] == '07' || $this->invoice['document_code'] == '08'){
            $this->ValidateNDNC();
        }

        if ($this->invoice['document_code'] == '01'){
            $this->ValidateReferralGuide();
            $this->ValidateDetraction();
            $this->ValidatePerception();
        }
    }

    private function ValidateNDNC(){
        // Validate required
        if (trim($this->invoice['sale_update']['document_code'] ?? '') == ''){
            $this->addError('sale_update','No se especificó el documento a modificar');
        }
        if (trim($this->invoice['sale_update']['serie'] ?? '') == ''){
            $this->addError('sale_update','No se especificó la serie del documento modificar');
        }
        if (trim($this->invoice['sale_update']['correlative'] ?? '') == ''){
            $this->addError('sale_update','No se especificó el correlativo documento a modificar');
        }
        if (trim($this->invoice['sale_update']['credit_note_code'] ?? '') == ''){
            $this->addError('sale_update','No se especificó el motivo');
        }

        // Advanced Validate
        if (strlen($this->invoice['sale_update']['serie'] ?? '') !== 4 ){
            $this->addError('sale_update','La serie debe contener 4 dígitos');
        }
    }

    private function ValidateReferralGuide(){

        if ($this->invoice['referral_guide_enabled'] ?? false){
            if (trim($this->invoice['referral_guide']['transfer_code'] ?? '') == ""){
                $this->addError('transfer_code','Falta especificar el motivo del traslado');
            }
            if (trim($this->invoice['referral_guide']['transport_code'] ?? '') == ""){
                $this->addError('transport_code','Falta especificar el tipo de transporte');
            }
            if (trim($this->invoice['referral_guide']['total_gross_weight'] ?? '') == ""){
                $this->addError('total_gross_weight','Falta ingresar el peso bruto total');
            }
            if (trim($this->invoice['referral_guide']['carrier_document_code'] ?? '') == ''){
                $this->addError('carrier_document_code','Falta especificar el tipo de documento del transportista');
            }
            if (trim($this->invoice['referral_guide']['carrier_document_number'] ?? '') == ""){
                $this->addError('carrier_document_number','Falta ingresar el número de documento del transportista');
            }
            if (trim($this->invoice['referral_guide']['carrier_denomination'] ?? '') == ""){
                $this->addError('carrier_denomination','Falta ingresar la denominación del transportista');
            }
            if (trim($this->invoice['referral_guide']['carrier_plate_number'] ?? '') == ""){
                $this->addError('carrier_plate_number','Falta ingresar la placa del transportista');
            }
            if (trim($this->invoice['referral_guide']['driver_document_code'] ?? '') == ''){
                $this->addError('driver_document_code','Falta especificar el tipo de documento del conductor');
            }
            if (trim($this->invoice['referral_guide']['driver_document_number'] ?? '') == ""){
                $this->addError('driver_document_number','Falta ingresar el número del documento del conductor');
            }
            if (trim($this->invoice['referral_guide']['driver_full_name'] ?? '') == ""){
                $this->addError('driver_full_name','Falta ingresar el nombre completo del conductor');
            }
            if (trim($this->invoice['referral_guide']['location_starting_code'] ?? '') == ""){
                $this->addError('location_starting_code','Falta especificar el Ubigeo de punto de partida');
            }
            if (trim($this->invoice['referral_guide']['address_starting_point'] ?? '') == ""){
                $this->addError('address_starting_point','Falta ingresar la dirección de punto de partida');
            }
            if (trim($this->invoice['referral_guide']['location_arrival_code'] ?? '') == ""){
                $this->addError('location_arrival_code','Falta especificar el Ubigeo de punto de llegada');
            }
            if (trim($this->invoice['referral_guide']['address_arrival_point'] ?? '') == ""){
                $this->addError('address_arrival_point','Falta ingresar la dirección de punto de llegada');
            }

            // Especial Validation
            $validateCarrierDocument = ValidateIdentityDocumentNumber($this->invoice['referral_guide']['carrier_document_number'], $this->invoice['referral_guide']['carrier_document_code']);
            if (!$validateCarrierDocument->success){
                $this->addError('carrier_document_number',$validateCarrierDocument->errorMessage);
            }

            $validateDriverDocument = ValidateIdentityDocumentNumber($this->invoice['referral_guide']['driver_document_number'], $this->invoice['referral_guide']['driver_document_code']);
            if (!$validateDriverDocument->success){
                $this->addError('driver_document_number',$validateDriverDocument->errorMessage);
            }
        }
    }

    private function ValidatePerception(){
        if ($this->invoice['perception_enabled'] ?? false){
            if (trim($this->invoice['perception_code'] ?? '') == ''){
                $this->addError('perception_code','No se especificó el tipo de la percepcion');
            }
        }
    }

    private function ValidateDetraction(){
        if ($this->invoice['detraction_enabled'] ?? false){
            if (trim($this->invoice['detraction_percentage'] ?? '') == ''){
                $this->addError('detraction_percentage','No se especificó el porcentage de la detracción');
            }

            if (trim($this->invoice['subject_detraction_code'] ?? '') == ''){
                $this->addError('subject_detraction_code','No se especificó el tipo de detracción');
            }

            if ($this->invoice['subject_detraction_code'] == '027'){
                if (trim($this->invoice['detraction_location_starting_code'] ?? '') == ""){
                    $this->addError('detraction_location_starting_code','Falta especificar el Ubigeo de punto de partida');
                }
                if (trim($this->invoice['detraction_address_starting_point'] ?? '') == ""){
                    $this->addError('detraction_address_starting_point','Falta ingresar la dirección de punto de partida');
                }
                if (trim($this->invoice['detraction_location_arrival_code'] ?? '') == ""){
                    $this->addError('detraction_location_arrival_code','Falta especificar el Ubigeo de punto de llegada');
                }
                if (trim($this->invoice['detraction_address_arrival_point'] ?? '') == ""){
                    $this->addError('detraction_address_arrival_point','Falta ingresar la dirección de punto de llegada');
                }
                if (trim($this->invoice['detraction_referral_value'] ?? '') == ""){
                    $this->addError('detraction_referral_value','Falta ingresar el valor referencial Servicio de Transporte');
                }
                if (trim($this->invoice['detraction_effective_load'] ?? '') == ""){
                    $this->addError('detraction_effective_load','Falta ingresar el valor referencial Carga Efectiva');
                }
                if (trim($this->invoice['detraction_useful_load'] ?? '') == ""){
                    $this->addError('detraction_useful_load','Falta ingresar el valor referencial Carga Útil');
                }
                if (trim($this->invoice['detraction_travel_detail'] ?? '') == ""){
                    $this->addError('detraction_travel_detail','Falta ingresar el detalle del Viaje');
                }
            }

            if ($this->invoice['subject_detraction_code'] == '004'){
                if (trim($this->invoice['detraction_boat_registration'] ?? '') == ""){
                    $this->addError('detraction_boat_registration','Falta ingresar el matrícula Embarcación');
                }
                if (trim($this->invoice['detraction_boat_name'] ?? '') == ""){
                    $this->addError('detraction_boat_name','Falta ingresar el nombre de la Embarcación');
                }
                if (trim($this->invoice['detraction_species_kind'] ?? '') == ""){
                    $this->addError('detraction_species_kind','Falta ingresar el tipo Especie vendida');
                }
                if (trim($this->invoice['detraction_delivery_address'] ?? '') == ""){
                    $this->addError('detraction_delivery_address','Falta ingresar el Lugar de descarga');
                }
                if (trim($this->invoice['detraction_quantity'] ?? '') == ""){
                    $this->addError('detraction_quantity','Falta ingresar la cantidad de la Especie vendida');
                }
                if (trim($this->invoice['detraction_delivery_date'] ?? '') == ""){
                    $this->addError('detraction_delivery_date','Falta ingresar la fecha de descarga');
                }
            }
        }
    }

    private function ValidateItem(){

        foreach ($this->invoice['item'] as $index => $row){

            // Validate required
            if ($row['product_id'] == ''){
                $this->addErrorRowChildren('item',$index,'product_id','Producto o servicio no puede estar en blanco');
                $this->addErrorRowChildren('item',$index,'description','La descripcion no puede estar en blanco');
            }

            if ($row['quantity'] == ''){
                $this->addErrorRowChildren('item',$index,'description','La cantidad no puede estar en blanco');
            }

            if ($row['affectation_code'] == ''){
                $this->addErrorRowChildren('item',$index,'affectation_code','El tipo de afectacion no puede estar en blanco');
            }

            if ($row['unit_value'] == ''){
                $this->addErrorRowChildren('item',$index,'unit_value','El precio unitario no puede estar en blanco');
            }

            // Advanced Validate
            if (!is_numeric($row['quantity'])){
                $this->addErrorRowChildren('item',$index,'quantity','la cantidad no es un número');
            }

            if (!($row['quantity'] > 0)){
                $this->addErrorRowChildren('item',$index,'quantity','cantidad debe ser mayor que 0');
            }

            switch ($this->customer['identity_document_code']){
                case '-':
                    break;
                case '0': // No domiliado
//                    if ($row['affectation_code'] != '40'){
//                        $this->addErrorRowChildren('item',$index,'affectation_code','tipo de IGV El tipo de IGV debe ser Exportación');
//                    }
//                    break;
                case '1': // DNI
                case '6': // RUC
//                    if ($row['affectation_code'] == '40'){
//                        $this->addErrorRowChildren('item',$index,'affectation_code','tipo de IGV El tipo de IGV NO debe ser Exportación');
//                    }
                    break;
                case '4':
                case '7':
                case 'A':
                case 'B':
                case 'C':
                case 'D':
                default:
                    break;
            }
        }
    }
}

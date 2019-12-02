<?php

require_once MODEL_PATH . 'User/Invoice.php';
require_once MODEL_PATH . 'User/InvoiceNote.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceBuild.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceNoteBuild.php';
require_once CONTROLLER_PATH . 'Helper/ApiSign.php';

class ApiRequestController
{
    private $connection;
    private $invoiceModel;
    private $invoiceNoteModel;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->invoiceModel = new Invoice($this->connection);
        $this->invoiceNoteModel = new InvoiceNote($this->connection);
    }

    public function Exec(){
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $res = new Result();
        try{
            $postData = file_get_contents("php://input");
            $invoice = json_decode($postData, true);

            if (!isset($_GET['token'])){
                throw new Exception("No se encontró ningún token de autenticación.");
            }
            $token = $_GET['token'];
            $authorization = ApiSign::decode($token);

            $invoice = $this->ValidateInput($invoice);
            $response = $this->BuildDocument($invoice,$authorization);
            //var_dump($response);
            if (!$response->success){
                throw new Exception($response->errorMessage);
            }
            $res->result = $response->result;
            $res->success = true;

        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    private function ValidateInput($invoiceApi){
        $invoice['date_of_issue'] = $invoiceApi['fecha_de_emision'];
        $invoice['time_of_issue'] = $invoiceApi['hora_de_emision'];
        $invoice['date_of_due'] = $invoiceApi['fecha_de_vencimiento'];
        $invoice['serie'] = $invoiceApi['serie_documento'];
        $invoice['correlative'] = $invoiceApi['numero_documento'];
        $invoice['observation'] = $invoiceApi['observacion'];
        $invoice['change_type'] = '';
        $invoice['document_code'] = $invoiceApi['codigo_tipo_documento'];
        $invoice['currency_code'] = $invoiceApi['codigo_tipo_moneda'];
        $invoice['operation_code'] = $invoiceApi['codigo_tipo_operacion'];
        $invoice['global_discount_percentage'] = $invoiceApi['porcentaje_descuento_global'];
        $invoice['purchase_order'] = $invoiceApi['numero_orden_de_compra'];
        $invoice['vehicle_plate'] = $invoiceApi['placa_vehiculo'];
        $invoice['term'] = $invoiceApi['terminos'];
        $invoice['perception_code'] = $invoiceApi['codigo_tipo_percepcion'];
        $invoice['related_array'] = [];
        // $invoice['related_array'] = $invoiceApi['documentos_relacionados'];

        $invoice['pdf_format'] = $invoiceApi['formato_de_pdf'];
        $invoice['percentage_igv'] = $invoiceApi['porcentaje_igv'];
        $invoice['percentage_plastic_bag_tax'] = $invoiceApi['tasa_bolsas'];

        // Guide
        $invoice['guide_array'] = [];
        foreach ($invoiceApi['guias'] as $row){
            $guideArray['document_code'] = $row['codigo_tipo_documento'];
            $guideArray['serie'] = $row['serie_numero'];
            array_push($invoice['guide_array'], $guideArray);
        }

        // Legend
        $invoice['legend'] = [];
        if ($invoiceApi['servicio_region_selva']){
            array_push($invoice['legend'],2002);
        }
        if ($invoiceApi['producto_region_selva']){
            array_push($invoice['legend'],2001);
        }

        // Customer
        $invoice['customer']['document_number'] = $invoiceApi['datos_del_cliente']['numero_documento'];
        $invoice['customer']['identity_document_code'] = $invoiceApi['datos_del_cliente']['codigo_tipo_documento_identidad'];
        $invoice['customer']['social_reason'] = $invoiceApi['datos_del_cliente']['nombres_o_razon_social'];
        $invoice['customer']['fiscal_address'] = $invoiceApi['datos_del_cliente']['direccion_fiscal'];
        $invoice['customer']['email'] = $invoiceApi['datos_del_cliente']['correo_electronico'];
        $invoice['customer']['telephone'] = $invoiceApi['datos_del_cliente']['telefono'];

        // Totals
        $invoice['total_prepayment'] = $invoiceApi['totales']['total_anticipos'];
        $invoice['total_free'] = $invoiceApi['totales']['total_operaciones_gratuitas'];
        $invoice['total_exportation'] = $invoiceApi['totales']['total_exportacion'];
        $invoice['total_other_charged'] = $invoiceApi['totales']['total_cargos'];
        $invoice['total_discount'] = $invoiceApi['totales']['total_discount'];
        $invoice['total_exonerated'] = $invoiceApi['totales']['total_operaciones_exoneradas'];
        $invoice['total_unaffected'] = $invoiceApi['totales']['total_operaciones_inafectas'];
        $invoice['total_taxed'] = $invoiceApi['totales']['total_operaciones_gravadas'];
        $invoice['total_igv'] = $invoiceApi['totales']['total_igv'];
        $invoice['total_base_isc'] = $invoiceApi['totales']['total_base_isc'];
        $invoice['total_isc'] = $invoiceApi['totales']['total_isc'];
        $invoice['total_charge'] = $invoiceApi['totales']['total_charge'];
        $invoice['total_base_other_taxed'] = $invoiceApi['totales']['total_base_otros_impuesto'];
        $invoice['total_other_taxed'] = $invoiceApi['totales']['total_otros_impuestos'];
        $invoice['total_value'] = $invoiceApi['totales']['total_valor'];
        $invoice['total_plastic_bag_tax'] = $invoiceApi['totales']['total_impuesto_bolsas'];
        $invoice['total'] = $invoiceApi['totales']['total_venta'];

        // Items
        $invoice['item'] = [];
        foreach ($invoiceApi['items'] as $row){
            $invoiceItem['product_code'] = $row['codigo_producto_sunat'];
            $invoiceItem['unit_measure'] = $row['unidad_de_medida'];
            $invoiceItem['description'] = $row['descripcion'];
            $invoiceItem['quantity'] = $row['cantidad'];
            $invoiceItem['unit_value'] = $row['valor_unitario'];
            $invoiceItem['unit_price'] = $row['precio_unitario'];
            $invoiceItem['discount'] = $row['descuento'];
            $invoiceItem['affectation_code'] = $row['codigo_tipo_afectacion_igv'];
            $invoiceItem['total_base_igv'] = $row['total_base_igv'];
            $invoiceItem['igv']  = $row['igv'];
            $invoiceItem['system_isc_code'] = $row['codigo_tipo_sistema_isc'];
            $invoiceItem['total_base_isc'] = $row['total_base_isc'];
            $invoiceItem['tax_isc'] = $row['tasa_isc'];
            $invoiceItem['isc'] = $row['isc'];
            $invoiceItem['total_base_other_taxed'] = $row['total_base_otros_impuestos'];
            $invoiceItem['percentage_other_taxed'] = $row['porcentage_otros_impuestos'];
            $invoiceItem['other_taxed'] = $row['otros_impuestos'];

            $invoiceItem['total_value'] = $row['total_valor'];
            $invoiceItem['total'] = $row['total'];
            $invoiceItem['charge'] = $row['otros_cargos'];

            $invoiceItem['quantity_plastic_bag'] = $row['cantidad_bolsas'];
            $invoiceItem['plastic_bag_tax'] = $row['impuesto_bolsas'];

            $invoiceItem['prepayment_regulation'] = $row['regulacion_anticipo'];
            $invoiceItem['prepayment_serie'] = $row['regulacion_anticipo_serie'];
            $invoiceItem['prepayment_correlative'] = $row['regulacion_anticipo_correlativo'];
            array_push($invoice['item'], $invoiceItem);
        }

        // Sale Itinerant
        $invoice['itinerant_enable'] = $invoiceApi['con_venta_itinerante'];
        $invoice['itinerant_location'] = $invoiceApi['venta_itinerante_ubigeo'];
        $invoice['itinerant_address'] = $invoiceApi['venta_itinerante_direccion'];
        $invoice['itinerant_urbanization'] = $invoiceApi['venta_itinerante_urbanizacion'];

        // Guide
        if ($invoiceApi['con_factura_guia']){
            $invoice['referral_guide']['referral_guide_enabled'] = $invoiceApi['con_factura_guia'];
            $invoice['referral_guide']['transfer_code'] = $invoiceApi['factura_guia']['codigo_motivo_traslado'];
            $invoice['referral_guide']['transport_code'] = $invoiceApi['factura_guia']['codigo_tipo_tranporte'];
            $invoice['referral_guide']['transfer_start_date'] = $invoiceApi['factura_guia']['fecha_inicio_traslado'];
            $invoice['referral_guide']['total_gross_weight'] = $invoiceApi['factura_guia']['peso_bruto_total'];
            $invoice['referral_guide']['carrier_document_code'] = $invoiceApi['factura_guia']['transportista_codigo_tipo_documento_identidad'];
            $invoice['referral_guide']['carrier_document_number'] = $invoiceApi['factura_guia']['transportista_numero_documento'];
            $invoice['referral_guide']['carrier_denomination'] = $invoiceApi['factura_guia']['transportista_nombres_o_razon_social'];
            $invoice['referral_guide']['driver_document_code'] = $invoiceApi['factura_guia']['conductor_codigo_tipo_documento_identidad'];
            $invoice['referral_guide']['driver_document_number'] = $invoiceApi['factura_guia']['conductor_numero_documento'];
            $invoice['referral_guide']['driver_full_name'] = $invoiceApi['factura_guia']['conductor_nombres_o_razon_social'];
            $invoice['referral_guide']['location_starting_code'] = $invoiceApi['factura_guia']['ubigeo_punto_partida'];
            $invoice['referral_guide']['address_starting_point'] = $invoiceApi['factura_guia']['dureccion_punto_partida'];
            $invoice['referral_guide']['location_arrival_code'] = $invoiceApi['factura_guia']['ubigeo_punto_llegada'];
            $invoice['referral_guide']['address_arrival_point'] = $invoiceApi['factura_guia']['dureccion_punto_llegada'];
        }

        // Credit Note And Debit Note
        if ($invoice['document_code'] == '07' && $invoice['document_code'] == '08'){
            $invoiceId  = $this->invoiceModel->ExistDocument(
                $invoiceApi['documento_afectado']['numero_documento'],
                $invoiceApi['documento_afectado']['serie_documento'],
                $invoiceApi['documento_afectado']['codigo_tipo_documento']
            );
            if (!$invoiceId){
                throw new Exception('El documento que hace referecnia no existe');
            }
        }

        return $invoice;

        // Detraction
//        $invoice['detraction_referral_value'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_effective_load'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_useful_load'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_travel_detail'] = $invoiceApi['detraccion'][''];
//        $invoice['subject_detraction_code'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_percentage'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_location_starting_code'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_address_starting_point'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_location_arrival_code'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_address_arrival_point'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_boat_registration'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_boat_name'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_species_kind'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_delivery_address'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_delivery_date'] = $invoiceApi['detraccion'][''];
//        $invoice['detraction_quantity'] = $invoiceApi['detraccion'][''];
    }

    private function BuildDocument($invoice,$authorization){
        $res = new Result();
        try{
            if($invoice['document_code'] === '01'){
                $invoiceBuild = new InvoiceBuild($this->connection);
                $invoiceId = $this->invoiceModel->Insert($invoice,$authorization['userId'],$authorization['localId']);

                $response = $invoiceBuild->BuildDocument($invoiceId, $authorization['userId']);
                if (!$response->success){
                    throw new Exception($res->errorMessage);
                }

                $protocol = stripos($_SERVER['REQUEST_SCHEME'], 'https') === 0 ? 'https://' : 'http://';
                $hostName = $_SERVER['SERVER_NAME'];
                $currentUrl = $protocol . $hostName . str_replace('/ose','',FOLDER_NAME);

                $invoiceResponse = $this->invoiceModel->GetApiResponseById($invoiceId);
                $invoiceResponse['enlace_del_pdf'] = $currentUrl . $invoiceResponse['enlace_del_pdf'];
                $invoiceResponse['enlace_del_xml'] = $currentUrl . $invoiceResponse['enlace_del_xml'];
                $invoiceResponse['enlace_del_cdr'] = $currentUrl . $invoiceResponse['enlace_del_cdr'];

                $res->result = $invoiceResponse;
                $res->success = true;
                return $res;
            } elseif($invoice['document_code'] === '03'){
                $invoiceBuild = new InvoiceBuild($this->connection);
                $invoiceId = $this->invoiceModel->Insert($invoice,$authorization['userId'],$authorization['localId']);

                $response = $invoiceBuild->BuildDocument($invoiceId, $authorization['userId']);
                if (!$response->success){
                    throw new Exception($res->errorMessage);
                }

                $protocol = stripos($_SERVER['REQUEST_SCHEME'], 'https') === 0 ? 'https://' : 'http://';
                $hostName = $_SERVER['SERVER_NAME'];
                $currentUrl = $protocol . $hostName . str_replace('/ose','',FOLDER_NAME);

                $invoiceResponse = $this->invoiceModel->GetApiResponseById($invoiceId);
                $invoiceResponse['enlace_del_pdf'] = $currentUrl . $invoiceResponse['enlace_del_pdf'];
                $invoiceResponse['enlace_del_xml'] = $currentUrl . $invoiceResponse['enlace_del_xml'];
                $invoiceResponse['enlace_del_cdr'] = $currentUrl . $invoiceResponse['enlace_del_cdr'];

                $res->result = $invoiceResponse;
                $res->success = true;
                return $res;
            } elseif($invoice['document_code'] === '07'){
                $invoiceBuild = new InvoiceNoteBuild($this->connection);
                $invoiceId = $this->invoiceModel->Insert($invoice,$authorization['userId'],$authorization['localId']);

                $response = $invoiceBuild->BuildDocument($invoiceId, $authorization['userId']);
                if (!$response->success){
                    throw new Exception($res->errorMessage);
                }

                $protocol = stripos($_SERVER['REQUEST_SCHEME'], 'https') === 0 ? 'https://' : 'http://';
                $hostName = $_SERVER['SERVER_NAME'];
                $currentUrl = $protocol . $hostName . str_replace('/ose','',FOLDER_NAME);

                $invoiceResponse = $this->invoiceModel->GetApiResponseById($invoiceId);
                $invoiceResponse['enlace_del_pdf'] = $currentUrl . $invoiceResponse['enlace_del_pdf'];
                $invoiceResponse['enlace_del_xml'] = $currentUrl . $invoiceResponse['enlace_del_xml'];
                $invoiceResponse['enlace_del_cdr'] = $currentUrl . $invoiceResponse['enlace_del_cdr'];

                $res->result = $invoiceResponse;
                $res->success = true;
                return $res;
            } elseif($invoice['document_code'] === '08'){
                $invoiceBuild = new InvoiceNoteBuild($this->connection);
                $invoiceId = $this->invoiceModel->Insert($invoice,$authorization['userId'],$authorization['localId']);

                $response = $invoiceBuild->BuildDocument($invoiceId, $authorization['userId']);
                if (!$response->success){
                    throw new Exception($res->errorMessage);
                }

                $protocol = stripos($_SERVER['REQUEST_SCHEME'], 'https') === 0 ? 'https://' : 'http://';
                $hostName = $_SERVER['SERVER_NAME'];
                $currentUrl = $protocol . $hostName . str_replace('/ose','',FOLDER_NAME);

                $invoiceResponse = $this->invoiceModel->GetApiResponseById($invoiceId);
                $invoiceResponse['enlace_del_pdf'] = $currentUrl . $invoiceResponse['enlace_del_pdf'];
                $invoiceResponse['enlace_del_xml'] = $currentUrl . $invoiceResponse['enlace_del_xml'];
                $invoiceResponse['enlace_del_cdr'] = $currentUrl . $invoiceResponse['enlace_del_cdr'];

                $res->result = $invoiceResponse;
                $res->success = true;
                return $res;
            } else {
                throw new Exception("Tipo de documento no soportado");
            }
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        return $res;
    }
}

<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class Invoice extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("invoice","invoice_id",$db);
    }

    public function Paginate($page = 1, $limit = 10, $filter = []) {
        try{
            $filterNumber = 0;
            $sqlFilter = '';
            if (isset($filter['documentCode']) && $filter['documentCode']){
                $sqlFilter .= " WHERE invoice.document_code = {$filter['documentCode']}";
                $filterNumber++;
            }
            if (isset($filter['customerID']) && $filter['customerID']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "invoice.customer_id = {$filter['customerID']}";
                $filterNumber++;
            }
            if (isset($filter['startDate']) && $filter['startDate']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "invoice.date_of_issue >= '{$filter['startDate']}'";
                $filterNumber++;
            }
            if (isset($filter['invoiceSearch']) && $filter['invoiceSearch']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "invoice.invoice_id = '{$filter['invoiceSearch']}'";
                $filterNumber++;
            }
            if (isset($filter['endDate']) && $filter['endDate']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "invoice.date_of_issue <= '{$filter['endDate']}'";
            }
            $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sqlFilter .= "invoice.local_id = {$_COOKIE['CurrentBusinessLocal']}";

            $limit = 10;
            $offset = ($page - 1) * $limit;
            $total_rows = $this->db->query("SELECT COUNT(invoice_id) FROM invoice {$sqlFilter}")->fetchColumn();
            $total_pages = ceil($total_rows / $limit);

            $sql = "SELECT invoice.*, cat_document_type_code.description as document_type_code_description, cat_operation_type_code.description as operation_type_code_description,
                           ic.social_reason as customer_social_reason, ic.document_number as customer_document_number, ic.sent_to_client as customer_sent_to_client,
                           cat_currency_type_code.symbol as currency_symbol,
                           isn.invoice_state_id,  isn.send, isn.response_code, isn.response_message, isn.other_message, isn.pdf_url, isn.xml_url, isn.cdr_url
                    FROM invoice
                        INNER JOIN invoice_customer ic on invoice.invoice_id = ic.invoice_id
                        INNER JOIN invoice_sunat isn on invoice.invoice_id = isn.invoice_id
                        INNER JOIN cat_document_type_code ON invoice.document_code = cat_document_type_code.code
                        INNER JOIN cat_currency_type_code ON invoice.currency_code = cat_currency_type_code.code
                        INNER JOIN cat_operation_type_code ON invoice.operation_code = cat_operation_type_code.code ";

            $sql .= $sqlFilter;
            $sql .= " ORDER BY invoice.invoice_id DESC LIMIT $offset, $limit";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return [
                'current' => $page,
                'pages' => $total_pages,
                'limit' => $limit,
                'data' => $data,
            ];
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function NotDailySummaryAll($dateOfIssue){
        try{
            $sql = "SELECT invoice.invoice_id, invoice.date_of_issue, invoice.local_id FROM invoice WHERE invoice.date_of_issue = :date_of_issue AND invoice.document_code = '03'
                AND invoice.invoice_id NOT IN (SELECT invoice_summary_item.invoice_id FROM invoice_summary_item)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':date_of_issue' => $dateOfIssue,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function NotDailySummaryByUserReferenceId($dateOfIssue, $userReferenceId){
        try{
            $sql = "SELECT invoice.invoice_id, invoice.date_of_issue, invoice.local_id FROM invoice WHERE invoice.date_of_issue = :date_of_issue AND invoice.document_code = '03'
                AND invoice.local_id = :invoice_user_id
                AND invoice.invoice_id NOT IN (SELECT invoice_summary_item.invoice_id FROM invoice_summary_item WHERE invoice_summary_item.local_id = :detail_invoice_user_reference_id)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':date_of_issue' => $dateOfIssue,
                ':invoice_user_id' => $userReferenceId,
                ':detail_invoice_user_reference_id' => $userReferenceId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function ExistDocument($correlative, $serie, $document_code) {
        try{
            $sql = "SELECT invoice_id FROM invoice WHERE correlative = :correlative AND serie = :serie AND  document_code = :document_code LIMIT 1";
            $stmt = $this -> db -> prepare($sql);

            if (!$stmt -> execute([
                ':correlative' => $correlative,
                ':serie' => $serie,
                ':document_code' => $document_code,
            ])){
                return 0;
            }

            $data = $stmt->fetch();
            return $data['invoice_id'];
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function SummaryById(int $invoiceID) {
        try{
            $sql = 'SELECT invoice.*, 
                            (invoice.total_igv + invoice.total_isc + invoice.total_other_taxed) as total_tax,
                            cat_document_type_code.description as document_type_code_description, 
                            cat_operation_type_code.description as operation_type_code_description, 
                            ic.social_reason as customer_social_reason, ic.document_number as customer_document_number, 
                            ic.identity_document_code as customer_identity_document_code,
                            ic.fiscal_address as customer_fiscal_address,
                            cat_currency_type_code.symbol as currency_type_code_symbol,
                            cat_currency_type_code.description as currency_type_code_description,
       
                            isn.invoice_state_id,
       
                            srg.whit_guide, srg.transfer_code, srg.total_gross_weight, srg.transport_code, srg.carrier_document_code, srg.carrier_document_number,
                            srg.carrier_denomination, srg.carrier_plate_number, srg.driver_document_code, srg.driver_document_number, srg.driver_full_name, srg.location_arrival_code,
                            srg.address_arrival_point, srg.location_starting_code, srg.address_starting_point,
       
                            sd.referral_value as detraction_referral_value, sd.effective_load as detraction_effective_load, sd.useful_load as detraction_useful_load, sd.travel_detail as detraction_travel_detail,
                            sd.location_starting_code as detraction_location_starting_code, sd.address_starting_point as detraction_address_starting_point, 
                            sd.location_arrival_code as detraction_location_arrival_code, sd.address_arrival_point as detraction_address_arrival_point,
                            sd.whit_detraction, sd.detraction_code as detraction_code, sd.percentage as detraction_percentage, sd.amount as detraction_amount,
       
                            sd.boat_registration as detraction_boat_registration, sd.boat_name as detraction_boat_name, sd.species_kind as detraction_species_kind,
                            sd.delivery_address as detraction_delivery_address, sd.delivery_date as detraction_delivery_date, sd.quantity as detraction_quantity
                    FROM invoice
                    INNER JOIN invoice_customer ic on invoice.invoice_id = ic.invoice_id
                    INNER JOIN invoice_sunat isn on invoice.invoice_id = isn.invoice_id  
                    INNER JOIN cat_document_type_code ON invoice.document_code = cat_document_type_code.code
                    INNER JOIN cat_currency_type_code ON invoice.currency_code = cat_currency_type_code.code
                    INNER JOIN cat_operation_type_code ON invoice.operation_code = cat_operation_type_code.code
                    LEFT JOIN invoice_referral_guide srg ON invoice.invoice_id = srg.invoice_id
                    LEFT JOIN invoice_detraction sd on invoice.invoice_id = sd.invoice_id
                    WHERE invoice.invoice_id = :invoice_id LIMIT 1';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':invoice_id'=>$invoiceID]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Insert($invoice, $userReferId, $localId) {
        try{
            $currentDate = date('Y-m-d H:i:s');
            $currentTime = date('H:i:s');

            $this->db->beginTransaction();

            // Invoice
            $sql = "INSERT INTO invoice (local_id, invoice_key, date_of_issue, time_of_issue, date_of_due, serie, correlative, observation, change_type,
                                        document_code, currency_code, operation_code, total_prepayment,
                                        total_free, total_exportation, total_other_charged, total_discount, total_exonerated, total_unaffected,
                                        total_taxed, total_igv, total_base_isc, total_isc, total_charge, total_base_other_taxed, total_other_taxed,
                                        total_value, total, global_discount_percentage, purchase_order, vehicle_plate, term,
                                        perception_code, related, guide, legend,
                                        pdf_format, percentage_igv, percentage_plastic_bag_tax, total_plastic_bag_tax,
                                        created_at,updated_at,creation_user_id,modification_user_id, itinerant_enable, itinerant_location, itinerant_address, itinerant_urbanization)
                    VALUES (:local_id, :invoice_key, :date_of_issue, :time_of_issue, :date_of_due, :serie, :correlative, :observation, :change_type,
                                        :document_code, :currency_code, :operation_code, :total_prepayment,
                                        :total_free, :total_exportation, :total_other_charged, :total_discount, :total_exonerated, :total_unaffected,
                                        :total_taxed, :total_igv, :total_base_isc, :total_isc, :total_charge, :total_base_other_taxed, :total_other_taxed,
                                        :total_value, :total, :global_discount_percentage, :purchase_order, :vehicle_plate, :term,
                                        :perception_code, :related, :guide, :legend,
                                        :pdf_format, :percentage_igv, :percentage_plastic_bag_tax, :total_plastic_bag_tax,
                                        :created_at,:updated_at,:creation_user_id,:modification_user_id, :itinerant_enable, :itinerant_location, :itinerant_address, :itinerant_urbanization)";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':local_id' => $localId,
                ':invoice_key' => $localId . $invoice['document_code'] . $invoice['correlative'] . $invoice['serie'],
                ':date_of_issue' => $invoice['date_of_issue'],
                ':time_of_issue' => $invoice['time_of_issue'],
                ':date_of_due' => $invoice['date_of_due'],
                ':serie' => $invoice['serie'],
                ':correlative' => $invoice['correlative'] ?? 1,
                ':observation' => $invoice['observation'] ?? '',
                ':change_type' => $invoice['change_type'],
                ':document_code' => $invoice['document_code'],
                ':currency_code' => $invoice['currency_code'],
                ':operation_code' => $invoice['operation_code'],
                ':total_prepayment' => (float)($invoice['total_prepayment'] ?? 0),
                ':total_free' => (float)($invoice['total_free'] ?? 0),
                ':total_exportation' => (float)($invoice['total_exportation'] ?? 0),
                ':total_other_charged' => (float)($invoice['total_other_charged'] ?? 0),
                ':total_discount' => (float)($invoice['total_discount'] ?? 0),
                ':total_exonerated' => (float)($invoice['total_exonerated'] ?? 0),
                ':total_unaffected' => (float)($invoice['total_unaffected'] ?? 0),
                ':total_taxed' => (float)($invoice['total_taxed'] ?? 0),
                ':total_igv' => (float)($invoice['total_igv'] ?? 0),
                ':total_base_isc' => (float)($invoice['total_base_isc'] ?? 0),
                ':total_isc' => (float)($invoice['total_isc'] ?? 0),
                ':total_charge' => (float)($invoice['total_charge'] ?? 0),
                ':total_base_other_taxed' => (float)($invoice['total_base_other_taxed'] ?? 0),
                ':total_other_taxed' => (float)($invoice['total_other_taxed'] ?? 0),
                ':total_value' => (float)($invoice['total_value'] ?? 0),
                ':total' => (float)($invoice['total'] ?? 0),
                ':global_discount_percentage' => (float)($invoice['global_discount_percentage'] ?? 0),
                ':purchase_order' => $invoice['purchase_order'],
                ':vehicle_plate' => $invoice['vehicle_plate'],
                ':term' => $invoice['term'],
                ':perception_code' => $invoice['perception_code'] ?? '',
                ':related' => json_encode($invoice['related_array'] ?? []),
                ':guide' => json_encode($invoice['guide_array'] ?? []),
                ':legend' => json_encode($invoice['legend'] ?? []),
                ':pdf_format' => $invoice['pdf_format'] ?? '',
                ':percentage_igv' => (float)($invoice['percentage_igv'] ?? 0),
                ':percentage_plastic_bag_tax' => (float)($invoice['percentage_plastic_bag_tax'] ?? 0),
                ':total_plastic_bag_tax' => (float)($invoice['total_plastic_bag_tax'] ?? 0),

                ":created_at" => $currentDate,
                ":updated_at" => $currentDate,
                ":creation_user_id" => $userReferId,
                ":modification_user_id" => $userReferId,
                ":itinerant_enable" => $invoice['itinerant_enable'] ?? 0,
                ":itinerant_location" => $invoice['itinerant_location'] ?? '',
                ":itinerant_address" => $invoice['itinerant_address'] ?? '',
                ":itinerant_urbanization" => $invoice['itinerant_urbanization'] ?? '',
            ])){
                throw new Exception('No se pudo insertar el registro');
            }
            $invoiceId = (int)$this->db->lastInsertId();

            // Insert customer
            $sql = "INSERT INTO invoice_customer (invoice_id, document_number, identity_document_code, social_reason, fiscal_address, email, telephone, sent_to_client)
                    VALUES (:invoice_id, :document_number, :identity_document_code, :social_reason, :fiscal_address, :email, :telephone, :sent_to_client)";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':invoice_id' => $invoiceId,
                ':document_number' => $invoice['customer']['document_number'],
                ':identity_document_code' => $invoice['customer']['identity_document_code'],
                ':social_reason' => $invoice['customer']['social_reason'],
                ':fiscal_address' => $invoice['customer']['fiscal_address'],
                ':email' => $invoice['customer']['email'],
                ':telephone' => $invoice['customer']['telephone'],
                ':sent_to_client' => 0,
            ])){
                throw new Exception('No se pudo insertar el registro');
            }

            // Insert sunat states
            $sql = "INSERT INTO invoice_sunat (invoice_id, invoice_state_id)
                    VALUES (:invoice_id, :invoice_state_id)";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':invoice_id' => $invoiceId,
                ':invoice_state_id' => 1,
            ])){
                throw new Exception('No se pudo insertar el registro');
            }

            // Insert items
            foreach ($invoice['item'] as $row){
                $sql = "INSERT INTO invoice_item (invoice_id, product_code, unit_measure, description, quantity, unit_value, unit_price, discount, affectation_code,
                                                    total_base_igv, igv, system_isc_code, total_base_isc, tax_isc, 
                                                    isc, total_base_other_taxed, percentage_other_taxed, other_taxed, plastic_bag_tax, quantity_plastic_bag,
                                                    prepayment_regulation, prepayment_serie, prepayment_correlative, total_value, total, charge)
                                        VALUES (:invoice_id, :product_code, :unit_measure, :description, :quantity, :unit_value, :unit_price, :discount, :affectation_code,
                                                :total_base_igv, :igv, :system_isc_code, :total_base_isc, :tax_isc, 
                                                :isc, :total_base_other_taxed, :percentage_other_taxed, :other_taxed, :plastic_bag_tax, :quantity_plastic_bag,
                                                :prepayment_regulation, :prepayment_serie, :prepayment_correlative, :total_value, :total, :charge)";
                $stmt = $this->db->prepare($sql);
                if (!$stmt->execute([
                    ':invoice_id' => $invoiceId,
                    ':product_code' => $row['product_code'],
                    ':unit_measure' => $row['unit_measure'],
                    ':description' => $row['description'],
                    ':quantity' => (float)($row['quantity'] ?? 0),
                    ':unit_value' => (float)($row['unit_value'] ?? 0),
                    ':unit_price' => (float)($row['unit_price'] ?? 0),
                    ':discount' => (float)($row['discount'] ?? 0),

                    ':affectation_code' => $row['affectation_code'] ?? '',
                    ':total_base_igv' => (float)($row['total_base_igv'] ?? 0),
                    ':igv' => (float)($row['igv'] ?? 0),

                    ':system_isc_code' => $row['system_isc_code'] ?? '',
                    ':total_base_isc' => (float)($row['total_base_isc'] ?? 0),
                    ':tax_isc' => (float)($row['tax_isc'] ?? 0),
                    ':isc' => (float)($row['isc'] ?? 0),

                    ':total_base_other_taxed' => (float)($row['total_base_other_taxed'] ?? 0),
                    ':percentage_other_taxed' => (float)($row['percentage_other_taxed'] ?? 0),
                    ':other_taxed' => (float)($row['other_taxed'] ?? 0),

                    ':quantity_plastic_bag' => (float)($row['quantity_plastic_bag'] ?? 0),
                    ':plastic_bag_tax' => (float)($row['plastic_bag_tax'] ?? 0),

                    ':prepayment_regulation' => $row['prepayment_regulation'] ?? 0,
                    ':prepayment_serie' => $row['prepayment_serie'] ?? '',
                    ':prepayment_correlative' => $row['prepayment_correlative'] ?? '',

                    ':total_value' => (float)($row['total_value'] ?? 0),
                    ':total' => (float)($row['total'] ?? 0),
                    ':charge' => (float)($row['charge'] ?? 0),
                ])){
                    throw new Exception('Error al insertar los items');
                }
            }

            // Insert Detraction
            if (isset($invoice['detraction_percentage']) && isset($invoice['detraction_enabled']) ){
                $sql = "INSERT INTO invoice_detraction(invoice_id, referral_value, effective_load, useful_load, travel_detail, whit_detraction, detraction_code, percentage, amount,
                                                        location_starting_code, address_starting_point, location_arrival_code, address_arrival_point,
                                                        boat_registration, boat_name, species_kind, delivery_address, delivery_date, quantity
                                                    )  
                                                    VALUES (:invoice_id, :referral_value, :effective_load, :useful_load, :travel_detail, :whit_detraction, :detraction_code, :percentage, :amount,
                                                        :location_starting_code, :address_starting_point, :location_arrival_code, :address_arrival_point,
                                                        :boat_registration, :boat_name, :species_kind, :delivery_address, :delivery_date, :quantity
                                                    )";
                $stmt = $this->db->prepare($sql);
                $detractionEnabled = $invoice['detraction_enabled'] == 'on' ? 1 : 0;

                if (!$stmt->execute([
                    ':invoice_id' => $invoiceId,
                    ':referral_value' => $invoice['detraction_referral_value'],
                    ':effective_load' => $invoice['detraction_effective_load'],
                    ':useful_load' => $invoice['detraction_useful_load'],
                    ':travel_detail' => $invoice['detraction_travel_detail'],

                    ':whit_detraction' => $detractionEnabled,
                    ':detraction_code' => $invoice['subject_detraction_code'],
                    ':percentage' => $invoice['detraction_percentage'],
                    ':amount' => $invoice['total'] * ($invoice['detraction_percentage'] / 100),
                    ':location_starting_code' => $invoice['detraction_location_starting_code'],
                    ':address_starting_point' => $invoice['detraction_address_starting_point'],
                    ':location_arrival_code' => $invoice['detraction_location_arrival_code'],
                    ':address_arrival_point' => $invoice['detraction_address_arrival_point'],

                    ':boat_registration' => $invoice['detraction_boat_registration'],
                    ':boat_name' => $invoice['detraction_boat_name'],
                    ':species_kind' => $invoice['detraction_species_kind'],
                    ':delivery_address' => $invoice['detraction_delivery_address'],
                    ':delivery_date' => $invoice['detraction_delivery_date'],
                    ':quantity' => $invoice['detraction_quantity'],
                ])){
                    throw new Exception('No se pudo insertar el registro');
                }
            }

            // Insert invoice guide
            if (isset($invoice['referral_guide_enabled'])){
                $referralGuide = $invoice['referral_guide'];
                $sql = "INSERT INTO invoice_referral_guide(invoice_id, whit_guide, document_code, transfer_code, transport_code, transfer_start_date, total_gross_weight,
                                                        carrier_document_code, carrier_document_number, carrier_denomination, driver_document_code,
                                                        driver_document_number, driver_full_name, location_starting_code, address_starting_point,
                                                        location_arrival_code, address_arrival_point)  
                                                    VALUES (:invoice_id, :whit_guide, :document_code, :transfer_code, :transport_code, :transfer_start_date, :total_gross_weight,
                                                        :carrier_document_code, :carrier_document_number, :carrier_denomination, :driver_document_code,
                                                        :driver_document_number, :driver_full_name, :location_starting_code, :address_starting_point,
                                                        :location_arrival_code, :address_arrival_point)";
                $stmt = $this->db->prepare($sql);
                if (!$stmt->execute([
                    ':invoice_id' => $invoiceId,
                    ':whit_guide' => $invoice['referral_guide_enabled'],
                    ':document_code' => '09',
                    ':transfer_code' => $referralGuide['transfer_code'],
                    ':transport_code' => $referralGuide['transport_code'],
                    ':transfer_start_date' => $referralGuide['transfer_start_date'],
                    ':total_gross_weight' => $referralGuide['total_gross_weight'],
                    ':carrier_document_code' => $referralGuide['carrier_document_code'],
                    ':carrier_document_number' => $referralGuide['carrier_document_number'],
                    ':carrier_denomination' => $referralGuide['carrier_denomination'],
                    ':driver_document_code' => $referralGuide['driver_document_code'],
                    ':driver_document_number' => $referralGuide['driver_document_number'],
                    ':driver_full_name' => $referralGuide['driver_full_name'],
                    ':location_starting_code' => $referralGuide['location_starting_code'],
                    ':address_starting_point' => $referralGuide['address_starting_point'],
                    ':location_arrival_code' => $referralGuide['location_arrival_code'],
                    ':address_arrival_point' => $referralGuide['address_arrival_point'],
                ])){
                    throw new Exception('No se pudo insertar el registro');
                }
            }

            $this->db->commit();
            return $invoiceId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function UpdateInvoiceSunatByInvoiceId($invoiceId, $data)
    {
        try {
            $sql = "UPDATE invoice_sunat SET ";
            foreach ($data as $key => $value) {
                $sql .= "$key = :$key, ";
            }
            $sql = trim(trim($sql), ',');
            $sql .= " WHERE invoice_id = :invoice_id";

            $execute = [];
            foreach ($data as $key => $value) {
                $execute[":$key"] = $value;
            }
            $execute[":invoice_id"] = $invoiceId;

            $stmt = $this->db->prepare($sql);
            if (!$stmt->execute($execute)) {
                throw new Exception("Error al actualizar el registro");
            }
            return $invoiceId;
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function GetByIds($ids, int $userReferenceId){
        try{
            $ids = implode("','",$ids);

            $sql = "SELECT  invoice.invoice_id, invoice.serie, invoice.correlative, invoice.total, invoice.date_of_issue FROM invoice
                    WHERE invoice.invoice_id IN('{$ids}') AND invoice.local_id = :local_id  LIMIT 8";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':local_id' => $userReferenceId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function SearchBySerieCorrelative(string $search) {
        try{
            $sql = 'SELECT  invoice.invoice_id, invoice.serie, invoice.correlative, invoice.total, invoice.date_of_issue, cat_document_type_code.description as document_type_code_description FROM invoice
                    INNER JOIN cat_document_type_code ON invoice.document_code = cat_document_type_code.code
                    WHERE serie LIKE :serie OR correlative LIKE :correlative  LIMIT 8';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':serie' => '%' . $search . '%',
                ':correlative' => '%' . $search . '%',
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function GetByIdDocumentDescription(int $id)
    {
        try{
            $sql = "SELECT invoice.invoice_id, CONCAT(invoice.serie,'-',invoice.correlative,' (',dtc.description,') ',invoice.date_of_issue) as description FROM invoice
                    INNER JOIN cat_document_type_code dtc on invoice.document_code = dtc.code
                    WHERE invoice.invoice_id = :invoice_id ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':invoice_id' => $id,
            ]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

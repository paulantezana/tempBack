<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class InvoiceNote extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("invoice_note","invoice_note_id",$db);
    }

    public function Paginate($page = 1, $limit = 10, $filter = []) {
        try{
            $filterNumber = 0;
            $sqlFilter = '';
            if ($filter['documentCode']){
                $sqlFilter .= " WHERE invoice_note.document_code = {$filter['documentCode']}";
                $filterNumber++;
            }
            if ($filter['customerID']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "invoice_note.customer_id = {$filter['customerID']}";
                $filterNumber++;
            }
            if ($filter['startDate']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "invoice_note.date_of_issue >= '{$filter['startDate']}'";
                $filterNumber++;
            }
            if ($filter['invoiceSearch']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "invoice_note.invoice_note_id = '{$filter['invoiceSearch']}'";
                $filterNumber++;
            }
            if ($filter['endDate']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "invoice_note.date_of_issue <= '{$filter['endDate']}'";
            }
            $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sqlFilter .= "invoice_note.local_id = {$_COOKIE['CurrentBusinessLocal']}";

            $limit = 10;
            $offset = ($page - 1) * $limit;
            $total_rows = $this->db->query("SELECT COUNT(*) FROM invoice_note {$sqlFilter}")->fetchColumn();
            $total_pages = ceil($total_rows / $limit);

            $sql = "SELECT invoice_note.*,  cat_document_type_code.description as document_type_code_description, cat_operation_type_code.description as operation_type_code_description,
                            inc.social_reason as customer_social_reason, inc.document_number as customer_document_number, inc.sent_to_client as customer_sent_to_client,
                            cat_currency_type_code.symbol as currency_symbol,
                            invoice.document_code as invoice_document_code,
                            ins.invoice_state_id,  ins.send, ins.response_code, ins.response_message, ins.other_message, ins.pdf_url, ins.xml_url, ins.cdr_url
                        FROM invoice_note
                        INNER JOIN invoice_note_customer inc on invoice_note.invoice_note_id = inc.invoice_note_id
                        INNER JOIN invoice_note_sunat ins on invoice_note.invoice_note_id = ins.invoice_note_id
                        INNER JOIN cat_document_type_code ON invoice_note.document_code = cat_document_type_code.code
                        INNER JOIN cat_currency_type_code ON invoice_note.currency_code = cat_currency_type_code.code
                        INNER JOIN cat_operation_type_code ON invoice_note.operation_code = cat_operation_type_code.code
                        LEFT JOIN invoice ON invoice_note.invoice_id = invoice.invoice_id";
            $sql .= $sqlFilter;
            $sql .= " ORDER BY invoice_note.invoice_note_id DESC LIMIT $offset, $limit";

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

    public function ValidateSerieCorrelativeDocument($correlative, $serie, $document_code){
        try{
            $sql = "SELECT * FROM invoice_note WHERE correlative = :correlative AND serie = :serie AND  document_code = :document_code";
            $stmt = $this -> db -> prepare($sql);

            $stmt -> execute([
                ':correlative' => $correlative,
                ':serie' => $serie,
                ':document_code' => $document_code,
            ]);

            if ($stmt->rowCount() > 1){
                return false;
            }

            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function SummaryById(int $invoiceNoteId) {
        try{
            $sql = 'SELECT invoice_note.*,
                            (invoice_note.total_igv + invoice_note.total_isc + invoice_note.total_other_taxed) as total_tax,
                            invoice.serie as invoice_serie, invoice.correlative as invoice_correlative, invoice.document_code as invoice_document_code, 
                            cat_document_type_code.description as document_type_code_description, 
                            cat_operation_type_code.description as operation_type_code_description,
       
                            inc.social_reason as customer_social_reason, inc.document_number as customer_document_number, 
                            inc.identity_document_code as customer_identity_document_code,
                            inc.fiscal_address as customer_fiscal_address,

                            ins.invoice_state_id,
       
                            cat_currency_type_code.symbol as currency_type_code_symbol,
                            cat_currency_type_code.description as currency_type_code_description,
       
                            srg.whit_guide, srg.transfer_code, srg.total_gross_weight, srg.transport_code, srg.carrier_document_code, srg.carrier_document_number,
                            srg.carrier_denomination, srg.carrier_plate_number, srg.driver_document_code, srg.driver_document_number, srg.driver_full_name, srg.location_arrival_code,
                            srg.address_arrival_point, srg.location_starting_code, srg.address_starting_point,
       
                            sd.referral_value as detraction_referral_value, sd.effective_load as detraction_effective_load, sd.useful_load as detraction_useful_load, sd.travel_detail as detraction_travel_detail,
                            sd.location_starting_code as detraction_location_starting_code, sd.address_starting_point as detraction_address_starting_point, 
                            sd.location_arrival_code as detraction_location_arrival_code, sd.address_arrival_point as detraction_address_arrival_point,
                            sd.whit_detraction, sd.detraction_code as detraction_code, sd.percentage as detraction_percentage, sd.amount as detraction_amount,
       
                            sd.boat_registration as detraction_boat_registration, sd.boat_name as detraction_boat_name, sd.species_kind as detraction_species_kind,
                            sd.delivery_address as detraction_delivery_address, sd.delivery_date as detraction_delivery_date, sd.quantity as detraction_quantity
                    FROM invoice_note
                    INNER JOIN invoice ON invoice_note.invoice_id = invoice.invoice_id
                    INNER JOIN invoice_note_customer inc on invoice_note.invoice_note_id = inc.invoice_note_id
                    INNER JOIN invoice_note_sunat ins on invoice_note.invoice_note_id = ins.invoice_note_id
                    INNER JOIN cat_document_type_code ON invoice_note.document_code = cat_document_type_code.code
                    INNER JOIN cat_currency_type_code ON invoice_note.currency_code = cat_currency_type_code.code
                    INNER JOIN cat_operation_type_code ON invoice_note.operation_code = cat_operation_type_code.code
                    LEFT JOIN invoice_referral_guide srg ON invoice.invoice_id = srg.invoice_id
                    LEFT JOIN invoice_detraction sd on invoice.invoice_id = sd.invoice_id
                    WHERE invoice_note.invoice_note_id = :invoice_note_id LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':invoice_note_id'=>$invoiceNoteId]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function SearchBySerieCorrelative(array $search) {
        try{
            $sql = 'SELECT  invoice_note.invoice_note_id, invoice_note.serie, invoice_note.correlative, invoice_note.total, invoice_note.date_of_issue, cat_document_type_code.description as document_type_code_description 
                    FROM invoice_note
                    INNER JOIN cat_document_type_code ON invoice_note.document_code = cat_document_type_code.code
                    WHERE invoice_note.serie LIKE :serie OR invoice_note.correlative LIKE :correlative AND invoice_note.local_id = :local_id LIMIT 8';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':serie' => '%' . $search['search'] . '%',
                ':correlative' => '%' . $search['search'] . '%',
                ':local_id' => $search['localId'],
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Insert($invoice, $userReferId, $localId)
    {
        try{
            $currentDate = date('Y-m-d H:i:s');
            $currentTime = date('H:i:s');

            $this->db->beginTransaction();

            $sql = "INSERT INTO invoice_note ( local_id, invoice_note_key,  date_of_issue, time_of_issue, date_of_due, serie, correlative, observation, change_type,
                                            document_code, currency_code, operation_code, total_prepayment, total_free, total_exportation,
                                            total_other_charged, total_discount, total_exonerated, total_unaffected, total_taxed, total_igv, total_base_isc,
                                            total_isc, total_charge, total_base_other_taxed, total_other_taxed, total_value, total,
                                            global_discount_percentage, purchase_order, vehicle_plate, term, perception_code, detraction,
                                            related, guide, legend, pdf_format, reason_update_code, invoice_id, percentage_igv, percentage_plastic_bag_tax, total_plastic_bag_tax,
                                            created_at,updated_at,created_user_id,updated_user_id)
                    VALUES (:local_id, :invoice_note_key, :date_of_issue, :time_of_issue, :date_of_due, :serie, :correlative, :observation, :change_type,
                            :document_code, :currency_code, :operation_code, :total_prepayment, :total_free, :total_exportation,
                            :total_other_charged, :total_discount, :total_exonerated, :total_unaffected, :total_taxed, :total_igv, :total_base_isc,
                            :total_isc, :total_charge, :total_base_other_taxed, :total_other_taxed, :total_value, :total,
                            :global_discount_percentage, :purchase_order, :vehicle_plate, :term, :perception_code, :detraction, 
                            :related, :guide, :legend, :pdf_format, :reason_update_code, :invoice_id, :percentage_igv, :percentage_plastic_bag_tax, :total_plastic_bag_tax,
                            :created_at,:updated_at,:created_user_id,:updated_user_id)";
            $stmt = $this->db->prepare($sql);

            if(!$stmt->execute([
                ':local_id' => $localId,
                ':invoice_note_key' => $localId . $invoice['document_code'] . $invoice['correlative'] . $invoice['serie'],
                ':date_of_issue' => $invoice['date_of_issue'],
                ':time_of_issue' => $currentTime,
                ':date_of_due' => $invoice['date_of_due'],
                ':serie' => $invoice['serie'],
                ':correlative' => $invoice['correlative'],
                ':observation' => $invoice['observation'],
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
                ':perception_code' => '',
                ':detraction' => json_encode($invoice['detraction_object'] ?? new stdClass()),
                ':related' => json_encode($invoice['related_array'] ?? []),
                ':guide' => json_encode($invoice['guide'] ?? []),
                ':legend' => json_encode($invoice['legend'] ?? []),
                ':pdf_format' => $invoice['pdf_format'],
                ':reason_update_code' => $invoice['reason_update_code'] ?? '',
                ':invoice_id' => $invoice['invoice_id'] ?? '',
                ':percentage_igv' => (float)($invoice['percentage_igv'] ?? 0),
                ':percentage_plastic_bag_tax' => (float)($invoice['percentage_plastic_bag_tax'] ?? 0),
                ':total_plastic_bag_tax' => (float)($invoice['total_plastic_bag_tax'] ?? 0),

                ":created_at" => $currentDate,
                ":updated_at" => $currentDate,
                ":created_user_id" => $userReferId,
                ":updated_user_id" => $userReferId,
            ])){
                throw new Exception('No se pudo insertar el registro');
            }
            $invoiceNoteId = (int)$this->db->lastInsertId();

            // Insert customer
            $sql = "INSERT INTO invoice_note_customer (invoice_note_id, document_number, identity_document_code, social_reason, fiscal_address, email, telephone, sent_to_client)
                    VALUES (:invoice_note_id, :document_number, :identity_document_code, :social_reason, :fiscal_address, :email, :telephone, :sent_to_client)";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':invoice_note_id' => $invoiceNoteId,
                ':document_number' => $invoice['customer']['document_number'],
                ':identity_document_code' => $invoice['customer']['identity_document_code'],
                ':social_reason' => $invoice['customer']['social_reason'],
                ':fiscal_address' => $invoice['customer']['fiscal_address'],
                ':email' => $invoice['customer']['email'],
                ':telephone' => $invoice['customer']['telephone'] ?? '',
                ':sent_to_client' => 0,
            ])){
                throw new Exception('No se pudo insertar el registro');
            }

            // Insert sunat states
            $sql = "INSERT INTO invoice_note_sunat (invoice_note_id, invoice_state_id)
                    VALUES (:invoice_note_id, :invoice_state_id)";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':invoice_note_id' => $invoiceNoteId,
                ':invoice_state_id' => 1,
            ])){
                throw new Exception('No se pudo insertar el registro');
            }

            // Insert items
            foreach ($invoice['item'] as $row){
                $sql = "INSERT INTO invoice_note_item (invoice_note_id, product_code, unit_measure, description, quantity, unit_value, unit_price, discount,
                                                        affectation_code, total_base_igv, igv, system_isc_code, total_base_isc,
                                                        tax_isc, isc, total_base_other_taxed, quantity_plastic_bag, plastic_bag_tax, percentage_other_taxed, other_taxed,
                                                        total_value, total)
                            VALUES (:invoice_note_id, :product_code, :unit_measure, :description, :quantity, :unit_value, :unit_price, :discount,
                                    :affectation_code, :total_base_igv, :igv, :system_isc_code, :total_base_isc,
                                    :tax_isc, :isc, :total_base_other_taxed, :quantity_plastic_bag, :plastic_bag_tax, :percentage_other_taxed, :other_taxed,
                                    :total_value, :total)";
                $stmt = $this->db->prepare($sql);

                $stmt->execute([
                    ':invoice_note_id' => $invoiceNoteId,
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

                    ':system_isc_code' => (float)($row['system_isc_code'] ?? 0),
                    ':total_base_isc' => (float)($row['total_base_isc'] ?? 0),
                    ':tax_isc' => (float)($row['tax_isc'] ?? 0),
                    ':isc' => (float)($row['isc'] ?? 0),

                    ':total_base_other_taxed' => 0,
                    ':percentage_other_taxed' => 0,
                    ':other_taxed' => 0,

                    ':quantity_plastic_bag' => (float)($row['quantity_plastic_bag'] ?? 0),
                    ':plastic_bag_tax' => (float)($row['plastic_bag_tax'] ?? 0),

                    ':total_value' => (float)($row['total_value'] ?? 0),
                    ':total' => (float)($row['total'] ?? 0),
                ]);
            }

            $this->db->commit();
            return $invoiceNoteId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }


    public function UpdateInvoiceNoteSunatByInvoiceId($invoiceId, $data)
    {
        try {
            $sql = "UPDATE invoice_note_sunat SET ";
            foreach ($data as $key => $value) {
                $sql .= "$key = :$key, ";
            }
            $sql = trim(trim($sql), ',');
            $sql .= " WHERE invoice_note_id = :invoice_note_id";

            $execute = [];
            foreach ($data as $key => $value) {
                $execute[":$key"] = $value;
            }
            $execute[":invoice_note_id"] = $invoiceId;

            $stmt = $this->db->prepare($sql);
            if (!$stmt->execute($execute)) {
                throw new Exception("Error al actualizar el registro");
            }
            return $invoiceId;
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function GetByIdDocumentDescription(int $id)
    {
        try{
            $sql = "SELECT invoice_note.invoice_note_id, CONCAT(invoice_note.serie,'-',invoice_note.correlative,' (',dtc.description,') ',invoice_note.date_of_issue) as description
                    FROM invoice_note
                    INNER JOIN cat_document_type_code dtc on invoice_note.document_code = dtc.code
                    WHERE invoice_note.invoice_note_id = :invoice_note_id ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':invoice_note_id' => $id,
            ]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

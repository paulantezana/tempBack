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
                            customer.social_reason, customer.document_number, cat_currency_type_code.symbol as currency_symbol,
                            invoice.document_code as invoice_document_code,
                            sunat_comunicate.sunat_response_description, sunat_response_code, creation_date as sunat_creation_date
                        FROM invoice_note
                        INNER JOIN customer ON invoice_note.customer_id = customer.customer_id
                        INNER JOIN cat_document_type_code ON invoice_note.document_code = cat_document_type_code.code
                        INNER JOIN cat_currency_type_code ON invoice_note.currency_code = cat_currency_type_code.code
                        INNER JOIN cat_operation_type_code ON invoice_note.operation_code = cat_operation_type_code.code
                        LEFT JOIN invoice ON invoice_note.invoice_id = invoice.invoice_id
                        LEFT JOIN (
                            SELECT sunat_communication.reference_id, sunat_response.sunat_response_description, sunat_response.sunat_response_code, sunat_communication.creation_date FROM sunat_communication
                            INNER JOIN sunat_response on sunat_communication.sunat_communication_id = sunat_response.sunat_communication_id
                        ) as sunat_comunicate ON sunat_comunicate.reference_id = invoice_note.invoice_note_id
                        ";
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
                            customer.social_reason as customer_social_reason, customer.document_number as customer_document_number, 
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
                    INNER JOIN customer ON invoice_note.customer_id = customer.customer_id
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

    public function SearchBySerieCorrelative(string $search) {
        try{
            $sql = 'SELECT  invoice_note.invoice_note_id, invoice_note.serie, invoice_note.correlative, invoice_note.total, invoice_note.date_of_issue, cat_document_type_code.description as document_type_code_description 
                    FROM invoice_note
                    INNER JOIN cat_document_type_code ON invoice_note.document_code = cat_document_type_code.code
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

    public function Insert($invoice)
    {
        try{
            $currentDate = date('Y-m-d H:i:s');
            $currentTime = date('H:i:s');

            $this->db->beginTransaction();

            $sql = "INSERT INTO invoice_note ( local_id, invoice_note_key,  date_of_issue, time_of_issue, date_of_due, serie, correlative, observation, sunat_state, change_type,
                                            document_code, currency_code, operation_code, customer_id, total_prepayment, total_free, total_exportation,
                                            total_other_charged, total_discount, total_exonerated, total_unaffected, total_taxed, total_igv, total_base_isc,
                                            total_isc, total_charge, total_base_other_taxed, total_other_taxed, total_value, total,
                                            global_discount_percentage, purchase_order, vehicle_plate, term, perception_code, detraction,
                                            related, guide, legend, pdf_format, pdf_url, reason_update_code, invoice_id, percentage_igv, percentage_plastic_bag_tax, total_plastic_bag_tax,
                                            created_at,updated_at,created_user_id,updated_user_id)
                    VALUES (:local_id, :invoice_note_key, :date_of_issue, :time_of_issue, :date_of_due, :serie, :correlative, :observation, :sunat_state, :change_type,
                            :document_code, :currency_code, :operation_code, :customer_id, :total_prepayment, :total_free, :total_exportation,
                            :total_other_charged, :total_discount, :total_exonerated, :total_unaffected, :total_taxed, :total_igv, :total_base_isc,
                            :total_isc, :total_charge, :total_base_other_taxed, :total_other_taxed, :total_value, :total,
                            :global_discount_percentage, :purchase_order, :vehicle_plate, :term, :perception_code, :detraction, 
                            :related, :guide, :legend, :pdf_format, :pdf_url, :reason_update_code, :invoice_id, :percentage_igv, :percentage_plastic_bag_tax, :total_plastic_bag_tax,
                            :created_at,:updated_at,:created_user_id,:updated_user_id)";
            $stmt = $this->db->prepare($sql);

            $localId = (int)$_COOKIE['CurrentBusinessLocal'];

            if(!$stmt->execute([
                ':local_id' => $localId,
                ':invoice_note_key' => $localId . $invoice['document_code'] . $invoice['correlative'] . $invoice['serie'],
                ':date_of_issue' => $invoice['date_of_issue'],
                ':time_of_issue' => $currentTime,
                ':date_of_due' => $invoice['date_of_due'],
                ':serie' => $invoice['serie'],
                ':correlative' => $invoice['correlative'],
                ':observation' => $invoice['observation'],
                ':sunat_state' => 1,
                ':change_type' => $invoice['change_type'],
                ':document_code' => $invoice['document_code'],
                ':currency_code' => $invoice['currency_code'],
                ':operation_code' => $invoice['operation_code'],
                ':customer_id' => $invoice['customer_id'],
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
                ':pdf_url' => $invoice['pdf_url'] ?? '',
                ':reason_update_code' => $invoice['reason_update_code'] ?? '',
                ':invoice_id' => $invoice['invoice_id'] ?? '',
                ':percentage_igv' => (float)($invoice['percentage_igv'] ?? 0),
                ':percentage_plastic_bag_tax' => (float)($invoice['percentage_plastic_bag_tax'] ?? 0),
                ':total_plastic_bag_tax' => (float)($invoice['total_plastic_bag_tax'] ?? 0),

                ":created_at" => $currentDate,
                ":updated_at" => $currentDate,
                ":created_user_id" => $_SESSION[SESS],
                ":updated_user_id" => $_SESSION[SESS],
            ])){
                throw new Exception('No se pudo insertar el registro');
            }
            $invoiceNoteId = (int)$this->db->lastInsertId();

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

            // Insert Detraction
            if (isset($invoice['detraction_percentage']) && isset($invoice['detraction_enabled']) ){
                $sql = "INSERT INTO invoice_note_detraction(invoice_note_id, referral_value, effective_load, useful_load, travel_detail, 
                                                        whit_detraction, detraction_code, percentage, amount,
                                                        location_starting_code, address_starting_point, location_arrival_code, address_arrival_point,
                                                        boat_registration, boat_name, species_kind, delivery_address, delivery_date, quantity
                                                )  
                                                    VALUES (:invoice_note_id, :referral_value, :effective_load, :useful_load, :travel_detail,
                                                        :whit_detraction, :detraction_code, :percentage, :amount,
                                                        :location_starting_code, :address_starting_point, :location_arrival_code, :address_arrival_point,
                                                        :boat_registration, :boat_name, :species_kind, :delivery_address, :delivery_date, :quantity
                                                    )";
                $stmt = $this->db->prepare($sql);
                $detractionEnabled = $invoice['detraction_enabled'] == 'on' ? 1 : 0;

                if (!$stmt->execute([
                    ':invoice_note_id' => $invoiceNoteId,
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
                $sql = "INSERT INTO invoice_note_referral_guide(invoice_note_id, whit_guide, document_code, transfer_code, transport_code, transfer_start_date, total_gross_weight,
                                                        carrier_document_code, carrier_document_number, carrier_denomination, driver_document_code,
                                                        driver_document_number, driver_full_name, location_starting_code, address_starting_point,
                                                        location_arrival_code, address_arrival_point)  
                                                    VALUES (:invoice_note_id, :whit_guide, :document_code, :transfer_code, :transport_code, :transfer_start_date, :total_gross_weight,
                                                        :carrier_document_code, :carrier_document_number, :carrier_denomination, :driver_document_code,
                                                        :driver_document_number, :driver_full_name, :location_starting_code, :address_starting_point,
                                                        :location_arrival_code, :address_arrival_point)";
                $stmt = $this->db->prepare($sql);
                $referralGuideEnabled = $invoice['referral_guide_enabled'] == 'on' ? 1 : 0;
                if (!$stmt->execute([
                    ':invoice_note_id' => $invoiceNoteId,
                    ':whit_guide' => $referralGuideEnabled,
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
            return $invoiceNoteId;
        } catch (Exception $e) {
            $this->db->rollBack();
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

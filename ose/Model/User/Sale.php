<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class Sale extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("sale","sale_id",$db);
    }

    public function Paginate($page = 1, $limit = 10, $filter = []) {
        try{
            $filterNumber = 0;
            $sqlFilter = '';
            if ($filter['documentCode']){
                $sqlFilter .= " WHERE sale.document_code = {$filter['documentCode']}";
                $filterNumber++;
            }
            if ($filter['customerID']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "sale.customer_id = {$filter['customerID']}";
                $filterNumber++;
            }
            if ($filter['startDate']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "sale.date_of_issue >= '{$filter['startDate']}'";
                $filterNumber++;
            }
            if ($filter['saleSearch']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "sale.sale_id = '{$filter['saleSearch']}'";
                $filterNumber++;
            }
            if ($filter['endDate']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "sale.date_of_issue <= '{$filter['endDate']}'";
            }
            $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sqlFilter .= "sale.local_id = {$_COOKIE['CurrentBusinessLocal']}";

            $limit = 10;
            $offset = ($page - 1) * $limit;
            $total_rows = $this->db->query("SELECT COUNT(sale_id) FROM sale {$sqlFilter}")->fetchColumn();
            $total_pages = ceil($total_rows / $limit);

            $sql = "SELECT sale.*, cat_document_type_code.description as document_type_code_description, cat_operation_type_code.description as operation_type_code_description,
                           customer.social_reason, customer.document_number, cat_currency_type_code.symbol as currency_symbol,
                           sunat_comunicate.sunat_response_description, sunat_response_code, creation_date as sunat_creation_date
                    FROM sale
                        INNER JOIN customer ON sale.customer_id = customer.customer_id
                        INNER JOIN cat_document_type_code ON sale.document_code = cat_document_type_code.code
                        INNER JOIN cat_currency_type_code ON sale.currency_code = cat_currency_type_code.code
                        INNER JOIN cat_operation_type_code ON sale.operation_code = cat_operation_type_code.code
                        LEFT JOIN (
                            SELECT sunat_communication.reference_id, sunat_response.sunat_response_description, sunat_response.sunat_response_code, sunat_communication.creation_date FROM sunat_communication
                            INNER JOIN sunat_response on sunat_communication.sunat_communication_id = sunat_response.sunat_communication_id
                        ) as sunat_comunicate ON sunat_comunicate.reference_id = sale.sale_id
                    ";

            $sql .= $sqlFilter;
            $sql .= " ORDER BY sale.sale_id DESC LIMIT $offset, $limit";

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
            $sql = "SELECT sale.sale_id, sale.date_of_issue, sale.local_id FROM sale WHERE sale.date_of_issue = :date_of_issue AND sale.document_code = '03'
                AND sale.sale_id NOT IN (SELECT detail_sale_summary.sale_id FROM detail_sale_summary)";

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
            $sql = "SELECT sale.sale_id, sale.date_of_issue, sale.local_id FROM sale WHERE sale.date_of_issue = :date_of_issue AND sale.document_code = '03'
                AND sale.local_id = :sale_user_id
                AND sale.sale_id NOT IN (SELECT detail_sale_summary.sale_id FROM detail_sale_summary WHERE detail_sale_summary.local_id = :detail_sale_user_reference_id)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':date_of_issue' => $dateOfIssue,
                ':sale_user_id' => $userReferenceId,
                ':detail_sale_user_reference_id' => $userReferenceId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function ExistDocument($correlative, $serie, $document_code) {
        try{
            $sql = "SELECT sale_id FROM sale WHERE correlative = :correlative AND serie = :serie AND  document_code = :document_code LIMIT 1";
            $stmt = $this -> db -> prepare($sql);

            if (!$stmt -> execute([
                ':correlative' => $correlative,
                ':serie' => $serie,
                ':document_code' => $document_code,
            ])){
                return 0;
            }

            $data = $stmt->fetch();
            return $data['sale_id'];
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function SummaryById(int $saleID) {
        try{
            $sql = 'SELECT sale.*, 
                            (sale.total_igv + sale.total_isc + sale.total_other_taxed) as total_tax,
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
                    FROM sale
                    INNER JOIN customer ON sale.customer_id = customer.customer_id
                    INNER JOIN cat_document_type_code ON sale.document_code = cat_document_type_code.code
                    INNER JOIN cat_currency_type_code ON sale.currency_code = cat_currency_type_code.code
                    INNER JOIN cat_operation_type_code ON sale.operation_code = cat_operation_type_code.code
                    LEFT JOIN sale_referral_guide srg ON sale.sale_id = srg.sale_id
                    LEFT JOIN sale_detraction sd on sale.sale_id = sd.sale_id
                    WHERE sale.sale_id = :sale_id LIMIT 1';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':sale_id'=>$saleID]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Insert($invoice) {
        try{
            $currentDate = date('Y-m-d H:i:s');
            $currentTime = date('H:i:s');

            $this->db->beginTransaction();
            $sql = "INSERT INTO sale (local_id, sale_key, date_of_issue, time_of_issue, date_of_due, serie, correlative, observation, sunat_state, change_type,
                                        document_code, currency_code, operation_code, customer_id, total_prepayment,
                                        total_free, total_exportation, total_other_charged, total_discount, total_exonerated, total_unaffected,
                                        total_taxed, total_igv, total_base_isc, total_isc, total_charge, total_base_other_taxed, total_other_taxed,
                                        total_value, total, global_discount_percentage, purchase_order, vehicle_plate, term,
                                        perception_code, related, guide, legend,
                                        pdf_format, pdf_url, percentage_igv, percentage_plastic_bag_tax, total_plastic_bag_tax,
                                        created_at,updated_at,creation_user_id,modification_user_id, itinerant_enable, itinerant_location, itinerant_address, itinerant_urbanization)
                    VALUES (:local_id, :sale_key, :date_of_issue, :time_of_issue, :date_of_due, :serie, :correlative, :observation, :sunat_state, :change_type,
                                        :document_code, :currency_code, :operation_code, :customer_id, :total_prepayment,
                                        :total_free, :total_exportation, :total_other_charged, :total_discount, :total_exonerated, :total_unaffected,
                                        :total_taxed, :total_igv, :total_base_isc, :total_isc, :total_charge, :total_base_other_taxed, :total_other_taxed,
                                        :total_value, :total, :global_discount_percentage, :purchase_order, :vehicle_plate, :term,
                                        :perception_code, :related, :guide, :legend,
                                        :pdf_format, :pdf_url, :percentage_igv, :percentage_plastic_bag_tax, :total_plastic_bag_tax,
                                        :created_at,:updated_at,:creation_user_id,:modification_user_id, :itinerant_enable, :itinerant_location, :itinerant_address, :itinerant_urbanization)";
            $stmt = $this->db->prepare($sql);

            $guide = [];
            if (isset($invoice['guide'])){
                foreach ($invoice['guide'] as $key => $value){
                    array_push($guide,$value);
                }
            }
            $invoice['itinerant_enable'] = ($invoice['itinerant_enable'] ?? false) == 'on' ? 1 : 0;

            $localId = (int)$_COOKIE['CurrentBusinessLocal'];
            if(!$stmt->execute([
                ':local_id' => $localId,
                ':sale_key' => $localId . $invoice['document_code'] . $invoice['correlative'] . $invoice['serie'],
                ':date_of_issue' => $invoice['date_of_issue'],
                ':time_of_issue' => $currentTime,
                ':date_of_due' => $invoice['date_of_due'],
                ':serie' => $invoice['serie'],
                ':correlative' => $invoice['correlative'] ?? 1,
                ':observation' => $invoice['observation'] ?? '',
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
                ':perception_code' => $invoice['perception_code'] ?? '',
                ':related' => json_encode($invoice['related_array'] ?? []),
                ':guide' => json_encode($guide),
                ':legend' => json_encode($invoice['legend'] ?? []),
                ':pdf_format' => $invoice['pdf_format'] ?? '',
                ':pdf_url' => $invoice['pdf_url'] ?? '',
                ':percentage_igv' => (float)($invoice['percentage_igv'] ?? 0),
                ':percentage_plastic_bag_tax' => (float)($invoice['percentage_plastic_bag_tax'] ?? 0),
                ':total_plastic_bag_tax' => (float)($invoice['total_plastic_bag_tax'] ?? 0),

                ":created_at" => $currentDate,
                ":updated_at" => $currentDate,
                ":creation_user_id" => $_SESSION[SESS],
                ":modification_user_id" => $_SESSION[SESS],
                ":itinerant_enable" => $invoice['itinerant_enable'] ?? 0,
                ":itinerant_location" => $invoice['itinerant_location'] ?? '',
                ":itinerant_address" => $invoice['itinerant_address'] ?? '',
                ":itinerant_urbanization" => $invoice['itinerant_urbanization'] ?? '',
            ])){
                throw new Exception('No se pudo insertar el registro');
            }
            $saleId = (int)$this->db->lastInsertId();

            // Insert items
            foreach ($invoice['item'] as $row){
                $sql = "INSERT INTO detail_sale (sale_id, product_code, unit_measure, description, quantity, unit_value, unit_price, discount, affectation_code,
                                                    total_base_igv, igv, system_isc_code, total_base_isc, tax_isc, 
                                                    isc, total_base_other_taxed, percentage_other_taxed, other_taxed,
                                                    plastic_bag_tax, quantity_plastic_bag,
                                                    prepayment_regulation, prepayment_serie, prepayment_correlative,
                                                    total_value, total, charge)
                            VALUES (:sale_id, :product_code, :unit_measure, :description, :quantity, :unit_value, :unit_price, :discount, :affectation_code,
                                    :total_base_igv, :igv, :system_isc_code, :total_base_isc, :tax_isc, 
                                    :isc, :total_base_other_taxed, :percentage_other_taxed, :other_taxed,
                                    :plastic_bag_tax, :quantity_plastic_bag,
                                    :prepayment_regulation, :prepayment_serie, :prepayment_correlative,
                                    :total_value, :total, :charge)";

                $stmt = $this->db->prepare($sql);

                if (!$stmt->execute([
                    ':sale_id' => $saleId,
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

                    ':prepayment_regulation' => 0,
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
                $sql = "INSERT INTO sale_detraction(sale_id, referral_value, effective_load, useful_load, travel_detail, 
                                                        whit_detraction, detraction_code, percentage, amount,
                                                        location_starting_code, address_starting_point, location_arrival_code, address_arrival_point,
                                                        boat_registration, boat_name, species_kind, delivery_address, delivery_date, quantity
                                                )  
                                                    VALUES (:sale_id, :referral_value, :effective_load, :useful_load, :travel_detail,
                                                        :whit_detraction, :detraction_code, :percentage, :amount,
                                                        :location_starting_code, :address_starting_point, :location_arrival_code, :address_arrival_point,
                                                        :boat_registration, :boat_name, :species_kind, :delivery_address, :delivery_date, :quantity
                                                    )";
                $stmt = $this->db->prepare($sql);
                $detractionEnabled = $invoice['detraction_enabled'] == 'on' ? 1 : 0;

                if (!$stmt->execute([
                    ':sale_id' => $saleId,
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
                $sql = "INSERT INTO sale_referral_guide(sale_id, whit_guide, document_code, transfer_code, transport_code, transfer_start_date, total_gross_weight,
                                                        carrier_document_code, carrier_document_number, carrier_denomination, driver_document_code,
                                                        driver_document_number, driver_full_name, location_starting_code, address_starting_point,
                                                        location_arrival_code, address_arrival_point)  
                                                    VALUES (:sale_id, :whit_guide, :document_code, :transfer_code, :transport_code, :transfer_start_date, :total_gross_weight,
                                                        :carrier_document_code, :carrier_document_number, :carrier_denomination, :driver_document_code,
                                                        :driver_document_number, :driver_full_name, :location_starting_code, :address_starting_point,
                                                        :location_arrival_code, :address_arrival_point)";
                $stmt = $this->db->prepare($sql);
                $referralGuideEnabled = $invoice['referral_guide_enabled'] == 'on' ? 1 : 0;
                if (!$stmt->execute([
                    ':sale_id' => $saleId,
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
            return $saleId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function GetByIds($ids, int $userReferenceId){
        try{
            $ids = implode("','",$ids);

            $sql = "SELECT  sale.sale_id, sale.serie, sale.correlative, sale.total, sale.date_of_issue FROM sale
                    WHERE sale.sale_id IN('{$ids}') AND sale.local_id = :local_id  LIMIT 8";
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
            $sql = 'SELECT  sale.sale_id, sale.serie, sale.correlative, sale.total, sale.date_of_issue, cat_document_type_code.description as document_type_code_description FROM sale
                    INNER JOIN cat_document_type_code ON sale.document_code = cat_document_type_code.code
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
            $sql = "SELECT sale.sale_id, CONCAT(sale.serie,'-',sale.correlative,' (',dtc.description,') ',sale.date_of_issue) as description FROM sale
                    INNER JOIN cat_document_type_code dtc on sale.document_code = dtc.code
                    WHERE sale.sale_id = :sale_id ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':sale_id' => $id,
            ]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

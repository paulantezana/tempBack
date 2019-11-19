<?php

require_once __DIR__ . '/BaseModel.php';

class ReferralGuide extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("referral_guide","referral_guide_id",$db);
    }

    public function GetByIdXML(int $id) : array
    {
        try{
            $sql = "SELECT referral_guide.*, document_type_code.description as document_type_code_description, 
                        c.document_number as customer_document_number, c.identity_document_code as customer_identity_document_code,
                        c.social_reason as customer_social_reason,
                        trc.description as transfer_reason_description
                        FROM referral_guide
                        INNER JOIN document_type_code ON referral_guide.document_code = document_type_code.code
                        INNER JOIN customer c on referral_guide.customer_id = c.customer_id
                        INNER JOIN transfer_reason_code trc on document_type_code.code = trc.code
                        WHERE referral_guide_id = :referral_guide_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([":referral_guide_id"=>$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function SearchBySerieCorrelative($search) : array {
        try{
            $sql = 'SELECT referral_guide_id, serie, correlative FROM referral_guide WHERE serie LIKE :serie OR correlative LIKE :correlative  LIMIT 8';
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

    public function Paginate($page = 1, $limit = 10, $filter = []){
        try{
            $filterNumber = 0;
            $sqlFilter = '';
            if ($filter['customer_id']){
                $sqlFilter .= " WHERE referral_guide.customer_id = {$filter['customer_id']}";
                $filterNumber++;
            }
            if ($filter['start_date']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "referral_guide.date_of_issue >= '{$filter['start_date']}'";
                $filterNumber++;
            }
            if ($filter['referral_guide_id']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "referral_guide.referral_guide_id = '{$filter['referral_guide_id']}'";
                $filterNumber++;
            }
            if ($filter['end_date']){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "referral_guide.date_of_issue <= '{$filter['end_date']}'";
            }
            $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sqlFilter .= "referral_guide.local_id = {$_COOKIE['CurrentBusinessLocal']}";

            $offset = ($page - 1) * $limit;
            $totalRows = $this->db->query("SELECT COUNT(*) FROM referral_guide {$sqlFilter}")->fetchColumn();
            $totalPages = ceil($totalRows / $limit);

            $sql = "SELECT referral_guide.*, customer.social_reason as customer_social_reason FROM referral_guide
                INNER JOIN customer ON referral_guide.customer_id = customer.customer_id";
            $sql .= $sqlFilter;
            $sql .= " ORDER BY referral_guide.referral_guide_id DESC LIMIT $offset, $limit";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            $paginate = [
                'current' => $page,
                'pages' => $totalPages,
                'limit' => $limit,
                'data' => $data,
            ];
            return $paginate;
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Insert(array $guide) {
        try{
//            $currentDate = date('Y-m-d H:i:s');
            $currentTime = date('H:i:s');

            $sql = "INSERT INTO referral_guide( local_id, referral_guide_key, customer_id, document_code, serie, correlative, date_of_issue, time_of_issue,
                                                transfer_code, transport_code, transfer_start_date, total_gross_weight, number_packages,
                                                carrier_document_code, carrier_document_number, carrier_denomination, carrier_plate_number,
                                                driver_document_code, driver_document_number, driver_full_name, location_starting_code,
                                                address_starting_point, location_arrival_code, address_arrival_point, observations,
                                                pdf_format, pdf_url, sunat_state
                           )  VALUES (:local_id, :referral_guide_key, :customer_id, :document_code, :serie, :correlative, :date_of_issue, :time_of_issue,
                                        :transfer_code, :transport_code, :transfer_start_date, :total_gross_weight, :number_packages,
                                        :carrier_document_code, :carrier_document_number, :carrier_denomination, :carrier_plate_number,
                                        :driver_document_code, :driver_document_number, :driver_full_name, :location_starting_code,
                                        :address_starting_point, :location_arrival_code, :address_arrival_point, :observations,
                                        :pdf_format, :pdf_url, :sunat_state)";
            $stmt = $this->db->prepare($sql);

            $this->db->beginTransaction();
            if (!$stmt->execute([
                ':local_id' => $_COOKIE['CurrentBusinessLocal'],
                ':referral_guide_key' => $_COOKIE['CurrentBusinessLocal'] . $guide['document_code'] . $guide['serie'] . $guide['correlative'],
                ':customer_id' => $guide['customer_id'],
                ':document_code' => $guide['document_code'],
                ':serie' => $guide['serie'],
                ':correlative' => $guide['correlative'],
                ':date_of_issue' => $guide['date_of_issue'],
                ':time_of_issue' => $currentTime,
                ':transfer_code' => $guide['transfer_code'],
                ':transport_code' => $guide['transport_code'],
                ':transfer_start_date' => $guide['transfer_start_date'],
                ':total_gross_weight' => $guide['total_gross_weight'],
                ':number_packages' => $guide['number_packages'],

                ':carrier_document_code' => $guide['carrier_document_code'],
                ':carrier_document_number' => $guide['carrier_document_number'],
                ':carrier_denomination' => $guide['carrier_denomination'],
                ':carrier_plate_number' => $guide['carrier_plate_number'],

                ':driver_document_code' => $guide['driver_document_code'],
                ':driver_document_number' => $guide['driver_document_number'],
                ':driver_full_name' => $guide['driver_full_name'],

                ':location_starting_code' => $guide['location_starting_code'],
                ':address_starting_point' => $guide['address_starting_point'],
                ':location_arrival_code' => $guide['location_arrival_code'],
                ':address_arrival_point' => $guide['address_arrival_point'],

                ':observations' => $guide['observations'],
                ':pdf_format' => $guide['pdf_format'] ?? 'A4',
                ':pdf_url' => $guide['pdf_url'] ?? '',
                ':sunat_state' => 1,
            ])){
                throw new Exception('No se pudo insertar el registro');
            }
            $referralGuideId = (int)$this->db->lastInsertId();

            // Insert items
            foreach ($guide['item'] as $row){
                $sql = "INSERT INTO detail_referral_guide(quantity, description, product_code, unit_measure, referral_guide_id) VALUES 
                                                        (:quantity, :description, :product_code, :unit_measure, :referral_guide_id)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ":quantity" => $row['quantity'],
                    ":description" => $row['description'],
                    ":product_code" => $row['product_code'],
                    ":unit_measure" => $row['unit_measure'],
                    ":referral_guide_id" => $referralGuideId,
                ]);
            }

            $this->db->commit();
            return $referralGuideId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Update(int $guideId, array $guide)
    {
        try{
            $sql = "UPDATE referral_guide SET local_id = :local_id, customer_id = :customer_id, document_code = :document_code, serie = :serie, 
                                                correlative = :correlative, date_of_issue = :date_of_issue, time_of_issue = :time_of_issue,
                                                transfer_code = :transfer_code, transport_code = :transport_code, transfer_start_date = :transfer_start_date,
                                                total_gross_weight = :total_gross_weight, number_packages = :number_packages,
                                                carrier_document_code = :carrier_document_code, carrier_document_number = :carrier_document_number, 
                                                carrier_denomination = :carrier_denomination, carrier_plate_number = :carrier_plate_number,
                                                driver_document_code = :driver_document_code, driver_document_number = :driver_document_number,
                                                driver_full_name = :driver_full_name, location_starting_code = :location_starting_code,
                                                address_starting_point = :address_starting_point, location_arrival_code = :location_arrival_code,
                                                address_arrival_point = :address_arrival_point, observations = :observations
                        WHERE referral_guide_id = :referral_guide_id";
            $stmt = $this->db->prepare($sql);

            $this->db->beginTransaction();
            if (!$stmt->execute([
                ':local_id' => $_COOKIE['CurrentBusinessLocal'],
                ':customer_id' => $guide['customer_id'],
                ':document_code' => $guide['document_code'],
                ':serie' => $guide['serie'],
                ':correlative' => $guide['correlative'],
                ':date_of_issue' => $guide['date_of_issue'],
                ':time_of_issue' => $guide['time_of_issue'],
                ':transfer_code' => $guide['transfer_code'],
                ':transport_code' => $guide['transport_code'],
                ':transfer_start_date' => $guide['transfer_start_date'],
                ':total_gross_weight' => $guide['total_gross_weight'],
                ':number_packages' => $guide['number_packages'],

                ':carrier_document_code' => $guide['carrier_document_code'],
                ':carrier_document_number' => $guide['carrier_document_number'],
                ':carrier_denomination' => $guide['carrier_denomination'],
                ':carrier_plate_number' => $guide['carrier_plate_number'],

                ':driver_document_code' => $guide['driver_document_code'],
                ':driver_document_number' => $guide['driver_document_number'],
                ':driver_full_name' => $guide['driver_full_name'],

                ':location_starting_code' => $guide['location_starting_code'],
                ':address_starting_point' => $guide['address_starting_point'],
                ':location_arrival_code' => $guide['location_arrival_code'],
                ':address_arrival_point' => $guide['address_arrival_point'],

                ':observations' => $guide['observations'],

                ':referral_guide_id' => $guideId,
            ])){
                throw new Exception('No se pudo actualizar los registros');
            }

            foreach ($guide['item'] as $row){
                $stmt = $this->db->prepare("SELECT * FROM  detail_referral_guide WHERE referral_guide_id = :referral_guide_id");
                $stmt -> execute([
                    ':referral_guide_id' => $row['detail_referral_guide_id'],
                ]);
                $data = $stmt->fetch();

                if ($stmt->rowCount() > 0) {
                    $stmt = $this->db->prepare("UPDATE detail_referral_guide SET description = :description, quantity = :quantity, product_code = :product_code, referral_guide_id = :referral_guide_id
                                                            WHERE detail_referral_guide_id = :detail_referral_guide_id");
                    $stmt->execute([
                        ":description" => $row['description'],
                        ":quantity" => $row['quantity'],
                        ":product_code" => $row['product_code'],
                        ":referral_guide_id" => $row['referral_guide_id'],
                        ":detail_referral_guide_id" => $data['detail_referral_guide_id'],
                    ]);
                    continue;
                }

                $sql = "INSERT INTO detail_referral_guide(description, quantity, product_code, referral_guide_id) VALUES (:description, :quantity, :product_code, :referral_guide_id)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ":description" => $row['description'] ?? 0,
                    ":quantity" => $row['quantity'] ?? 0,
                    ":product_code" => $row['product_code'] ?? 0,
                    ":referral_guide_id" => $guideId,
                ]);
            }

            $this->db->commit();
            return $guideId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class Customer extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("customer","customer_id",$db);
    }

    public function GetByDocumentNumber($customer)
    {
        try {
            $sql = "SELECT * FROM customer WHERE document_number = :document_number AND business_id = :business_id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ":document_number" => $customer['documentNumber'],
                ":business_id" => $customer['businessId'],
            ]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Paginate($page, $limit = 10, $search = '', $businessId = 0) {
        try{
            $offset = ($page - 1) * $limit;
            $totalRows = $this->db->query("SELECT COUNT(*) FROM customer WHERE business_id = '$businessId'")->fetchColumn();
            $totalPages = ceil($totalRows / $limit);

            $sql = "SELECT customer.*, cidtc.description as identity_document_type_code_description FROM customer
                    INNER JOIN cat_identity_document_type_code cidtc on customer.identity_document_code = cidtc.code
                    WHERE customer.business_id = :business_id
                    ORDER BY customer_id DESC LIMIT $offset, $limit";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':business_id' => $businessId
            ]);
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

    public function Insert(array $customer) {
        try{
            $currentDate = date('Y-m-d H:i:s');

            $sql = "SELECT * FROM customer WHERE business_id = :business_id AND document_number = :document_number";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ":business_id" => $customer['businessId'],
                ":document_number" => $customer['documentNumber'],
            ])){
                throw new Exception("Error al consultar el cliente");
            }

            if ($stmt->fetch()){
                throw new Exception("El cliente ya está registrado en la base de datos");
            }

            $sql = "INSERT INTO customer (document_number,identity_document_code,social_reason,commercial_reason,fiscal_address,main_email,
                                        optional_email_1,optional_email_2,telephone,business_id,created_at,updated_at,created_user_id,updated_user_id)
                VALUES (:document_number,:identity_document_code,:social_reason,:commercial_reason,:fiscal_address,:main_email,
                        :optional_email_1,:optional_email_2,:telephone,:business_id,:created_at,:updated_at,:created_user_id,:updated_user_id)";
            $stmt = $this->db->prepare($sql);

            // Execute query
            if(!$stmt->execute([
                ":document_number" => $customer['documentNumber'],
                ":identity_document_code" => $customer['identityDocumentCode'],
                ":social_reason" => $customer['socialReason'],
                ":commercial_reason" => $customer['commercialReason'],
                ":fiscal_address" => $customer['fiscalAddress'],
                ":main_email" => $customer['mainEmail'] ?? '',
                ":optional_email_1" => $customer['optionalEmail1'] ?? '',
                ":optional_email_2" => $customer['optionalEmail2'] ?? '',
                ":telephone" => $customer['telephone'] ?? '',
                ":business_id" => $customer['businessId'],

                ":created_at" => $currentDate,
                ":updated_at" => $currentDate,
                ":created_user_id" => $_SESSION[SESS],
                ":updated_user_id" => $_SESSION[SESS],
            ])){
                throw new Exception("Error al insertar el cliente");
            }

            return $this->db->lastInsertId();

        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Search($search){
        try{
            $sql = 'SELECT * FROM customer WHERE (social_reason 
                            LIKE :social_reason OR commercial_reason LIKE :commercial_reason OR fiscal_address LIKE :fiscal_address)
                            AND business_id = :business_id LIMIT 8';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':social_reason' => '%' . $search['search'] . '%',
                ':commercial_reason' => '%' . $search['search'] . '%',
                ':fiscal_address' => '%' . $search['search'] . '%',
                ':business_id' => $search['businessId'],
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
    public function SearchByDocumentNumber($search){
        try{
            $sql = 'SELECT * FROM customer WHERE document_number LIKE :document_number AND business_id = :business_id LIMIT 8';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':document_number' => '%' . $search['search'] . '%',
                ':business_id' => $search['businessId'],
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

<?php

require_once __DIR__ . '/BaseModel.php';

class BusinessBankAccount extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("business_bank_account","business_bank_account_id",$db);
    }

    public function Paginate($page = 1, $limit = 10, $businessId = 0) {
        try{
            $offset = ($page - 1) * $limit;

            $totalRows = $this->db->query("SELECT COUNT(*) FROM business_bank_account WHERE business_bank_account_id = '$businessId'")->fetchColumn();
            $totalPages = ceil($totalRows / $limit);

            $sql = "SELECT business_bank_account.* FROM business_bank_account
                    WHERE business_bank_account.business_bank_account_id = :business_bank_account_id
                    LIMIT $offset, $limit";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':business_bank_account_id' => $businessId
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

            $sql = "INSERT INTO business_bank_account (updated_at, created_at, creation_user_id, modification_user_id, business_local_id,
                                                        currency_code, account_type, name_bank, headline, account_number, cci, description)
                VALUES (:updated_at, :created_at, :creation_user_id, :modification_user_id, :business_local_id,
                        :currency_code, :account_type, :name_bank, :headline, :account_number, :cci, :description)";
            $stmt = $this->db->prepare($sql);

            // Execute query
            if(!$stmt->execute([
                ":created_at" => $currentDate,
                ":updated_at" => $currentDate,
                ":creation_user_id" => $_SESSION[SESS],
                ":modification_user_id" => $_SESSION[SESS],

                ":business_local_id" => $customer['business_local_id'],
                ":currency_code" => $customer['currency_code'],
                ":account_type" => $customer['account_type'],
                ":name_bank" => $customer['name_bank'],
                ":headline" => $customer['headline'],
                ":account_number" => $customer['account_number'],
                ":cci" => $customer['cci'],
                ":description" => $customer['description'],
            ])){
                throw new Exception("Error al insertar el cliente");
            }

            return $this->db->lastInsertId();

        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}
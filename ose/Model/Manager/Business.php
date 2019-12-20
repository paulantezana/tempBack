<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class Business extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("business","business_id",$db);
    }

    public function Paginate($page = 1, $limit = 10, $search = '') {
        try{
            $offset = ($page - 1) * $limit;

            $totalRows = $this->db->query("SELECT COUNT(*) FROM business WHERE social_reason LIKE '%{$search}%'")->fetchColumn();
            $totalPages = ceil($totalRows / $limit);

            $sql = "SELECT * FROM business WHERE social_reason LIKE '%{$search}%' ORDER BY business_id DESC LIMIT $offset, $limit";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':social_reason' => $search
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

    public function Insert(array $business, $userReferId) {
        try{
            $sql = "INSERT INTO business (include_igv, continue_payment, total_calculation_item, send_email_company, ruc, social_reason, commercial_reason, email, phone, detraction_bank_account)
                        VALUES (:include_igv, :continue_payment, :total_calculation_item, :send_email_company, :ruc, :social_reason, :commercial_reason, :email, :phone, :detraction_bank_account)";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':include_igv' => $business['includeIgv'] ?? 0,
                ':continue_payment' => $business['continuePayment'] ?? 0,
                ':total_calculation_item' => $business['totalCalculationItem'] ?? '',
                ':send_email_company' => $business['sendEmailCompany'] ?? 0,
                ':ruc' => $business['ruc'],
                ':social_reason' => $business['socialReason'],
                ':commercial_reason' => $business['commercialReason'],
                ':email' => $business['email'],
                ':phone' => $business['phone'],
                ':detraction_bank_account' => $business['detractionBankAccount'],
            ])){
                throw new Exception("Error al insertar el registro");
            }
            $businessId = (int)$this->db->lastInsertId();

            $sql = "INSERT INTO business_user (business_id, user_id) VALUES (:business_id, :user_id)";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':business_id' => $businessId,
                ':user_id' => $userReferId,
            ])){
                throw new Exception("Error al insertar el registro");
            }
            return $businessId;
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

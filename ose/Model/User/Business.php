<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class Business extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("business","business_id",$db);
    }

    public function GetByUserId($userReferID){
        try{
            $sql = "SELECT business.* 
                    FROM business 
                    INNER JOIN business_user ON business.business_id = business_user.business_id
                    WHERE business_user.user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([":user_id" => $userReferID]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Save($business){
        try{
            if (((int)$business['business_id'] ?? 0) >= 1){
                $this->UpdateById((int)$business['business_id'],[
                    'include_igv' => (bool)$business['include_igv'] ?? false,
                    'continue_payment' => (bool)$business['continue_payment'] ?? false,
                    'total_calculation_item' => $business['total_calculation_item'] ?? '',
                    'ruc' => $business['ruc'],
                    'social_reason' => $business['social_reason'],
                    'commercial_reason' => $business['commercial_reason'],
                    'email' => $business['email'],
                    'phone' => $business['phone'],
                    'web_site' => $business['web_site'],
                    'detraction_bank_account' => $business['detraction_bank_account'],
                ]);
                return $business['business_id'];
            } else {
                $sql = "INSERT INTO business (include_igv, continue_payment, total_calculation_item, send_email_company, ruc, social_reason, commercial_reason, email, phone, web_site, detraction_bank_account)
                        VALUES (:include_igv, :continue_payment, :total_calculation_item, :send_email_company, :ruc, :social_reason, :commercial_reason, :email, :phone, :web_site, :detraction_bank_account)";
                $stmt = $this->db->prepare($sql);
                if(!$stmt->execute([
                    ':include_igv' => (bool)$business['include_igv'] ?? false,
                    ':continue_payment' => (bool)$business['continue_payment'] ?? false,
                    ':total_calculation_item' => $business['total_calculation_item'] ?? '',
                    ':send_email_company' => $business['send_email_company'] ?? false,
                    ':ruc' => $business['ruc'],
                    ':social_reason' => $business['social_reason'],
                    ':commercial_reason' => $business['commercial_reason'],
                    ':email' => $business['email'],
                    ':phone' => $business['phone'],
                    ':web_site' => $business['web_site'],
                    ':detraction_bank_account' => $business['detraction_bank_account'],
                ])){
                    throw new Exception("Error al insertar el registro");
                }
                $businessId = (int)$this->db->lastInsertId();


                $sql = "INSERT INTO business_user (business_id, user_id) VALUES (:business_id, :user_id)";
                $stmt = $this->db->prepare($sql);
                if(!$stmt->execute([
                    ':business_id' => $businessId,
                    ':user_id' => $_SESSION[SESS],
                ])){
                    throw new Exception("Error al insertar el registro");
                }

                return $businessId;
            }
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class DetailReferralGuide extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("referral_guide","referral_guide_id",$db);
    }

    public function ByReferralGuideIdXML(int $referralGuideId) {
        try{
            $sql = 'SELECT * FROM detail_referral_guide WHERE referral_guide_id = :referral_guide_id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':referral_guide_id' => $referralGuideId,
            ]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

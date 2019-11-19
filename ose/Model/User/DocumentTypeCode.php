<?php

require_once __DIR__ . '/BaseModel.php';

class DocumentTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("document_type_code","code",$db);
    }

    public function ByInCodes(array $codes) {
        try{
            $in =  "'" . implode('\',\'',$codes) . "'";
            $sql = "SELECT * FROM document_type_code WHERE code IN ($in)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

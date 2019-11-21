<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class ProductCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("product_code","code",$db);
    }
    public function Search($search){
        try{
            $sql = "SELECT * FROM product_code WHERE description LIKE :description OR code LIKE :code LIMIT 8";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ":description" => '%' . $search . '%',
                ":code" => '%' . $search . '%',
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

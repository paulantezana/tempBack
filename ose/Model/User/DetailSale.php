<?php


class DetailSale
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function BySaleId($saleId) {
        try{
            $sql = 'SELECT * FROM detail_sale WHERE sale_id = :sale_id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':sale_id' => $saleId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function BySaleIdSummary($saleId) {
        try{
            $sql = 'SELECT * FROM detail_sale WHERE detail_sale.sale_id = :sale_id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':sale_id' => $saleId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function BySaleIdXML($saleId) {
        try{
            $sql = 'SELECT detail_sale.*, 
                                (IFNULL(detail_sale.igv,0) + IFNULL(detail_sale.isc,0) + IFNULL(detail_sale.other_taxed,0))  as total_taxed,
                                affectation.description as affectation_description, affectation.tribute_code as affectation_tribute_code, affectation.onerous as affectation_onerous,
                                affectation.international_code as affectation_international_code, affectation.name as affectation_name
                            FROM detail_sale
                            LEFT JOIN (
                                SELECT affectation_igv_type_code.*, tribute_type_code.international_code, tribute_type_code.name  FROM affectation_igv_type_code
                                INNER JOIN tribute_type_code ON affectation_igv_type_code.tribute_code = tribute_type_code.code
                            ) as affectation ON affectation.code = detail_sale.affectation_code
                            WHERE detail_sale.sale_id = :sale_id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':sale_id' => $saleId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

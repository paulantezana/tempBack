<?php


class DetailSaleNote
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function BySaleId(int $saleNoteId) {
        try{
            $sql = 'SELECT * FROM detail_sale_note WHERE sale_note_id = :sale_note_id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':sale_note_id' => $saleNoteId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function BySaleNoteIdSummary(int $saleNoteId) {
        try{
            $sql = 'SELECT detail_sale_note.* FROM detail_sale_note WHERE detail_sale_note.sale_note_id = :sale_note_id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':sale_note_id' => $saleNoteId,
            ]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function BySaleNoteIdXML(int $saleNoteId) {
        try{
            $sql = 'SELECT detail_sale_note.*,
                            (IFNULL(detail_sale_note.igv,0) + IFNULL(detail_sale_note.isc,0) + IFNULL(detail_sale_note.other_taxed,0))  as total_taxed,
                               affectation.description as affectation_description, affectation.tribute_code as affectation_tribute_code, affectation.onerous as affectation_onerous,
                               affectation.international_code as affectation_international_code, affectation.name as affectation_name
                            FROM detail_sale_note
                            LEFT JOIN (
                                SELECT affectation_igv_type_code.*, tribute_type_code.international_code, tribute_type_code.name  FROM affectation_igv_type_code
                                    INNER JOIN tribute_type_code ON affectation_igv_type_code.tribute_code = tribute_type_code.code
                            ) as affectation ON affectation.code = detail_sale_note.affectation_code
                    WHERE detail_sale_note.sale_note_id = :sale_note_id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':sale_note_id' => $saleNoteId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

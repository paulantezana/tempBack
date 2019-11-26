<?php


class InvoiceNoteItem
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function ByInvoiceId(int $invoiceNoteId) {
        try{
            $sql = 'SELECT * FROM invoice_note_item WHERE invoice_note_id = :invoice_note_id';

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':invoice_note_id' => $invoiceNoteId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function ByInvoiceNoteIdSummary(int $invoiceNoteId) {
        try{
            $sql = 'SELECT invoice_note_item.* FROM invoice_note_item WHERE invoice_note_item.invoice_note_id = :invoice_note_id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':invoice_note_id' => $invoiceNoteId,
            ]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function ByInvoiceNoteIdXML(int $invoiceNoteId) {
        try{
            $sql = 'SELECT invoice_note_item.*,
                            (IFNULL(invoice_note_item.igv,0) + IFNULL(invoice_note_item.isc,0) + IFNULL(invoice_note_item.other_taxed,0))  as total_taxed,
                               affectation.description as affectation_description, affectation.tribute_code as affectation_tribute_code, affectation.onerous as affectation_onerous,
                               affectation.international_code as affectation_international_code, affectation.name as affectation_name
                            FROM invoice_note_item
                            LEFT JOIN (
                                SELECT cat_affectation_igv_type_code.*, cat_tribute_type_code.international_code, cat_tribute_type_code.name  FROM cat_affectation_igv_type_code
                                    INNER JOIN cat_tribute_type_code ON cat_affectation_igv_type_code.tribute_code = cat_tribute_type_code.code
                            ) as affectation ON affectation.code = invoice_note_item.affectation_code
                    WHERE invoice_note_item.invoice_note_id = :invoice_note_id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':invoice_note_id' => $invoiceNoteId,
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

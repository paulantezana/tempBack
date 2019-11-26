<?php


class DetailTicketSummary
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function GetByTicketSummaryId($ticketSummaryId) : array {
        try{
            $sql = 'SELECT detail_ticket_summary .*,
                       invoice.date_of_issue as invoice_date_of_issue, invoice.serie as invoice_serie, invoice.correlative as invoice_correlative, invoice.total as invoice_total, 
                       cat_document_type_code.description as document_type_code_description,
                       invoice.currency_code as invoice_currency_code,
                       customer.social_reason as customer_social_reason FROM detail_ticket_summary 
                INNER JOIN invoice ON detail_ticket_summary.invoice_id = invoice.invoice_id
                INNER JOIN cat_document_type_code ON invoice.document_code = cat_document_type_code.code
                INNER JOIN customer ON invoice.customer_id = customer.customer_id
                WHERE detail_ticket_summary.ticket_summary_id = :ticket_summary_id';

            $stmt = $this -> db -> prepare($sql);
            $stmt->execute([
                ':ticket_summary_id' => $ticketSummaryId,
            ]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function GetByTicketSummaryIdXML(int $ticketSummaryId) : array {
        try{
            $sql = 'SELECT sa.invoice_id, sa.document_code,  sa.serie, sa.correlative, sa.total_prepayment, sa.total_free, sa.total_exportation, 
                           sa.total_other_charged, sa.total_discount, sa.total_exonerated, sa.total_unaffected, sa.total_taxed, sa.total_igv,
                           sa.total_isc, sa.total_charge, sa.total_base_other_taxed, sa.total_other_taxed, sa.total,
                           sa.perception_code,
                        cus.document_number as customer_document_number, cus.identity_document_code as customer_identity_document_code,
                        dTs.summary_state_code as summary_state_code
                        FROM detail_ticket_summary as dTs
                        INNER JOIN invoice sa on dTs.invoice_id = sa.invoice_id
                        INNER JOIN customer cus on sa.customer_id = cus.customer_id
                        WHERE dTs.ticket_summary_id = :ticket_summary_id';

            $stmt = $this -> db -> prepare($sql);
            $stmt->execute([
                ':ticket_summary_id' => $ticketSummaryId,
            ]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

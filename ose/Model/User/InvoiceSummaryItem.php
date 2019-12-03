<?php


class InvoiceSummaryItem
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
            $sql = 'SELECT i.invoice_id, i.document_code,  i.serie, i.correlative, i.total_prepayment, i.total_free, i.total_exportation,
                           i.total_other_charged, i.total_discount, i.total_exonerated, i.total_unaffected, i.total_taxed, i.total_igv,
                           i.total_isc, i.total_charge, i.total_base_other_taxed, i.total_other_taxed, i.total,
                           i.perception_code, i.currency_code,
                           ic.document_number as customer_document_number, ic.identity_document_code as customer_identity_document_code,
                           invoice_summary_item.summary_state_code
                            FROM invoice_summary_item
                            INNER JOIN invoice i on invoice_summary_item.invoice_id = i.invoice_id
                            INNER JOIN invoice_customer ic on i.invoice_id = ic.invoice_id
                            WHERE invoice_summary_item.invoice_summary_id = :invoice_summary_id';
            $stmt = $this -> db -> prepare($sql);
            $stmt->execute([
                ':invoice_summary_id' => $ticketSummaryId,
            ]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

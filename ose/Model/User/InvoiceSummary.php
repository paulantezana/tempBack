<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class InvoiceSummary extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("invoice_summary","invoice_summary_id",$db);
    }

    public function Paginate($page, $limit = 10, $filter = [], $localId = 0){
        $filterNumber = 0;
        $sqlFilter = '';
        if ($filter['startDate'] ?? false){
            $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sqlFilter .= " WHERE invoice_summary.date_of_issue >= '{$filter['startDate']}'";
            $filterNumber++;
        }
        if ($filter['endDate'] ?? false){
            $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sqlFilter .= "invoice_summary.date_of_issue <= '{$filter['endDate']}'";
        }

        $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
        $sqlFilter .= "invoice_summary.local_id = {$localId}";

        $offset = ($page - 1) * $limit;
        $totalRows = $this->db->query("SELECT COUNT(*) FROM invoice_summary {$sqlFilter}")->fetchColumn();
        $totalPages = ceil($totalRows / $limit);

        $sql = "SELECT * FROM invoice_summary";
        $sql .= $sqlFilter;
        $sql .= " ORDER BY invoice_summary.invoice_summary_id DESC LIMIT $offset, $limit";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        return [
            'current' => $page,
            'pages' => $totalPages,
            'limit' => $limit,
            'data' => $data,
        ];
    }

    public function Insert(array $invoice, int $localId, int $userId, string $dateOfIssue){
        try {
            $this->db->beginTransaction();

            if (count($invoice) >= 1){
                $sql = "INSERT INTO invoice_summary (local_id, date_of_issue, date_of_reference, ticket, pdf_format, sunat_state, creation_user_id)
                            VALUES (:local_id, :date_of_issue, :date_of_reference, :ticket, :pdf_format, :sunat_state, :creation_user_id)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':local_id' => $localId,
                    ':date_of_issue' => date('Y-m-d'),
                    ':date_of_reference' => $dateOfIssue,
                    ':ticket' => '',
                    ':pdf_format' => 'A4',
                    ':sunat_state' => 0,
                    ':creation_user_id' => $userId,
                ]);
                $ticketSummaryId = (int)$this->db->lastInsertId();

                foreach ($invoice as $key => $row){
                    $sql = "INSERT INTO invoice_summary_item (invoice_summary_id, invoice_id, sunat_state, date_of_issue, date_of_reference, local_id, summary_state_code)
                            VALUES (:invoice_summary_id, :invoice_id, :sunat_state, :date_of_issue, :date_of_reference, :local_id,:summary_state_code);";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        ':invoice_summary_id' => $ticketSummaryId,
                        ':invoice_id' => $row['invoice_id'],
                        ':date_of_issue' => date('Y-m-d'),
                        ':date_of_reference' => $row['date_of_issue'],
                        ':sunat_state' => '1',
                        ':local_id' => $localId,
                        ':summary_state_code' => $row['summary_state_code'],
                    ]);

                    $sql = "UPDATE invoice SET sunat_state = :sunat_state WHERE invoice_id = :invoice_id";
                    $stmt = $this->db->prepare($sql);
                    if(!$stmt->execute([
                        ':sunat_state' => 3,
                        ':invoice_id' => $row['invoice_id'],
                    ])){
                        throw new Exception("Error al generar el resumen diario");
                    }
                }
            }

            $this->db->commit();
            return $ticketSummaryId ?? 0;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class InvoiceNoteVoided extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("invoice_note_voided","invoice_note_voided_id",$db);
    }

    public function Paginate($page = 1, $limit = 10, array $filter = [], $localId = 0) {
        try{
            $filterNumber = 0;
            $sqlFilter = '';
            if ($filter['startDate'] ?? false){
                $sqlFilter .= " WHERE invoice_note_voided.date_of_issue >= '{$filter['startDate']}'";
                $filterNumber++;
            }
            if ($filter['endDate'] ?? false){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "invoice_note_voided.date_of_issue <= '{$filter['endDate']}'";
            }
            $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sqlFilter .= "invoice_note_voided.local_id = {$_COOKIE['CurrentBusinessLocal']}";

            $limit = 10;
            $offset = ($page - 1) * $limit;
            $totalRows = $this->db->query("SELECT COUNT(*) FROM invoice_note_voided {$sqlFilter}")->fetchColumn();
            $totalPages = ceil($totalRows / $limit);

            $sql = "SELECT invoice_note_voided.*, invoice_note.correlative as invoice_correlative, invoice_note.serie as invoice_serie,
                        invoice_note.date_of_issue as invoice_date_of_issue, invoice_note.document_code as invoice_document_code,
                        dtc.description as invoice_document_code_description
                        FROM invoice_note_voided
                        INNER JOIN invoice_note ON invoice_note_voided.invoice_note_id = invoice_note.invoice_note_id
                        INNER JOIN cat_document_type_code dtc on invoice_note.document_code = dtc.code";
            $sql .= $sqlFilter;
            $sql .= " ORDER BY invoice_note_voided.invoice_note_voided_id DESC LIMIT $offset, $limit";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            return [
                'current' => $page,
                'pages' => $totalPages,
                'limit' => $limit,
                'data' => $data,
            ];
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Insert($invoiceVoided){
        try{
            $this->db->beginTransaction();
            $currentDate = date('Y-m-d H:i:s');

            $sql = "INSERT INTO invoice_note_voided (local_id, date_of_issue, invoice_note_id, reason,
                                                created_at,updated_at,creation_user_id,modification_user_id) 
                                        VALUES (:local_id, :date_of_issue, :invoice_note_id, :reason,
                                                :created_at,:updated_at,:creation_user_id,:modification_user_id)";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':local_id' => $_COOKIE['CurrentBusinessLocal'],
                ':date_of_issue' => date('Y-m-d'),
                ':invoice_note_id' => $invoiceVoided['invoiceNoteId'],
                ':reason' => $invoiceVoided['reason'],

                ":created_at" => $currentDate,
                ":updated_at" => $currentDate,
                ":creation_user_id" => $_SESSION[SESS],
                ":modification_user_id" => $_SESSION[SESS],
            ])){
                throw new Exception("Error al insertar al anular el documento");
            }
            $voidedId = (int)$this->db->lastInsertId();


            $sql = "UPDATE invoice_note SET sunat_state = :sunat_state, modification_user_id = :modification_user_id, updated_at = :updated_at WHERE invoice_note_id = :invoice_note_id";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':sunat_state' => 4,
                ":modification_user_id" => $_SESSION[SESS],
                ":updated_at" => $currentDate,
                ':invoice_note_id' => $invoiceVoided['invoiceNoteId'],
            ])){
                throw new Exception("Error al insertar al anular el documento");
            }

            $this->db->commit();
            return $voidedId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

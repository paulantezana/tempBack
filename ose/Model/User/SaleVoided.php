<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class SaleVoided extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("sale_voided","sale_voided_id",$db);
    }

    public function Paginate($page = 1, $limit = 10, array $filter = [], $localId = 0) {
        try{
            $filterNumber = 0;
            $sqlFilter = '';
            if ($filter['startDate'] ?? false){
                $sqlFilter .= " WHERE sale_voided.date_of_issue >= '{$filter['startDate']}'";
                $filterNumber++;
            }
            if ($filter['endDate'] ?? false){
                $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
                $sqlFilter .= "sale_voided.date_of_issue <= '{$filter['endDate']}'";
            }
            $sqlFilter .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sqlFilter .= "sale_voided.local_id = {$_COOKIE['CurrentBusinessLocal']}";

            $limit = 10;
            $offset = ($page - 1) * $limit;
            $totalRows = $this->db->query("SELECT COUNT(*) FROM sale_voided {$sqlFilter}")->fetchColumn();
            $totalPages = ceil($totalRows / $limit);

            $sql = "SELECT sale_voided.*, sale.correlative as sale_correlative, sale.serie as sale_serie, sale.date_of_issue as sale_date_of_issue,
                        sale.document_code as sale_document_code,
                        dtc.description as sale_document_code_description
                        FROM sale_voided
                        INNER JOIN sale ON sale_voided.sale_id = sale.sale_id
                        INNER JOIN cat_document_type_code dtc on sale.document_code = dtc.code";
            $sql .= $sqlFilter;
            $sql .= " ORDER BY sale_voided.sale_voided_id DESC LIMIT $offset, $limit";

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

    public function Insert($saleVoided){
        try{
            $this->db->beginTransaction();
            $currentDate = date('Y-m-d H:i:s');

            $sql = "INSERT INTO sale_voided (local_id, date_of_issue, sale_id, reason,
                                                created_at,updated_at,creation_user_id,modification_user_id) 
                                        VALUES (:local_id, :date_of_issue, :sale_id, :reason,
                                                :created_at,:updated_at,:creation_user_id,:modification_user_id)";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':local_id' => $_COOKIE['CurrentBusinessLocal'],
                ':date_of_issue' => date('Y-m-d'),
                ':sale_id' => $saleVoided['saleId'],
                ':reason' => $saleVoided['reason'],

                ":created_at" => $currentDate,
                ":updated_at" => $currentDate,
                ":creation_user_id" => $_SESSION[SESS],
                ":modification_user_id" => $_SESSION[SESS],
            ])){
                throw new Exception("Error al insertar al anular el documento");
            }
            $voidedId = (int)$this->db->lastInsertId();


            $sql = "UPDATE sale SET sunat_state = :sunat_state, modification_user_id = :modification_user_id, updated_at = :updated_at WHERE sale_id = :sale_id";
            $stmt = $this->db->prepare($sql);
            if(!$stmt->execute([
                ':sunat_state' => 4,
                ':sale_id' => $saleVoided['saleId'],

                ":updated_at" => $currentDate,
                ":modification_user_id" => $_SESSION[SESS],
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

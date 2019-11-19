<?php


class Summary
{
    protected $db;
    public function __construct(PDO $DbConection)
    {
        $this->db=$DbConection;
    }

    public function Paginate(int $page, $filter){
        $page_count = 10;
        $offset = ($page - 1) * $page_count;

        $sql = "SELECT COUNT(*) FROM ticket_summary";
        if ($filter['referenceUserId'] ?? false){
            $sql .= " WHERE ticket_summary.user_id = '{$filter['referenceUserId']}'";
        }
        $total_rows = $this->db->query($sql)->fetchColumn();
        $total_pages = ceil($total_rows / $page_count);

        $sql = "SELECT * FROM ticket_summary";
        $filterNumber = 0;
        if ($filter['startDate'] ?? false){
            $sql .= " WHERE ticket_summary.date_of_issue >= '{$filter['startDate']}'";
            $filterNumber++;
        }
        if ($filter['endDate'] ?? false){
            $sql .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sql .= "ticket_summary.date_of_issue <= '{$filter['endDate']}'";
        }
        if ($filter['referenceUserId'] ?? false){
            $sql .= $filterNumber >= 1 ? ' AND ' : ' WHERE ';
            $sql .= "ticket_summary.user_id = '{$filter['referenceUserId']}'";
        }
        $sql .= " ORDER BY ticket_summary.ticket_summary_id DESC LIMIT $offset, $page_count";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        return [
            'current' => $page,
            'pages' => $total_pages,
            'data' => $data,
        ];
    }

    public function SearchByUserReferenceId($search, int $referenceUserId){
        $res = new Result();
        try{
            $sql = 'SELECT  sale.sale_id, sale.serie, sale.correlative, sale.total, sale.date_of_issue, document_type_code.description as document_type_code_description FROM sale
                    INNER JOIN document_type_code ON sale.document_code = document_type_code.code
                    WHERE (serie LIKE :serie OR correlative LIKE :correlative) AND sale.user_id = :user_id  LIMIT 8';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':serie' => '%' . $search . '%',
                ':correlative' => '%' . $search . '%',
                ':user_id' => $referenceUserId,
            ]);

            $res->result = $stmt->fetchAll();
            $res->success = true;
        }catch (Exception $e){
            $res->errorMessage = $e->getMessage();
            $res->success = false;
        }
        return $res;
    }
}
<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class Product extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("product","product_id",$db);
    }

    public function GetById($id)
    {
        try {
            $sql = "SELECT product.*, cumtc.description as  unit_measure_code_description, cpc.description as  product_code_description,
                        caitc.description as affectation_code_description
                        FROM product
                        INNER JOIN cat_unit_measure_type_code cumtc on product.unit_measure_code = cumtc.code
                        INNER JOIN cat_product_code cpc on product.product_code = cpc.code
                        INNER JOIN cat_affectation_igv_type_code caitc on product.affectation_code = caitc.code
                        WHERE product_id = :product_id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([":product_id" => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function GetAllByBusinessId($businessId)
    {
        try {
            $sql = "SELECT product.*, cumtc.description as  unit_measure_code_description, cpc.description as  product_code_description,
                        caitc.description as affectation_code_description
                        FROM product
                        INNER JOIN cat_unit_measure_type_code cumtc on product.unit_measure_code = cumtc.code
                        INNER JOIN cat_product_code cpc on product.product_code = cpc.code
                        INNER JOIN cat_affectation_igv_type_code caitc on product.affectation_code = caitc.code
                        WHERE business_id = :business_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([":business_id" => $businessId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Paginate($page, $limit = 10, $search = '', $businessId = 0) {
        try{
            $offset = ($page - 1) * $limit;
            $totalRows = $this->db->query('SELECT COUNT(*) FROM product WHERE business_id = ' . $businessId)->fetchColumn();
            $totalPages = ceil($totalRows / $limit);

            $sql = "SELECT product.*, cumtc.description as  unit_measure_code_description, cpc.description as  product_code_description,
                        caitc.description as affectation_code_description
                        FROM product
                        INNER JOIN cat_unit_measure_type_code cumtc on product.unit_measure_code = cumtc.code
                        INNER JOIN cat_product_code cpc on product.product_code = cpc.code
                        INNER JOIN cat_affectation_igv_type_code caitc on product.affectation_code = caitc.code
                        WHERE product.business_id = :business_id
                        ORDER BY product.product_id DESC LIMIT $offset, $limit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':business_id',$businessId);
            $stmt->execute();
            $data = $stmt->fetchAll();

            $paginate = [
                'current' => $page,
                'pages' => $totalPages,
                'limit' => $limit,
                'data' => $data,
            ];
            return $paginate;
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Insert($product){
        try{
            $currentDate = date('Y-m-d H:i:s');

            $sql = "INSERT INTO product (updated_at, created_at, created_user_id, updated_user_id, business_id, description,
                                        unit_price_sale, unit_price_sale_igv, product_code, unit_measure_code, affectation_code, system_isc_code, isc)
                    VALUES (:updated_at, :created_at, :created_user_id, :updated_user_id, :business_id, :description,
                                        :unit_price_sale, :unit_price_sale_igv, :product_code, :unit_measure_code, :affectation_code, :system_isc_code, :isc)";
            $stmt = $this->db->prepare($sql);

            // Execute query
            if(!$stmt->execute([
                ':updated_at' => $currentDate,
                ':created_at' => $currentDate,
                ':created_user_id' => $_SESSION[SESS],
                ':updated_user_id' => $_SESSION[SESS],

                ':business_id' => $product['businessId'],
                ':description' => $product['description'],
                ':unit_price_sale' => $product['unitPriceSale'],
                ':unit_price_sale_igv' => $product['unitPriceSaleIgv'],
                ':product_code' => $product['productCode'],
                ':unit_measure_code' => $product['unitMeasureCode'],
                ':affectation_code' => $product['affectationCode'],
                ':system_isc_code' => $product['systemIscCode'],
                ':isc' => $product['isc'],
            ])){
                throw new Exception("Error al insertar el producto.");
            }
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Search($search){
        try{
            $sql = 'SELECT * FROM product WHERE (description LIKE :description OR product_code LIKE :product_code) AND business_id = :business_id LIMIT 8';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':description' => '%' . $search['search'] . '%',
                ':product_code' => '%' . $search['search'] . '%',
                ':business_id' => $search['business_id'],
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}

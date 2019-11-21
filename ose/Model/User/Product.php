<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class Product extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("product","product_id",$db);
    }

    public function Paginate($page = 1, $limit = 10, $businessId = 0) {
        try{
            $offset = ($page - 1) * $limit;
            $totalRows = $this->db->query('SELECT COUNT(*) FROM product WHERE business_id = ' . $businessId)->fetchColumn();
            $totalPages = ceil($totalRows / $limit);

            $sql = "SELECT product.*, unit_measure_type_code.description as unit_measure_type_code_description, product_code.description as product_code_description, affectation_igv_type_code.description as affectation_igv_type_code_description  FROM product 
                INNER JOIN unit_measure_type_code ON product.unit_measure_code = unit_measure_type_code.code
                INNER JOIN product_code ON product.product_code = product_code.code
                INNER JOIN affectation_igv_type_code ON product.affectation_code = affectation_igv_type_code.code
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

            $sql = "INSERT INTO product (description, unit_price_purchase, unit_price_sale, unit_price_purchase_igv, unit_price_sale_igv, 
                                            product_code, product_code_inner, unit_measure_code, affectation_code, stock, currency_code, system_isc_code, isc,
                                        business_id, created_at,updated_at,creation_user_id,modification_user_id)
                    VALUES (:description, :unit_price_purchase, :unit_price_sale, :unit_price_purchase_igv, :unit_price_sale_igv, 
                            :product_code, :product_code_inner, :unit_measure_code, :affectation_code, :stock, :currency_code, :system_isc_code, :isc,
                            :business_id, :created_at,:updated_at,:creation_user_id,:modification_user_id)";

            $stmt = $this->db->prepare($sql);

            // Execute query
            if(!$stmt->execute([
                ':description' => $product['description'] ?? '',
                ':unit_price_purchase' => (float)($product['unitPricePurchase'] ?? 0),
                ':unit_price_sale' => (float)($product['unitPriceSale'] ?? 0),
                ':unit_price_purchase_igv' => (float)($product['unitPricePurchaseIgv'] ?? 0),
                ':unit_price_sale_igv' => (float)($product['unitPriceSaleIgv'] ?? 0),
                ':product_code' => $product['productCode'],
                ':product_code_inner' => $product['productCodeInner'] ?? '',
                ':unit_measure_code' => $product['unitMeasureCode'],
                ':affectation_code' => $product['affectationCode'],
                ':stock' => (float)($product['stock'] ?? 0),
                ':currency_code' => $product['currencyCode'] ?? '',
                ':system_isc_code' => $product['systemIscCode'] ?? '',
                ':isc' => (float)($product['isc'] ?? 0),
                ':business_id' => $product['business_id'],

                ":created_at" => $currentDate,
                ":updated_at" => $currentDate,
                ":creation_user_id" => $_SESSION[SESS],
                ":modification_user_id" => $_SESSION[SESS],
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

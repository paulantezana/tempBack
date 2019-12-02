<?php

require_once MODEL_PATH . 'User/Product.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/CatAffectationIgvTypeCode.php';
require_once MODEL_PATH . 'User/CatUnitMeasureTypeCode.php';
require_once MODEL_PATH . 'User/CatSystemIscTypeCode.php';

class ProductController
{
    private $connection;
    private $param;
    private $businessModel;
    private $productModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
        $this->businessModel = new Business($this->connection);
        $this->productModel = new Product($this->connection);
    }

    public function Exec(){
        try{
            $affectationIgvTypeCodeModel = new CatAffectationIgvTypeCode($this->connection);
            $systemIscTypeCodeModel = new CatSystemIscTypeCode($this->connection);

            $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->getAll();
            $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();

            $content = requireToVar(VIEW_PATH . "User/Product.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function Table(){
        try {
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            $business = $this->businessModel->GetByUserId($_SESSION[SESS]);
            $product = $this->productModel->Paginate($page, $limit, $search, $business['business_id']);
            $parameter['product'] = $product;
            echo requireToVar(VIEW_PATH . "User/Partial/ProductTable.php", $parameter);
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function Update(){
        $res = new Result();
        try{
            $currentDate = date('Y-m-d H:i:s');
            $body = $_POST ?? [];

            $validate = $this->ValidateInput($body);
            if (!$validate->success){
                throw new Exception($validate->errorMessage);
            }

            $productId = $this->productModel->UpdateById($body['productId'],[
                'updated_at' => $currentDate,
                'updated_user_id' => $_SESSION[SESS],

                'description' => $body['description'],
                'unit_price_sale' => $body['unitPriceSale'],
                'unit_price_sale_igv' => $body['unitPriceSaleIgv'],
                'product_code' => $body['productCode'],
                'unit_measure_code' => $body['unitMeasureCode'],
                'affectation_code' => $body['affectationCode'],
                'system_isc_code' => $body['systemIscCode'],
                'isc' => $body['isc'],
            ]);

            $res->result = $productId;
            $res->successMessage = "El producto se actualizo exitosamente";
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function Create(){
        $res = new Result();
        try{
            $body = $_POST ?? [];
            $validate = $this->ValidateInput($body);
            if (!$validate->success){
                throw new Exception($validate->errorMessage);
            }

            $body['businessId'] = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
            $productId = $this->productModel->Insert($body);

            $res->result = $productId;
            $res->successMessage = "El producto se creó exitosamente";
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function ById(){
        $res = new Result();
        try{
            $productId = $_POST['productId'] ?? 0;
            $product = $this->productModel->GetById($productId);
            $res->result = $product;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function Delete(){
        $res = new Result();
        try{
            $productId = $_POST['productId'] ?? 0;
            $productId = $this->productModel->DeleteById($productId);
            $res->result = $productId;
            $res->successMessage = "El producto se eliminó exitosamente";
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function Search(){
        $res = new Result();
        try{
            $q = $_POST['q'] ?? '';

            $search['search'] = $q;
            $search['business_id'] = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
            $response = $this->productModel->Search($search);

            $res->result = $response;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    private function ValidateInput(array $product) {
        $collector = new ErrorCollector();
        if (trim($product['unitMeasureCode'] ?? '') == ""){
            $collector->addError('unitMeasureCode','No se especificó el código de unidad de medida SUNAT');
        }
        if (trim($product['description'] ?? '') == ""){
            $collector->addError('description','El campo descripción es obligatorio');
        }
        if (trim($product['productCode'] ?? '') == ""){
            $collector->addError('productCode','El campo codigo producto es obligatorio');
        }
        if (trim($product['affectationCode'] ?? '') == ""){
            $collector->addError('affectationCode','No se especifico el tipo de afectación del producto');
        }
        return $collector->getResult();
    }
}

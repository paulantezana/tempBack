<?php

require_once MODEL_PATH . 'User/Product.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/CatProductCode.php';
require_once MODEL_PATH . 'User/CatAffectationIgvTypeCode.php';
require_once MODEL_PATH . 'User/CatCurrencyTypeCode.php';
require_once MODEL_PATH . 'User/CatUnitMeasureTypeCode.php';
require_once MODEL_PATH . 'User/CatSystemIscTypeCode.php';

class ProductController
{
    private $connection;
    private $param;
    private $businessModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
        $this->businessModel = new Business($this->connection);
    }

    public function Exec(){
        try{
            $page = $_GET['page'] ?? 0;
            if (!$page){
                $page = 1;
            }

            $productModel = new Product($this->connection);
            $affectationIgvTypeCodeModel = new CatAffectationIgvTypeCode($this->connection);
            $currencyTypeCodeModel = new CatCurrencyTypeCode($this->connection);
            $systemIscTypeCodeModel = new CatSystemIscTypeCode($this->connection);

            $businessId = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
            $parameter['products'] = $productModel->paginate($page,10, $businessId);
            $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->getAll();
            $parameter['currencyTypeCode'] = $currencyTypeCodeModel->getAll();
            $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();

            $content = requireToVar(VIEW_PATH . "User/Product.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function Update(){
        $postData = file_get_contents("php://input");
        $product = json_decode($postData, true);

        $validate = $this->ValidateProduct($product);

        if ($validate->success){
            $product_model = new Product($this->connection);
            $response = $product_model->UpdateById($product['productId'],[
                'description' => $product['description'] ?? '',
                'unit_price_purchase' => $product['unitPricePurchase'] ?? 0.0,
                'unit_price_sale' => $product['unitPriceSale'] ?? 0.0,
                'unit_price_purchase_igv' => $product['unitPricePurchaseIgv'] ?? 0.0,
                'unit_price_sale_igv' => $product['unitPriceSaleIgv'] ?? 0.0,
                'product_code' => $product['productCode'],
                'unit_measure_code' => $product['unitMeasureCode'],
                'affectation_code' => $product['affectationCode'],
                'currency_code' => $product['currencyCode'],
                'system_isc_code' => $product['systemIscCode'] ?? '',
                'isc' => $product['isc'] ?? 0,
            ]);
            echo json_encode([
                'success' => true,
                'data' => $response,
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => $validate->errorMessage,
                'error' => $validate->error,
            ]);
        }
    }

    public function Create(){
        $postData = file_get_contents("php://input");
        $product = json_decode($postData, true);

        $validate = $this->ValidateProduct($product);

        if ($validate->success){
            $productModel = new Product($this->connection);
            $product['business_id'] = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
            $response = $productModel->Insert($product);
            echo json_encode([
                'success' => true,
                'data' => $response,
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => $validate->errorMessage,
                'error' => $validate->error,
            ]);
        }
    }

    public function ById(){
        $postData = file_get_contents("php://input");
        $body = json_decode($postData, true);

        $productId = $body['product_id'];

        $productModel = new Product($this->connection);
        $productCodeModel = new CatProductCode($this->connection);
        $unitMeasureTypeCodeModel =  new CatUnitMeasureTypeCode($this->connection);
        $affectationIgvTypeModel = new CatAffectationIgvTypeCode($this->connection);

        $product = $productModel->GetById($productId);
        $unitMeasureTypeCode = $unitMeasureTypeCodeModel->GetBy('code',$product['unit_measure_code']);
        $affectationIgvType = $affectationIgvTypeModel->GetBy('code',$product['affectation_code']);
        $productCode = $productCodeModel->GetBy('code',$product['product_code']);

        echo json_encode([
            'success' => true,
            'data' => array_merge(
                $product,
                [
                    'affectation' => $affectationIgvType,
                    'product_code' => $productCode,
                    'unit_measure_code' => $unitMeasureTypeCode,
                ]
            ),
            'message' => 'Los datos se obtenieron exitosamente',
        ]);
    }

    public function Delete(){

        $postData = file_get_contents("php://input");
        $body = json_decode($postData, true);

        $productId = $body['product_id'];
        $productModel = new Product($this->connection);
        $data = $productModel->DeleteById($productId);

        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function Search(){

        $q = $_POST['q'] ?? '';

        $productModel = new Product($this->connection);
        $search['search'] = $q;
        $search['business_id'] = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
        $data = $productModel->Search($search);
        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
    }

    private function ValidateProduct(array $product) {
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

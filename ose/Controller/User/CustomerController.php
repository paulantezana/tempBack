<?php

require_once MODEL_PATH . 'User/Customer.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/CatIdentityDocumentTypeCode.php';

require_once CONTROLLER_PATH . 'Helper/Services/JneDNI.php';
require_once CONTROLLER_PATH . 'Helper/Services/SunatRUC.php';

class CustomerController
{
    private $connection;
    private $param;
    private $customerModel;
    private $businessModel;
    private $catIdentityDocumentTypeCodeModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
        $this->customerModel = new Customer($this->connection);
        $this->businessModel = new Business($this->connection);
        $this->catIdentityDocumentTypeCodeModel = new CatIdentityDocumentTypeCode($this->connection);
    }

    public function Exec(){
        try{
            $parameter['identityDocumentTypeCode'] = $this->catIdentityDocumentTypeCodeModel->getAll();

            $content = requireToVar(VIEW_PATH . "User/Customer.php", $parameter);
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
            $customer = $this->customerModel->Paginate($page, $limit, $search, $business['business_id']);
            $parameter['customer'] = $customer;
            echo requireToVar(VIEW_PATH . "User/Partial/CustomerTable.php", $parameter);
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

            $customerId = $this->customerModel->UpdateById($body['customerId'],[
                'updated_at' => $currentDate,
                'updated_user_id' => $_SESSION[SESS],

                'description' => $body['description'],
                'unit_price_sale' => $body['unitPriceSale'],
                'unit_price_sale_igv' => $body['unitPriceSaleIgv'],
                'customer_code' => $body['customerCode'],
                'unit_measure_code' => $body['unitMeasureCode'],
                'affectation_code' => $body['affectationCode'],
                'system_isc_code' => $body['systemIscCode'],
                'isc' => $body['isc'],
            ]);

            $res->result = $customerId;
            $res->successMessage = "El customero se actualizo exitosamente";
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
            $customerId = $this->customerModel->Insert($body);

            $res->result = $customerId;
            $res->successMessage = "El customero se creó exitosamente";
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function ById(){
        $res = new Result();
        try{
            $customerId = $_POST['customerId'] ?? 0;
            $customer = $this->customerModel->GetById($customerId);
            $res->result = $customer;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function ByDocumentNumber(){
        $res = new Result();
        try{
            $customer['documentNumber'] = $_POST['documentNumber'] ?? '';
            $customer['businessId'] = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
            $customer = $this->customerModel->GetByDocumentNumber($customer);
            if (empty($customer)){
                $sunatRUC = new SunatRUC();
                $response = $sunatRUC->Query( $customer['documentNumber'] );
                if (!$response->success){
                    throw new Exception($response->errorMessage);
                }
                $customer = [
                    'documentNumber' => $response->result['ruc'],
                    'socialReason' => $response->result['razon_social'],
                    'commercialReason' => $response->result['nombre_comercial'],
                    'identityDocumentCode' => '6',
                    'condition' => $response->result['condicion'],
                    'fiscalAddress' => $response->result['direccion'],
                ];
            }

            $res->result = $customer;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function Delete(){
        $res = new Result();
        try{
            $customerId = $_POST['customerId'] ?? 0;
            $customerId = $this->customerModel->DeleteById($customerId);
            $res->result = $customerId;
            $res->successMessage = "El customero se eliminó exitosamente";
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
            $search['businessId'] = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
            $response = $this->customerModel->Search($search);

            $res->result = $response;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function SearchByDocumentNumber(){
        $search['search'] = $_POST['q'] ?? '';
        $search['businessId'] = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
        $response = $this->customerModel->SearchByDocumentNumber($search);

        echo json_encode($response ?? []);
    }

    private function ValidateInput(array $customer) {
        $collector = new ErrorCollector();
        $collector->setSeparator('</br>');
        if (trim($customer['documentNumber'] ?? '') == ''){
            $collector->addError('documentNumber','El número del documento es inválido');
        }
        if (trim($customer['identityDocumentCode'] ?? '') == ''){
            $collector->addError('identityDocumentCode','No se especificó el tipo de documento de identificación');
        }
        if (trim($customer['socialReason'] ?? '') == ''){
            $collector->addError('socialReason','No se especificó la razón social');
        }

        $identityDocValidate = ValidateIdentityDocumentNumber($customer['documentNumber'],$customer['identityDocumentCode']);
        if (!$identityDocValidate->success){
            $collector->addError('documentNumber',$identityDocValidate->errorMessage);
        }

        return $collector->getResult();
    }

    public function SearchPublicDocumentExtractor(){
        $res = new Result();
        try{
            $body = $_POST ?? [];
            $validate = $this->ValidateSearchPublicDocument($body ?? []);
            if (!$validate->success){
                throw new Exception($validate->errorMessage);
            }

            $customer = [];
            $documentNumber = trim(htmlspecialchars($body['documentNumber']));
            if (strlen($documentNumber) == 8){
                $jneDNI = new JneDNI();
                $response = $jneDNI->Query($documentNumber);
                if (!$response->success){
                    throw new Exception($response->errorMessage);
                }

                $customer = [
                    'documentNumber' => $documentNumber,
                    'socialReason' => $response->result['fullName'],
                    'identityDocumentCode' => '1',
                ];
            }elseif (strlen($documentNumber) == 11){
                $sunatRUC = new SunatRUC();
                $response = $sunatRUC->Query( $documentNumber );
                if (!$response->success){
                    throw new Exception($response->errorMessage);
                }
                $customer = [
                    'documentNumber' => $response->result['ruc'],
                    'socialReason' => $response->result['razon_social'],
                    'commercialReason' => $response->result['nombre_comercial'],
                    'identityDocumentCode' => '6',
                    'condition' => $response->result['condicion'],
                    'fiscalAddress' => $response->result['direccion'],
                ];
            }else{
                $customer = [ 'documentNumber' => $documentNumber ];
            }

            $res->result = $customer;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    private function ValidateSearchPublicDocument($customer){
        $collector = new ErrorCollector();
        $collector->setSeparator('</br>');
        if (trim($customer['documentNumber'] ?? '') == ''){
            $collector->addError('documentNumber','El número del documento es inválido');
        }
        return $collector->getResult();
    }
}

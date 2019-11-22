<?php

require_once MODEL_PATH . 'User/BusinessBankAccount.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/CatCurrencyTypeCode.php';

class BankAccountController
{
    private $connection;
    private $param;
    private $currencyTypeCodeModel;
    private $businessBankAccountModel;
    private $businessModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
        $this->currencyTypeCodeModel = new CatCurrencyTypeCode($this->connection);
        $this->businessBankAccountModel = new BusinessBankAccount($this->connection);
        $this->businessModel = new Business($this->connection);
    }

    public function Exec(){
        $page = $_GET['page'] ?? 0;
        if (!$page){
            $page = 1;
        }

        $businessId = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
        $parameter['bankAccount'] = $this->businessBankAccountModel->Paginate($page,10, $businessId);
        $parameter['currencyTypeCode'] = $this->currencyTypeCodeModel->GetAll();

        $content = requireToVar(VIEW_PATH . "User/BankAccount.php", $parameter);
        require_once(VIEW_PATH. "User/Layout/main.php");
    }

    public function Update(){
        $postData = file_get_contents("php://input");
        $customer = json_decode($postData, true);

        $validate = $this->ValidateCustomer($customer);

        if ($validate->success){
            $response = $this->customerModel->UpdateById($customer['customerId'],[
                'document_number'=>$customer['documentNumber'],
                'identity_document_code'=>$customer['identityDocumentCode'],
                'social_reason'=>$customer['socialReason'],
                'commercial_reason'=>$customer['commercialReason'],
                'fiscal_address'=>$customer['fiscalAddress'],
                'main_email'=>$customer['mainEmail'] ?? '',
                'optional_email_1'=>$customer['optionalEmail1'] ?? '',
                'optional_email_2'=>$customer['optionalEmail2'] ?? '',
                'telephone'=>$customer['telephone'] ?? '',
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
        $customer = json_decode($postData, true);

        $validate = $this->ValidateCustomer($customer);

        if ($validate->success){
            $customer['business_id'] = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
            $response = $this->customerModel->Insert($customer);
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

    public function ByID(){
        $postData = file_get_contents("php://input");
        $body = json_decode($postData, true);

        $customerId = $body['customer_id'];
        $customerModel = new Customer($this->connection);
        $data = $customerModel->GetById($customerId);

        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function Delete(){
        $postData = file_get_contents("php://input");
        $body = json_decode($postData, true);

        $customerId = $body['customer_id'];
        $customerModel = new Customer($this->connection);
        $response = $customerModel->DeleteById($customerId);

        echo json_encode([
            'success' => true,
            'data' => $response,
        ]);
    }

    public function Search(){
        $q = $_POST['q'] ?? '';
        $search['search'] = $q;
        $search['business_id'] = $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'];
        $data = $this->customerModel->Search($search);

        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function SearchPublicDocumentExtractor(){
        $postData = file_get_contents("php://input");
        $body = json_decode($postData, true);

        $validate = $this->ValidateSearchPublicDocument($body ?? []);
        if ($validate->success){
            $customer = [];
            $documentNumber = trim(htmlspecialchars($body['documentNumber']));

            if (strlen($documentNumber) == 8){
                $jneDNI = new JneDNI();
                $responseDni = $jneDNI->Query($documentNumber);
                if ($responseDni->success){
                    $customer = [
                        'documentNumber' => $documentNumber,
                        'socialReason' => $responseDni->result['fullName'],
                        'identityDocumentCode' => '1',
                    ];
                }else{
                    echo json_encode([
                        'success' => false,
                        'message' => $responseDni['message']
                    ]);
                    return;
                }
            }elseif (strlen($documentNumber) == 11){
                $sunatRUC = new SunatRUC();
                $response = $sunatRUC->Query( $documentNumber );
                if( $response -> success == true ) {
                    $customer = [
                        'documentNumber' => $response->result['ruc'],
                        'socialReason' => $response->result['razon_social'],
                        'commercialReason' => $response->result['nombre_comercial'],
                        'identityDocumentCode' => '6',
                        'condition' => $response->result['condicion'],
                        'fiscalAddress' => $response->result['direccion'],
                    ];
                }else{
                    echo json_encode([
                        'success' => false,
                        'message' => $response->errorMessage
                    ]);
                    return;
                }
            }else{
                $customer = [
                    'documentNumber' => $documentNumber,
                ];
            }

            echo json_encode([
                'success' => true,
                'data' => $customer
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => $validate->errorMessage,
                'error' => $validate->error,
            ]);
        }
    }

    private function ValidateSearchPublicDocument($customer){
        $collector = new ErrorCollector();
        $collector->setSeparator('</br>');
        if (trim($customer['documentNumber'] ?? '') == ''){
            $collector->addError('documentNumber','El número del documento es inválido');
        }
        return $collector->getResult();
    }

    private function ValidateCustomer(array $customer) {
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
}

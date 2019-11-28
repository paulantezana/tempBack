<?php

require_once MODEL_PATH . 'Manager/Business.php';
require_once MODEL_PATH . 'Manager/BusinessLocal.php';
require_once MODEL_PATH . 'Manager/user.php';

require_once CONTROLLER_PATH . 'Helper/ApiSign.php';

class BusinessController
{
    private $connection;
    private $businessModel;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
        $this->businessModel = new Business($this->connection);;
    }

    public function Exec(){
        try{
            $parameter = [];
            $content = requireToVar(VIEW_PATH . "Manager/Business.php", $parameter);
            require_once(VIEW_PATH. "Manager/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function Table(){
        try {
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            $business = $this->businessModel->Paginate($page, $limit, $search);
            $parameter['business'] = $business;

            echo requireToVar(VIEW_PATH . "Manager/Partial/BusinessTable.php", $parameter);
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function Id(){
        $res = new Result();
        try {
            $res->result = $this->businessModel->GetById($_POST['businessId']);
            $res->success = true;
        } catch (Exception $e) {
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function Create(){
        $res = new Result();
        $this->connection->beginTransaction();
        try {
            $business = $_POST;

            $validate = $this->validateInput($business);
            if (!$validate->success) {
                $res->error = $validate->error;
                throw new Exception($validate->message);
            }

            $userClassModel = new userClass($this->connection);
            $userId = $userClassModel->userRegistration([
                'typeUser' => 1,
                'names' => $business['userName'],
                'email' => $business['email'],
                'phone' => $business['phone'],
                'ruc' => $business['ruc'],
                'address' => '',
                'id_document_type' => 6,
                'password' => $business['userPassword'],
                'state' => 1,
            ]);

            $businessId = $this->businessModel->Insert($business, $userId);

            $businessLocalModel = new BusinessLocal($this->connection);
            $businessLocalId = $businessLocalModel->Insert([
                'short_name' => 'Local principal',
                'sunat_code' => '',
                'location_code' => '',
                'pdf_invoice_size' => 'A4',
                'pdf_header' => 'Email: ' . $business['email'],
                'description' => '',
                'business_id' => $businessId,
                'department' => '',
                'province' => '',
                'district' => '',
                'address' => '',
                'item' => [
                    [
                        'serie' => 'F001',
                        'document_code' => '01',
                    ],
                    [
                        'serie' => 'B001',
                        'document_code' => '03',
                    ],
                    [
                        'serie' => 'FP01',
                        'document_code' => '07',
                    ],
                    [
                        'serie' => 'FP01',
                        'document_code' => '08',
                    ],
                    [
                        'serie' => 'T001',
                        'document_code' => '09',
                    ],
                ]
            ], $userId);

            $payload = [
                'localId' => $businessLocalId,
                'userId' => $userId,
                'businessId' => $businessId,
            ];

            $token = ApiSign::encode($payload);
            $businessLocalModel->UpdateById($businessLocalId,[
                'api_token' => $token
            ]);

            // data
            $this->connection->commit();
            $res->success = true;
            $res->successMessage = 'El registro se inserto exitosamente';
        } catch (Exception $e) {
            $this->connection->rollBack();
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function Update(){
        $res = new Result();
        try {
            $postData = file_get_contents("php://input");
            $body = json_decode($postData, true);
            $validate = $this->validateInput($body);
            if (!$validate->success) {
                $res->error = $validate->error;
                throw new Exception($validate->message);
            }
            $currentDate = date('Y-m-d H:i:s');

            $this->businessModel->UpdateById($body['businessId'], [

            ]);
            $res->success = true;
            $res->message = 'El registro se actualizo exitosamente';
        } catch (Exception $e) {
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function Delete(){
        $res = new Result();
        try {
            $postData = file_get_contents("php://input");
            $body = json_decode($postData, true);

            $this->businessModel->DeleteById($body['businessId']);
            $res->success = true;
            $res->successMessage = 'El registro se eliminó exitosamente';
        } catch (Exception $e) {
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    public function ValidateInput($body){
        $collector = new ErrorCollector();
        return $collector->getResult();
    }
}

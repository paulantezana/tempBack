<?php

require_once MODEL_PATH . 'Manager/Business.php';

class BusinessController
{
    private $connection;
    private $businessModel;

    public function __construct($connection)
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
        try {
            $validate = $this->validateInput($_POST);
            if (!$validate->success) {
                $res->error = $validate->error;
                throw new Exception($validate->message);
            }

            $res->result = $this->businessModel->Insert($_POST);
            $res->success = true;
            $res->successMessage = 'El registro se inserto exitosamente';
        } catch (Exception $e) {
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

<?php

require_once MODEL_PATH . 'User/CatProductCode.php';

class ProductCodeController
{
    private $connection;
    private $param;
    private $catProductCode;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
        $this->catProductCode = new CatProductCode($this->connection);
    }

    public function Search(){
        $res = new Result();
        try{
            $search = $_POST['q'] ?? '';
            $response = $this->catProductCode->Search($search);

            $res->result = $response;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }
}

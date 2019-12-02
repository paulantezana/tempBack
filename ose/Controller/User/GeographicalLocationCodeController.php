<?php

require_once MODEL_PATH . 'User/CatGeographicalLocationCode.php';

class GeographicalLocationCodeController
{
    private $connection;
    private $param;
    private $catGeographicalLocationCodeModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
        $this->catGeographicalLocationCodeModel = new CatGeographicalLocationCode($this->connection);
    }

    public function Search(){
        $res = new Result();
        try{
            $search = $_POST['q'] ?? '';
            $response = $this->catGeographicalLocationCodeModel->Search($search);

            $res->result = $response;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }
}

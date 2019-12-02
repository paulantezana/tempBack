<?php

require_once MODEL_PATH . 'User/CatUnitMeasureTypeCode.php';

class UnitMeasureTypeCodeController
{
    private $connection;
    private $param;
    private $catUnitMeasureTypeCodeModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
        $this->catUnitMeasureTypeCodeModel = new CatUnitMeasureTypeCode($this->connection);
    }

    public function Search(){
        $res = new Result();
        try{
            $search = $_POST['q'] ?? '';
            $response = $this->catUnitMeasureTypeCodeModel->SearchBy('description',$search);

            $res->result = $response;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }
}

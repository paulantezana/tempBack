<?php

require_once MODEL_PATH . 'User/UnitMeasureTypeCode.php';

class UnitMeasureTypeCodeController
{
    private $connection;
    private $param;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
    }

    public function Search(){
        header('Content-Type: application/json; charset=UTF-8');
        $search = $_POST['q'] ?? '';

        $unitMeasureModel = new UnitMeasureTypeCode($this->connection);
        $data = $unitMeasureModel->SearchBy('description',$search);
        echo json_encode([
            'data' => $data,
            'success' => true
        ]);
    }
}

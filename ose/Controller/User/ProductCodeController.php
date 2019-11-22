<?php

require_once MODEL_PATH . 'User/CatProductCode.php';

class ProductCodeController
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
        $productCode = new CatProductCode($this->connection);
        $data = $productCode->Search($search);

        echo json_encode([
            'data' => $data,
            'success' => true
        ]);
    }
}

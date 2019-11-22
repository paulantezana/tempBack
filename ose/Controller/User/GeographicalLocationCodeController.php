<?php

require_once MODEL_PATH . 'User/CatGeographicalLocationCode.php';

class GeographicalLocationCodeController
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

        $geographicalLocationCodeModel = new CatGeographicalLocationCode($this->connection);
        $data = $geographicalLocationCodeModel->Search($search);

        // Response data
        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
    }
}

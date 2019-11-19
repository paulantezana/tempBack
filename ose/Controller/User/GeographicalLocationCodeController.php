<?php

require_once MODEL_PATH . 'User/GeographicalLocationCode.php';

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

        $geographicalLocationCodeModel = new GeographicalLocationCode($this->connection);
        $data = $geographicalLocationCodeModel->Search($search);

        // Response data
        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
    }
}

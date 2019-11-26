<?php


class ApiRequestController
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function Exec(){
        $res = new Result();
        try{

            if (!isset($_GET['token'])){
                throw new Exception("No se encontró ningún token de autenticación.");
            }

            $token = $_GET['token'];

            $res->result = $token;

        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }


    private function ValidateInput(){

    }

    private function Insert(){

    }
}

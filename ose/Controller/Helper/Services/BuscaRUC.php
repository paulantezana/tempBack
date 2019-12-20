<?php


class BuscaRUC
{
    private $curl;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function Query(string $ruc)
    {
        $res = new Result();
        try{
            if( strlen($ruc)!=11 )
            {
                throw new Exception('EL RUC debe contener 11 dígitos');
            }
            $options = [
                CURLOPT_URL => "http://buscaruc.com/consultas/api.php?ruc=" . $ruc,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
            ];
            curl_setopt_array($this->curl, $options);

            $response = curl_exec($this->curl);
            $err = curl_error($this->curl);

            if(!$response || $err){
                $res->errorMessage = "No se encontraron datos suficientes";
                return $res;
            }
            $data = json_decode($response);

            $res->success = true;
            $res->result = $data;
        }catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        return $res;
    }
}

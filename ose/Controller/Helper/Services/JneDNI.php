<?php


class JneDNI
{
    private $curl;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function Query(string $dni)
    {
        $res = new Result();
        try{
            if( strlen($dni)!=8 )
            {
                throw new Exception('EL DNI debe contener 8 dígitos');
            }

            $options = [
                CURLOPT_URL => "http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI=" . $dni,
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

            $response = explode('|',trim($response));
            $response = implode(' ', $response);

            $data = ['fullName' => $response];

            $res->success = true;
            $res->result = $data;
        }catch (Exception $e){
            $res->errorMessage = $e->getMessage()."\n\n".$e->getTraceAsString();
        }
        return $res;
    }
}
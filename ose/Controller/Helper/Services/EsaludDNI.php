<?php


class EsaludDNI
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
                throw new Exception('EL RUC debe contener 8 dígitos');
            }
            $options = [
                CURLOPT_URL => "//https://ww1.essalud.gob.pe/sisep/postulante/postulante/postulante_obtenerDatosPostulante.htm?strDni=" . $dni,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "GET",
            ];
            curl_setopt_array($this->curl, $options);

            $response = curl_exec($this->curl);
            $err = curl_error($this->curl);

            if(!$response || $err){
                throw new Exception('No se encontraron datos suficientes');
            }
            $data = json_decode($response);
            $data = $data['DatosPerson'][0];
            if (strlen($data['ApellidoPaterno']) == 0 || strlen($data['Nombres']) == 0){
                throw new Exception('No se encontró ningun dato con el DNI: ' . $dni);
            }

            $res->success = true;
            $res->result = [
                'socialReason' => $data['ApellidoPaterno'] . ' ' . $data['Nombres'],
                'documentNumber' => $dni,
                'sex' => $data['ApellidoPaterno'],
                'birthDate' => $data['FechaNacimiento'],
            ];
        }catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        return $res;
    }
}

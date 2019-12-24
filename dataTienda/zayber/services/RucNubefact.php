<?php
class ClaRucNubefact{
	public static function getList_Ruc_NubeFact($Datos){
		$NroDoc=$Datos[0];
		//echo "".$NroDoc;
		$ruta = "https://ruc.com.pe/api/v1/ruc";
		//$token = "1cde02ac-0361-44f8-a41d-991472228715-65d611ee-66b5-45b5-84b2-4aeba10d0e22";
		$token = "80a09f2c-bd12-4e81-93a8-1be26000f78f-e8aac574-c3e0-41b9-97aa-f350293ffb9a";
		$rucaconsultar = $NroDoc;
		$data = array(
			"token"	=> $token,
			"ruc"   => $rucaconsultar
		);
			
		$data_json = json_encode($data);
		// Invocamos el servicio a ruc.com.pe
		// Ejemplo para JSON
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $ruta);
		curl_setopt(
			$ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			)
		);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$respuesta  = curl_exec($ch);
		curl_close($ch);

		$leer_respuesta = json_decode($respuesta, true);
		//print_r($$leer_respuesta);
		$Result=array();
		if (isset($leer_respuesta['errors'])) {
			//Mostramos los errores si los hay
			array_push($Result,array("success"=>false,"Dato"=>$leer_respuesta['errors']));
		} else {
			//Mostramos la respuesta
			//echo "Respuesta de la API:<br>";
			//print_r($$leer_respuesta);
			array_push($Result,array("success"=>true,"Dato"=>$leer_respuesta));
		}
        
        return $Result;
	}
}
?>

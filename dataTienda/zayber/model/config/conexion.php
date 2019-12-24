<?php 
	class ConexionBD{
		public static function conectarBD(){
			try{
				$conexion = new PDO('mysql:host=localhost;dbname=zayber','root','');
				// $conexion = new PDO('mysql:host=localhost;dbname=db_zayber','store_niko','WcAyBo032635102018');
				$conexion->exec('SET NAMES utf8 COLLATE utf8_unidecode_ci');
				$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conexion;

			}catch(Exception $e){
				echo "ERROR DE CONEXION";//. $e->getMessage. $e->getLine;
			}
		}	
	}
?>
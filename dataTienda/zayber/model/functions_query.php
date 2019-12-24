<?php
require_once 'config/conexion.php';
 class Class_Run
{
	static function Select_Query($query){
		$sql = ConexionBD::conectarBD()->prepare($query);
		$sql->execute();return $sql->fetchAll();$sql->close();
	}
	static function Select_Query_J($query){
		$sql = ConexionBD::conectarBD()->prepare($query);
		$sql->execute();
		$data=$sql->fetchAll(PDO::FETCH_ASSOC);
		return $data;
		$sql->close();
	}
	static function Execute_Query_Bool($query){
		$sql = ConexionBD::conectarBD()->prepare($query);
		if($sql->execute()){return true;}else{return false;}$sql->close();
    }	
	static function Execute_Query_Result($query){
		$sql = ConexionBD::conectarBD()->prepare($query);
		if($sql->execute()){
			$Result=$sql->fetchAll();return array("Val"=>true,"Result"=>$Result);
		}else{return array("Val"=>false,"Result"=>[]);
		}
		$sql->close();
    }
	static function Execute_Query_Valido($query){
		$sql = ConexionBD::conectarBD()->prepare($query);
		if($sql->execute()){
			$Result=$sql->fetchAll();
			if($Result[0]["cont"]>0){
				return true;
			}else{return false;}
		}else{
			return false;
		}
		$sql->close();
    }	
}
//$resultado = $gsent->fetchColumn(); obtiene primer elemento de la fila
//$resultado = $gsent->fetchColumn(1); obtiene elemento de segundo fila
?>
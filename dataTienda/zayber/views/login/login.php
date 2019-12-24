<?php //session_start();
require_once("model/config/conexion.php");
	try {
		$error = '';
		$enviar='';
		$enviado='';
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$NameUser = $_POST['userFACTR'];
			$PasswUser = $_POST['passFACTR'];
			
			$query="SELECT IdUsuario,CONCAT(Nombres,' ',ApPaterno) AS 'nombre',IdTipoUsuario,IdEmpresa,fn_RecuperarNombre_ns('USER_TIPOUSER',IdTipoUsuario) AS TypeUser
					FROM user_usuario_sistema
					WHERE CodUsuario='".$NameUser."' AND Contrasenia='".md5(md5($PasswUser))."' AND Estado=1 LIMIT 1;";
			
			//echo $query;
			$sql = ConexionBD::conectarBD()->prepare($query);
			if($sql->execute()){
				$Result=$sql->fetchAll();
				if(count($Result)>0){
					$Dati=array("IdUser"=>$Result[0]['IdUsuario'],"nombre"=>$Result[0]['nombre'],
					"IdTypeUser"=>$Result[0]['IdTipoUsuario'],"IdCompany"=>$Result[0]['IdEmpresa'],
					"TypeUser"=>$Result[0]['TypeUser']);
					$_SESSION['UserTRPE'] = $Dati;
					header("Location: http://localhost/zayber/home");
				}else{
					$error= 'Los datos ingresados son incorrectos.'; 
				}
			}else{
				$error= 'Los datos ingresados son incorrectos.'; 
			}
		}
	}catch(Exception $e){
		echo "Error  de conexion a base de datos.";
	}
	require 'loginView.php';
 ?>
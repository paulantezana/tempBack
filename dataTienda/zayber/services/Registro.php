<?php
class ClaRegistro{
	public static function getList_TipoDocumento_DNI(){
 	 	$query="SELECT IdTipoDocumento,TipoDocumento,Simbolo FROM `mante_tipo_documento` WHERE Estado=1 AND IdTipoDocumento=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	//TIPO USUARIO 
	public static function getList_Mante_TipoUsuario($IdEmpresa){
 	 	$query="SELECT IdTipoUsuario,TipoUsuario,Simbolo,CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est
				FROM `user_tipo_usuario_sistema` where IdTipoUsuario>0;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_TipoUsuario_Est(){
 	 	$query="SELECT IdTipoUsuario,TipoUsuario,Simbolo FROM `user_tipo_usuario_sistema` WHERE IdTipoUsuario>1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	//REGISTRAR USUARIO
	public static function getList_Mante_UserSystem(){
 	 	$query="SELECT IdEmpresa,`IdUsuario`,`IdTipoDocumento`,`NroDocumento`,`Nombres`,`ApPaterno`,`ApMaterno`,DATE_FORMAT(FechaNac,'%d/%m/%Y') AS FechaNac,
		`Sexo`,`Direccion`,`Telefono`,`Email`,`CodUsuario`,`Firma`,Estado,IdTipoUsuario,Estado,CASE WHEN Sexo=1 THEN 'M' ELSE 'F' END AS Sex,
		fn_RecuperarNombre_ns('DOCUMENTO_SIM',IdTipoDocumento) AS TipoDoc,fn_RecuperarNombre_ns('USER_TIPOUSER_SIM',IdTipoUsuario) AS TipoUser,
		CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est
		FROM `user_usuario_sistema` WHERE IdUsuario>1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_UserSystem_Id($pId){
 	 	$query="SELECT IdEmpresa,`IdUsuario`,`IdTipoDocumento`,`NroDocumento`,`Nombres`,`ApPaterno`,`ApMaterno`,DATE_FORMAT(FechaNac,'%d/%m/%Y') AS FechaNac,
			`Sexo`,`Direccion`,`Telefono`,`Email`,`CodUsuario`,`Firma`,Estado,IdTipoUsuario,Estado
			FROM `user_usuario_sistema` WHERE IdUsuario='$pId';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_UserSystem_Edit($Datos,$IdEmpresa){
 	 	$User=ClaRegistro::getList_Mante_UserSystem_Id($Datos[0]);
 	 	$TipoDoc=ClaRegistro::getList_TipoDocumento_DNI();
 	 	$TipoUser=ClaRegistro::getList_Mante_TipoUsuario_Est();
		//echo $query;
		return array("User"=>$User,"TipoDoc"=>$TipoDoc,"TipoUser"=>$TipoUser);
 	}
	public static function Save_Mante_UserSystem($Datos,$IdEmpresa){
 	 	$query="CALL mante_save_UsuarioSystem('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]','$Datos[6]','$Datos[7]','$Datos[8]','$Datos[9]',
					'$Datos[10]','$Datos[11]','$Datos[12]','".md5(md5($Datos[13]))."','$Datos[14]','$Datos[15]','$Datos[16]',$IdEmpresa);";
		//echo $query;	
		$val=Class_Run::Execute_Query_Bool($query);
		$Dato=array();
		if($val){
			$Dato=ClaRegistro::getList_Mante_UserSystem();
		}
		return array("Val"=>$val,"Dato"=>$Dato);
 	}
	public static function getList_Mante_UserSystem_Venta($Datos,$IdEmpresa){
 	 	$Alm=ClaRegistro::getList_Mante_Almacen();
 	 	$Dat=ClaRegistro::getList_Mante_Almacen_User($Datos[0]);
		//echo $query;
		return array("Alm"=>$Alm,"Dat"=>$Dat);
 	}
	public static function getList_Mante_Almacen(){
 	 	$query="SELECT IdAlmacen,Almacen FROM `mante_almacen` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Almacen_User($pId){
 	 	$query="SELECT IdAlmacen FROM `mante_usuario_almacen` WHERE IdUsuario='$pId';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Config_UserSystem_Alm($Datos,$IdEmpresa){
 	 	$valido=false;
		$IdUser=$Datos[0];
		$Dato=array();
		if(isset($Datos[1])){
			$Dato=$Datos[1];
		}else{$valido=true;}
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$query="DELETE FROM `mante_usuario_almacen` WHERE IdUsuario=".$IdUser.";";
		//echo $query;
		$sql = $pdo->prepare($query);
		if($sql->execute()){
			for($i=0;$i<count($Dato);$i++)
			{
				$IdAlm=$Dato[$i]["aId"];
				$QueryIns="INSERT INTO mante_usuario_almacen VALUES(".$IdAlm.",".$IdUser.");";
				$sql = $pdo->prepare($QueryIns);
				if($sql->execute()){
					$valido=true;
				}else{
					$valido=false;$i=count($Porcc);
				}
			}
		}else{$valido=false;}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		return $valido;
 	}
	
	//PERMISO USUARIO   
	public static function getList_Config_PermisoUser($IdEmpresa){
 	 	$TipoUser=ClaRegistro::getList_TipoUser_Fact();
 	 	$Menu=ClaRegistro::getList_Mante_MenuSistem();
		//echo $query;
		return array("TipoUser"=>$TipoUser,"Menu"=>$Menu);
 	}
	public static function getList_TipoUser_Fact(){
 	 	$query="SELECT IdTipoUsuario,TipoUsuario,Simbolo FROM `user_tipo_usuario_sistema` WHERE Estado=1 AND IdTipoUsuario>1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_MenuSistem(){
 	 	$query="SELECT IdForm,Nombre,Menu FROM `user_menu_sistema` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Config_PermisoUserDatos($Datos,$IdEmpresa){
 	 	$query="SELECT IdForm FROM `user_permiso_sistema` WHERE IdTipoUsuario='$Datos[0]';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Config_PermisoUser($Datos,$IdEmpresa){
 	 	$valido=false;
		$IdTipo=$Datos[0];
		$Dato=array();
		if(isset($Datos[1])){
			$Dato=$Datos[1];
		}else{$valido=true;}
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$query="DELETE FROM `user_permiso_sistema` WHERE IdTipoUsuario=".$IdTipo;
		//echo $query;
		$sql = $pdo->prepare($query);
		if($sql->execute()){
			for($i=0;$i<count($Dato);$i++)
			{
				$pIdd=$Dato[$i]["aId"];
				$QueryIns="INSERT INTO user_permiso_sistema VALUES(".$pIdd.",".$IdTipo.");";
				$sql = $pdo->prepare($QueryIns);
				if($sql->execute()){
					$valido=true;
				}else{
					$valido=false;$i=count($Porcc);
				}
			}
		}else{$valido=false;}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		return $valido;
 	}
	
	public static function getList_Mante_Region_Estado(){
 	 	$query="SELECT `IdRegion`,`Region`,`Simbolo` 
		FROM `mante_region` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_CategoriaCond_Estado(){
 	 	$query="SELECT IdLicencia,Licencia FROM mante_conductor_licencia WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	

	
	
	
	//HABILITAR USUARIO TRANSPORTISTA POR REGION 
	public static function getList_Mante_UserTransportista_Region($Datos,$IdEmpresa){
 	 	$Region=ClaRegistro::getList_Mante_Region_Empresa($IdEmpresa);
 	 	$Dat=ClaRegistro::getList_Mante_User_Empresa_Region($Datos[0],$IdEmpresa);
		//echo $query;
		return array("Region"=>$Region,"Dat"=>$Dat);
 	}
	public static function getList_Mante_Region_Empresa($pId){
 	 	$query="SELECT IdRegion,fn_RecuperarNombre_ns('REGION',IdRegion) AS Region
			FROM `mante_empresa_region` WHERE Estado=1 AND IdEmpresa='$pId';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_User_Empresa_Region($pId,$IdEmpresa){
 	 	$query="SELECT IdRegion FROM `user_usuario_region` WHERE IdUsuario='$pId' AND IdEmpresa='$IdEmpresa';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Config_UserRegion_transp($Datos,$IdEmpresa){
 	 	$valido=false;
		$IdUser=$Datos[0];
		$Dato=array();
		if(isset($Datos[1])){
			$Dato=$Datos[1];
		}else{$valido=true;}
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$query="DELETE FROM `user_usuario_region` WHERE IdUsuario=".$IdUser.";";
		//echo $query;
		$sql = $pdo->prepare($query);
		if($sql->execute()){
			for($i=0;$i<count($Dato);$i++)
			{
				$IdReg=$Dato[$i]["aId"];
				$QueryIns="INSERT INTO user_usuario_region VALUES(".$IdUser.",".$IdReg.",".$IdEmpresa.");";
				$sql = $pdo->prepare($QueryIns);
				if($sql->execute()){
					$valido=true;
				}else{
					$valido=false;$i=count($Porcc);
				}
			}
		}else{$valido=false;}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		return $valido;
 	}
	
	

	//MANTENIMIENTO RESPONSABLE
	public static function getList_Mante_Combo_Responsable(){
 	 	return ClaRegistro::getList_Mante_Region_Estado();
 	}
	public static function getList_Mante_Responsable($Datos){
 	 	$query="SELECT `IdResponsable`,`Responsable`,`Estado`,`Telefono`,`Email`,CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est
				FROM `mante_responsable` WHERE IdRegion=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Responsable_Edit($Datos){
 	 	$query="SELECT `IdResponsable`,`Responsable`,`Estado`,`Telefono`,`Email`
		FROM `mante_responsable` WHERE IdResponsable=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Responsable($Datos){
 	 	$query="CALL mante_save_Responsable('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]');";
		//echo $query;
		$Valido=Class_Run::Execute_Query_Bool($query);
		$Dato=ClaRegistro::getList_Mante_Responsable($Datos[5]);
		return array("Val"=>$Valido,"Dato"=>$Dato);
 	}
	public static function Delete_Mante_Responsable($Datos){
 	 	$query="CALL mante_delete_Responsable('$Datos[0]');";
		//echo $query;
		$Valido=Class_Run::Execute_Query_Bool($query);
		$Dato=ClaRegistro::getList_Mante_Responsable($Datos[1]);
		return array("Val"=>$Valido,"Dato"=>$Dato);
 	}
	
	//MANTENIMIENTO GUIA 
	public static function getList_Mante_Combo_Guia(){
 	 	return ClaRegistro::getList_Mante_Region_Estado();
 	}
	public static function getList_Mante_Guia($Datos){
 	 	$query="SELECT IdGuia,Guia,`Estado`,`Telefono`,`Email`,CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est
				FROM `mante_guia` WHERE IdRegion=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Guia_Edit($Datos){
 	 	$query="SELECT IdGuia,Guia,`Estado`,`Telefono`,`Email`
		FROM `mante_guia` WHERE IdGuia=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Guia($Datos){
 	 	$query="CALL mante_save_Guia('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]');";
		//echo $query;
		$Valido=Class_Run::Execute_Query_Bool($query);
		$Dato=ClaRegistro::getList_Mante_Guia($Datos[5]);
		return array("Val"=>$Valido,"Dato"=>$Dato);
 	}
	public static function Delete_Mante_Guia($Datos){
 	 	$query="CALL mante_delete_Guia('$Datos[0]');";
		//echo $query;
		$Valido=Class_Run::Execute_Query_Bool($query);
		$Dato=ClaRegistro::getList_Mante_Guia($Datos[1]);
		return array("Val"=>$Valido,"Dato"=>$Dato);
 	}

	//CONDUCTOR 
	public static function getList_Mante_Combo_Conductor($IdCompany){
 	 	return ClaRegistro::getList_Mante_Region_Empresa($IdCompany);
 	}
	public static function getList_Mante_Conductor($Datos,$IdCompany){
 	 	$query="SELECT `IdConductor`,`IdRegion`,`Nombre1`,`Nombre2`,`ApPaterno`,`ApMaterno`,`IdTipoDocumento`,`NroDocumento`,`Sexo`,`LicConducir`,
		`LicConducirVenc`,`Categoria`,`CapAnual`,`Otros`,`CellPersonal`,`CellCorporativo`,`CorreoPersonal`,`CorreoCorporativo`,`Foto`,
		`NombreContacto`,`IdUnidad`,`Remuneracion`,`AFP`,`FondoPensiones`,`SeguroSocial`,`Bono`,`Estado`,`Firma`,
		fn_RecuperarNombre_ns('DOCUMENTO',IdTipoDocumento) AS TipoDoc,DATE_FORMAT(FechaNac,'%d/%m/%Y') AS FechaN,FechaNac,
		CASE WHEN Sexo=1 THEN 'M' ELSE 'F' END AS Sex,CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est,
		fn_RecuperarNombre_ns('CATEGORIA_CONDUCTOR',Categoria) AS Catg,CodUsuario
		FROM `mante_conductor` WHERE IdRegion='$Datos[0]' AND IdEmpresa=$IdCompany;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Conductor_Edit($Datos,$IdCompany){
 	 	$Conduct=ClaRegistro::getList_Mante_Conductor_IdCondc($Datos[0]);
		$TipoDoc=ClaRegistro::getList_TipoDocumento_Est();
		$Categ=ClaRegistro::getList_Mante_CategoriaCond_Estado();
		$Unidad=array();//claMante::getList_Mante_Conductor_IdCondc($Datos[0]);
		//echo $query;	
		return array("Conduct"=>$Conduct,"TipoDoc"=>$TipoDoc,"Unidad"=>$Unidad,"Categ"=>$Categ);
 	}
	public static function getList_Mante_Conductor_IdCondc($IdConductor){
 	 	$query="SELECT `IdConductor`,`IdRegion`,`Nombre1`,`Nombre2`,`ApPaterno`,`ApMaterno`,`IdTipoDocumento`,`NroDocumento`,`Sexo`,`LicConducir`,
		`LicConducirVenc`,`Categoria`,`CapAnual`,`Otros`,`CellPersonal`,`CellCorporativo`,`CorreoPersonal`,`CorreoCorporativo`,`Foto`,CodUsuario,
		`NombreContacto`,`IdUnidad`,`Remuneracion`,`AFP`,`FondoPensiones`,`SeguroSocial`,`Bono`,`Estado`,`Firma`,DATE_FORMAT(FechaNac,'%d/%m/%Y') AS FechaNac
		FROM `mante_conductor` WHERE IdConductor='$IdConductor';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_TipoDoc(){
 	 	$query="SELECT IdTipoDocumento,TipoDocumento,Simbolo FROM `mante_tipo_documento` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Conductor($Datos,$IdCompany){
		//[pId,IdReg,Nombre1,Nombre2,Paterno,Materno,IdTipoDoc,NroDoc,Fecha,Sexo,LicConducir,LicCondVenc,Categoria,CapAnual,Otros 14,
					//CellPersonal,CellCorporativo,CorreoPersonal,CorreCorporativo 18,Contacto,IdUnidad,Remu,AFP,FondoPen,SeguroSocial,Bono,hab,Imagen 27,
					//User,Pass,Firma]
 	 	$pId=$Datos[0];
		$IdReg=$Datos[1];
		
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=false;
		
		if($pId>0){//Existe
			$query0="UPDATE `mante_conductor` SET `Nombre1`='$Datos[2]',`Nombre2`='$Datos[3]',`ApPaterno`='$Datos[4]',`ApMaterno`='$Datos[5]',`IdTipoDocumento`='$Datos[6]',
					`NroDocumento`='$Datos[7]',`FechaNac`='$Datos[8]',`Sexo`='$Datos[9]',`LicConducir`='$Datos[10]',`LicConducirVenc`='$Datos[11]',`Categoria`='$Datos[12]',
					`CapAnual`='$Datos[13]',`Otros`='$Datos[14]',`CellPersonal`='$Datos[15]',`CellCorporativo`='$Datos[16]',`CorreoPersonal`='$Datos[17]',`CorreoCorporativo`='$Datos[18]',
					`Foto`='$Datos[27]',`NombreContacto`='$Datos[19]',`IdUnidad`='$Datos[20]',`Remuneracion`='$Datos[21]',`AFP`='$Datos[22]',`FondoPensiones`='$Datos[23]',
					`SeguroSocial`='$Datos[24]',`Bono`='$Datos[25]',`Estado`='$Datos[26]',Firma='$Datos[30]',CodUsuario='$Datos[28]'
				WHERE IdConductor='$pId';";
			//echo $query0;
			$sql = $pdo->prepare($query0);
			if($sql->execute()){
				if($Datos[29]!=""){
					$Pass=md5(md5($Datos[29]));
					$query2="UPDATE `mante_conductor` SET Contrasenia='".$Pass."' WHERE IdConductor='$pId';";
					//echo $query2;
					$sql = $pdo->prepare($query2);
					if($sql->execute()){$valido=true;}
				}else{$valido=true;}
			}
		}else{//New
			$query1="SELECT IFNULL(MAX(IdConductor+1),1) AS IdConductor FROM mante_conductor;";
			$sql = $pdo->prepare($query1);
			if($sql->execute()){
				$Pass=md5(md5($Datos[29]));
				$Result=$sql->fetchAll();
				$pId=$Result[0]["IdConductor"];
				$query2="INSERT INTO mante_conductor VALUES($pId,$IdReg,'$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]','$Datos[6]','$Datos[7]','$Datos[8]','$Datos[9]','$Datos[10]',
					'$Datos[11]','$Datos[12]','$Datos[13]','$Datos[14]','$Datos[15]','$Datos[16]','$Datos[17]','$Datos[18]','$Datos[27]','$Datos[19]','$Datos[20]','$Datos[21]',
					'$Datos[22]','$Datos[23]','$Datos[24]','$Datos[25]','$Datos[26]','$Datos[30]',$IdCompany,'$Datos[28]','".$Pass."');";
				//echo $query2;	
				$sql = $pdo->prepare($query2);
				if($sql->execute()){$valido=true;}
			}
		}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		$Dato=array();
		if($valido){
			$Dato=ClaRegistro::getList_Mante_Conductor([$IdReg],$IdCompany);
		}
		return array("Val"=>$valido,"Dato"=>$Dato);
 	
 	}
	public static function Delete_Mante_Conductor($Datos,$IdCompany){
 	 	$query="UPDATE mante_conductor SET Estado=0 WHERE IdConductor='$Datos[0]';";
		//echo $query;	
		$val=Class_Run::Execute_Query_Bool($query);
		$Dato=array();
		if($val){
			$Dato=claMante::getList_Mante_Conductor([$Datos[1]],$IdCompany);
		}
		return array("Val"=>$val,"Dato"=>$Dato);
 	}
	
	//UNIDAD 
	public static function getList_Mante_Combo_Unidad($IdCompany){
 	 	return ClaRegistro::getList_Mante_Region_Empresa($IdCompany);
 	}
	public static function getList_Mante_Unidad($IdCompany){
 	 	$query="SELECT `IdVehiculo`,`Marca`,`Modelo`,`CatUnidad`,`Codigo`,`Descripcion`,`Placa`,`Anio`,`NroAsientos`,`CatVehicular`,`CatLicReq`,
			`TUC`,`SOAT`,`RT`,`SCTR`,`SCAP`,`Estado`,`IdEmpresa`,CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est,
			fn_RecuperarNombre_ns('VEHICULO_MARCA',Marca) AS Marcas,fn_RecuperarNombre_ns('VEHICULO_MODELO',Modelo) AS Modelos,
			fn_RecuperarNombre_ns('CAT_UNIDAD',CatUnidad) AS CatUnidads,fn_RecuperarNombre_ns('CATEGORIA_VEHICULAR',CatVehicular) AS CatVehiculars,
			fn_RecuperarNombre_ns('LICENCIA_CONDUCIR',CatLicReq) AS CatLicReqs,SerieMotor,SerieChasis,IdTipoCombustible,fn_RecuperarNombre_ns('COMBUSTIBLE_TIPO',IdTipoCombustible) as TipoCombustible
			FROM `mante_vehiculo` WHERE IdEmpresa='$IdCompany';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Unidad_Edit($Datos,$IdCompany){
 	 	$Marca=ClaRegistro::getList_Mante_Marca_Est();
 	 	$CatVeh=ClaRegistro::getList_Mante_CatVehicular_Est();
 	 	$TipoCom=ClaRegistro::getList_Mante_TipoComb_Est();
		$Dato=ClaRegistro::getList_Mante_Unidad_Id($Datos[0],$IdCompany);
		return array("Marca"=>$Marca,"CatVeh"=>$CatVeh,"TipoCom"=>$TipoCom,"Dato"=>$Dato);
 	}
	public static function getList_Mante_TipoComb_Est(){
 	 	$query="SELECT IdTipoCombustible,TipoCombustible FROM `mante_combustible_tipo` WHERE Estado=1;";
		//echo $query;	  
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Marca_Est(){
 	 	$query="SELECT IdMarca,Marca,Simbolo,Estado FROM `mante_vehiculo_marca` WHERE Estado=1;";
		//echo $query;	  
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_CatVehicular_Est(){
 	 	$query="SELECT IdCategoriaVehicular,CategoriaVehicular,Simbolo FROM `mante_categoria_vehicular` WHERE Estado=1;";
		//echo $query;	  
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Unidad_Id($IdUnidad,$IdCompany){
 	 	$query="SELECT `IdVehiculo`,`Marca`,`Modelo`,`CatUnidad`,`Codigo`,`Descripcion`,`Placa`,`Anio`,`NroAsientos`,`CatVehicular`,`CatLicReq`,
			`TUC`,`SOAT`,`RT`,`SCTR`,`SCAP`,`Estado`,`IdEmpresa`,CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est,
			fn_RecuperarNombre_ns('VEHICULO_MARCA',Marca) AS Marcas,fn_RecuperarNombre_ns('VEHICULO_MODELO',Modelo) AS Modelos,
			fn_RecuperarNombre_ns('CAT_UNIDAD',CatUnidad) AS CatUnidads,fn_RecuperarNombre_ns('CATEGORIA_VEHICULAR',CatVehicular) AS CatVehiculars,
			fn_RecuperarNombre_ns('LICENCIA_CONDUCIR',CatLicReq) AS CatLicReqs,SerieMotor,SerieChasis,IdTipoCombustible
			FROM `mante_vehiculo` WHERE IdEmpresa='$IdCompany' AND IdVehiculo='$IdUnidad';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Marca_Modelo($Datos){
 	 	$query="SELECT `IdMarca`,`IdModelo`,`Modelo`,`Simbolo`,`Estado`
			FROM `mante_vehiculo_marca_modelo` WHERE IdMarca='$Datos[0]' AND Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_CtVehicular($Datos,$IdCompany){
 	 	$query="SELECT IdLicConducir,fn_RecuperarNombre_ns('LICENCIA_CONDUCIR',IdLicConducir) AS Lic
			FROM `mante_categoria_licconducir` WHERE IdCategoriaVehicular='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Modelo_CatUnidad($Datos,$IdCompany){
 	 	$query="SELECT IdCatUnidad,fn_RecuperarNombre_ns('CAT_UNIDAD_SIM',IdCatUnidad) AS CatUnidad
		FROM `mante_catunidad_modelo` WHERE IdModelo='$Datos[0]' GROUP BY IdCatUnidad ORDER BY CatUnidad ASC;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Unidad($Datos,$IdCompany){
 	 	$query="CALL mante_save_Unidad('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]','$Datos[6]','$Datos[7]','$Datos[8]','$Datos[9]','$Datos[10]',
			'$Datos[11]','$Datos[12]','$Datos[13]','$Datos[14]','$Datos[15]','$Datos[16]','$Datos[17]','$Datos[18]','$Datos[19]',$IdCompany);";
		//echo $query;
		$Valido=Class_Run::Execute_Query_Bool($query);
		$Dato=ClaRegistro::getList_Mante_Unidad($IdCompany);
		return array("Val"=>$Valido,"Dato"=>$Dato);
 	}
	
	//user agencia shuttle
	public static function getList_combo_UserAgenciaShuttle($Datos,$IdCompany){
 	 	$query="SELECT IdAgencia,fn_RecuperarNombre_ns('AGENCIA',IdAgencia) AS Agencia
				FROM `mante_agencia_sistema` WHERE IdEmpresa=$IdCompany AND IdRegion=$Datos[0] AND Habilitado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Agencia_User($Datos,$IdCompany){
 	 	$query="SELECT IdEmpresa,`IdUsuario`,`IdTipoDocumento`,`NroDocumento`,`Nombres`,`ApPaterno`,`ApMaterno`,DATE_FORMAT(FechaNac,'%d/%m/%Y') AS FechaNac,
			`Sexo`,`Direccion`,`Telefono`,`Email`,`CodUsuario`,`Firma`,Estado,IdTipoUsuario,Estado,CASE WHEN Sexo=1 THEN 'M' ELSE 'F' END AS Sex,
			fn_RecuperarNombre_ns('DOCUMENTO',IdTipoDocumento) AS TipoDoc,fn_RecuperarNombre_ns('USER_TIPOUSER_SIM',IdTipoUsuario) AS TipoUser,
			CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est
		FROM `user_usuario_sistema` WHERE IdEmpresa=$IdCompany AND IdAgencia='$Datos[0]' AND Nivel=4;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_UserAgenciaShuttle_Modal($Datos,$IdCompany){
 	 	$TipoDoc=ClaRegistro::getList_Mante_TipoDoc_Est();
		$TipoUser=ClaRegistro::getList_Mante_TipoUser();
		$Datos=ClaRegistro::getList_User_Id($Datos[0],$Datos[1],$IdCompany);
		return array("TipoDoc"=>$TipoDoc,"TipoUser"=>$TipoUser,"Dato"=>$Datos);
 	}
	public static function getList_Mante_TipoDoc_Est(){
		$query="SELECT IdTipoDocumento,TipoDocumento,Simbolo FROM `mante_tipo_documento` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_TipoUser(){
		$query="SELECT IdTipoUsuario,TipoUsuario,Simbolo
			FROM `user_tipo_usuario_sistema` WHERE Estado=1 AND Nivel=4;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_User_Id($IdAge,$IdUser,$IdCompany){
		$query="SELECT `IdEmpresa`,`IdUsuario`,`IdTipoDocumento`,`NroDocumento`,`Nombres`,`ApPaterno`,`ApMaterno`,DATE_FORMAT(`FechaNac`,'%d/%m/%Y') AS FechaNac,
		`Sexo`,`Direccion`,`Telefono`,`Email`,`CodUsuario`,`IdTipoUsuario`,`Estado`,`Firma`,`Nivel`
		FROM `user_usuario_sistema` WHERE IdEmpresa=$IdCompany AND IdUsuario='$IdUser' AND IdAgencia='$IdAge';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_UserAgenciaShuttle($Datos,$IdUser,$IdCompany){
		$query="CALL admin_save_UserAenciaShuttle('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]','$Datos[6]','$Datos[7]','$Datos[8]','$Datos[9]',
					'$Datos[10]','$Datos[11]','$Datos[12]','".md5(md5($Datos[13]))."','$Datos[14]','$Datos[15]','$Datos[16]','$IdCompany','$Datos[18]');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//proveedor
	public static function getList_Mante_Combo_Proveedor($IdCompany){
 	 	$query="SELECT IdTipoProveedor,TipoProveedor,Simbolo
			FROM `mante_proveedor_tipo` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Proveedor($Datos,$IdCompany){
 	 	$query="SELECT `IdProveedor`,`Ruc`,`RazonSocial`,`DireccionFiscal`,`NComercial`,`NOperacion`,`Representante`,`Email`,`Telefono`,`Banco`,`NroCuenta`,
		`Estado`,`IdTipoProveedor`,`IdEmpresa`,CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est
		FROM `mante_proveedor` WHERE IdTipoProveedor='$Datos[0]' AND IdEmpresa='$IdCompany';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Proveedor_Edit($Datos,$IdCompany){
 	 	$query="SELECT `IdProveedor`,`Ruc`,`RazonSocial`,`DireccionFiscal`,`NComercial`,`NOperacion`,`Representante`,`Email`,`Telefono`,`Banco`,`NroCuenta`,
		`Estado`,`IdTipoProveedor`,`IdEmpresa`
		FROM `mante_proveedor` WHERE IdProveedor='$Datos[0]' AND IdTipoProveedor='$Datos[1]' AND IdEmpresa='$IdCompany';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Proveedor($Datos,$IdCompany){
		//inst.Save_Mante_Proveedor([pId,IdTipoP,Ruc,RS,DirFiscal,NComercial,NOperacion,Repres,Email,Telefono,Banco,NroCuenta,IdEst]);
 	 	$query="CALL admin_save_mante_proveedor('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]','$Datos[6]','$Datos[7]','$Datos[8]','$Datos[9]','$Datos[10]',
				'$Datos[11]','$Datos[12]',$IdCompany);";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//GRIFOS
	public static function getList_Mante_Combo_Grifos($IdCompany){
		$query="SELECT IdProveedor,Ruc,RazonSocial,NComercial
				FROM `mante_proveedor` WHERE IdEmpresa='$IdCompany' AND Estado=1 AND IdTipoProveedor=2;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Grifos($Datos,$IdCompany){
		$query="SELECT IdEstacion,Estacion,Codigo,Direccion,Estado,CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est
				FROM `mante_grifo` WHERE IdRegion='$Datos[1]' AND IdEmpresa='$IdCompany' AND IdProveedor='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Grifo($Datos,$IdCompany){
		//[pId,IdReg,IdTipoP,Nombre,Codig,Direccion,IdEst]
 	 	$query="CALL admin_save_mante_Grifo('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]','$Datos[6]',$IdCompany);";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function getList_Mante_Grifo_Edit($Datos,$IdCompany){//[pId,IdTipoP,IdReg]
		$query="SELECT IdEstacion,Estacion,Codigo,Direccion,Estado
				FROM `mante_grifo` WHERE IdRegion='$Datos[2]' AND IdEmpresa='$IdCompany' AND IdProveedor='$Datos[1]' AND IdEstacion='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	//Act. Costos
	public static function getList_Mante_Combo_ActCostos($IdCompany){
		$Provv=ClaRegistro::getList_Mante_Combo_Grifos($IdCompany);
		//$TipoC=ClaRegistro::getList_Combustible_Tipo();
		return array("Prove"=>$Provv);
 	}
	public static function getList_Combustible_Tipo(){
		$query="SELECT IdTipoCombustible,TipoCombustible,Tipo FROM `mante_combustible_tipo` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_ActCostos($Datos,$IdCompany){
		$query="SELECT Diesel,Gas84,Gas90,Gas95,Gas98 FROM `mante_combustible_costos` 
			WHERE IdEmpresa='$IdCompany' AND IdProveedor='$Datos[0]' ORDER BY FechaReg DESC limit 1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_ActCostos($Datos,$IdCompany,$IdUser){
		//[IdTipoP,Diesel,Gas84,Gas90,Gas95,Gas98]
		$IdProve=$Datos[0];
		$Diesel=$Datos[1];
		$Gas84=$Datos[2];
		$Gas90=$Datos[3];
		$Gas95=$Datos[4];
		$Gas98=$Datos[5];
		
		$query="INSERT INTO `mante_combustible_costos` VALUES($IdCompany,$IdProve,CURRENT_TIMESTAMP(),1,$IdUser,'$Diesel','$Gas84','$Gas90','$Gas95','$Gas98');";
		//echo $query;
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//VAR GRIFOS
	public static function getList_Mante_Combo_VarGrifo($IdCompany){
		return ClaRegistro::getList_Mante_Combo_Grifos($IdCompany);
 	}
	public static function getList_Mante_VGrifos($Datos,$IdCompany){
		$query="select IdEstacion,IdRegion,Estacion,Codigo,Direccion,fn_RecuperarNombre_ns('REGION',IdRegion) as Region
			from `mante_grifo` where IdEmpresa='$IdCompany' and IdProveedor='$Datos[0]' and Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_TarifaProveedor($Datos,$IdCompany){
		$Prove=ClaRegistro::getList_Mante_ActCostos($Datos,$IdCompany);
		$Esta=ClaRegistro::getList_Variac_VGrifos($Datos,$IdCompany);
		return array("Prove"=>$Prove,"Esta"=>$Esta);
 	}
	public static function getList_Variac_VGrifos($Datos,$IdCompany){
		$query="SELECT Diesel,Gas84,Gas90,Gas95,Gas98 FROM `mante_grifo_variacion` 
			WHERE IdEmpresa='$IdCompany' AND IdProveedor='$Datos[0]' AND IdEstacion='$Datos[1]' ORDER BY FechaReg DESC limit 1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Variacion_CostosGrifo($Datos,$IdCompany,$IdUser){
		//[IdTipoP,pId,IdReg,Diesel,Gas84,Gas90,Gas95,Gas98]
		$IdProve=$Datos[0];
		$IdEsta=$Datos[1];
		$IdReg=$Datos[2];
		$Diesel=$Datos[3];
		$Gas84=$Datos[4];
		$Gas90=$Datos[5];
		$Gas95=$Datos[6];
		$Gas98=$Datos[7];
		
		$query="INSERT INTO `mante_grifo_variacion` VALUES($IdCompany,$IdProve,CURRENT_TIMESTAMP(),$IdUser,$IdEsta,'$Diesel','$Gas84','$Gas90','$Gas95','$Gas98');";
		//echo $query;
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//BANCO
	public static function getList_Mante_Banco($IdCompany){
		$query="SELECT IdBanco,Banco,Simbolo,CASE WHEN Estado=1 THEN 'Habilitado' ELSE 'DesHabilitado' END AS Est
				FROM `mante_banco` WHERE IdEmpresa='$IdCompany';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Banco_Est($IdCompany){
		$query="SELECT IdBanco,Banco,Simbolo
				FROM `mante_banco` WHERE IdEmpresa='$IdCompany' AND Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Banco_Edit($Datos,$IdCompany){
		$query="SELECT IdBanco,Banco,Simbolo,Estado
				FROM `mante_banco` WHERE IdEmpresa='$IdCompany' AND IdBanco=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Banco($Datos,$IdCompany){
		$query="CALL mante_save_Banco($Datos[0],'$Datos[1]','$Datos[2]',$Datos[3],$IdCompany);";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//CUENTAS
	public static function getList_Mante_Cuenta($IdCompany){
		$query="SELECT `IdCuenta`,`IdBanco`,`IdMoneda`,`IdArea`,`Numero`,`Nombre`,`Codigo`,`IdEncargado`,`IdTipo`,`Estado`,
		`fn_RecuperarNombre_ns`('BANCO_CUENTA_TIPO',IdTipo) AS Tipo,`fn_RecuperarNombre_ns`('MONEDA_SIM',IdMoneda) AS Moneda,
		`fn_RecuperarNombre_ns`('AREA',IdArea) AS Areaa,`fn_RecuperarNombre_ns`('BANCO',IdBanco) AS Banco,
		`fn_RecuperarNombre_ns`('USER_AP',IdEncargado) AS Userr
		FROM `mante_banco_cuentas` WHERE IdEmpresa='$IdCompany';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Cuenta_Id($IdCuenta,$IdCompany){
		$query="SELECT `IdCuenta`,`IdBanco`,`IdMoneda`,`IdArea`,`Numero`,`Nombre`,`Codigo`,`IdEncargado`,`IdTipo`,`Estado`
		FROM `mante_banco_cuentas` WHERE IdEmpresa='$IdCompany' AND IdCuenta='$IdCuenta';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Cuentas_Edit($Datos,$IdCompany){
		$Cuenta=ClaRegistro::getList_Mante_Cuenta_Id($Datos[0],$IdCompany);
		$Banco=ClaRegistro::getList_Mante_Banco_Est($IdCompany);
		$Area=ClaRegistro::getList_Mante_Areaa();
		$Tipo=ClaRegistro::getList_Mante_TipoC();
		$Moneda=ClaRegistro::getList_Mante_Moneda();
		$Encargado=ClaRegistro::getList_Mante_Encargado($IdCompany);
		//echo $query;	
		return array("Cuenta"=>$Cuenta,"Banco"=>$Banco,"Area"=>$Area,"Tipo"=>$Tipo,"Encargado"=>$Encargado,"Moneda"=>$Moneda);
 	}
	public static function getList_Mante_TipoC(){
		$query="select IdTipoCuenta,TipoCuenta,Simbolo
			from `mante_banco_cuenta_tipo` where Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Moneda(){
		$query="SELECT IdMoneda,Moneda,Simbolo FROM `mante_moneda` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Areaa(){
		$query="select IdArea,Area,Simbolo
			from `mante_region_area` where Estado=1 group by IdArea;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Encargado($IdCompany){
		$query="SELECT IdUsuario,Nombres,ApPaterno
			FROM `user_usuario_sistema` WHERE IdEmpresa='$IdCompany' AND Estado=1 AND IdAgencia=-1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Cuentas($Datos,$IdCompany){
		$query="CALL mante_save_Cuentas($Datos[0],'$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]','$Datos[6]',
				'$Datos[7]','$Datos[8]','$Datos[9]',$IdCompany);";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}

	//CONDUCTOR COMPENSACION 
	public static function getList_Mante_Combo_CondCompe($IdCompany){
		return ClaRegistro::getList_Mante_Region_Empresa($IdCompany);
 	}
	public static function getList_Mante_CondCompe($Datos,$IdCompany){
		$query="select `IdTipoCompensacion`,`TipoCompensacion`,`Simbolo`,`Estado`,`Monto`,
			case when Estado=1 then 'Habilitado' else 'DesHabilitado' end as Est
			from `mante_conductor_compensacion` where IdEmpresa='$IdCompany' and IdRegion='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_CondCompe_Edit($Datos,$IdCompany){
		$query="select `IdTipoCompensacion`,`TipoCompensacion`,`Simbolo`,`Estado`,`Monto`
			from `mante_conductor_compensacion` where IdEmpresa='$IdCompany' and IdRegion='$Datos[1]' AND IdTipoCompensacion=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_CondCompe($Datos,$IdCompany){
		$query="CALL mante_save_CondCompe($Datos[0],'$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]',$IdCompany);";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	
}



?>

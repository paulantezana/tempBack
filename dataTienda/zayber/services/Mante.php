<?php
class ClaMante{
	//TC
	public static function getList_Mante_TC(){
 	 	$query="SELECT Cambio FROM mante_tipo_cambio ORDER BY FechaReg DESC;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}public static function Save_Mante_TC($Datos){
 	 	$query="INSERT INTO mante_tipo_cambio VALUES(2,CURRENT_TIMESTAMP(),'".$Datos[0]."');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//MONEDA
	public static function getList_Mante_Moneda_Est(){
 	 	$query="SELECT IdMoneda,Moneda,Simbolo FROM `mante_moneda` WHERE Habilitado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	//ALMACEN 
	public static function getList_Mante_Almacen($IdEmpresa){
 	 	$query="SELECT IdAlmacen,Almacen,Simbolo,Descripcion,Ruc,RazonSocial,Direccion,Estado,
		CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est
		FROM `mante_almacen`;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Almacen_Edit($Datos){
 	 	$query="SELECT IdAlmacen,Almacen,Simbolo,Descripcion,Ruc,RazonSocial,Direccion,ColorFondo,ColorTexto,Estado
		FROM `mante_almacen` where IdAlmacen=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Almacen($Datos){
 	 	$query="CALL mante_save_almacen('".$Datos[0]."','".addslashes($Datos[1])."','".addslashes($Datos[2])."',
			'".addslashes($Datos[3])."','".addslashes($Datos[4])."','".addslashes($Datos[5])."','".addslashes($Datos[6])."','".addslashes($Datos[7])."','".addslashes($Datos[8])."','".$Datos[9]."');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//UNIDAD 
	public static function getList_Mante_Unidad($IdEmpresa){
 	 	$query="SELECT IdUnidad,Unidad,Simbolo,CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est
				FROM mante_unidad;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Unidad_Edit($Datos){
 	 	$query="SELECT IdUnidad,Unidad,Simbolo,Estado
				FROM mante_unidad where IdUnidad=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Unidad($Datos){
 	 	$query="CALL mante_save_Unidad('".$Datos[0]."','".addslashes($Datos[1])."','".addslashes($Datos[2])."','".$Datos[3]."');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function getList_Mante_Unidad_Est(){
 	 	$query="SELECT IdUnidad,Unidad,Simbolo FROM mante_unidad where Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	//MARCA
	public static function getList_Mante_Marca_Est(){
 	 	$query="select IdMarca,Marca,Simbolo from `mante_marca` where Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Marca($IdEmpresa){
 	 	$query="select IdMarca,Marca,Simbolo,CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est 
		from `mante_marca`;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Marca_Edit($Datos){
 	 	$query="select IdMarca,Marca,Simbolo,Estado
		from `mante_marca` where IdMarca=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Marca($Datos){
 	 	$query="CALL mante_save_Marca('".$Datos[0]."','".addslashes($Datos[1])."','".addslashes($Datos[2])."','".$Datos[3]."');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//Categoria
	public static function getList_Mante_Categoria_Est(){
 	 	$query="select IdCategoria,Categoria,Simbolo from `mante_categoria` where Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Categoria($IdEmpresa){
 	 	$query="select IdCategoria,Categoria,Simbolo,CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est 
		from `mante_categoria`;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Categoria_Edit($Datos){
 	 	$query="select IdCategoria,Categoria,Simbolo,Estado
		from `mante_categoria` where IdCategoria=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Categoria($Datos){
 	 	$query="CALL mante_save_Categoria('".$Datos[0]."','".addslashes($Datos[1])."','".addslashes($Datos[2])."','".$Datos[3]."');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//PROVEEDOR 
	public static function getList_Mante_Proveedor($IdEmpresa){
 	 	$query="SELECT `IdProveedor`,`Comercial`,`Ruc`,`RazonSocial`,`Direccion`,`Telefono`,`Responsable`,`Obs`,Email,
			CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est
			FROM `mante_proveedor`;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Proveedor_Edit($Datos,$IdEmpresa){
 	 	$query="SELECT `IdProveedor`,`Comercial`,`Ruc`,`RazonSocial`,`Direccion`,`Telefono`,`Responsable`,`Obs`,Email,Estado
			FROM `mante_proveedor` WHERE IdProveedor=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Proveedor($Datos,$IdEmpresa){
 	 	$query="CALL mante_save_mante_proveedor('$Datos[0]','".addslashes($Datos[1])."','".addslashes($Datos[2])."',
			'".addslashes($Datos[3])."','".addslashes($Datos[4])."','".addslashes($Datos[5])."','".addslashes($Datos[6])."',
			'".addslashes($Datos[7])."','".addslashes($Datos[8])."','$Datos[9]');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//CLIENTE
	public static function getList_Mante_Cliente($IdEmpresa){
 	 	$query="SELECT IdCliente,IdTipoDocumento,NroDocumento,NombreRS,Direccion,`Telefono`,`Obs`,Email,Estado,
			CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est
			FROM `mante_cliente`;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Cliente_Edit($Datos,$IdEmpresa){
 	 	$query="SELECT IdCliente,IdTipoDocumento,NroDocumento,NombreRS,Direccion,`Telefono`,`Obs`,Email,Estado
			FROM `mante_cliente` WHERE IdCliente=$Datos[0];";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Cliente($Datos,$IdEmpresa){
		//[pId,Ruc,RS,Direccion,Telef,Email,Obs,IdEst]
 	 	$query="CALL mante_save_mante_cliente('$Datos[0]','".addslashes($Datos[1])."','".addslashes($Datos[2])."',
			'".addslashes($Datos[3])."','".addslashes($Datos[4])."','".addslashes($Datos[5])."','".addslashes($Datos[6])."',
			'$Datos[7]');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	public static function getList_Mante_ConfClienteTrf($IdEmpresa){
 	 	$Produ=ClaMante::getList_Producto_ConfClienteTrf();
 	 	$Cliente=ClaMante::getList_Cliente_ConfClienteTrf();
		//echo $query;	
		return array("Produ"=>$Produ,"Cliente"=>$Cliente);
 	}
	public static function getList_Cliente_ConfClienteTrf(){
 	 	$query="SELECT `IdCliente`,`Comercial`
			FROM `mante_cliente_p` where Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Producto_ConfClienteTrf(){
 	 	$query="select IdProducto,Codigo,Producto,fn_RecuperarNombre_ns('UNIDAD_SIM',IdUnidad) AS Unidad,
			fn_RecuperarNombre_ns('CATEGORIA',IdCategoria) as Categoria
			from `mante_producto` where Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Tarifa_ConfClienteTrf($Datos,$IdEmpresa){
 	 	$query="SELECT IdProducto,Costo
			FROM `mante_cliente_producto_tarifa` WHERE IdCliente='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_ConfClienteTrf($Datos,$IdEmpresa){
 	 	$query="CALL mante_save_mante_cliente_trf('$Datos[0]','$Datos[1]','$Datos[2]');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function getList_NroRuc_Client($Datos){
 	 	$sunatt = new Sunat();
		$Datt=$claSunat::getList_Datos_RUC($Datos[0]);
		return array($Datt);
 	}
	
	//PRODUCTOS 
	public static function getList_Mante_Productos($IdEmpresa){
 	 	$query="select IdProducto,Codigo,Producto,IdMarca,IdCategoria,Estado,
		fn_RecuperarNombre_ns('MARCA',IdMarca) AS Marca,fn_RecuperarNombre_ns('CATEGORIA',IdCategoria) AS Categoria,
		CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est
		from mante_producto WHERE Estado=1 order by IdProducto asc;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Productos_Est(){
 	 	$query="select IdProducto,Codigo,Producto
			from `mante_producto` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_ManteProductos_Edit($Datos,$IdEmpresa){
 	 	$Categoria=ClaMante::getList_Mante_Categoria_Est();
 	 	$Marca=ClaMante::getList_Mante_Marca_Est();
 	 	$Produ=ClaMante::getList_Mante_Productos_Id($Datos[0]);
		return array("Categoria"=>$Categoria,"Marca"=>$Marca,"Produ"=>$Produ);
 	}
	public static function getList_Mante_Productos_Id($pId){
 	 	$query="select IdProducto,Codigo,Producto,IdMarca,IdCategoria,Estado
			from `mante_producto` where IdProducto=$pId;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Productos($Datos,$IdEmpresa){
		//[pId,Codigo,Prodc,IdMarca,IdCategoria,IdEst]
 	 	$query="CALL mante_save_mante_productos('$Datos[0]','".addslashes($Datos[1])."','".addslashes($Datos[2])."','$Datos[3]','$Datos[4]','$Datos[5]');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//PRODUCTOS ALMACEN
	public static function getList_Mante_ProductoAlm($IdEmpresa){
 	 	$query="SELECT IdAlmacen,Almacen FROM `mante_almacen` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_ProductoAlm($Datos,$IdEmpresa){
 	 	$query="SELECT mpa.IdAlmacen,mpa.IdProducto,mpa.IdUnidad,mpa.IdMoneda,mpa.Stock,mpa.PrecioCompra,mpa.PrecioBase,mpa.PrecioDistribuido,mpa.PrecioPublico,mpa.Estado,
		  fn_RecuperarNombre_ns('UNIDAD',mpa.IdUnidad) AS Unidad,CASE WHEN mpa.Estado=1 THEN 'Si' ELSE 'No' END AS Est,
		  fn_RecuperarNombre_ns('MONEDA_SIM',mpa.IdMoneda) AS Moneda,fn_RecuperarNombre_ns('PRODUCTO',mpa.IdProducto) AS Producto,fn_RecuperarNombre_ns('PRODUCTO_CODIGO',mpa.IdProducto) AS Codigo,
		  fn_RecuperarNombre_ns('MARCA',mp.IdMarca) AS Marc,fn_RecuperarNombre_ns('CATEGORIA',mp.IdCategoria) AS Categ
		  FROM `mante_producto_almacen`  mpa inner join `mante_producto` mp on mpa.IdProducto=mp.IdProducto
		  WHERE IdAlmacen='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_ProductoAlm_Id($pId,$pIdUni,$pIdAlm){
 	 	$query="SELECT IdAlmacen,IdProducto,IdUnidad,IdMoneda,Stock,PrecioCompra,PrecioBase,PrecioDistribuido,PrecioPublico,Estado,TipoCambio
			FROM `mante_producto_almacen` WHERE IdAlmacen='$pIdAlm' AND IdProducto='$pId' AND IdUnidad='$pIdUni';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_ProductoAlm_Edit($Datos,$IdEmpresa){
 	 	$Unidad=ClaMante::getList_Mante_Unidad_Est();
 	 	$Moneda=ClaMante::getList_Mante_Moneda_Est();
 	 	$Produ=ClaMante::getList_Mante_Productos_Est();
 	 	$PA=ClaMante::getList_Datos_ProductoAlm_Id($Datos[0],$Datos[1],$Datos[2]);
		//echo $query;	
		return array("PA"=>$PA,"Produ"=>$Produ,"Unidad"=>$Unidad,"Moneda"=>$Moneda);
 	}
	public static function Save_Mante_ProductoAlm($Datos,$IdEmpresa){
		//[pId,IdAlm,IdProd,PComp,PBase,PDistribuido,PPublico,IdUnidad,IdMoneda,IdEst,TC]
 	 	$query="CALL mante_save_mante_ProductoAlm('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]','$Datos[6]','$Datos[7]',
				'$Datos[8]','$Datos[9]','$Datos[10]');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function getList_cbo_ProductoAlm_IdProd($Datos,$IdEmpresa){
 	 	$query="SELECT IdAlmacen,IdProducto,IdUnidad,IdMoneda,Stock,PrecioCompra,PrecioBase,PrecioDistribuido,PrecioPublico,Estado,TipoCambio
			FROM `mante_producto_almacen` WHERE IdAlmacen='$Datos[1]' AND IdProducto='$Datos[0]' AND IdUnidad=$Datos[2];";
		//echo $query;
		return Class_Run::Select_Query($query);	
 	}
	
	//EXPORTAR PRODUCTO ALM
	public static function getList_Datos_ExportarProduct($Datos){
		$IdAlm=$Datos[0];
 	 	$query="SELECT alm.PrecioCompra,PrecioPublico,alm.`PrecioMenor`,alm.`PrecioMayor`,alm.`Stock`,
		prod.`Codigo`,prod.`Producto`,prod.Anio,prod.`CodigoFabricante`,
		fn_RecuperarNombre_ns('MARCA',IdMarca) AS Marca,fn_RecuperarNombre_ns('MODELO',IdModelo) AS Modelo
		FROM `mante_producto_almacen` alm
		LEFT JOIN `mante_producto` prod ON(alm.`IdProducto`=prod.IdProducto)
		WHERE alm.`IdAlmacen`='".$IdAlm."';";
		return Class_Run::Select_Query($query);	
 	}
	public static function getList_Datos_ImportarProduct(){
		$Marca=ClaMante::getList_Marca();
		$Modelo=ClaMante::getList_Modelo();
		return array("Marca"=>$Marca,"Modelo"=>$Modelo);	
 	}
	public static function getList_Marca(){
 	 	$query="SELECT IdMarca as Id,Marca as Nombre FROM `mante_marca` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Modelo(){
 	 	$query="SELECT IdCategoria as Id,Categoria as Nombre FROM `mante_categoria` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Marca_ImportarProduct($Datos){
 	 	$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		for($i=0;$i<count($Datos);$i++){
			$Marca=$Datos[$i];
			$query="SELECT fn_Save_marca_importP('".$Marca."') as cont;";
			$sql3 = $pdo->prepare($query);
			if($sql3->execute()){
				$valido=true;
			}else{$valido=false;}
		}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		return $valido;
 	}
	public static function Save_Modelo_ImportarProduct($Datos){
 	 	$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		for($i=0;$i<count($Datos);$i++){
			$Modelo=$Datos[$i];
			$query="SELECT fn_Save_modelo_importP('".$Modelo."') as cont;";
			$sql3 = $pdo->prepare($query);
			if($sql3->execute()){
				$valido=true;
			}else{$valido=false;}
		}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		return $valido;
 	}
	public static function Save_Producto_ImportarProduct($Datos){
		$IdAlm=$Datos[0];
		$Dato=$Datos[1];
		//print_r($Datos);
		$valido=true;
		try {
			$pdo = ConexionBD::conectarBD();
			$pdo->beginTransaction();
			$long=count($Dato);
			for($i=0;$i<$long;$i++){
				/*  && !empty($Dato[$i]["fabrica"]) && !empty($Dato[$i]["descripcion"]) && 
					!empty($Dato[$i]["marca"]) && !empty($Dato[$i]["modelo"]) && !empty($Dato[$i]["compra"]) && !empty($Dato[$i]["mayor"]) && 
					!empty($Dato[$i]["menor"]) && !empty($Dato[$i]["publico"]) */
				if(!empty($Dato[$i]["codigo"]) ){
					$Codigo=$Dato[$i]["codigo"];
					//$Fabrica=$Dato[$i]["fabrica"];
					$Descripcion=$Dato[$i]["descripcion"];
					$Marca=$Dato[$i]["marca"];
					$Modelo=$Dato[$i]["modelo"];
					$Compra=$Dato[$i]["compra"];
					$Mayor=$Dato[$i]["mayor"];
					$Menor=$Dato[$i]["menor"];
					$Publico=$Dato[$i]["publico"];
					$query="SELECT fn_Save_Productos_importP('".addslashes($Codigo)."','".addslashes($Descripcion)."',
						'".$Marca."','".$Modelo."','".trim($Compra)."','".trim($Mayor)."','".trim($Menor)."','".trim($Publico)."',".$IdAlm.") as cont;";
					//echo $query;	
					$sql3 = $pdo->prepare($query);
					if($sql3->execute()){
						$valido=true;
					}else{$valido=false;}
				}else{$valido=false;}
			}
			
		} catch (Exception $e) {
			$valido=false;echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		return $valido;
 	}
	public static function GenerarLetras($datos,$idusuario){
		$fechaReg=$datos[0];
		$fechaPago=$datos[1];
		$ruc=$datos[2];
		$razonsocial=$datos[3];
		$direccion=$datos[4];
		$total=$datos[5];
		$son=$datos[6];
		$lugarGiro=$datos[7];
		$Localidad=$datos[8];
		$IdEmpresa=$datos[9];
		$query="SELECT IFNULL(MAX(CodImpresion+1),10000) FROM `mante_letras` WHERE IdEmpresa='".$IdEmpresa."' ";
		$Respuesta= Class_Run::Select_Query($query);	
		$CodImp=$Respuesta[0][0];
		$consulta="INSERT INTO mante_letras(IdEmpresa,CodImpresion,FechaReg,FechaPago,LugarGiro,Ruc,RazonSocial,Direccion,Total,Son,idUsuario,Localidad) 
		VALUES('".$IdEmpresa."','".$CodImp."','".$fechaReg."','".$fechaPago."','".$lugarGiro."','".$ruc."','".$razonsocial."','".$direccion."','".$total."','".$son."','".$idusuario."','".$Localidad."')";
		return Class_Run::Execute_Query_Bool($consulta);
	 }
	 public static function ListarLetrasGeneradas($datos){
		$fechaInicio=$datos[0];
		$fechaFin=$datos[1];
		$idEmpresa=$datos[2];
		//$query="SELECT * FROM `mante_letras` WHERE DATE_FORMAT(fechaReg,'%d/%m/%Y') BETWEEN '$fechaInicio' AND '$fechaFin';";
		$query="SELECT * FROM mante_letras WHERE IdEmpresa='".$idEmpresa."'";
		return Class_Run::Select_Query($query);	
	 }
	public static function Print_Letras($IdLetra){
		$query="SELECT IdEmpresa,CodImpresion,FechaReg,LugarGiro,FechaPago,Total,Son,RazonSocial,Direccion,Ruc,Localidad FROM mante_letras WHERE idletra='".$IdLetra."' ";
		return Class_Run::Select_Query($query);	
	}
}
?>
<?php 
class homeModel{
    public static function getList_permission_UserSistema($IdTipoUser,$IdEmpresa){
		$query="";
		if($IdTipoUser==1){
			$query="SELECT IdForm,Menu,Enlace,Nombre,Nivel1,Nivel2,ColorFondo,Clase,Icono
				FROM `user_menu_sistema` WHERE Estado=1 ORDER BY Nivel1,Nivel2 ASC;";
		}else{
			$query="SELECT per.IdTipoUsuario,per.IdForm,me.Menu,me.Enlace,me.Nombre,me.Nivel1,me.Nivel2,me.ColorFondo,me.Clase,Icono
			FROM `user_permiso_sistema` per
			LEFT JOIN `user_usuario_sistema`us ON(per.IdTipoUsuario=us.IdTipoUsuario)
			LEFT JOIN `user_menu_sistema` me ON(per.IdForm=me.IdForm)
			WHERE per.IdTipoUsuario='$IdTipoUser' AND us.Estado=1 AND me.`Estado`=1 GROUP BY per.IdForm ORDER BY Nivel1,Nivel2 ASC;";
		}
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_UserAlm($pIdUser,$IdEmpresa){
 	 	$query="SELECT mua.IdAlmacen, ma.Almacen, ma.ColorFondo, ma.ColorTexto  FROM `mante_usuario_almacen` AS mua
		  INNER JOIN mante_almacen AS ma ON mua.IdAlmacen = ma.IdAlmacen WHERE IdUsuario = '$pIdUser';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Almacen_IdAlm($IdAlm){
 	 	$query="select IdAlmacen,Almacen from `mante_almacen` where IdAlmacen=$IdAlm;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Productos(){
 	 	$query="select IdProducto,Codigo,Producto,IdMarca,IdModelo,Anio,CodigoFabricante,StockMinimo,Estado,
		fn_RecuperarNombre_ns('MARCA',IdMarca) AS Marca,fn_RecuperarNombre_ns('MODELO',IdModelo) AS Modelo,
		CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est,IdUnidad,fn_RecuperarNombre_ns('UNIDAD',IdUnidad) AS Unidad
		from mante_producto WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	
	public static function getList_ventas($IdAlm){
 	 	$Alm=homeModel::getList_Almacen_IdAlm($IdAlm);
 	 	$Comprobante=homeModel::getList_Mante_Comprobantes_Vent();
 	 	//$TipoDoc=homeModel::getList_Mante_TipoDoc_Vent();
 	 	$Empresa=homeModel::getList_EmpresaAlm_Vent($IdAlm);
		//echo $query;	
		return array("Alm"=>$Alm,"Comprobante"=>$Comprobante,"Empresa"=>$Empresa);
 	}
	public static function getList_Mante_Comprobantes_Vent(){
 	 	$query="SELECT IdComprobante as Id,Comprobante as Nombre
				FROM `mante_comprobante` WHERE IdComprobante=1 OR IdComprobante=2 OR IdComprobante=10;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_TipoDoc_Vent(){
 	 	$query="SELECT IdTipoDocumento as Id,TipoDocumento as Nombre FROM `mante_tipo_documento` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_EmpresaAlm_Vent($pIdAlm){
 	 	$query="SELECT alm.IdEmpresa as Id,emp.Comercial as Nombre
		FROM `mante_almacen_empresa` alm
		LEFT JOIN `mante_empresa` emp ON(emp.IdEmpresa=alm.IdEmpresa)
		WHERE alm.IdAlmacen='$pIdAlm';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	
	/*  MODELO REPORT VENTA */ 
	public static function getList_ReportVentas($IdAlm){
 	 	$Alm=homeModel::getList_Almacen_IdAlm($IdAlm);
 	 	$Empresa=homeModel::getList_EmpresaAlm_Vent($IdAlm);
		//echo $query;	
		return array("Alm"=>$Alm,"Empresa"=>$Empresa);
 	}
	public static function getList_ExportarProducto(){
 	 	$Alm=homeModel::getList_Alm_Expor();
 	 	
		return array("Alm"=>$Alm);
 	}
	public static function getList_Alm_Expor(){
 	 	$query="SELECT IdAlmacen AS Id,Almacen AS Nombre FROM `mante_almacen` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	
 }
?>
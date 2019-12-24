<?php
class ClaReport{
	//REPORTE IMPRESION
	public static function getList_Datos_printTICKETS($Datos){
		$pIdVenta=$Datos[0];
		$IdEmp=$Datos[1];
 	 	$Venta=ClaReport::getList_Cab_Ventas($pIdVenta);
 	 	$Detalle=ClaReport::getList_Detalle_Ventas($pIdVenta);
 	 	$Empresa=ClaReport::getList_Datos_Almacen_Ventas($IdEmp);
		//echo $query;	
		return array("Venta"=>$Venta,"Detalle"=>$Detalle,"Empresa"=>$Empresa);
 	}
	public static function getList_Cab_Ventas($pIdVenta){
 	 	$query="SELECT IdEmpresa,IdAlmacen,IdVenta,IdComprobante,FechaReg,DATE_FORMAT(FechaE,'%d/%m/%Y') AS Fecha,Email,NroFactura,
			fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,Ruc,RazonSocial,Direccion,Total,SubTotal,IGV,Son,IdChkIGV,
			fn_RecuperarNombre_ns('CREDITO_SIM',IdTipoCredito) AS TipoC,Obs,Estado,Serie,Numero,
			fn_RecuperarNombre_ns('COMPROBANTE',IdComprobante) AS Comprobante
			FROM `mante_venta` WHERE IdVenta='".$pIdVenta."';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Detalle_Ventas($pIdVenta){
 	 	$query="SELECT IdDetalle,Cantidad,Codigo,Producto,PUnitario,Importe,Unidad,IdProducto
			FROM `mante_venta_detalle` where IdVenta='$pIdVenta';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_Almacen_Ventas($IdEmp){
 	 	$query="SELECT Comercial,Ruc,RazonSocial,Direccion,Representante,Telefono,Email
			FROM mante_empresa WHERE IdEmpresa='$IdEmp';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Print_FacturaBoleta($Datos){
		$IdVenta=$Datos[0];
 	 	$query="select ifnull(enlace,'') as enlace from `mante_venta` where IdVenta='".$IdVenta."';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	//REPORTE VENTA 
	public static function getList_Datos_RVenta($Datos){
 	 	$query="select IdEmpresa,IdAlmacen,IdVenta,IdComprobante,fn_RecuperarNombre_ns('COMPANY',IdEmpresa) AS Empresa,
				fn_RecuperarNombre_ns('COMPROBANTE',IdComprobante) as Comprobante,Serie,Numero,date_format(FechaE,'%d/%m/%Y') as Fec,
				FechaReg,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,Ruc,RazonSocial,Direccion,Email,NroFactura,
				Total,SubTotal,IGV,Son,IdChkIGV,Obs,PagoObs,Estado,Impresion,fn_RecuperarNombre_ns('CREDITO',IdTipoCredito) as TipoC,
				fn_RecuperarNombre_ns('VENTA_ESTADO',Estado) AS Est
		from `mante_venta` where FechaE between '$Datos[0]' and '$Datos[1]' and IdAlmacen='$Datos[2]' and IdEmpresa='$Datos[3]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_combo_RVenta($Datos){
 	 	$query="SELECT IdEmpresa,Comercial FROM `mante_empresa` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	//REPORTE COMPRA
	public static function getList_Datos_RCompra($Datos){
 	 	$query="SELECT `IdCompra`,`IdUsuario`,`FechaReg`,`IdComprobante`,`Serie`,`Numero`,`IdProveedor`,`Obs`,Total,SubTotal,IGV,
			IdTipoPago,`Estado`,fn_RecuperarNombre_ns('COMPRA_ESTADO',Estado) AS Est,DATE_FORMAT(FechaEmision,'%d/%m/%Y') AS Fec,
			fn_RecuperarNombre_ns('COMPROBANTE',IdComprobante) AS Comprobante,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,
			fn_RecuperarNombre_ns('PAGO_TIPO',IdTipoPago) AS TipoPago,IdAlmacen,DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPago,
			fn_RecuperarNombre_ns('PROVEEDOR',IdProveedor) AS Proveedor,
			fn_RecuperarNombre_ns('MONEDA_SIM',IdMoneda) AS Moneda
			from `mante_compra` where IdAlmacen='$Datos[2]' AND FechaEmision between '$Datos[0]' and '$Datos[1]' 
			ORDER BY FechaEmision ASC;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_Compra_Detalle($Datos){
 	 	$query="SELECT IdDetalle,Cantidad,Codigo,Producto,PUnitario,Importe,Unidad,PrecioPublico,PrecioMenor,PrecioMayor
			FROM `mante_compra_detalle` WHERE IdAlmacen='$Datos[1]' AND IdCompra='$Datos[0]';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Anular_Compra($Datos,$IdUser){
		$pOrigen=$Datos[3];
		$pDestino='Anulado';
		$pIdTipoEntrada=5;
		$aFechaE=date("Y-m-d", (strtotime ("-5 Hours")));
		$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
 	 	$query="CALL mante_anular_Compra('".$Datos[0]."','".$Datos[1]."','".addslashes($Datos[2])."',".$IdUser.",
				'".addslashes($pOrigen)."','".addslashes($pDestino)."','".$pIdTipoEntrada."','".$FechaHr."');";
		//echo $query;
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//REPORTE COMPRA SIMPLE
	public static function Anular_CompraS($Datos,$IdUser){
		$pOrigen=$Datos[3];
		$pDestino='Anulado';
		$pIdTipoEntrada=8;
		$aFechaE=date("Y-m-d", (strtotime ("-5 Hours")));
		$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
 	 	$query="CALL mante_anular_Compra_Simple('".$Datos[0]."','".$Datos[1]."','".addslashes($Datos[2])."',".$IdUser.",
				'".addslashes($pOrigen)."','".addslashes($pDestino)."','".$pIdTipoEntrada."','".$FechaHr."');";
		//echo $query;
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function getList_Datos_RCompraS($Datos){
 	 	$query="SELECT IdAlmacen,IdCompraS,FechaReg,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,Responsable,Total,Obs,Estado,
			CASE WHEN Estado=1 THEN 'Valido' ELSE 'Anulado' END AS Est,DATE_FORMAT(FechaReg,'%d/%m/%Y') AS Fec
			FROM `mante_compra_simple` 
			WHERE IdAlmacen='$Datos[2]' AND DATE_FORMAT(FechaReg,'%Y-%m-%d') BETWEEN '$Datos[0]' AND '$Datos[1]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_CompraS_Detalle($Datos){
 	 	$query="SELECT IdDetalle,Cantidad,Codigo,Producto,PrecioCompra,Importe,Unidad,PrecioPublico,PrecioMenor,PrecioMayor
			FROM `mante_compra_simple_detalle` WHERE IdAlmacen='$Datos[1]' AND IdCompraS='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	// NOTA PEDIDO 
	public static function getList_Datos_RNP($Datos){
 	 	$query="select IdEmpresa,IdAlmacen,IdVenta,IdNotaPedido,Serie,Numero,fn_RecuperarNombre_ns('COMPROBANTE',IdNotaPedido) as Comprobante,
				FechaReg,date_format(FechaE,'%d/%m/%Y') as Fec,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,Obs,
				Total,SubTotal,IGV,IdChkIGV,Son,IdTipoDoc,Ruc,RS,Direccion,Email,Telefono,date_format(FechaEntrega,'%d/%m/%Y') as FechaEntrega,
				fn_RecuperarNombre_ns('COMPANY',IdEmpresa) AS Empresa,Estado
			from `mante_registro_nota_pedido` where IdAlmacen='$Datos[2]' and FechaE between '$Datos[0]' and '$Datos[1]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_NotaPedido_Detalle($Datos){
 	 	$query="SELECT IdDetalle,Cantidad,Codigo,Descripcion,Precio,Importe,Unidad
			FROM `mante_registro_nota_pedido_detalle` WHERE IdAlmacen='$Datos[1]' AND IdVenta='$Datos[0]' AND IdEmpresa='$Datos[3]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Anular_Venta_NP($Datos,$IdUser){
 	 	$query="UPDATE mante_registro_nota_pedido SET  Estado=0,Obs=CONCAT(Obs,'/','".addslashes($Datos[2])."')
				WHERE IdAlmacen='$Datos[1]' AND IdVenta='$Datos[0]' AND Estado=1 AND IdEmpresa='$Datos[3]';";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}

	/////////// REPORT VENTA PAGO VENDEDOR 
	public static function getList_cbo_VPV(){
 	 	$query="SELECT IdEmpresa,Comercial FROM `mante_empresa` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_VPV($Datos){
		$Condi='';
		if($Datos[2]>0){
			$Condi=' AND IdEmpresa='.$Datos[2];
		}
 	 	$query="SELECT IdEmpresa,IdAlmacen,IdVenta,IdComprobante,Serie,Numero,FechaReg,fn_RecuperarNombre_ns('COMPANY',IdEmpresa) AS Empresa,
		fn_RecuperarNombre_ns('COMPROBANTE',IdComprobante) AS Comprobante,DATE_FORMAT(FechaE,'%d/%m/%Y') AS Fec,Ruc,RazonSocial,Direccion,
		Email,NroFactura,Total,SubTotal,IGV,Estado,Impresion,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,Email,
		DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FecPag,IdCliente,fn_RecuperarNombre_ns('VENTA_ESTADO',Estado) AS Est
		FROM `mante_venta`
		WHERE IdTipoCredito=2 AND Estado>0 AND FechaE BETWEEN '$Datos[0]' AND '$Datos[1]' $Condi;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Datos_VentaCredito($Datos,$IdUser){
		//[NroRuc,RS,TotalAdd,IdVend,IdAlm,Total,Datos,Detail]
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$aIdCliente=$Datos[0];
		$aRuc=$Datos[1];
		$aRS=$Datos[2];
		$aIdEmpresa=$Datos[3];
		$aIdVend=$Datos[4];
		$aTotal=$Datos[5];
		
		$Ventas=array();
		$Ventas=$Datos[6];
		$aDetail=array();
		$aDetail=$Datos[7];
		$IdVentaC=1;
		
		$queryRes="SELECT IFNULL(MAX(IdVentaCredito+1),1) AS Com FROM mante_venta_credito;";
		$sql = $pdo->prepare($queryRes);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdVentaC=$fila1[0]["Com"];
			$queryInsR="INSERT INTO mante_venta_credito VALUES(".$IdVentaC.",'".$aIdCliente."','".$aTotal."','".$aIdVend."',CURRENT_TIMESTAMP(),'".$IdUser."','".$aIdEmpresa."');";
			//echo $queryInsR;
			$sql1 = $pdo->prepare($queryInsR);
			if($sql1->execute()){
				for($i=0;$i<count($aDetail);$i++)
				{	
					$aNroC=$aDetail[$i]["aNroC"];
					$aMonto=$aDetail[$i]["aMonto"];
					$aInteres=$aDetail[$i]["aInteres"];
					$aTotal=$aDetail[$i]["aTotal"];
					$aFechaPago=$aDetail[$i]["aFechaPago"];
					
					$queryDet="INSERT INTO mante_venta_credito_detalle VALUES('".$IdVentaC."','".$aNroC."','".$aMonto."','".$aInteres."','".$aTotal."','".$aFechaPago."','".$aIdEmpresa."');";
					//echo $queryDet;
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$valido=true;
					}else{$valido=false;}
				}
				for($i=0;$i<count($Ventas);$i++)
				{	
					$aId=$Ventas[$i]["aIdVenta"];					
					$aIdEmp=$Ventas[$i]["aIdEmpresa"];					
					$queryDet="INSERT INTO mante_venta_credito_venta VALUES('".$IdVentaC."','".$aId."','".$aIdEmp."');";
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$query12345="UPDATE `mante_venta` SET Estado=2 WHERE IdVenta='".$aId."' AND IdEmpresa='".$aIdEmp."';";
						$sql3 = $pdo->prepare($query12345);
						if($sql3->execute()){
							$valido=true;
						}else{$valido=false;}
					}else{$valido=false;}
				}
			}else{$valido=false;}
		}else{$valido=false;}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		//$Dat=[$IdVenta,];
		return array("Val"=>$valido,"IdVenta"=>$IdVentaC);
 	}
	public static function getList_cbo_VentCrd_VPV(){
 	 	$query="SELECT IdUsuario,CONCAT(Nombres,' ',ApPaterno,' ',ApMaterno) AS Nombres
				FROM `user_usuario_sistema` WHERE Estado=1 AND IdTipoUsuario=20;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_PagarSimple_VentaCreditoS($Datos,$IdUser){
 	 	//[IdVenta,pIdEmpresa,pIdAlm,Total,Mora,TotalPagar,aRuc,FechaPag,pIdCliente]
 	 	$query="CALL mante_pagar_VentaCredito_simple('".$Datos[0]."','".$Datos[1]."','".$Datos[2]."','".$Datos[3]."',
					'".$Datos[4]."','".$Datos[5]."','".addslashes($Datos[6])."','".$Datos[7]."','".$Datos[8]."','".$IdUser."');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function Build_Modal_Delete_VentaCredito($Datos,$IdUser){
		//[IdVenta,pEstado,IdEmpresa,IdAlm,pIdCliente,motivo]
		$query="CALL mante_delete_ventacredito_simple('".$Datos[0]."','".$Datos[1]."','".$Datos[2]."','".$Datos[3]."','".addslashes($Datos[5])."','".$IdUser."');";
		//echo $query;	
		return Class_Run::Execute_Query_Result($query);
 	}
	
	// PAGO VENTA VENDEDOR 
	public static function getList_cbo_PAGV(){
 	 	$query="SELECT IdEmpresa,Comercial FROM `mante_empresa` WHERE Estado=1;";
		//echo $query;
		return ClaReport::getList_cbo_VPV();
 	}
	public static function getList_Datos_PAGV($Datos,$IdUser){
		//[feIn,feFn,IdEmp]
		$condi='';
		if($Datos[2]>0){
			$condi=' AND crd.IdEmpresa='.$Datos[2];
		}
 	 	$query="select del.`IdVentaCredito`,del.`NroCuota`,del.`Monto`,del.`Interes`,del.`Total`,del.`IdEmpresa`,
				fn_RecuperarNombre_ns('COMPANY',del.`IdEmpresa`) as Empresa,DATE_FORMAT(del.FechaPago,'%d/%m/%Y') AS FechaPa,
				IFNULL(pag.`Monto`,'') AS MontoPag,IFNULL(pag.Mora,'') AS MoraPag,IFNULL(pag.Total,'') AS TotalPag,
				IFNULL(DATE_FORMAT(pag.FechaPago,'%d/%m/%Y'),'') AS FechaPag,IFNULL(pag.NroCuota,-1) as IdEst,
				fn_RecuperarNombre_ns('CLIENTE_RUC',crd.`IdCliente`) AS Ruc,fn_RecuperarNombre_ns('CLIENTE_RS',crd.`IdCliente`) AS RS
				from mante_venta_credito_detalle del
				left join mante_venta_credito crd on(crd.IdVentaCredito=del.IdVentaCredito)
				left join `mante_venta_credito_pago` pag on(del.`IdVentaCredito`=pag.`IdVentaCredito` and del.`NroCuota`=pag.`NroCuota`)
				where crd.`IdVendedor`='$IdUser' and del.FechaPago between '$Datos[0]' and '$Datos[1]' $condi
				ORDER BY del.FechaPago ASC;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_PayCredito($Datos,$IdUser){
		$query="select NroCuota,Monto,Interes,Total,0 as Mora,DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPag
			from `mante_venta_credito_detalle`
			where IdVentaCredito='$Datos[0]' and NroCuota='$Datos[1]' and IdEmpresa='$Datos[2]';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Pago_VentaCredito($Datos,$IdUser){
		//[pIdCVenta,pNroCuota,pIdEmpresa,Monto,Mora,TotalPagar]
 	 	$query="INSERT INTO `mante_venta_credito_pago` VALUES('".$Datos[0]."','".$Datos[1]."','".$Datos[2]."',
					'".$Datos[3]."','".$Datos[4]."','".$Datos[5]."',CURRENT_DATE(),$IdUser,CURRENT_TIMESTAMP());";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function getList_Ids_PayCredito($Datos,$IdUser){
		$query="select det.NroCuota,det.Monto,det.Interes,det.Total,DATE_FORMAT(det.FechaPago,'%d/%m/%Y') AS FechaPag,
		ifnull(pag.`NroCuota`,-1) as Pag,ifnull(fn_RecuperarNombre_ns('USER_AP',pag.`IdUsuario`),'') as Userr
		from mante_venta_credito_detalle det
		left join `mante_venta_credito_pago` pag on(det.`IdVentaCredito`=pag.`IdVentaCredito` and det.`NroCuota`=pag.`NroCuota`)
		where det.IdVentaCredito='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	//PAGO COMPRA CREDITO 
	public static function getList_Datos_CPC($Datos){
		//[feIn,feFn,IdAlm]
		$query="SELECT IdCompra,IdUsuario,FechaReg,fn_RecuperarNombre_ns('COMPROBANTE',IdComprobante) AS Comprobante,Serie,Numero,IdProveedor,
			DATE_FORMAT(FechaEmision,'%d/%m/%Y') AS Fec,fn_RecuperarNombre_ns('PROVEEDOR',IdProveedor) AS Proveedor,Total,
			SubTotal,IGV,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,fn_RecuperarNombre_ns('COMPRA_ESTADO',Estado) AS Est,
			DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPago,IdAlmacen,Estado,Obs,fn_RecuperarNombre_ns('PAGO_TIPO',IdTipoPago) AS TipoPago
			FROM `mante_compra` WHERE IdAlmacen='$Datos[2]' AND IdTipoPago=2 AND FechaEmision BETWEEN '$Datos[0]' AND '$Datos[1]'
			ORDER BY FechaEmision ASC;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Datos_CompraCredito($Datos,$IdUser){
		//[Proveedor,pIdProv,IdAlm,Total,Datos,Detail]
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$aProveed=$Datos[0];
		$IdProveedor=$Datos[1];
		$aIdAlm=$Datos[2];
		$aTotal=$Datos[3];
		
		$Ventas=array();
		$Compra=$Datos[4];
		$aDetail=array();
		$aDetail=$Datos[5];
		$IdVentaC=1;
		
		$queryRes="SELECT IFNULL(MAX(IdCompraCredito+1),1) AS Com FROM mante_compra_credito;";
		$sql = $pdo->prepare($queryRes);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdVentaC=$fila1[0]["Com"];
			$queryInsR="INSERT INTO mante_compra_credito VALUES(".$IdVentaC.",".$IdProveedor.",'".$aTotal."',CURRENT_TIMESTAMP(),'".$IdUser."','".$aIdAlm."');";
			//echo $queryInsR;
			$sql1 = $pdo->prepare($queryInsR);
			if($sql1->execute()){
				for($i=0;$i<count($aDetail);$i++)
				{	
					$aNroC=$aDetail[$i]["aNroC"];
					$aMonto=$aDetail[$i]["aMonto"];
					$aInteres=$aDetail[$i]["aInteres"];
					$aTotal=$aDetail[$i]["aTotal"];
					$aFechaPago=$aDetail[$i]["aFechaPago"];
					
					$queryDet="INSERT INTO mante_compra_credito_detalle VALUES('".$IdVentaC."','".$aNroC."','".$aMonto."','".$aInteres."','".$aTotal."','".$aFechaPago."','".$aIdAlm."');";
					//echo $queryDet;
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$valido=true;
					}else{$valido=false;}
				}
				for($i=0;$i<count($Compra);$i++)
				{	
					$aId=$Compra[$i]["aId"];					
					$queryDet="INSERT INTO mante_compra_credito_compra VALUES('".$IdVentaC."','".$aId."','".$aIdAlm."');";
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$query12345="UPDATE `mante_compra` SET Estado=2 WHERE IdCompra='".$aId."' AND IdAlmacen='".$aIdAlm."';";
						$sql3 = $pdo->prepare($query12345);
						if($sql3->execute()){
							$valido=true;
						}else{$valido=false;}
					}else{$valido=false;}
				}
			}else{$valido=false;}
		}else{$valido=false;}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		//$Dat=[$IdVenta,];
		return array("Val"=>$valido,"IdCompra"=>$IdVentaC);
 	}
	public static function Save_PagarSimple_CompraCredito($Datos,$IdUser){
		//[IdCompra,IdAlm,Total,Mora,TotalPagar,pProveedor,pFechaPag]
 	 	$query="CALL mante_pagar_compracredito_simple('".$Datos[0]."','".$Datos[1]."','".$Datos[2]."','".$Datos[3]."',
					'".$Datos[4]."','".addslashes($Datos[5])."','".$Datos[6]."','".$Datos[7]."','".$IdUser."');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function Build_Modal_Delete_CompraCredito($Datos,$IdUser){
		$query="CALL mante_delete_compracredito_simple('".$Datos[0]."','".$Datos[1]."','".$Datos[2]."','".addslashes($Datos[3])."','".$IdUser."');";
		//echo $query;	
		return Class_Run::Execute_Query_Result($query);
 	}
	public static function getList_Datos_CompraCredito_Edit($Datos){
		$query="CALL mante_delete_compracredito_simple('".$Datos[0]."','".$Datos[1]."','".$Datos[2]."','".addslashes($Datos[3])."','".$IdUser."');";
		//echo $query;	
		return Class_Run::Execute_Query_Result($query);
 	}
	
	//REPORTE VENTA CREDITO 
	public static function getList_Datos_RVENTCRD($Datos){
		$query="SELECT del.IdEmpresa,del.IdVentaCredito,del.NroCuota,del.Monto,del.Interes,del.Total,DATE_FORMAT(del.FechaPago,'%d/%m/%Y') AS FechaPa,
			fn_RecuperarNombre_ns('COMPANY',del.IdEmpresa) AS Empresa,fn_RecuperarNombre_ns('USER_AP',crd.IdVendedor) AS Venedd,
			fn_RecuperarNombre_ns('CLIENTE_RUC',crd.IdCliente) AS Ruc,fn_RecuperarNombre_ns('CLIENTE_RS',crd.IdCliente) AS RS,
			IFNULL(pag.NroCuota,-1) AS Pagado,IFNULL(fn_RecuperarNombre_ns('USER_AP',pag.IdUsuario),'') AS UserPag
			FROM mante_venta_credito_detalle del
			LEFT JOIN mante_venta_credito crd ON(crd.IdVentaCredito=del.IdVentaCredito)
			LEFT JOIN mante_venta_credito_pago pag ON(del.IdVentaCredito=pag.IdVentaCredito AND del.NroCuota=pag.NroCuota)
			WHERE del.FechaPago BETWEEN '$Datos[0]' AND '$Datos[1]'
			ORDER BY del.FechaPago ASC;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Delete_Pago_VentaCredito($Datos,$IdUser){
		//[IdVentaCredito,NroCuota,IdEmpresa,motivo]
 	 	$query="CALL mante_delete_VentaCredito_Admin('".$Datos[0]."','".$Datos[1]."','".$Datos[2]."',
					'".addslashes($Datos[3])."',$IdUser);";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//REPORTE VENTA CREDITO 
	public static function getList_Datos_RCOMPCRD($Datos){
		$query="SELECT del.IdCompraCredito,del.NroCuota,del.Monto,del.Interes,del.Total,DATE_FORMAT(del.FechaPago,'%d/%m/%Y') AS FechaPa,
			fn_RecuperarNombre_ns('ALMACEN',del.IdAlmacen) AS Almacen,IFNULL(pag.NroCuota,-1) AS Pagado,
			fn_RecuperarNombre_ns('PROVEEDOR',crd.`IdProveedor`) AS Proveedor
			FROM `mante_compra_credito_detalle` del
			LEFT JOIN mante_compra_credito crd ON(crd.IdCompraCredito=del.IdCompraCredito)
			LEFT JOIN mante_compra_credito_pago pag ON(del.IdCompraCredito=pag.IdCompraCredito AND del.NroCuota=pag.NroCuota)
			WHERE del.FechaPago BETWEEN '$Datos[0]' AND '$Datos[1]'
			ORDER BY del.FechaPago ASC;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	
	//GENERAR GUIA REMISION 
	public static function getList_Gnerar_Guia_Factura($Datos){
		//[IdAlm,IdVenta,IdComp,IdEstado,IdImpres,IdEmpresa]
		$pIdAlm=$Datos[0];
		$pIdVenta=$Datos[1];
		$pIdComp=$Datos[2];
		$pIdEstado=$Datos[3];
		$pIdImpresion=$Datos[4];
		$pIdEmpresa=$Datos[5];
 	 	$query="SELECT Serie,Numero FROM `mante_venta_guia` 
		WHERE IdAlmacen='$pIdAlm' AND IdVenta='$pIdVenta' AND IdEmpresa=$pIdEmpresa AND IdComprobante=20;";
		//echo $query;	
		$Dato1=Class_Run::Select_Query($query);
		$aSerie=1;
		$aNro=1;
		if(count($Dato1)>0){
			$aSerie=$Dato1[0]["Serie"];
			$aNro=$Dato1[0]["Numero"];
		}else{
			$query2="SELECT IFNULL(Serie,1) AS Serie,IFNULL(MAX(Numero+1),1) AS Numero
					FROM `mante_venta` WHERE IdComprobante='20' AND IdEmpresa=$pIdEmpresa;";
			$Dato2=Class_Run::Select_Query($query2);
			if(count($Dato2)>0){
				$aSerie=$Dato2[0]["Serie"];
				$aNro=$Dato2[0]["Numero"];
			}
		}
		$SN=[$aSerie,$aNro];
		$Venta=ClaReport::getList_Cab_Venta_Print($pIdVenta,$pIdAlm,$pIdEmpresa);
 	 	$Detalle=ClaReport::getList_Detalle_Venta_Print($pIdVenta,$pIdAlm,$pIdEmpresa);
		$TipoDoc=ClaProceso::getList_Mante_TipoDoc_Vent();
		//echo $query;	
		return array("Venta"=>$Venta,"Detalle"=>$Detalle,"SN"=>$SN,"TipoDoc"=>$TipoDoc);
		
 	}
	public static function Save_GuiaRemis_Factura($Datos,$IdUser){
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
						
		$valido=true;
		$aIdComprob=$Datos[0]["aIdComprob"];
		$aSerie=$Datos[0]["aSerie"];
		$aNumero=$Datos[0]["aNumero"];
		
		$aTotaal=$Datos[0]["aTotaal"];
		$aSubTotal=$Datos[0]["aSubTotal"];
		$aIGV=$Datos[0]["aIGV"];
		$aObs=$Datos[0]["aObs"];
		$aPago=$Datos[0]["aPago"];
		$aTipoV=$Datos[0]["aTipoV"];
		$aIdAlm=$Datos[0]["aIdAlm"];
		$aAlm=$Datos[0]["aAlm"];
		$aRuc=$Datos[0]["aRuc"];
		$aRS=$Datos[0]["aRS"];
		$aDireccion=$Datos[0]["aDireccion"];
		$aSon=$Datos[0]["aSon"];
		$aIdVent=$Datos[0]["aIdVent"];
		$aNroFac=$Datos[0]["aNroFac"];

		$aDetail=array();
		$aDetail=$Datos[0]["aDetail"];
		$IdVenta=1;
		$aIdIGV=$Datos[0]["aIdIGV"];
		$aIdTipoDoc=$Datos[0]["aIdTipoDoc"];
		$aIdEmpresa=$Datos[0]["aIdEmpresa"];
		$aIdCliente=-1;
		$queryRes="SELECT IFNULL(MAX(IdVenta+1),1) AS Com FROM mante_venta where IdEmpresa=$aIdEmpresa;";
		$sql = $pdo->prepare($queryRes);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdVenta=$fila1[0]["Com"];
			
			$queryInsR="INSERT INTO mante_venta VALUES(".$aIdEmpresa.",'".$aIdAlm."',".$IdVenta.",".$aIdComprob.",'".$aSerie."',
						'".$aNumero."',CURRENT_TIMESTAMP(),current_date(),".$IdUser.",$aIdTipoDoc,'".$aRuc."','".addslashes($aRS)."',
						'".addslashes($aDireccion)."','','$aNroFac','".$aTotaal."','".$aSubTotal."','".$aIGV."',$aIdIGV,'".$aSon."',
						1,'".$aPago."','".$aObs."',1,'-1',0,current_date());";
			//echo $queryInsR;
			$sql1 = $pdo->prepare($queryInsR);
			if($sql1->execute()){
				$valido=true;
				$cont=0;
				$aIdGast=1;
				for($i=0;$i<count($aDetail);$i++)
				{		
					$aCantidad=$aDetail[$i]["aCantidad"];
					$aCodigo=$aDetail[$i]["aCodigo"];
					$aDescripcion=$aDetail[$i]["aDescripcion"];
					$aPrecio=$aDetail[$i]["aPrecio"];
					$aUnidad=$aDetail[$i]["aUnidad"];
					$aImporte=$aDetail[$i]["aImporte"];
					$aIdprod=$aDetail[$i]["aIdprod"];
					
					$queryDet="SELECT IFNULL(MAX(IdDetalle+1),1) AS IdDeatil FROM mante_venta_detalle WHERE IdVenta=".$IdVenta." AND IdEmpresa=$aIdEmpresa;";
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$fila2=$sql2->fetchAll();
						$IdDetalles=$fila2[0]["IdDeatil"];
						$querDe="INSERT INTO mante_venta_detalle VALUES(".$aIdEmpresa.",'".$aIdAlm."','".$IdVenta."','".$IdDetalles."',
							'".$aCantidad."','".addslashes($aCodigo)."','".addslashes($aDescripcion)."','".$aPrecio."','".$aImporte."',
							'".$aIdprod."',-1,1,'$aUnidad');";
						//echo $querDe;
						$sql3 = $pdo->prepare($querDe);
						if($sql3->execute()){
							$valido=true;
						}else{$valido=false;}
					}else{$valido=false;}
				}
			}else{$valido=false;}
		}else{$valido=false;}
		if($valido){
			$query1="select ifnull(count(*),0) as cont from mante_venta_guia 
					where IdAlmacen='$aIdAlm' and Serie='$aSerie' and Numero='$aNumero' and IdVenta='$aIdVent' AND IdEmpresa=$aIdEmpresa;";
			//echo $query1;
			$sql = $pdo->prepare($query1);
			if($sql->execute()){
				$fila2=$sql->fetchAll();
				$aCont=$fila2[0]["cont"];
				if($aCont>0){
					$valido=true;
				}else{
					$query2="INSERT INTO `mante_venta_guia` VALUES($aIdVent,$aIdComprob,$aIdAlm,$aSerie,$aNumero,$aIdEmpresa);";
					//echo $query2;
					$sql5 = $pdo->prepare($query2);
					if($sql5->execute()){
						$valido=true;
					}else{$valido=false;}
				}
			}else{
				$valido=false;
			}
		}
		
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		//$Dat=[$IdVenta,];
		return array("Val"=>$valido,"IdVenta"=>$IdVenta);
 	}
		
	//GROUP G.R. 
	public static function getList_Gnerar_Guia_Factura_Group($Datos){
		$pIdAlm=$Datos[0];
		$Dato=$Datos[1];
		$pIdVenta=$Dato[0]["aIdVenta"];
		$pIdEmpresa=$Dato[0]["aIdEmpresa"];
		$aSerie=1;
		$aNro=1;
		$query2="SELECT IFNULL(Serie,1) AS Serie,IFNULL(MAX(Numero+1),1) AS Numero
					FROM `mante_venta` WHERE IdComprobante='20' AND IdAlmacen='$pIdAlm';";
		$Dato2=Class_Run::Select_Query($query2);
		if(count($Dato2)>0){
			$aSerie=$Dato2[0]["Serie"];
			$aNro=$Dato2[0]["Numero"];
		}
		
		$SN=[$aSerie,$aNro];
		$Venta=ClaReport::getList_Cab_Venta_Print($pIdVenta,$pIdAlm,$pIdEmpresa);
 	 	$Detalle=ClaReport::getList_Detalle_Venta_Print_Group($Dato,$pIdAlm);
		$TipoDoc=ClaProceso::getList_Mante_TipoDoc_Vent();
		//echo $query;	
		return array("Venta"=>$Venta,"Detalle"=>$Detalle,"SN"=>$SN,"TipoDoc"=>$TipoDoc);
		
 	}
	public static function getList_Detalle_Venta_Print_Group($Dato,$pIdAlm){
		$Condi='';
		for($i=0;$i<count($Dato);$i++){
			if($i==0){
				$Condi='(IdVenta='.$Dato[$i]["aIdVenta"].' AND IdEmpresa='.$Dato[$i]["aIdEmpresa"].')';
			}else{
				$Condi=$Condi.' OR (IdVenta='.$Dato[$i]["aIdVenta"].' AND IdEmpresa='.$Dato[$i]["aIdEmpresa"].')';
			}
		}
 	 	$query="SELECT IdDetalle,Cantidad,Codigo,Producto,PUnitario,Importe,Unidad,IdProducto
			FROM `mante_venta_detalle` where IdAlmacen=$pIdAlm AND (".$Condi.");";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Save_GuiaRemis_Factura_Group($Datos,$IdUser){
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();			
		$valido=true;
		$aIdComprob=$Datos[0]["aIdComprob"];
		$aSerie=$Datos[0]["aSerie"];
		$aNumero=$Datos[0]["aNumero"];
		
		$aTotaal=$Datos[0]["aTotaal"];
		$aSubTotal=$Datos[0]["aSubTotal"];
		$aIGV=$Datos[0]["aIGV"];
		$aObs=$Datos[0]["aObs"];
		$aPago=$Datos[0]["aPago"];
		$aTipoV=$Datos[0]["aTipoV"];
		$aIdAlm=$Datos[0]["aIdAlm"];
		$aAlm=$Datos[0]["aAlm"];
		$aRuc=$Datos[0]["aRuc"];
		$aRS=$Datos[0]["aRS"];
		$aDireccion=$Datos[0]["aDireccion"];
		$aSon=$Datos[0]["aSon"];
		$aNroFac=$Datos[0]["aNroFac"];

		$aDetail=array();
		$aDetail=$Datos[0]["aDetail"];
		$IdVenta=1;
		$aIdIGV=$Datos[0]["aIdIGV"];
		$aIdTipoDoc=$Datos[0]["aIdTipoDoc"];
		$aIdEmpresa=$Datos[0]["aIdEmpresa"];
		$Facturas=$Datos[0]["aFact"];
		$aIdCliente=-1;
		$queryRes="SELECT IFNULL(MAX(IdVenta+1),1) AS Com FROM mante_venta where IdEmpresa=$aIdEmpresa;";
		$sql = $pdo->prepare($queryRes);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdVenta=$fila1[0]["Com"];
			
			$queryInsR="INSERT INTO mante_venta VALUES(".$aIdEmpresa.",'".$aIdAlm."',".$IdVenta.",".$aIdComprob.",'".$aSerie."',
						'".$aNumero."',CURRENT_TIMESTAMP(),current_date(),".$IdUser.",$aIdTipoDoc,'".$aRuc."','".addslashes($aRS)."',
						'".addslashes($aDireccion)."','','$aNroFac','".$aTotaal."','".$aSubTotal."','".$aIGV."',$aIdIGV,'".$aSon."',
						1,'".$aPago."','".$aObs."',1,'-1',0,current_date());";
			//echo $queryInsR;
			$sql1 = $pdo->prepare($queryInsR);
			if($sql1->execute()){
				$valido=true;
				$cont=0;
				$aIdGast=1;
				for($i=0;$i<count($aDetail);$i++)
				{		
					$aCantidad=$aDetail[$i]["aCantidad"];
					$aCodigo=$aDetail[$i]["aCodigo"];
					$aDescripcion=$aDetail[$i]["aDescripcion"];
					$aPrecio=$aDetail[$i]["aPrecio"];
					$aUnidad=$aDetail[$i]["aUnidad"];
					$aImporte=$aDetail[$i]["aImporte"];
					$aIdprod=$aDetail[$i]["aIdprod"];
					
					$queryDet="SELECT IFNULL(MAX(IdDetalle+1),1) AS IdDeatil FROM mante_venta_detalle WHERE IdVenta=".$IdVenta." AND IdEmpresa=$aIdEmpresa;";
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$fila2=$sql2->fetchAll();
						$IdDetalles=$fila2[0]["IdDeatil"];
						$querDe="INSERT INTO mante_venta_detalle VALUES(".$aIdEmpresa.",'".$aIdAlm."','".$IdVenta."','".$IdDetalles."',
							'".$aCantidad."','".addslashes($aCodigo)."','".addslashes($aDescripcion)."','".$aPrecio."','".$aImporte."',
							'".$aIdprod."',-1,1,'$aUnidad');";
						//echo $querDe;
						$sql3 = $pdo->prepare($querDe);
						if($sql3->execute()){
							$valido=true;
						}else{$valido=false;}
					}else{$valido=false;}
				}
			}else{$valido=false;}
		}else{$valido=false;}
		if($valido){
			for($i=0;$i<count($Facturas);$i++){
				$aIdVenta=$Facturas[$i]["aIdVenta"];
				$aIdEmpre=$Facturas[$i]["aIdEmpresa"];
				
				$query1="select ifnull(count(*),0) as cont from mante_venta_guia 
						where IdAlmacen='$aIdAlm' and Serie='$aSerie' and Numero='$aNumero' and IdVenta='$aIdVenta' AND IdEmpresa=$aIdEmpre AND IdComprobante=$aIdComprob;";
				//echo $query1;
				$sql = $pdo->prepare($query1);
				if($sql->execute()){
					$fila2=$sql->fetchAll();
					$aCont=$fila2[0]["cont"];
					if($aCont>0){
						$valido=true;
					}else{
						$query2="INSERT INTO `mante_venta_guia` VALUES($aIdVenta,$aIdComprob,$aIdAlm,$aSerie,$aNumero,$aIdEmpre);";
						//echo $query2;
						$sql5 = $pdo->prepare($query2);
						if($sql5->execute()){
							$valido=true;
						}else{$valido=false;}
					}
				}else{
					$valido=false;
				}
			}	
		}
		
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		//$Dat=[$IdVenta,];
		return array("Val"=>$valido,"IdVenta"=>$IdVenta);
 	}
	
	//////////////// REPORTE PRINT VENTA
	public static function getList_Datos_ReportVentta_Print($Datos){
		$pIdVenta=$Datos[0];
		$pIdAlm=$Datos[1];
		$IdEmpresa=$Datos[2];
 	 	$Venta=array();//ClaReport::getList_Cab_Venta_Print($pIdVenta,$pIdAlm,$IdEmpresa);
 	 	$Detalle=array();//ClaReport::getList_Detalle_Venta_Print($pIdVenta,$pIdAlm,$IdEmpresa);
 	 	$Alm=array();//ClaReport::getList_Datos_Almacen_RRSD($pIdAlm);
		$NubeF=ClaReport::getList_DetalleVNubefact_Print($pIdVenta,$pIdAlm,$IdEmpresa);
		
		return array("NubeF"=>$NubeF);
 	}
	public static function getList_DetalleVNubefact_Print($pIdVenta,$pIdAlm,$IdEmpresa){
 	 	$query="SELECT UrlPrint FROM `mante_venta`
				WHERE IdEmpresa='".$IdEmpresa."' AND IdAlmacen='".$pIdAlm."' AND IdVenta='".$pIdVenta."';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Cab_Venta_Print($pIdVenta,$pIdAlm,$IdEmpresa){
 	 	$query="SELECT IdVenta,fn_RecuperarNombre_ns('COMPROBANTE',IdComprobante) AS Comprobante,Serie,Numero,
				DATE_FORMAT(FechaE,'%d/%m/%Y') AS Fec,FechaReg,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,
				Ruc,RazonSocial,Direccion,Total,SubTotal,IGV,Son,IdComprobante,NroFactura,
				fn_RecuperarNombre_ns('CREDITO_SIM',IdTipoCredito) AS TipoC,Obs,PagoObs,Estado,
				CASE WHEN Estado=1 THEN 'Emitido' ELSE 'Anulado' END AS Est,'Punto Partida' AS Origen,IdTipoDoc
				from `mante_venta` where IdVenta='$pIdVenta' AND IdAlmacen=$pIdAlm AND IdEmpresa=$IdEmpresa;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Detalle_Venta_Print($pIdVenta,$pIdAlm,$IdEmpresa){
 	 	$query="SELECT IdDetalle,Cantidad,Codigo,Producto,PUnitario,Importe,Unidad,IdProducto
			FROM `mante_venta_detalle` where IdVenta='$pIdVenta' AND IdAlmacen=$pIdAlm AND IdEmpresa=$IdEmpresa;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function Anular_Datos_Factura($Datos,$IdUser){
		//[IdVenta,IdAlm,Motivo,IdComprobante,Estado,Impresion,IdEmpresa]
		$Idventa=$Datos[0];
		$IdAlm=$Datos[1];
		$aMotivo=$Datos[2];
		$IdEmpresa=$Datos[6];
		$IdComprobante=$Datos[3];
		$fechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		$valido=false;$Result=array();
		if($Datos[5]==0){//Anular sin Kardex
			$query="CALL mante_anular_ventaSinKardex('$Datos[0]','$Datos[1]','".addslashes($Datos[2])."',$IdUser,'".$Datos[6]."','".$$fechaHr."');";
			$valido=Class_Run::Execute_Query_Bool($query);
		}else{//Anular con Kardex
			$query="CALL mante_anular_venta('$Datos[0]','$Datos[1]','".addslashes($Datos[2])."',$IdUser,'".$Datos[3]."',
				'".$Datos[4]."','".$Datos[5]."','".$Datos[6]."','".$fechaHr."');";
			
			$valido=Class_Run::Execute_Query_Bool($query);
			if($valido){
				$query0="SELECT Serie,Numero,fn_RecuperarNombre_ns('COMPROBANTE_SIM',IdComprobante) AS Simbolo
						FROM `mante_venta` WHERE IdEmpresa='".$IdEmpresa."' AND IdAlmacen='".$IdAlm."' AND 
						IdVenta='".$Idventa."' AND IdComprobante='".$IdComprobante."';";
				$Dat=Class_Run::Select_Query($query0);
				$Serie=1;
				$Numero=1;
				$Simbolo='';
				if(count($Dat)>0){
					$Serie=$Dat[0]["Serie"];
					$Numero=$Dat[0]["Numero"];
					$Simbolo=$Dat[0]["Simbolo"];
				}
				
				$Dat=ClaProceso::AnularComprobante_NubeFact($IdEmpresa,$IdComprobante,$Serie,$Numero,$aMotivo,$Simbolo);
				//print_r($Dat);
				$array = json_decode(json_encode($Dat), True);
				$Resul=$array["resultado"];
				$Result=$array;
				if($Resul!=""){
					//print_r($array);
					if($Resul==1){
						$error1=$array["error"];
						$respuestaSunat=$array["respuestaSunat"];
						$direccionComprobante=$array["direccionComprobante"];
						$numeroNubeFact=$array["numeroNubeFact"];
						$numeroSunat=$array["numeroSunat"];
						$sunatRespuesta=$array["sunatRespuesta"];
						$sunatDescripcion=$array["sunatDescripcion"];
						$sunatNota=$array["sunatNota"];
						$sunatCodigoRespuesta=$array["sunatCodigoRespuesta"];
						$sunatSoapError=$array["sunatSoapError"];
					
						$query2="UPDATE `mante_venta` SET Estado=0,Obs='".addslashes($aMotivo)."' 
								WHERE IdVenta='".$Idventa."' AND IdEmpresa='".$IdEmpresa."' AND IdAlmacen='".$IdAlm."';";
						$valido1=Class_Run::Execute_Query_Bool($query2);
						if($valido1){
							$query3="INSERT INTO `mante_venta_factura_anulado` VALUES('".$Idventa."','".$IdComprobante."','".$Serie."','".$Numero."',
									'".addslashes($aMotivo)."','".$fechaHr."','".$error1."','".$respuestaSunat."','".$direccionComprobante."','".$numeroNubeFact."',
									'".$numeroSunat."','".$sunatRespuesta."','".$sunatDescripcion."','".$sunatNota."','".$sunatCodigoRespuesta."',
									'".$sunatSoapError."','".$IdAlm."','".$IdEmpresa."');";
							//echo $query2;
							$valido2=Class_Run::Execute_Query_Bool($query3);
							if($valido2){
								$valido=true;
							}else{
								$valido=false;
							}
						}else{
							$valido=false;
						}
					}else{
						$valido=false;
					}
				}else{
					$valido=false;
				}
			}
		}
 	 	//AnularComprobante_NubeFact($pIdTipoComprobante, $pSerie, $pNumero, $pMotivo,$pSimboloS){
		return array("Val"=>$valido,"Result"=>$Result);
 	}
	public static function getList_Datos_Almacen_RRSD($IdAlm){
 	 	$query="SELECT IdAlmacen,Almacen,Simbolo,Ruc,Descripcion,Direccion,RazonSocial
			FROM `mante_almacen` WHERE IdAlmacen='$IdAlm';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	
	
	//REPORTE KARDEX 
	public static function getList_combo_Kardex($Datos){
		return ClaReport::getList_Producto_Kardex($Datos[0]);
 	}
	public static function getList_Producto_Kardex($IdAlm){
 	 	$query="SELECT IdProducto,fn_RecuperarNombre_ns('CODIGO_PRODUCTO',IdProducto) AS Producto
					FROM `mante_kardex` WHERE IdAlmacen='".$IdAlm."' GROUP BY IdProducto;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_Kardex($Datos){
		//[feIn,feFn,IdAlm,IdProd]
 	 	$condi='';
		if($Datos[3]>0){
			$condi=' AND IdProducto='.$Datos[3];
		}
		$query="SELECT FechaReg,Origen,Destino,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,DATE_FORMAT(FechaReg,'%d/%m/%Y') AS Fecha,Documento,
				Producto,Cantidad,PUnitario,Importe,Stock,fn_RecuperarNombre_ns('TIPO_ENTRADA',IdTipoEntrada) AS TEntrada,IngresoEgreso
				FROM `mante_kardex` 
				WHERE DATE_FORMAT(FechaReg,'%Y-%m-%d') BETWEEN '$Datos[0]' AND '$Datos[1]' AND IdAlmacen=$Datos[2] $condi
				ORDER BY FechaReg ASC;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	//REPORTE CAJA 
	public static function getList_Datos_RCaja($Datos){
 	 	$query="select IdCaja,Tipo,fn_RecuperarNombre_ns('CAJA_TIPO_IE',Tipo) as Tip,Soles,Dolar,FechaReg,
			fn_RecuperarNombre_ns('USER_AP',IdUsuario) as Userr,SaldoSoles,SaldoDolares,Descripcion,Obs,Estado,
			fn_TipoServicio_Caja(Tipo,IdTipoServicio) as TipoServ
			from `mante_caja_corriente` 
			where IdAlmacen='$Datos[2]' AND DATE_FORMAT(FechaReg,'%Y-%m-%d') BETWEEN '$Datos[0]' AND '$Datos[1]'
			ORDER BY FechaReg asc;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	
	//precio por almacen 
	public static function getList_combo_RPrecioAlm(){
 	 	$query="SELECT IdAlmacen,Almacen FROM `mante_almacen` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_RPrecioAlm($Datos){
 	 	$query="SELECT IdAlmacen,IdProducto,IdUnidad,IdMoneda,Stock,PrecioCompra,PrecioBase,PrecioDistribuido,PrecioPublico,Estado,
		fn_RecuperarNombre_ns('UNIDAD',IdUnidad) AS Unidad,CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est,
		fn_RecuperarNombre_ns('MONEDA_SIM',IdMoneda) AS Moneda,fn_RecuperarNombre_ns('CODIGO_PRODUCTO',IdProducto) AS Producto,TipoCambio
		FROM `mante_producto_almacen` WHERE IdAlmacen='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	//RESUMEN DE CAJA
	public static function getList_Usuarios(){
		$consulta="SELECT IdUsuario,Nombres,ApPaterno FROM `user_usuario_sistema` WHERE Estado=1";
		return Class_Run::Select_Query($consulta);
	}
	public function getList_DatosCaja($fecha,$idAlmacen,$idEmpresa,$idUser){
		$consulta="SELECT IFNULL(SUM(Total),0) AS total,ifnull(count(*),0) AS nroVentas FROM `mante_venta` WHERE IdUsuario='$idUser' AND DATE_FORMAT(FechaReg,'%Y-%m-%d')='$fecha'";
		$ventas= Class_Run::Select_Query($consulta);
		$consultaIngresos="SELECT IFNULL(SUM(Soles),0) AS soles,IFNULL(SUM(Dolar),0) AS dolares FROM `mante_caja_corriente` WHERE Tipo=1 AND IdUsuario='$idUser' AND DATE_FORMAT(FechaReg,'%Y-%m-%d')='$fecha'";
		$Ingresos= Class_Run::Select_Query($consultaIngresos);
		$consultaEgresos="SELECT IFNULL(SUM(Soles),0) AS soles,IFNULL(SUM(Dolar),0) AS dolares FROM `mante_caja_corriente` WHERE Tipo=2 AND IdUsuario='$idUser' AND DATE_FORMAT(FechaReg,'%Y-%m-%d')='$fecha'";
		$Egresos= Class_Run::Select_Query($consultaEgresos);
		return array("ventas"=>$ventas,"ingresos"=>$Ingresos,"egresos"=>$Egresos);
	}
	//REPORTE DE VENTAS ESPECIALES
	public function ProductosEspecialesVendidos($fechaInicio,$fechaFin,$idAlmacen){
		$consulta="SELECT DATE_FORMAT(mv.FechaReg,'%d/%m/%Y') as fecha,mv.`IdEmpresa`,mv.`IdAlmacen`,mv.`IdVenta`,mv.IdComprobante,mc.`Comprobante`,us.`Nombres`,mv.`Serie`,mv.`Numero`,mv.`RazonSocial`,mv.`Total`,mv.`SubTotal`,mv.`IGV`,mv.Estado
		FROM `mante_venta` mv 
		INNER JOIN `mante_venta_detalle` mvd ON mv.`IdVenta`=mvd.`IdVenta` AND mv.`IdAlmacen`=mvd.`IdAlmacen`
		INNER JOIN `mante_comprobante` mc ON mv.`IdComprobante`=mc.`IdComprobante`
		INNER JOIN `user_usuario_sistema` us ON mv.`IdUsuario`=us.`IdUsuario`
		WHERE mvd.`IdProducto`=-1 and (DATE_FORMAT(mv.FechaReg,'%Y-%m-%d') between '$fechaInicio' and '$fechaFin') and mv.IdAlmacen='$idAlmacen'
		GROUP BY mv.`IdVenta`";
		return Class_Run::Select_Query_J($consulta);
	}
}



?>

<?php
	//REPORTE VENTA
			else if($_POST["action"]=='getList_Datos_RVenta'){
				echo json_encode(ClaReport::getList_Datos_RVenta($_POST["array"]));
			}else if($_POST["action"]=='getList_Datos_RVentaD'){
				echo json_encode(ClaReport::getList_Datos_RVentaD($_POST["array"],$_SESSION["UserFIQ"]["IdCompany"]));
			}
			
			//IMPRESION VENTA
			else if($_POST["action"]=='getList_Datos_ReportVentta_Print'){
				echo json_encode(ClaReport::getList_Datos_ReportVentta_Print($_POST["array"]));
			}else if($_POST["action"]=='getList_Datos_Guia_Print'){
				echo json_encode(ClaReport::getList_Datos_Guia_Print($_POST["array"],$_SESSION["UserFIQ"]["IdCompany"]));
			}
			
			
			
			//GENERAR FACTURA
			else if($_POST["action"]=='getList_Gnerar_Factura_GuiaRemision'){
				echo json_encode(ClaReport::getList_Gnerar_Factura_GuiaRemision($_POST["array"],$_SESSION["UserFIQ"]["IdCompany"]));
			}else if($_POST["action"]=='Save_Factura_GuiaRemis'){
				echo json_encode(ClaReport::Save_Factura_GuiaRemis($_POST["array"],$_SESSION["UserFIQ"]["IdCompany"],$_SESSION["UserFIQ"]["IdUser"]));
			}
			
			
			
			
			
			//REPORTE VENTA IE 
			else if($_POST["action"]=='getList_Datos_RVentaIE'){
				echo json_encode(ClaReport::getList_Datos_RVentaIE($_POST["array"],$_SESSION["UserFIQ"]["IdCompany"]));
			}else if($_POST["action"]=='Save_FechaDetraccion_Venta'){
				echo json_encode(ClaReport::Save_FechaDetraccion_Venta($_POST["array"],$_SESSION["UserFIQ"]["IdUser"]));
			}else if($_POST["action"]=='getList_Datos_RVenta_FecDett'){
				echo json_encode(ClaReport::getList_Datos_RVenta_FecDett($_POST["array"]));
			}
			
			//REPORTE VENTA PAGO
			else if($_POST["action"]=='getList_cbo_RepVentaPago'){
				echo json_encode(ClaReport::getList_cbo_RepVentaPago());
			}else if($_POST["action"]=='getList_Datos_RVentaPago'){
				echo json_encode(ClaReport::getList_Datos_RVentaPago($_POST["array"]));
			}
			
			
	
	
	
	
	
	
	public static function getList_Cab_Venta($IdVenta,$pIdComp,$pSerie,$pNumero,$IdAlm){
 	 	$query="select IdVenta,fn_RecuperarNombre_ns('COMPROBANTE',IdComprobante) as Comprobante,Serie,Numero,date_format(FechaE,'%d/%m/%Y') as Fec,
		FechaReg,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,Ruc,RazonSocial,Direccion,Total,SubTotal,IGV,Son,IdComprobante,NroFactura,
		fn_RecuperarNombre_ns('CREDITO_SIM',IdTipoCredito) as TipoC,Obs,PagoObs,Estado,date_format(FechaCancelacion,'%d/%m/%Y') as FecCa,
		CASE WHEN Estado=1 THEN 'Emitido' ELSE 'Anulado' END AS Est,'Punto Partida' as Origen
		from `mante_venta` where IdVenta='$IdVenta' AND IdComprobante=$pIdComp and Serie=$pSerie and Numero=$pNumero AND IdAlmacen=$IdAlm;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Detalle_Venta($IdVenta,$pIdComp,$pSerie,$pNumero,$IdAlm){
 	 	$query="SELECT IdDetalle,Cantidad,Codigo,Producto,PUnitario,Dscto,Importe,fn_Unidad_IdProducto(IdProducto) as Unidad
			FROM `mante_venta_detalle` where IdVenta='$IdVenta' AND IdComprobante=$pIdComp and Serie=$pSerie and Numero=$pNumero AND IdAlmacen=$IdAlm;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_Guia_Print($Datos,$IdEmpresa){
 	 	$Venta=ClaReport::getList_Cab_Venta($Datos[0],$Datos[1],$Datos[2],$Datos[3],$Datos[4]);
 	 	$Detalle=ClaReport::getList_Detalle_Venta($Datos[0],$Datos[1],$Datos[2],$Datos[3],$Datos[4]);
		//echo $query;	
		return array("Venta"=>$Venta,"Detalle"=>$Detalle);
 	}
	public static function getList_Datos_RVentaD($Datos,$IdEmpresa){
 	 	$query="select ve.IdVenta,fn_RecuperarNombre_ns('COMPROBANTE',ve.IdComprobante) as Comprobante,ve.Serie,ve.Numero,date_format(FechaE,'%d/%m/%Y') as Fec,
				ve.Ruc,ve.RazonSocial,det.Cantidad,det.Producto,det.PUnitario,det.Dscto,det.Importe
			from `mante_venta` ve
			left join `mante_venta_detalle` det on(ve.IdVenta=det.IdVenta)
			where ve.FechaE BETWEEN '$Datos[0]' AND '$Datos[1]' AND ve.IdAlmacen='$Datos[2]' and ve.Estado>0;";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	
	
	//GENERAR FACTURA
	public static function getList_Gnerar_Factura_GuiaRemision($Datos,$IdEmpresa){
		$pIdVenta=$Datos[0];
		$pIdComp=$Datos[1];
		$pIdAlm=$Datos[2];
 	 	$query="SELECT Serie,Numero,IdComprobante FROM `mante_venta_guia` WHERE IdAlmacen='$pIdAlm' AND IdVenta='$pIdVenta';";
		//echo $query;	
		$Dato1=Class_Run::Select_Query($query);
		$aSerie=1;
		$aNro=1;
		if(count($Dato1)>0){
			$aSerie=$Dato1[0]["Serie"];
			$aNro=$Dato1[0]["Numero"];
		}else{
			$query2="SELECT IFNULL(Serie,1) AS Serie,IFNULL(MAX(Numero+1),1) AS Numero
					FROM `mante_venta` WHERE IdComprobante='1' AND IdAlmacen='$pIdAlm';";
			$Dato2=Class_Run::Select_Query($query2);
			if(count($Dato2)>0){
				$aSerie=$Dato2[0]["Serie"];
				$aNro=$Dato2[0]["Numero"];
			}
		}
		$SN=[$aSerie,$aNro];
		$Venta=ClaReport::getList_Cab_Venta_Print($pIdVenta,$pIdAlm);
 	 	$Detalle=ClaReport::getList_Detalle_Venta_Print($pIdVenta,$pIdAlm);
		$TPago=ClaProceso::getList_Mante_TipoPago_Vent();
		$TipoDoc=ClaProceso::getList_Mante_TipoDoc_Vent();
 	 	$TipoBien=ClaProceso::getList_Mante_TipoBien_Vent();
		//echo $query;	
		return array("Venta"=>$Venta,"Detalle"=>$Detalle,"SN"=>$SN,"TPago"=>$TPago,"TipoDoc"=>$TipoDoc,"TipoBien"=>$TipoBien);
		
 	}
	public static function Save_Factura_GuiaRemis($Datos,$IdEmpresa,$IdUser){
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$aIdComprob=$Datos[0]["aIdComprob"];
		$aSerie=$Datos[0]["aSerie"];
		$aNumero=$Datos[0]["aNumero"];
		$aIdCliente=$Datos[0]["aIdCliente"];
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
		$FechaCancel=$Datos[0]["aFechaCancel"];
		$aDetail=array();
		$aDetail=$Datos[0]["aDetail"];
		$IdVenta=1;
		$aIdIGV=$Datos[0]["aIdIGV"];
		$aIdTipoDoc=$Datos[0]["aIdTipoDoc"];
		$aIdBien=$Datos[0]["aIdBien"];
		
		$queryRes="SELECT IFNULL(MAX(IdVenta+1),1) AS Com FROM mante_venta;";
		$sql = $pdo->prepare($queryRes);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdVenta=$fila1[0]["Com"];
			$queryInsR="INSERT INTO mante_venta VALUES(".$IdVenta.",".$aIdComprob.",'".$aSerie."','".$aNumero."',CURRENT_TIMESTAMP(),
				current_date(),".$IdUser.",'".$aRuc."','".$aRS."','".$aDireccion."','".$aTotaal."','".$aSubTotal."','".$aIGV."','".$aSon."',
				'".$aTipoV."','$FechaCancel','$aNroFac','".$aObs."','".$aPago."',1,'".$aIdCliente."','".$aIdAlm."',1,-1,$aIdTipoDoc,$aIdIGV,$aIdBien,0);";
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
					$aDscto=$aDetail[$i]["aDscto"];
					$aImporte=$aDetail[$i]["aImporte"];
					$aIdprod=$aDetail[$i]["aIdprod"];
					
					$queryDet="SELECT IFNULL(MAX(IdDetalle+1),1) AS IdDeatil FROM mante_venta_detalle WHERE IdVenta=".$IdVenta.";";
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$fila2=$sql2->fetchAll();
						$IdDetalles=$fila2[0]["IdDeatil"];
						$querDe="INSERT INTO mante_venta_detalle VALUES(".$IdVenta.",".$IdDetalles.",".$aIdComprob.",'".$aSerie."','".$aNumero."',
							'".$aCantidad."','".$aCodigo."','".$aDescripcion."',".$aPrecio.",'".$aDscto."',".$aImporte.",'".$aIdAlm."','".$aIdprod."',-1);";
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
			$query1="update `mante_venta` set NroFactura=$aNroFac where IdAlmacen='$aIdAlm' and IdVenta='$aIdVent';";
			//echo $query1;
			$sql = $pdo->prepare($query1);
			if($sql->execute()){
				$valido=true;
			}else{
				$valido=false;
			}
		}
		
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		//$Dat=[$IdVenta,];
		return array("Val"=>$valido,"IdVenta"=>$IdVenta);
 	}
	
	
	
	
	//REPORTE VENTA IE 
	public static function getList_Datos_RVentaIE($Datos,$IdEmpresa){
 	 	$query="select ve.IdVenta,ve.Estado,ve.Impresion,date_format(ve.FechaE,'%d/%m/%Y') as Fec,date_format(ve.FechaCancelacion,'%d/%m/%Y') as FecCancel,
				fn_RecuperarNombre_ns('COMPROBANTE',ve.IdComprobante) as Comprobante,ve.Serie,ve.Numero,fn_RecuperarNombre_ns('DOCUMENTO_SIM',ve.IdTipoDoc) as TipoDoc,
				fn_RecuperarNombre_ns('USER_AP',ve.IdUsuario) AS Userr,ve.Ruc,ve.RazonSocial,ve.Direccion,ve.Total,ve.SubTotal,ve.IGV,ve.Son,
			fn_RecuperarNombre_ns('CREDITO_SIM',ve.IdTipoCredito) as TipoC,ve.Obs,ve.PagoObs,ve.Exonerado,ve.IdTipoBien,fn_RecuperarNombre_ns('TIPO_BIEN',ve.IdTipoBien) AS TipoBien,
			fn_RecuperarNombre_ns('VENTA_ESTADO',ve.Estado) AS Est,
			ifnull(date_format(de.Fecha,'%d/%m/%Y'),'') as FechaDe,ifnull(de.Monto,'') as Mont,ifnull(de.TipoPago,'') as TipoPag
		from `mante_venta` ve
		left join mante_venta_detraccion de on(ve.IdVenta=de.IdVenta and ve.IdAlmacen=de.IdAlmacen)
		where ve.FechaE between '$Datos[0]' and '$Datos[1]' and ve.IdAlmacen='$Datos[2]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_RVenta_FecDett($Datos){
 	 	$query="select date_format(Fecha,'%d/%m/%Y') as FechaDe,Monto,TipoPago
			from mante_venta_detraccion where IdAlmacen='$Datos[1]' and IdVenta='$Datos[0]';";
		//echo $query;	
		$Dato=Class_Run::Select_Query($query);
		$Bien=ClaReport::getList_Porcentaje_Bien();
		return array("Dato"=>$Dato,"Bien"=>$Bien);
 	}
	public static function getList_Porcentaje_Bien(){
 	 	$query="sSELECT IdTipoBien,TipoBien,Porcentaje
				FROM `mante_tipo_bien` WHERE Estado=1;";
		//echo $query;	
		return Class_Run::Select_Query($query);
		
 	}
	public static function Save_FechaDetraccion_Venta($Datos,$IdUser){
		//[pIdVenta,pIdAlm,Fec,Monto,TipoPag]
 	 	$query="CALL mante_save_FechaDetraccion_Venta('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]',$IdUser);";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//REPORTE VENTA PAGO 
	public static function getList_cbo_RepVentaPago(){
 	 	$Cliente=ClaProceso::getList_Mante_Cliente();
		return $Cliente;
 	}
	public static function getList_Datos_RVentaPago($Datos){
		//[feIn,feFn,IdAlm,IdCli]
		$query="SELECT Ruc FROM `mante_cliente_p` WHERE IdCliente='$Datos[3]';";
		$Dato=Class_Run::Select_Query($query);
		$NroRuc=0;
		if(count($Dato)>0){
			$NroRuc=$Dato[0]["Ruc"];
		}
 	 	$query1="select IdVenta,fn_RecuperarNombre_ns('COMPROBANTE',IdComprobante) as Comprobante,Serie,Numero,date_format(FechaE,'%d/%m/%Y') as Fec,
		FechaReg,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,Ruc,RazonSocial,Direccion,Total,SubTotal,IGV,Son,IdComprobante,
		fn_RecuperarNombre_ns('CREDITO_SIM',IdTipoCredito) as TipoC,Obs,PagoObs,Estado,Impresion,
		fn_RecuperarNombre_ns('VENTA_ESTADO',Estado) AS Est
		from `mante_venta` where FechaE between '$Datos[0]' and '$Datos[1]' and IdAlmacen='$Datos[2]' and Ruc='".$NroRuc."' and Estado>0
		order by IdComprobante,Serie,Numero asc;";
		//echo $query;	
		return Class_Run::Select_Query($query1);
 	}
	
	
?>
<?php
class ClaProceso{
	public static function getList_Mante_Almacen_Est(){
 	 	$query="SELECT IdAlmacen,Almacen FROM `mante_almacen` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Comprobantes(){
 	 	$query="select IdComprobante,Comprobante from `mante_comprobante` where Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Proveedors(){
 	 	$query="SELECT IdProveedor,Ruc,Comercial FROM `mante_proveedor` where Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
	 }
	 public static function getList_Mante_Unidades(){
		$query="SELECT IdUnidad,Unidad FROM `mante_unidad` where Estado=1;";
	  //echo $query;
	  return Class_Run::Select_Query($query);
   }
	
	//COMPRA
	public static function getList_combo_Compra($Datos){
 	 	$Compro=ClaProceso::getList_Mante_Comprobantes();
 	 	$Prove=ClaProceso::getList_Mante_Proveedors();
 	 	$Uni=ClaProceso::getList_Mante_Unidades();
		//echo $query;
		return array("Compro"=>$Compro,"Prove"=>$Prove,"Unidad"=>$Uni);
 	}
	public static function getList_Productos_IdAlmc($IdAlm){
 	 	$query="SELECT alm.`IdProducto`,pro.`Codigo`
		FROM `mante_producto_almacen` alm
		LEFT JOIN `mante_producto` pro ON(alm.`IdProducto`=pro.`IdProducto`)
		WHERE alm.`IdAlmacen`='$IdAlm';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Productosss_IdAlmc($IdAlm){
 	 	$query="SELECT alm.`IdProducto`,pro.`Codigo`,pro.Producto
		FROM `mante_producto_almacen` alm
		LEFT JOIN `mante_producto` pro ON(alm.`IdProducto`=pro.`IdProducto`)
		WHERE alm.`IdAlmacen`='$IdAlm';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Producto_Id($Datos){
 	 	$query="SELECT alm.`IdProducto`,pro.`Codigo`,pro.`Producto`,fn_RecuperarNombre_ns('MARCA',IdMarca) AS Marca,
		fn_RecuperarNombre_ns('CATEGORIA',IdCategoria) AS Modelo,fn_RecuperarNombre_ns('UNIDAD',IdUnidad) AS Unidad,
		PrecioCompra,PrecioPublico,PrecioBase,PrecioDistribuido,Stock,TipoCambio
		FROM mante_producto_almacen alm
		LEFT JOIN `mante_producto` pro ON(alm.`IdProducto`=pro.`IdProducto`)
		WHERE alm.`IdAlmacen`='$Datos[0]' AND alm.`IdProducto`='$Datos[1]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Proveedor_Id($Datos){
 	 	$query="SELECT IdProveedor,Comercial,Ruc,RazonSocial
			FROM `mante_proveedor` WHERE IdProveedor='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Proveedor_Update(){
 	 	return ClaProceso::getList_Mante_Proveedors();
 	}
	public static function getList_Productos_AlmComp($Datos){
 	 	$query="SELECT alm.`IdProducto`,pro.`Codigo`,
		CONCAT(pro.`Producto`,' ',fn_RecuperarNombre_ns('MARCA',IdMarca),' ',fn_RecuperarNombre_ns('CATEGORIA',IdCategoria)) AS Producto,
		fn_RecuperarNombre_ns('UNIDAD',IdUnidad) AS Unidad,Stock,alm.`PrecioPublico`
		FROM `mante_producto_almacen` alm
		LEFT JOIN `mante_producto` pro ON(alm.`IdProducto`=pro.`IdProducto`)
		WHERE alm.`IdAlmacen`='$Datos[0]';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Datos_Compra($Datos,$IdUser){
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$aIdComprob=$Datos[0]["aIdComprob"];
		$aSerie=$Datos[0]["aSerie"];
		$aNumero=$Datos[0]["aNumero"];
		$aFechaEm=$Datos[0]["aFechaEm"];
		$aIdProv=$Datos[0]["aIdProv"];
		$aTotaal=$Datos[0]["aTotaal"];
		$aSubTotal=$Datos[0]["aSubTotal"];
		$aIGV=$Datos[0]["aIGV"];
		$aObs=$Datos[0]["aObs"];
		$aTipoPago=$Datos[0]["aTipoPago"];
		$aIdAlm=$Datos[0]["aIdAlm"];
		$aAlm=$Datos[0]["aAlm"];
		$aFechaPago=$Datos[0]["aFechaPago"];
		$aComp=$Datos[0]["aComp"];
		$aIdMoneda=$Datos[0]["aIdMoneda"];
		$aNroDias=$Datos[0]["aNroDias"];
		
		$aDetail=array();
		$aDetail=$Datos[0]["aDetail"];
		$aFechaE=date("Y-m-d", (strtotime ("-5 Hours")));
		$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		
		$IdTipoEnt=1;$pOrigen='Compra';$pDestino=$aAlm;
		$queryRes="SELECT IFNULL(MAX(IdCompra+1),1) AS Com FROM mante_compra;";
		$sql = $pdo->prepare($queryRes);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdCompra=$fila1[0]["Com"];
				
			$queryInsR="INSERT INTO mante_compra VALUES(".$IdCompra.",".$IdUser.",'".$FechaHr."',".$aIdComprob.",'".$aSerie."','".$aNumero."',
				'".$aFechaEm."',".$aIdProv.",'".addslashes($aObs)."','".$aTotaal."','".$aSubTotal."','".$aIGV."','".$aTipoPago."',1,
				'".$aIdAlm."','".$aFechaPago."','".$aIdMoneda."','".$aNroDias."')";
			//echo $queryInsR;
			$sql1 = $pdo->prepare($queryInsR);
			if($sql1->execute()){
				for($i=0;$i<count($aDetail);$i++)
				{	
					$aCantidad=$aDetail[$i]["aCantidad"];
					$aCodigo=$aDetail[$i]["aCodigo"];
					$aDescripcion=$aDetail[$i]["aDescripcion"];
					$aUnidad=$aDetail[$i]["aUnidad"];
					$aPCompra=$aDetail[$i]["aPCompra"];
					$aImporte=$aDetail[$i]["aImporte"];
					$aPPublico=$aDetail[$i]["aPPublico"];
					$aPMenor=$aDetail[$i]["aPMenor"];
					$aPMayor=$aDetail[$i]["aPMayor"];
					$aIdProducto=$aDetail[$i]["aIdProducto"];
					$aTC=$aDetail[$i]["aTC"];
					$aidUnidad=$aDetail[$i]["aidUnidad"];
							
					$queryDet="SELECT IFNULL(MAX(IdDetalle+1),1) AS IdDeatil FROM mante_compra_detalle WHERE IdCompra=".$IdCompra.";";
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$fila2=$sql2->fetchAll();
						$IdDetalles=$fila2[0]["IdDeatil"];
						$querDe="INSERT INTO mante_compra_detalle VALUES(".$aIdAlm.",".$IdCompra.",".$IdDetalles.",'".$aIdProducto."',
								'".$aCantidad."','".addslashes($aCodigo)."','".addslashes($aDescripcion)."','".$aPCompra."','".$aImporte."',
								'".$aUnidad."','".$aPPublico."','".$aPMenor."','".$aPMayor."','".$aTC."');";
						//echo $querDe;
						$sql3 = $pdo->prepare($querDe);
						if($sql3->execute()){
							$queryDet1="SELECT IFNULL(COUNT(*),0) AS cont FROM `mante_producto_almacen` 
										WHERE IdAlmacen='".$aIdAlm."' AND IdProducto='".$aIdProducto."';";
							$sql3 = $pdo->prepare($queryDet1);
							if($sql3->execute()){
								$fila2=$sql3->fetchAll();
								$existP=$fila2[0]["cont"];
								if($existP>0){
									$query1234="UPDATE `mante_producto_almacen` SET PrecioCompra='".$aPCompra."',PrecioPublico='".$aPPublico."',
												PrecioBase='".$aPMenor."',PrecioDistribuido='".$aPMayor."',Stock=Stock+'".$aCantidad."',TipoCambio='".$aTC."'
												WHERE IdAlmacen='".$aIdAlm."' AND IdProducto='".$aIdProducto."';";
									$sql4 = $pdo->prepare($query1234);
									if($sql4->execute()){$valido=true;}else{$valido=false;}
								}else{
									$query123="INSERT INTO mante_producto_almacen VALUES('".$aIdAlm."','".$aIdProducto."','".$aidUnidad."',1,'".$aCantidad."','".$aPCompra."','".$aPMenor."','".$aPMayor."','".$aPPublico."',1,
												'".$aTC."');";
									$sql5 = $pdo->prepare($query123);
									if($sql5->execute()){$valido=true;}else{$valido=false;}
								}
							}else{$valido=false;}
							if($valido){
								$queryGast="SELECT fn_save_kardex_Compra('".$IdUser."','".$pOrigen."','".$pDestino."','".$aIdAlm."',
											'".$aIdProducto."','".addslashes($aDescripcion)."','".$aCantidad."','".$aPCompra."',
											'".$aImporte."','".$IdTipoEnt."','".$aComp."','".$FechaHr."') as con;";
								//echo $queryGast;	
								$sql4 = $pdo->prepare($queryGast);				
								if($sql4->execute()){
									$fila4=$sql4->fetchAll();
									$valor=$fila4[0]["con"];
									if($valor==1){$valido=true;}else{$valido=false;}
								}
							}else{$valido=false;}
						}else{$valido=false;}
					}else{$valido=false;}
				}
			}else{$valido=false;}
		}else{$valido=false;}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		return $valido;
 	}
	
	//VENTA
	public static function getList_Documentos_Venta($Datos){
		$IdComprobante=$Datos[0];
 	 	$Doc=ClaProceso::getList_Documento_IdComp($IdComprobante);
		//echo $query;
		return array("Doc"=>$Doc);
 	}
	public static function getList_Documento_IdComp($IdComp){
		$Condi='';
		if($IdComp==1){
			$Condi=' AND IsFactura=1';
		}else if($IdComp==2){
			$Condi=' AND IsBoletaV=1';
		}else if($IdComp==10){
			$Condi=' AND Isotros=1';
		}else{
			$Condi=' AND IdTipoDocumento=0';
		}
 	 	$query="SELECT IdTipoDocumento AS Id,TipoDocumento AS Nombre
			FROM `mante_tipo_documento` WHERE Estado=1 $Condi;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Clientes_ProcVenta(){
 	 	$query="SELECT IdCliente,IdTipoDocumento,NroDocumento AS Ruc,NombreRS AS RazonSocial,Direccion FROM `mante_cliente` 
				WHERE Estado=1 GROUP BY RazonSocial ASC;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_VentaNP($Datos){
		$query="SELECT IdEmpresa,IdVenta,IdNotaPedido,Serie,Numero,fn_RecuperarNombre_ns('COMPROBANTE',IdNotaPedido) AS Comprobante,
			Total,SubTotal,IGV,Obs,FechaReg,DATE_FORMAT(FechaE,'%d/%m/%Y') AS Fec,Ruc,RS,Direccion,Estado,
			fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr
			from `mante_registro_nota_pedido` where IdAlmacen='$Datos[0]' AND Estado=1 AND IdEmpresa='$Datos[1]'";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_RecuperarDetail_VentaNP($Datos){
		$Detail=ClaProceso::getList_Detail_IdNP_ALM($Datos[0],$Datos[1]);
		$Cabe=ClaProceso::getList_Cab_IdNP_ALM($Datos[0]);
		if(count($Cabe) == 0){
			$Detail = [];
			$Cabe = [];
		}
		return array("Cabe"=>$Cabe,"Detail"=>$Detail);
 	}
	public static function getList_Detail_IdNP_ALM($IdNP,$IdEmp){
 	 	$query="SELECT IdVenta,Cantidad,Codigo,Descripcion,Precio,Importe,IdProducto,IdTipoPrecio,Unidad,IdTipoPrecio,
				fn_RecuperarNombre_ns('PRECIO_TIPO',IdTipoPrecio) as TipPrecio
			FROM `mante_registro_nota_pedido_detalle` WHERE IdVenta='$IdNP' AND IdEmpresa='$IdEmp';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Cab_IdNP_ALM($IdNP){
 	 	$query="select mrnp.IdVenta,mrnp.IdNotaPedido,mrnp.Total,mrnp.Estado,ma.Almacen,ma.IdAlmacen from `mante_registro_nota_pedido` as mrnp
		  INNER JOIN mante_almacen AS ma ON mrnp.IdAlmacen = ma.IdAlmacen
		  where mrnp.Estado=1 AND mrnp.IdVenta='$IdNP';";
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Producto_Codigo($Datos){
 	 	$query="SELECT alm.`IdProducto`,pro.`Codigo`,pro.`Producto`,fn_RecuperarNombre_ns('MARCA',IdMarca) AS Marca,
		fn_RecuperarNombre_ns('CATEGORIA',IdCategoria) AS Modelo,fn_RecuperarNombre_ns('UNIDAD',IdUnidad) AS Unidad,
		PrecioCompra,PrecioPublico,PrecioBase,PrecioDistribuido,Stock
		FROM mante_producto_almacen alm
		LEFT JOIN `mante_producto` pro ON(alm.`IdProducto`=pro.`IdProducto`)
		WHERE alm.`IdAlmacen`='$Datos[0]' AND pro.`Codigo`='$Datos[1]';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Datos_Venta($Datos,$IdUser){
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$aIdAlm=$Datos[0]["aIdAlm"];$aAlm=$Datos[0]["aAlm"];
		$aIdEmpresa=$Datos[0]["aIdEmpresa"];$aIdComprob=$Datos[0]["aIdComprob"];
		$aFormato=$Datos[0]["aFormato"];
		
		$aIdTipoDoc=$Datos[0]["aIdTipoDoc"];
		$aRuc=$Datos[0]["aRuc"];$aRS=$Datos[0]["aRS"];$aDireccion=$Datos[0]["aDireccion"];$aEmail=$Datos[0]["aEmail"];
		$aNroGuia=$Datos[0]["aNroGuia"];
		
		$aTotaal=$Datos[0]["aTotaal"];
		$aSubTotal=$Datos[0]["aSubTotal"];
		$exonerado=$Datos[0]["aExonerado"];
		$aIGV=$Datos[0]["aIGV"];
		$aSon=$Datos[0]["aSon"];
		$aIdIGV=$Datos[0]["aIdIGV"];
		$aIdTipoPago=$Datos[0]["aIdTipoPago"];$aFechaPago=$Datos[0]["aFechaPago"];
		$aIdCliente=$Datos[0]["aIdCliente"];
		$aComprob=$Datos[0]["aComprob"];
		
		$IdTipoEnt=3;$pOrigen=$aAlm;$pDestino="Venta";	
		
		$aDetail=array();$aDetail=$Datos[0]["aDetail"];
		
		$aFechaE=date("Y-m-d", (strtotime ("-5 Hours")));$FechaFE=date("d-m-Y", (strtotime ("-5 Hours")));
		$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		
		$IdVenta=1;
		
		$query0="SELECT IFNULL(MAX(IdVenta+1),1) as cont FROM mante_venta;";
		$sql = $pdo->prepare($query0);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdVenta=$fila1[0]["cont"];
			$query1="INSERT INTO mante_venta VALUES(".$aIdEmpresa.",".$aIdAlm.",".$IdVenta.",".$aIdComprob.",'".$FechaHr."','".$aFechaE."',".$IdUser.",
					'".$aIdTipoDoc."','".addslashes($aRuc)."','".addslashes($aRS)."','".addslashes($aDireccion)."','".addslashes($aEmail)."',
					'".addslashes($aNroGuia)."','".$aTotaal."','".$aSubTotal."','".$aIGV."','".$aIdIGV."','".addslashes($aSon)."',
					'".$aIdTipoPago."','','',1,'".$aIdCliente."',1,'".$aFechaPago."',-1,-1,'','','".$exonerado."');";
			$sql1 = $pdo->prepare($query1);
			if($sql1->execute()){
				for($i=0;$i<count($aDetail);$i++){
					$aCantidad=$aDetail[$i]["aCantidad"];
					$aCodigo=$aDetail[$i]["aCodigo"];
					$aDescripcion=$aDetail[$i]["aDescripcion"];
					$aUnidad=$aDetail[$i]["aUnidad"];
					$aPU=$aDetail[$i]["aPU"];
					$aImporte=$aDetail[$i]["aImporte"];
					$aIdProducto=$aDetail[$i]["aIdProducto"];
					$aIdTipoPrecio=$aDetail[$i]["aIdTipoPrecio"];
					$aIdProductoEspecial=$aDetail[$i]["aIdEspecial"];
					$aIdTipoIgv=$aDetail[$i]["aIdTipoIgv"];
					$aIdNP=$aDetail[$i]["aIdNP"];
					if($valido){
						if($aIdNP>0){
							$queryNP="UPDATE mante_registro_nota_pedido SET  Estado=2
										WHERE IdAlmacen='$aIdAlm' AND IdVenta='$aIdNP' AND Estado=1 and IdEmpresa=$aIdEmpresa;";
							$sql15 = $pdo->prepare($queryNP);
							if($sql15->execute()){$valido=true;}else{$valido=false;}
						}
						$queryDet="SELECT IFNULL(MAX(IdDetalle+1),1) AS IdDeatil FROM mante_venta_detalle 
									WHERE IdVenta=".$IdVenta." AND IdEmpresa=$aIdEmpresa;";
						$sql2 = $pdo->prepare($queryDet);
						if($sql2->execute()){
							$fila2=$sql2->fetchAll();
							$IdDetalles=$fila2[0]["IdDeatil"];
							if ($aIdProducto=='-1') {
									$aIdEspecial=$aDetail[$i]["aIdEspecial"];
									//echo $aIdEspecial;
									if ($aIdEspecial==0) {
										$querEspecial="INSERT INTO mante_producto_especial(codigo,descripcion,estado) VALUES('".addslashes($aCodigo)."','".addslashes($aDescripcion)."',1);";
										//echo $querDe;
										$sqlEspecial = $pdo->prepare($querEspecial);
										$sqlEspecial->execute();
										$aIdProductoEspecial=$pdo->lastInsertId();
										
									}

							}else{
								$aIdProductoEspecial=0;
							}
							$querDe="INSERT INTO mante_venta_detalle VALUES(".$aIdEmpresa.",'".$aIdAlm."',".$IdVenta.",".$IdDetalles.",
									'".$aCantidad."','".addslashes($aCodigo)."','".addslashes($aDescripcion)."','".$aPU."',
									'".$aImporte."','".$aIdProducto."','".$aIdNP."','".$aIdTipoPrecio."','".$aUnidad."','".$aIdProductoEspecial."','".$aIdTipoIgv."');";
							//echo $querDe;
							$sql3 = $pdo->prepare($querDe);
							if($sql3->execute()){
								if ($aIdProducto!='-1') {//en caso de que sea un producto que existe, ya que -1 indica producto no existente
									$query1234="UPDATE `mante_producto_almacen` SET Stock=Stock-'".$aCantidad."'
													WHERE IdAlmacen='".$aIdAlm."' AND IdProducto='".$aIdProducto."';";
									$sql3 = $pdo->prepare($query1234);
									if($sql3->execute()){
										$queryGast="SELECT fn_save_kardex_Venta('".$IdUser."','".$pOrigen."','".$pDestino."','".$aIdAlm."',
													'".$aIdProducto."','".addslashes($aDescripcion)."','".$aCantidad."','".$aPU."',
													'".$aImporte."','".$IdTipoEnt."','".$aComprob."') as con;";
										//echo $queryGast;
										$sql4 = $pdo->prepare($queryGast);				
										if($sql4->execute()){
											$fila4=$sql4->fetchAll();
											$valor=$fila4[0]["con"];
											if($valor==1){$valido=true;}else{$valido=false;}
										}
									}else{$valido=false;}
								}
							}else{$valido=false;}
						}
					}else{$valido=false;}	
				}
			}else{$valido=false;}
		}else{$valido=false;}
		/* Ejecutar transaccion */
		
		$ErrSu=array();	
		if($valido){
			$query123="select fn_Serie_Numero_Simbolo_FE('".$aIdAlm."','".$aIdComprob."') as Cont;";
			$sql = $pdo->prepare($query123);
			if($sql->execute()){
				$fila1=$sql->fetchAll();
				$aDat=explode("/",$fila1[0]["Cont"]);
				$aSerie=$aDat[1];$aNumero=$aDat[2];$aSimbolo=$aDat[0];$Errors='';
				if($aIdComprob==1 || $aIdComprob==2){
						$resFacturacion = new stdClass();
						$resFacturacion=ClaProceso::Facturacion_NubeFact($aIdEmpresa,$aIdComprob,$aSerie,$aSimbolo,$aNumero,$aTotaal,$aIGV,$aSubTotal,
							$aIdTipoDoc,$aRuc,$aRS,$aDireccion,$aIdTipoPago,$FechaFE,$aDetail,$aEmail,$aFormato,$exonerado);
						//print_r($resFacturacion);
						$Errors=$resFacturacion->error;
						if(!empty($resFacturacion->direccionComprobante) && $resFacturacion->resultado){
							$comp=$resFacturacion->direccionComprobante;
							
							$query1="UPDATE mante_venta SET Enlace='$comp',Estado=1,Serie='".$aSerie."',Numero='".$aNumero."',ErrorSunat='".$Errors."'
										WHERE IdVenta='".$IdVenta."' AND IdComprobante=".$aIdComprob.";";
							$sql4 = $pdo->prepare($query1);				
							if($sql4->execute()){
								$pdo->commit();
								array_push($ErrSu,array("enlace"=>$comp,"error"=>$Errors));
							}else{
								array_push($ErrSu,array("enlace"=>"","error"=>$Errors));
							}
						}else{
							$valido=false;
							$pdo->rollBack();
							array_push($ErrSu,array("enlace"=>"","error"=>$Errors));
						}
				}else{/* TICKET */
					$query1="UPDATE mante_venta SET Enlace='',Estado=1,Serie='".$aSerie."',Numero='".$aNumero."',ErrorSunat='".$Errors."'
										WHERE IdVenta='".$IdVenta."' AND IdComprobante=".$aIdComprob.";";
							$sql4 = $pdo->prepare($query1);				
							if($sql4->execute()){
								$pdo->commit();
								array_push($ErrSu,array("enlace"=>"","error"=>$Errors));
							}else{
								array_push($ErrSu,array("enlace"=>"","error"=>$Errors));
							}
				}
			}else{
				$valido=false;
				$pdo->rollBack();
				array_push($ErrSu,array("enlace"=>"","error"=>$Errors));
			}
		}
		
		return array("Val"=>$valido,"IdVenta"=>$IdVenta,"Sunat"=>$ErrSu);
 	}
	
	//NUBEFACT
	public static function Facturacion_NubeFact($pIdEmpresa,$pIdTipoComprobante,$pSerie,$pSimboloS,$pNumero,$pTotal,$pIGV,$pSubTotal,$pIdTipoDoc,$pNroDoc,$pRS,$pDireccion,
				$pTipoPago,$FechaE,$Detalle,$pEmail,$Formato,$Exonerado){
		//$Detalle=Detail.push({"aIdProducto":aIdP,"aProducto":Producto,"aCantidad":Cant,"aPU":PU,"aImporte":Importe,"aDetalle":aDetalle});
		//$aFechaE='2018-07-24'
		//$pSimboloS (Factura =F y Boleta de Venta =B)
		try {
			$res = new stdClass();
			$res->resultado = false;
			$res->error = "";
			$res->respuestaSunat = "";
			$res->json = "";
			
			$ruta = "https://www.pse.pe/api/v1/bbbf5aabdf214d0ca43f71e4fa4d93d08eb534e392b74addb6ada413d09365fb";
			$token = "eyJhbGciOiJIUzI1NiJ9.ImQ4MGI4MDRhZDE2YTRmZTU5ZWU5MWY4ZDk4ZjdhNmRlOWRlNWVhNjBlZjk4NDliNDk1ODM0ZTcwNzI2ZTA3NWYi.V247v69STl1G7xjsiy8sy6SnW1PuGZ7z7eHZBVJ2AFs";
			
			// $ruta='';
			// $token='';
			// if ($pIdEmpresa==1) {
			// 	$ruta = "https://www.pse.pe/api/v1/bbbf5aabdf214d0ca43f71e4fa4d93d08eb534e392b74addb6ada413d09365fb";
			// 	$token = "eyJhbGciOiJIUzI1NiJ9.ImQ4MGI4MDRhZDE2YTRmZTU5ZWU5MWY4ZDk4ZjdhNmRlOWRlNWVhNjBlZjk4NDliNDk1ODM0ZTcwNzI2ZTA3NWYi.V247v69STl1G7xjsiy8sy6SnW1PuGZ7z7eHZBVJ2AFs";
			// }else if($pIdEmpresa==2){
			// 	$ruta = "https://www.pse.pe/api/v1/bbbf5aabdf214d0ca43f71e4fa4d93d08eb534e392b74addb6ada413d09365fb";
			// 	$token = "eyJhbGciOiJIUzI1NiJ9.ImQ4MGI4MDRhZDE2YTRmZTU5ZWU5MWY4ZDk4ZjdhNmRlOWRlNWVhNjBlZjk4NDliNDk1ODM0ZTcwNzI2ZTA3NWYi.V247v69STl1G7xjsiy8sy6SnW1PuGZ7z7eHZBVJ2AFs";
			// }
			
			$serie = $pSimboloS . str_pad($pSerie, 3, "0", STR_PAD_LEFT);

			if ($pIdTipoDoc == 1 || $pIdTipoDoc == 4 || $pIdTipoDoc == 6 || $pIdTipoDoc == 7) {
				$clienteTipoDocumento = $pIdTipoDoc;
			}elseif ($pIdTipoDoc == 0){
				$clienteTipoDocumento = "-"; 
			}else{
				throw new Exception("Id tipo documento no reconocido.");
			}
			
			$totalGravada = $pSubTotal; 
			$totalIgv = $pIGV;

			$items = array();
			foreach ($Detalle as $key => $item) {
				$tipoIgv=$item['aIdTipoIgv'];
				$valorUnitario=0;
				$subTotal=0;
				$igv = 0;
				if ($tipoIgv==1) {
					$valorUnitario = round(floatval($item['aPU'] / 1.18), 2);
					$subTotal = $valorUnitario * $item['aCantidad'];
					$igv = $item['aImporte'] - $subTotal;
				}else{
					$valorUnitario=$item['aPU'];
					$subTotal = $valorUnitario * $item['aCantidad'];
					$igv='0.00';
				}

				$nuevoItem = array(
                    "unidad_de_medida"          => "NIU",
                    "codigo"                    => $item['aCodigo'],
                    "descripcion"               => $item['aDescripcion'],
                    "cantidad"                  => $item['aCantidad'],
                    "valor_unitario"            => $valorUnitario,
                    "precio_unitario"           => $item['aPU'],
                    "descuento"                 => "",
                    "subtotal"                  => $subTotal,
                    "tipo_de_igv"               => $item['aIdTipoIgv'], //1 gravado venta   8 exonerado
                    "igv"                       => $igv,
                    "total"                     => $item['aImporte'],
                    "anticipo_regularizacion"   => "false",
                    "anticipo_documento_serie"  => "",
                    "anticipo_documento_numero" => ""
                );

                array_push($items, $nuevoItem);
			}

			$data = array(
			    "operacion"				=> "generar_comprobante",
			    "tipo_de_comprobante"               => $pIdTipoComprobante,
			    "serie"                             => $serie,
			    "numero"				=> $pNumero,
			    "sunat_transaction"			=> "1",		//1 para ventas nacionales comunes
			    "cliente_tipo_de_documento"		=> $clienteTipoDocumento,	
			    "cliente_numero_de_documento"	=> $pNroDoc,
			    "cliente_denominacion"              => $pRS,
			    "cliente_direccion"                 => $pDireccion,
			    "cliente_email"                     => $pEmail,
			    "cliente_email_1"                   => "",
			    "cliente_email_2"                   => "",
			    "fecha_de_emision"                  => $FechaE,
			    "fecha_de_vencimiento"              => "",
			    "moneda"                            => "1",		// 1 soles, 2 dolares
			    "tipo_de_cambio"                    => "",
			    "porcentaje_de_igv"                 => "18.00",
			    "descuento_global"                  => "",
			    "descuento_global"                  => "",
			    "total_descuento"                   => "",
			    "total_anticipo"                    => "",
			    "total_gravada"                     => $totalGravada,
			    "total_inafecta"                    => "",
			    "total_exonerada"                   => $Exonerado,
			    "total_igv"                         => $totalIgv,
			    "total_gratuita"                    => "",
			    "total_otros_cargos"                => "",
			    "total"                             => $pTotal,
			    "percepcion_tipo"                   => "",
			    "percepcion_base_imponible"         => "",
			    "total_percepcion"                  => "",
			    "total_incluido_percepcion"         => "",
			    "detraccion"                        => "false",
			    "observaciones"                     => "",
			    "documento_que_se_modifica_tipo"    => "",
			    "documento_que_se_modifica_serie"   => "",
			    "documento_que_se_modifica_numero"  => "",
			    "tipo_de_nota_de_credito"           => "",
			    "tipo_de_nota_de_debito"            => "",
			    "enviar_automaticamente_a_la_sunat" => "true",
			    "enviar_automaticamente_al_cliente" => "true",
			    "codigo_unico"                      => $serie.$pNumero,
			    "condiciones_de_pago"               => "",
			    "medio_de_pago"                     => $pTipoPago,
			    "placa_vehiculo"                    => "",
			    "orden_compra_servicio"             => "",
			    "tabla_personalizada_codigo"        => "",
			    "formato_de_pdf"                    => $Formato,/* A4,A5,TICKET */
			    "items" => $items
			);

			$data_json = json_encode($data);
			$res->json = $data_json;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $ruta);
			curl_setopt(
				$ch, CURLOPT_HTTPHEADER, array(
				'Authorization: Token token="'.$token.'"',
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
			if (isset($leer_respuesta['errors'])) {
				throw new Exception($leer_respuesta['errors']);
			} else {
				$res->resultado = true;
				$res->direccionComprobante = $leer_respuesta['enlace'].".pdf";
				$res->resultadoSunat = $leer_respuesta['aceptada_por_sunat'];
				$res->respuestaSunat = $leer_respuesta['sunat_description'];
				$res->pdfBase64 = $leer_respuesta['pdf_zip_base64'];
				$res->CodigoHas = $leer_respuesta['codigo_hash'];
                $res->CadenaQR = $leer_respuesta['cadena_para_codigo_qr'];
			}
		} catch (Exception $e) {
			$res->resultado = false;
			$res->error = $e->getMessage();
		}
		
		return $res;
	}
	public static function AnularComprobante_NubeFact($pIdEmpresa,$pIdTipoComprobante, $pSerie, $pNumero, $pMotivo,$pSimboloS){
        try {
            $res = new stdClass();
            $res->resultado = false;
            $res->error = "";
            $res->respuestaSunat = "";
            $res->json = "";
			/*
            $ruta = "https://www.pse.pe/api/v1/46e76c8a8d784750b5a6e8fa17b0d627ea6bebbcaf204e1eafcf54ad0c3ddc4c";
			$token = "eyJhbGciOiJIUzI1NiJ9.ImZiNzMzZjIwM2IwZDRiYTFiM2Q5NDg5ZTM3NjljNWIwNzE1ZGQ2MGZlYjlmNDI1MDhkZGZkY2UwYmQzZjZjNDYi.vH8XwPcsQ2C44o1mR2gvlhq85VSgmgczXfy0JFcYPAg";
			*/
			$ruta='';
			$token='';
			if ($pIdEmpresa==1) {
				$ruta = "https://www.pse.pe/api/v1/bbbf5aabdf214d0ca43f71e4fa4d93d08eb534e392b74addb6ada413d09365fb";
				$token = "eyJhbGciOiJIUzI1NiJ9.ImQ4MGI4MDRhZDE2YTRmZTU5ZWU5MWY4ZDk4ZjdhNmRlOWRlNWVhNjBlZjk4NDliNDk1ODM0ZTcwNzI2ZTA3NWYi.V247v69STl1G7xjsiy8sy6SnW1PuGZ7z7eHZBVJ2AFs";
			}else if($pIdEmpresa==2){
				$ruta = "https://www.pse.pe/api/v1/bbbf5aabdf214d0ca43f71e4fa4d93d08eb534e392b74addb6ada413d09365fb";
				$token = "eyJhbGciOiJIUzI1NiJ9.ImQ4MGI4MDRhZDE2YTRmZTU5ZWU5MWY4ZDk4ZjdhNmRlOWRlNWVhNjBlZjk4NDliNDk1ODM0ZTcwNzI2ZTA3NWYi.V247v69STl1G7xjsiy8sy6SnW1PuGZ7z7eHZBVJ2AFs";
			}
			
            $serie = $pSimboloS . str_pad($pSerie, 3, "0", STR_PAD_LEFT);

            $data = array(
                "operacion"                => "generar_anulacion",
                "tipo_de_comprobante"               => $pIdTipoComprobante,
                "serie"                             => $serie,
                "numero"                        => $pNumero,
                "motivo"                        => $pMotivo,
                "codigo_unico"        => "A".$serie.$pNumero
            );

            $data_json = json_encode($data);
            $res->json = $data_json;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $ruta);
            curl_setopt(
                $ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Token token="'.$token.'"',
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
            if (isset($leer_respuesta['errors'])) {
                throw new Exception($leer_respuesta['errors']);
            } else {
                $res->resultado = true;
                $res->direccionComprobante = $leer_respuesta['enlace'].".pdf";
                $res->numeroNubeFact = $leer_respuesta['numero'];
                $res->numeroSunat = $leer_respuesta['sunat_ticket_numero'];
                $res->sunatRespuesta = $leer_respuesta['aceptada_por_sunat'];
                $res->sunatDescripcion = $leer_respuesta['sunat_description'];
                $res->sunatNota = $leer_respuesta['sunat_note'];
                $res->sunatCodigoRespuesta = $leer_respuesta['sunat_responsecode'];
                $res->sunatSoapError = $leer_respuesta['sunat_soap_error'];
            }
        } catch (Exception $e) {
            $res->resultado = false;
            $res->error = $e->getMessage();
        }
        
        return $res;
    }
	public static function COnsultaComprobante_NubeFact($pIdTipoComprobante, $pSerie, $pNumero,$pSimboloS){
        try {
            $res = new stdClass();
            $res->resultado = false;
            $res->error = "";
            $res->respuestaSunat = "";
            $res->json = "";
			/*
            $ruta = "https://www.pse.pe/api/v1/46e76c8a8d784750b5a6e8fa17b0d627ea6bebbcaf204e1eafcf54ad0c3ddc4c";
			$token = "eyJhbGciOiJIUzI1NiJ9.ImZiNzMzZjIwM2IwZDRiYTFiM2Q5NDg5ZTM3NjljNWIwNzE1ZGQ2MGZlYjlmNDI1MDhkZGZkY2UwYmQzZjZjNDYi.vH8XwPcsQ2C44o1mR2gvlhq85VSgmgczXfy0JFcYPAg";
			*/
			$ruta = "https://www.pse.pe/api/v1/bbbf5aabdf214d0ca43f71e4fa4d93d08eb534e392b74addb6ada413d09365fb";
			$token = "eyJhbGciOiJIUzI1NiJ9.ImQ4MGI4MDRhZDE2YTRmZTU5ZWU5MWY4ZDk4ZjdhNmRlOWRlNWVhNjBlZjk4NDliNDk1ODM0ZTcwNzI2ZTA3NWYi.V247v69STl1G7xjsiy8sy6SnW1PuGZ7z7eHZBVJ2AFs";
			
			
            $serie = $pSimboloS . str_pad($pSerie, 3, "0", STR_PAD_LEFT);

            $data = array(
                "operacion"                => "consultar_comprobante",
                "tipo_de_comprobante"      => $pIdTipoComprobante,
                "serie"                    => $serie,
                "numero"                   => $pNumero
            );

            $data_json = json_encode($data);
            $res->json = $data_json;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $ruta);
            curl_setopt(
                $ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Token token="'.$token.'"',
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
            if (isset($leer_respuesta['errors'])) {
                throw new Exception($leer_respuesta['errors']);
            } else {
                $res->resultado = true;
                $res->direccionComprobante = $leer_respuesta['enlace'].".pdf";
                $res->numeroNubeFact = $leer_respuesta['numero'];
                $res->numeroSunat = $leer_respuesta['sunat_ticket_numero'];
                $res->sunatRespuesta = $leer_respuesta['aceptada_por_sunat'];
                $res->sunatDescripcion = $leer_respuesta['sunat_description'];
                $res->sunatNota = $leer_respuesta['sunat_note'];
                $res->sunatCodigoRespuesta = $leer_respuesta['sunat_responsecode'];
                $res->sunatSoapError = $leer_respuesta['sunat_soap_error'];
            }
        } catch (Exception $e) {
            $res->resultado = false;
            $res->error = $e->getMessage();
        }
        
        return $res;
    }
	
	//NOTA PEDIDO VENTA 
	public static function getList_User_Alm($pIdUser,$IdEmpresa){
		$query="select IdAlmacen,fn_RecuperarNombre_ns('ALMACEN',IdAlmacen) as Almacen
			  from `mante_usuario_almacen` where IdUsuario='$pIdUser';";
	  //echo $query;
	  return Class_Run::Select_Query($query);
   }
	public static function getList_combo_VentaNP($Datos){
		$IdAlm=$Datos[0];
 	 	$Compro=ClaProceso::getList_Mante_Comprobantes_NP();
		$TipoDoc=ClaProceso::getList_Mante_TipoDoc_Vent();
		$Empresa=ClaProceso::getList_EmpresaAlm_Vent($IdAlm);
		//echo $query;
		return array("Compro"=>$Compro,"Empresa"=>$Empresa);
 	}
	public static function getList_Mante_Comprobantes_NP(){
 	 	$query="SELECT IdComprobante as Id,Comprobante as Nombre FROM `mante_comprobante` WHERE IdComprobante=15;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_TipoDoc_Vent(){
 	 	$query="SELECT IdTipoDocumento AS Id,TipoDocumento AS Nombre
			FROM `mante_tipo_documento` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_EmpresaAlm_Vent($IdAlm){
 	 	$query="SELECT  IdEmpresa AS Id,`fn_RecuperarNombre_ns`('COMPANY',IdEmpresa) AS Nombre
			FROM `mante_almacen_empresa` WHERE IdAlmacen='".$IdAlm."';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Serie_Numero_VentaNP($Datos){
 	 	return ClaProceso::getList_Serie_Numero_NP($Datos[0],$Datos[1]);
 	}
	public static function getList_Serie_Numero_NP($IdEmpresa,$pIdComp){
 	 	//$query="select ifnull(Serie,1) as Serie FROM `mante_almacen_serie` WHERE IdAlmacen=$IdEmpresa AND IdComprobante='$pIdComp';";
		//echo $query;
		$ASerie=1;//Class_Run::Select_Query($query);
		$Serie=1;
		/*if(count($ASerie)>0){
			$Serie=$ASerie[0]["Serie"];
		}*/
		$query1="select ifnull(max(Numero+1),1) as Numero from mante_registro_nota_pedido
			where IdNotaPedido='$pIdComp' and Serie='$Serie' and IdEmpresa=$IdEmpresa;";
		//echo $query1;
		$Numero=Class_Run::Select_Query($query1);
		return array("Serie"=>$Serie,"Numero"=>$Numero);
 	}
	public static function Save_Datos_Venta_NP($Datos,$IdUser){
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$aIdEmpresa=$Datos[0]["aIdEmpresa"];
		$aIdComprob=$Datos[0]["aIdComprob"];
		// $aSerie=$Datos[0]["aSerie"];
		// $aNumero=$Datos[0]["aNumero"];
		$aFechaEm= date('Y-m-d H:i:s');
		// $aIdTipoDoc=$Datos[0]["aIdTipoDoc"];
		// $aRuc=$Datos[0]["aRuc"];
		// $aRS=$Datos[0]["aRS"];
		// $aDireccion=$Datos[0]["aDireccion"];
		// $aEmail=$Datos[0]["aEmail"];
		$aObs=$Datos[0]["aNroGuia"];
		
		$aTotaal=$Datos[0]["aTotaal"];
		$aSubTotal=$Datos[0]["aSubTotal"];
		$aIGV=$Datos[0]["aIGV"];
		$aSon=$Datos[0]["aSon"];
		$aIdIGV=$Datos[0]["aIdIGV"];
		// $aFechaEnt=$Datos[0]["aFechaEnt"];
		// $aTelefono=$Datos[0]["aTelefono"];

		$aAlm=$Datos[0]["aAlm"];
		$aIdAlm=$Datos[0]["aIdAlm"];
	
		$aDetail=array();
		$aDetail=$Datos[0]["aDetail"];
		$IdVenta=1;
		// $aFechaE=date("Y-m-d", (strtotime ("-5 Hours")));
		$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		
		$queryRes="SELECT IFNULL(MAX(IdVenta+1),1) AS Com FROM mante_registro_nota_pedido where IdEmpresa=$aIdEmpresa;";
		$sql = $pdo->prepare($queryRes);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdVenta=$fila1[0]["Com"];
			$sql = "INSERT INTO `mante_registro_nota_pedido`(`IdEmpresa`, `IdAlmacen`, `IdVenta`, `IdNotaPedido`, `Serie`, `Numero`, `FechaReg`,
															`IdUsuario`, `FechaE`, `Total`, `SubTotal`, `IGV`, `IdChkIGV`, `Son`, `IdTipoDoc`,
															`Ruc`, `FechaEntrega`, `Telefono`, `Estado`, `RS`, `Direccion`, `Email`, `Obs`) 
													VALUES ('{$aIdEmpresa}','{$aIdAlm}','{$IdVenta}','{$aIdComprob}','','','{$FechaHr}',
															'{$IdUser}','{$aFechaEm}','{$aTotaal}','{$aSubTotal}','{$aIGV}','{$aIdIGV}','{$aSon}','',
															'','','',1,'','','','{$aObs}')";
			// $sql = "INSERT INTO mante_registro_nota_pedido(`IdEmpresa`,`IdAlmacen`,`IdVenta`,`IdNotaPedido`,`FechaReg`,`IdUsuario`,`FechaE`,
			// 												`Total`,`SubTotal`,`IGV`,`IdChkIGV`,`Son`,`Obs`) 
			// 											VALUES ('{$aIdEmpresa}','{$aIdAlm}','{$IdVenta}','{$aIdComprob}','{$FechaHr}','{$IdUser}','{$aFechaEm}',
			// 													'{$aTotaal}','{$aSubTotal}','{$aIGV}','{$aIdIGV}','{$aSon}','{$aObs}')";
			// $queryInsR="INSERT INTO mante_registro_nota_pedido VALUES(".$aIdEmpresa.",".$aIdAlm.",".$IdVenta.",".$aIdComprob.",'".$aSerie."','".$aNumero."',
			// 		'".$FechaHr."',".$IdUser.",'".$aFechaEm."','".$aTotaal."','".$aSubTotal."','".$aIGV."','".$aIdIGV."','".$aSon."','".$aIdTipoDoc."',
			// 		'".addslashes($aRuc)."','".$aFechaEnt."','".$aTelefono."',1,'".addslashes($aRS)."','".addslashes($aDireccion)."','".addslashes($aEmail)."',
			// 		'".addslashes($aObs)."');";
			//echo $queryInsR;
			$sql1 = $pdo->prepare($sql);
			if($sql1->execute()){
				for($i=0;$i<count($aDetail);$i++)
				{		
					$aCantidad=$aDetail[$i]["aCantidad"];
					$aCodigo=$aDetail[$i]["aCodigo"];
					$aDescripcion=$aDetail[$i]["aDescripcion"];
					$aUnidad=$aDetail[$i]["aUnidad"];
					$aPU=$aDetail[$i]["aPU"];
					$aImporte=$aDetail[$i]["aImporte"];
					$aIdProducto=$aDetail[$i]["aIdProducto"];
					$aIdTipoPrecio=$aDetail[$i]["aIdTipoPrecio"];
									
					$queryDet="SELECT IFNULL(MAX(IdDetalle+1),1) AS IdDeatil FROM mante_registro_nota_pedido_detalle WHERE IdVenta=".$IdVenta." AND IdEmpresa=$aIdEmpresa;";
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$fila2=$sql2->fetchAll();
						$IdDetalles=$fila2[0]["IdDeatil"];
						$querDe="INSERT INTO mante_registro_nota_pedido_detalle VALUES(".$aIdEmpresa.",'".$aIdAlm."',".$IdVenta.",
								".$IdDetalles.",'".$aCantidad."','".addslashes($aCodigo)."','".addslashes($aDescripcion)."','".$aPU."',
								'".$aImporte."','".$aIdProducto."','".$aIdTipoPrecio."','".$aUnidad."');";
						//echo $querDe;
						$sql3 = $pdo->prepare($querDe);
						if($sql3->execute()){
							$valido=true;
						}else{$valido=false;}
					}else{$valido=false;}
				}
			}else{$valido=false;}
		}else{$valido=false;}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		//$Dat=[$IdVenta,];
		return array("Val"=>$valido,"IdVenta"=>$IdVenta);
 	}
	
	//COMPRA SIMPLE 
	public static function getList_Producto_Codigo_CS($Datos){
 	 	$query="SELECT prod.IdProducto,prod.Codigo,fn_RecuperarNombre_ns('UNIDAD',alm.IdUnidad) AS Unidad,prod.Producto,
		fn_RecuperarNombre_ns('CATEGORIA',prod.IdCategoria) AS Modelo,fn_RecuperarNombre_ns('MARCA',prod.IdMarca) AS Marca,
		IFNULL(alm.Stock,0) AS Stock,IFNULL(PrecioPublico,0) AS PrecioPublico,IFNULL(PrecioBase,0) AS PrecioMenor,
		IFNULL(PrecioDistribuido,0) AS PrecioMayor,IFNULL(PrecioCompra,0) AS PrecioCompra,TipoCambio
		FROM `mante_producto` prod
		LEFT JOIN `mante_producto_almacen` alm ON(alm.`IdProducto`=prod.IdProducto AND alm.`IdAlmacen`='$Datos[0]' AND alm.Estado=1)
		WHERE prod.Codigo='$Datos[1]';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Productos_AlmComp_CS($Datos){
 	 	$query="SELECT prod.IdProducto,prod.Codigo,
			CONCAT(prod.`Producto`,' ',fn_RecuperarNombre_ns('MARCA',prod.IdMarca),' ',fn_RecuperarNombre_ns('CATEGORIA',prod.IdCategoria)) AS Producto
			FROM `mante_producto` prod WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Producto_Id_CS($Datos){
 	 	$query="SELECT prod.IdProducto,prod.Codigo,fn_RecuperarNombre_ns('UNIDAD',alm.IdUnidad) AS Unidad,alm.IdUnidad,prod.Producto,
		fn_RecuperarNombre_ns('CATEGORIA',prod.IdCategoria) AS Modelo,fn_RecuperarNombre_ns('MARCA',prod.IdMarca) AS Marca,
		IFNULL(alm.Stock,0) AS Stock,IFNULL(PrecioPublico,0) AS PrecioPublico,IFNULL(PrecioBase,0) AS PrecioMenor,
		IFNULL(PrecioDistribuido,0) AS PrecioMayor,IFNULL(PrecioCompra,0) AS PrecioCompra,TipoCambio
		FROM `mante_producto` prod
		LEFT JOIN `mante_producto_almacen` alm ON(alm.`IdProducto`=prod.IdProducto AND alm.`IdAlmacen`='$Datos[0]' AND alm.Estado=1)
		WHERE prod.IdProducto='$Datos[1]';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Datos_CompraSimple($Datos,$IdUser){
 	 	$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$aRespo=$Datos[0]["aRespo"];
		$aTotal=$Datos[0]["aTotal"];
		$aAlm=$Datos[0]["aAlm"];
		$aIdAlm=$Datos[0]["aIdAlm"];
	
		$aDetail=array();
		$aDetail=$Datos[0]["aDetail"];
		$IdVenta=1;
		$IdTipoEnt=2;$pOrigen='Compra Simple';$pDestino=$aAlm;
		
		$aFechaE=date("Y-m-d", (strtotime ("-5 Hours")));
		$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		
		$queryRes="SELECT IFNULL(MAX(IdCompraS+1),1) AS Com FROM mante_compra_simple;";
		$sql = $pdo->prepare($queryRes);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdVenta=$fila1[0]["Com"];
			$queryInsR="INSERT INTO mante_compra_simple VALUES(".$aIdAlm.",".$IdVenta.",'".$FechaHr."',".$IdUser.",
						'".addslashes($aRespo)."',1,'".$aTotal."','');";
			//echo $queryInsR;
			$sql1 = $pdo->prepare($queryInsR);
			if($sql1->execute()){
				for($i=0;$i<count($aDetail);$i++)
				{		
					$aCantidad=$aDetail[$i]["aCantidad"];
					$aCodigo=$aDetail[$i]["aCodigo"];
					$aDescripcion=$aDetail[$i]["aDescripcion"];
					$aUnidad=$aDetail[$i]["aUnidad"];
					$aImporte=$aDetail[$i]["aImporte"];
					$aIdProducto=$aDetail[$i]["aIdProducto"];
					$aPPublico=$aDetail[$i]["aPPublico"];
					$aPMenor=$aDetail[$i]["aPMenor"];
					$aPMayor=$aDetail[$i]["aPMayor"];
					$aPCompra=$aDetail[$i]["aPCompra"];
					$aTC=$aDetail[$i]["aTC"];
					$aidUnidad=$aDetail[$i]["aidUnidad"];
									
					$queryDet="SELECT IFNULL(MAX(IdDetalle+1),1) AS IdDeatil FROM mante_compra_simple_detalle WHERE IdCompraS=".$IdVenta."";
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$fila2=$sql2->fetchAll();
						$IdDetalles=$fila2[0]["IdDeatil"];
						$querDe="INSERT INTO mante_compra_simple_detalle VALUES('".$aIdAlm."',".$IdVenta.",".$IdDetalles.",'".$aIdProducto."',
								'".$aCantidad."','".addslashes($aCodigo)."','".addslashes($aDescripcion)."','".$aUnidad."','".$aImporte."',
								'".$aPPublico."','".$aPMenor."','".$aPMayor."','".$aPCompra."','".$aTC."');";
						//echo $querDe;
						$sql3 = $pdo->prepare($querDe);
						if($sql3->execute()){
							$queryDet1="SELECT IFNULL(COUNT(*),0) AS cont FROM `mante_producto_almacen` 
										WHERE IdAlmacen='".$aIdAlm."' AND IdProducto='".$aIdProducto."';";
							$sql3 = $pdo->prepare($queryDet1);
							if($sql3->execute()){
								$fila2=$sql3->fetchAll();
								$existP=$fila2[0]["cont"];
								if($existP>0){
									$query1234="UPDATE `mante_producto_almacen` SET PrecioCompra='".$aPCompra."',PrecioPublico='".$aPPublico."',PrecioBase='".$aPMenor."',
												PrecioDistribuido='".$aPMayor."',Stock=Stock+'".$aCantidad."',TipoCambio='".$aTC."'
												WHERE IdAlmacen='".$aIdAlm."' AND IdProducto='".$aIdProducto."';";
									$sql4 = $pdo->prepare($query1234);
									if($sql4->execute()){$valido=true;}else{$valido=false;}
								}else{
									$query123="INSERT INTO mante_producto_almacen VALUES('".$aIdAlm."','".$aIdProducto."','".$aidUnidad."',1,'".$aCantidad."','".$aPCompra."','".$aPMenor."','".$aPMayor."','".$aPPublico."',1,
												'".$aTC."');";
									$sql5 = $pdo->prepare($query123);
									if($sql5->execute()){$valido=true;}else{$valido=false;}
								}
							}else{$valido=false;}
							if($valido){
								$queryGast="SELECT fn_save_kardex_Compra('".$IdUser."','".$pOrigen."','".$pDestino."','".$aIdAlm."',
											'".$aIdProducto."','".addslashes($aDescripcion)."','".$aCantidad."','".$aPCompra."',
											'".$aImporte."','".$IdTipoEnt."','Compra Simple','".$FechaHr."') as con;";
								//echo $queryGast;	
								$sql4 = $pdo->prepare($queryGast);				
								if($sql4->execute()){
									$fila4=$sql4->fetchAll();
									$valor=$fila4[0]["con"];
									if($valor==1){$valido=true;}else{$valido=false;}
								}
							}else{$valido=false;}
						}else{$valido=false;}
					}else{$valido=false;}
				}
			}else{$valido=false;}
		}else{$valido=false;}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		//$Dat=[$IdVenta,];
		return array("Val"=>$valido,"IdVenta"=>$IdVenta);
 	}
	
	//PAGO PROVEEDOR 
	public static function getList_Datos_PAGV($Datos){
 	 	$query="SELECT del.IdCompraCredito,del.`NroCuota`,del.`Monto`,del.`Interes`,del.`Total`,DATE_FORMAT(del.FechaPago,'%d/%m/%Y') AS FechaLim,
		fn_RecuperarNombre_ns('PROVEEDOR',crd.`IdProveedor`) AS Proveedor,del.IdAlmacen,
		IFNULL(pag.`Monto`,'') AS MontoPag,IFNULL(pag.Mora,'') AS MoraPag,IFNULL(pag.Total,'') AS TotalPag,
		IFNULL(DATE_FORMAT(pag.FechaPago,'%d/%m/%Y'),'') AS FechaPag,IFNULL(pag.NroCuota,-1) AS IdEst,
		IFNULL(fn_RecuperarNombre_ns('USER_AP',pag.`IdUsuario`),'') AS UserPag
		FROM `mante_compra_credito_detalle` del
		LEFT JOIN `mante_compra_credito` crd ON(crd.`IdCompraCredito`=del.`IdCompraCredito` AND crd.`IdAlmacen`=del.`IdAlmacen`)
		LEFT JOIN `mante_compra_credito_pago` pag ON(del.IdCompraCredito=pag.IdCompraCredito AND del.`NroCuota`=pag.`NroCuota`)
		WHERE  del.FechaPago BETWEEN '$Datos[0]' AND '$Datos[1]' ORDER BY del.FechaPago ASC;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Ids_PayCreditoProv($Datos){
		$query="select det.NroCuota,det.Monto,det.Interes,det.Total,DATE_FORMAT(det.FechaPago,'%d/%m/%Y') AS FechaPag,
		ifnull(pag.`NroCuota`,-1) as Pag,ifnull(fn_RecuperarNombre_ns('USER_AP',pag.`IdUsuario`),'') as Userr
		from mante_compra_credito_detalle det
		left join `mante_compra_credito_pago` pag on(det.`IdCompraCredito`=pag.`IdCompraCredito` and det.`NroCuota`=pag.`NroCuota`)
		where det.IdCompraCredito='$Datos[0]';";
		//echo $query;	
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_PayCreditoProv($Datos){
		$query="select NroCuota,Monto,Interes,Total,0 as Mora,DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPag
			from `mante_compra_credito_detalle`
			where IdCompraCredito='$Datos[0]' and NroCuota='$Datos[1]';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Pago_CompraCrdProve($Datos,$IdUser){
		//[pIdCVenta,pNroCuota,pIdEmpresa,Monto,Mora,TotalPagar]
 	 	$query="INSERT INTO `mante_compra_credito_pago` VALUES('".$Datos[0]."','".$Datos[1]."','".$Datos[2]."',
					'".$Datos[3]."','".$Datos[4]."','".$Datos[5]."',CURRENT_DATE(),$IdUser,CURRENT_TIMESTAMP());";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//CAJA
	public static function getList_Datos_Caja($Datos,$fecha,$IdEmpresa){
 	 	$Caja=ClaProceso::getList_Caja_50($Datos[0],$fecha);
		//echo $query;
		return array("Caja"=>$Caja);
 	}
	public static function getList_Caja_50($IdAlm,$fecha){
 	 	$query="select IdCaja,Tipo,fn_RecuperarNombre_ns('CAJA_TIPO_IE',Tipo) as Tip,Soles,Dolar,FechaReg,
			fn_RecuperarNombre_ns('USER_AP',IdUsuario) as Userr,SaldoSoles,SaldoDolares,Descripcion,Obs,Estado,
			fn_TipoServicio_Caja(Tipo,IdTipoServicio) as TipoServ
			from `mante_caja_corriente` where IdAlmacen='$IdAlm' AND DATE_FORMAT(FechaReg,'%d/%m/%Y')='$fecha' ORDER BY FechaReg;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_combo_CajaEgreso($IdEmpresa){
 	 	$query="SELECT IdTipo,Tipo FROM `mante_caja_corriente_servicio` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Ingreso_Caja($Datos,$fecha,$IdUser){
 	 	$query="CALL CajaCorriente_Save('$Datos[0]','$Datos[1]','$Datos[2]','$Datos[3]','$Datos[4]','$Datos[5]','$Datos[6]',$IdUser,'$fecha');";
		//echo $query;
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	//MOVIMIENTO DE ALMACEN 
	public static function getList_combo_MovAlm(){
 	 	return ClaProceso::getList_Mante_Almacen_Est();
 	}
	public static function getList_Productos_IdAlm($Datos){
 	 	$query="SELECT alm.IdProducto,IdUnidad,Stock,PrecioBase,PrecioDistribuido,PrecioPublico,
		prod.`Codigo`,prod.`Producto`,fn_RecuperarNombre_ns('UNIDAD',IdUnidad) AS Unidad
		FROM `mante_producto_almacen` alm
		LEFT JOIN `mante_producto` prod ON(alm.`IdProducto`=prod.`IdProducto`)
		WHERE alm.IdAlmacen='$Datos[0]' AND alm.Estado=1 AND prod.Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Datos_MovAlm($Datos,$IdEmpresa,$IdUser){
		$aFechaE=date("Y-m-d", (strtotime ("-5 Hours")));
		//$FechaFE=date("d-m-Y", (strtotime ("-5 Hours")));
		$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		
 	 	$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$aTotaal=$Datos[0]["aTotaal"];
		$aDesc=$Datos[0]["aDesc"];
		$aSubTotal=$Datos[0]["aSubTotal"];
		$aIGV=$Datos[0]["aIGV"];
		$aIdOriAlm=$Datos[0]["aIdOri"];
		$aOriAlm=$Datos[0]["aAlmOri"];
		$aIdDesAlm=$Datos[0]["aIdDes"];
		$aDesAlm=$Datos[0]["aAlmDes"];
		$aDetail=array();
		$aDetail=$Datos[0]["aDetail"];
		
		$queryRes="SELECT IFNULL(MAX(IdRegistro+1),1) AS Com FROM mante_movimiento_almacen;";
		$sql = $pdo->prepare($queryRes);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$IdCompra=$fila1[0]["Com"];
				
			$queryInsR="INSERT INTO mante_movimiento_almacen VALUES(".$IdCompra.",".$IdUser.",'".$FechaHr."',-1,-1,-1,
				'".$aFechaE."',-1,'Movimiento Almacen','".$aTotaal."','".$aSubTotal."','".$aIGV."','".addslashes($aDesc)."',1,'".$aIdOriAlm."','".$aIdDesAlm."')";
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
					$aImporte=$aDetail[$i]["aImporte"];
					$aUnidad=$aDetail[$i]["aUnidad"];
					$aIdprod=$aDetail[$i]["aIdprod"];
					$aDscto=0;
					$queryDet="SELECT IFNULL(MAX(IdDetalle+1),1) AS IdDeatil FROM mante_movimiento_almacen_detalle WHERE IdRegistro=".$IdCompra.";";
					$sql2 = $pdo->prepare($queryDet);
					if($sql2->execute()){
						$fila2=$sql2->fetchAll();
						$IdDetalles=$fila2[0]["IdDeatil"];
						$querDe="INSERT INTO mante_movimiento_almacen_detalle VALUES(".$IdCompra.",".$IdDetalles.",'".$aCantidad."',
								'".$aCodigo."','".addslashes($aDescripcion)."','".$aPrecio."','".$aImporte."','".$aIdprod."','".$aUnidad."');";
						//echo $querDe;
						$sql3 = $pdo->prepare($querDe);
						if($sql3->execute()){$valido=true;
							/*$queryGast="SELECT fn_save_kardex_MovAlm('".$aCantidad."','".addslashes($aDescripcion)."','".$aPrecio."','".$aImporte."','".$aIdprod."',
										'".$aIdOriAlm."','".$aOriAlm."','".$aIdDesAlm."','".$aDesAlm."','".$IdUser."','".$IdCompra."','".$IdDetalles."','".$FechaHr."') as con;";
							//echo $queryGast;	
							$sql4 = $pdo->prepare($queryGast);				
							if($sql4->execute()){
								$fila4=$sql4->fetchAll();
								$valor=$fila4[0]["con"];
								if($valor==1){$valido=true;}else{$valido=false;}
							}*/
						}else{$valido=false;}
					}else{$valido=false;}
				}
			}else{$valido=false;}
		}else{$valido=false;}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		return $valido;
 	}

	//procesar mov alm  
	public static function getList_Datos_RMovAlm($Datos){
 	 	$query="SELECT IdRegistro,fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,FechaReg,DATE_FORMAT(FechaEmision,'%d/%m/%Y') AS Fecha,
		Obs,Total,Responsable,fn_RecuperarNombre_ns('ALMACEN',IdOrigen) AS Origen,Estado,
		fn_RecuperarNombre_ns('ALMACEN',IdDestino) AS Destino
		FROM `mante_movimiento_almacen` WHERE FechaEmision BETWEEN '".$Datos[0]."' AND '".$Datos[1]."';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Datos_AprobMovAlm_Detalle($Datos){
 	 	$query="select Cantidad,Codigo,Producto,PUnitario,Importe,Unidad
			from `mante_movimiento_almacen_detalle` where IdRegistro='".$Datos[0]."';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Procesar_MovALm($Datos,$IdUser){
 	 	$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		$query="CALL procesar_movAlm('".$Datos[0]."',".$IdUser.",'".$FechaHr."');";
		//echo $query;
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function Anular_MovALm($Datos,$IdUser){
 	 	//$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		$query="DELETE FROM `mante_movimiento_almacen` WHERE IdRegistro='".$Datos[0]."' AND Estado=1;";
		//echo $query;
		return Class_Run::Execute_Query_Bool($query);
 	}
	//VENTA RAPIDA
	public static function RecuperarListaProductos($Almacen){
		$query="SELECT CONCAT(mp.`Producto`,' ',ma.`Marca`) as label,mp.`IdProducto`,mp.`Codigo`,mp.`Producto`,ma.`IdMarca`,ma.`Marca`,mc.`IdCategoria`,mc.`Categoria`,mu.`IdUnidad`,mu.`Unidad`,mpa.`Stock`,mpa.`PrecioPublico`,mpa.PrecioCompra,mpa.PrecioDistribuido 
		FROM `mante_producto` mp 
		INNER JOIN `mante_producto_almacen` mpa ON mp.`IdProducto`=mpa.`IdProducto` 
		INNER JOIN `mante_marca` ma ON mp.`IdMarca`=ma.`IdMarca`
		INNER JOIN `mante_categoria` mc ON mp.`IdCategoria`=mc.`IdCategoria`
		INNER JOIN `mante_unidad` mu ON mpa.`IdUnidad`=mu.`IdUnidad`
		WHERE mpa.`IdAlmacen`='".$Almacen."' AND mp.`Estado`=1";
		//echo $query;
		return Class_Run::Select_Query_J($query);
	}
	public static function RecuperarProductosEspeciales($Almacen){
		$query="SELECT id_producto_especial,codigo,descripcion AS label FROM mante_producto_especial WHERE estado=1";
		//echo $query;
		return Class_Run::Select_Query_J($query);
	}
	public static function ObtenerStockAlmacenes($idProducto){
		$query="SELECT ma.`Simbolo`,mpa.`Stock` FROM `mante_producto_almacen` mpa 
		INNER JOIN `mante_almacen` ma ON mpa.`IdAlmacen`=ma.`IdAlmacen` WHERE mpa.`IdProducto`='".$idProducto."'";
		//echo $query;
		return Class_Run::Select_Query_J($query);
	}
}
?>
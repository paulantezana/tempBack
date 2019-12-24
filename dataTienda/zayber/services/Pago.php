<?php
class ClaPago{
	public static function getList_cbo_CronoPago(){
 	 	$query="select IdCliente as Id,concat(NroDocumento,' ',NombreRS) as Nombre
				from `mante_cliente` where Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Tipo_Plan(){
 	 	$query="SELECT IdTipo AS Id,Tipo AS Nombre FROM `pago_tipo` WHERE Estado=1;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_combo_CronoPay($Datos){
 	 	$Tipo=ClaPago::getList_Tipo_Plan();
 	 	$Cliente=ClaPago::getList_CronoPlan($Datos[0]);
		//echo $query;
		return array("Cliente"=>$Cliente,"Tipo"=>$Tipo);
 	}
	public static function getList_CronoPlan($IdCliente){
 	 	$query="SELECT Descripcion,FechaVec,Monto,IdTipoPlan,MesVec
				FROM `pago_cronograma_cliente` WHERE IdCliente='".$IdCliente."';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Datos_CronoPay($Datos,$IdUser){
		//[Id,IdTip,Monto,Vecn,Anio,Obs,IdEst]
		//Vecn=21;
		//ANio=11/2020
		$IdCliente=$Datos[0];
		$IdTipoPlan=$Datos[1];
		$Monto=$Datos[2];
		$Vecn=$Datos[3];
		$Anio=$Datos[4];
		$Descrip=$Datos[5];
		$IdEst=$Datos[6];
		$fechaActual=$Datos[7];
		//$fechaActual=date("Y-m-d", (strtotime ("-5 Hours")));
		$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		$FechaFin=$Datos[4].'-01';
		
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$query0="SELECT IFNULL(COUNT(*),0) AS cont FROM `pago_cronograma_cliente` WHERE IdCliente='".$IdCliente."';";
		$sql = $pdo->prepare($query0);
		if($sql->execute()){
			$fila1=$sql->fetchAll();
			$cont=$fila1[0]["cont"];
			if($cont>0){//actualizar cliente
				$query2="UPDATE pago_cronograma_cliente SET IdUsuario='".$IdUser."',Descripcion='".$Descrip."',Estado='".$IdEst."',FechaVec='".$Vecn."',
						Monto='".$Monto."',IdTipoPlan='".$IdTipoPlan."',MesVec='".$Anio."'
						WHERE IdCliente='".$IdCliente."';";
				//echo $query2;
				$sql = $pdo->prepare($query2);
				if($sql->execute()){$valido=true;}else{$valido=false;}
			}else{//insert cliente
				$query1="INSERT INTO pago_cronograma_cliente VALUES('".$IdCliente."','".$FechaHr."','".$IdUser."','".$Descrip."','".$IdEst."',
						'".$Vecn."','".$Monto."','".$IdTipoPlan."','".$Anio."');";
				//echo $query1;
				$sql = $pdo->prepare($query1);
				if($sql->execute()){$valido=true;}else{$valido=false;}
			}
		}	

		if($valido){	
			while($fechaActual<$FechaFin){
				if($valido){
					$query5="select fn_Registrar_CronoPago_Cliente('".$IdCliente."','".$fechaActual."','".$Monto."','".$IdUser."','".$IdEst."','".$Descrip."','".$IdTipoPlan."');";
					//echo $query5;
					$sql = $pdo->prepare($query5);
					if($sql->execute()){$valido=true;}else{$valido=false;}
					$fechaActual =date("Y-m-d", strtotime ('+1 month', strtotime($fechaActual)));
				}
			}
			if($valido){
				$query6="select fn_Registrar_CronoPago_Cliente('".$IdCliente."','".$fechaActual."','".$Monto."','".$IdUser."','".$IdEst."','".$Descrip."','".$IdTipoPlan."');";
				$sql = $pdo->prepare($query6);
				if($sql->execute()){$valido=true;}else{$valido=false;}
			}
		}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		return $valido;
 	}
	public static function getList_Datos_CronoPago($Datos){
 	 	$query="SELECT CONCAT(IdDetalle,'_',Pagado) as Id,IdDetalle,DATE_FORMAT(FechaPago,'%d/%m/%Y') AS Fecha,Monto,Pagado,
			CASE WHEN Pagado=1 THEN 'Pagado' ELSE 'Pendiente' END AS Pag,
			fn_RecuperarNombre_ns('PLAN',IdPlan) AS Plan
			FROM `pago_cronograma_pago` WHERE IdCliente='".$Datos[0]."';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Datos_EditMonto_CronoPay($Datos,$IdUser){
		//[Id,IdDetalle,Monto,Obs]
 	 	$query="UPDATE `pago_cronograma_pago` SET Monto='".$Datos[2]."',Obs='".addslashes($Datos[3])."'
			WHERE IdCliente='".$Datos[0]."' AND IdDetalle='".$Datos[1]."' AND Pagado=0;";
		//echo $query;
		return Class_Run::Execute_Query_Bool($query);
 	}
	public static function Save_Pagar_CronoPay($Datos,$IdUser){
		//[Id,IdDetalle,Monto,IdForma,Obs]
		
		$fechaActual=date("Y-m-d", (strtotime ("-5 Hours")));
		$FechaHr=date("Y-m-d H:i:s", (strtotime ("-5 Hours")));
		
		$pdo = ConexionBD::conectarBD();
		$pdo->beginTransaction();
		$valido=true;
		$IdCliente=$Datos[0];
		$IdDet=$Datos[1];
		$Monto=$Datos[2];
		$IdForma=$Datos[3];
		$Obs=$Datos[4];
		$query0="UPDATE `pago_cronograma_pago` SET Pagado=1 WHERE IdCliente='".$IdCliente."' AND IdDetalle='".$IdDet."';";
		//echo $query0;
		$sql = $pdo->prepare($query0);
		$NroTicket=-1;
		if($sql->execute()){
			$query01="SELECT IFNULL(MAX(NroTicket+1),1) AS cont FROM `pago_cronograma_pagado`;";
			$sql = $pdo->prepare($query01);
			if($sql->execute()){
				$fila1=$sql->fetchAll();
				$NroTicket=$fila1[0]["cont"];
				$query1="INSERT INTO `pago_cronograma_pagado` VALUES('".$IdCliente."','".$IdDet."','".$FechaHr."',1,'".$Monto."',1,'".$IdForma."',
						'".$IdUser."','".addslashes($Obs)."','".$NroTicket."');";
				//echo $query1;
				$sql = $pdo->prepare($query1);
				if($sql->execute()){$valido=true;}else{$valido=false;}
			}
		}
		if($valido){$pdo->commit();}else{$pdo->rollBack();}
		$Cliente=ClaPago::getList_Clientes($IdCliente);
		return array("Val"=>$valido,"Ticket"=>$NroTicket,"Cliente"=>$Cliente);
 	}
	public static function getList_Tarifa_IdPlan($Datos){
 	 	$query="SELECT Monto FROM `pago_tipo` WHERE IdTipo='".$Datos[0]."';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Clientes($IdCliente){
 	 	$query="SELECT NroDocumento,NombreRS AS Nombre FROM `mante_cliente` WHERE IdCliente='".$IdCliente."';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function RePrint_Ticket_Pago($Datos){
		//[IdDetalle,Pagado]
 	 	$query="select Monto,pag.Obs,NroTicket,IdDetalle,FechaPay,NroDocumento,NombreRS,DATE_FORMAT(FechaPay,'%d/%m/%Y') AS FechaPago
			from `pago_cronograma_pagado` pag
			left join `mante_cliente` cli on(pag.IdCliente=cli.IdCliente)
			where IdDetalle='".$Datos[0]."';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	
	//REPORT 
	public static function getList_cbo_ReportCronoPago(){
		return ClaPago::getList_cbo_CronoPago();
 	}
	public static function getList_Datos_RPago($Datos){
		$Condi='';
		if($Datos[2]>0){
			$Condi=' AND IdCliente='.$Datos[2];
		}
 	 	$query="SELECT IdDetalle,Monto,fn_RecuperarNombre_ns('FORMA_PAGO',IdFormaPago) AS Pago,Obs,DATE_FORMAT(FechaPay,'%d/%m/%Y %h:%i %p') AS Fecha,
				fn_RecuperarNombre_ns('USER_AP',IdUsuario) AS Userr,fn_RecuperarNombre_ns('CLIENTE_RS',IdCliente) AS Cliente
				FROM `pago_cronograma_pagado`
				WHERE DATE_FORMAT(FechaPay,'%Y-%m-%d') BETWEEN '".$Datos[0]."' AND '".$Datos[1]."' $Condi;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	
	//tipo plan 
	public static function getList_Mante_Plan(){
 	 	$query="SELECT IdTipo AS Id,Tipo,Simbolo,Monto,CASE WHEN Estado=1 THEN 'Si' ELSE 'No' END AS Est
			FROM `pago_tipo`;";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function getList_Mante_Plan_Edit($Datos){
 	 	$query="SELECT IdTipo AS Id,Tipo,Simbolo,Estado,Monto
			FROM `pago_tipo` where IdTipo='".$Datos[0]."';";
		//echo $query;
		return Class_Run::Select_Query($query);
 	}
	public static function Save_Mante_Plan($Datos){
 	 	$query="CALL mante_save_Plan('".$Datos[0]."','".addslashes($Datos[1])."','".addslashes($Datos[2])."','".$Datos[3]."','".$Datos[4]."');";
		//echo $query;	
		return Class_Run::Execute_Query_Bool($query);
 	}
	
	
	
}
?>
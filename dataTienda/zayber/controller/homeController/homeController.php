<?php  
ob_start();//Activa el almacenamiento en búfer de la salida

class MvcController {
	public function plantilla(){
   	    include 'views/template.php';
    }
  	#INTERACCIÓN DEL USUARIO
	public function enlacesPaginasController(){
		if(isset($_GET["action"])){
		  $enlacesController = $_GET["action"];
		}else{
		   $enlacesController = "index";
		}
		// le pide al modelo y que conecte con :: al método y asi heredo la clase y sus metodos y atributos..
		//$enlacesController = str_replace("-", "_", $enlacesController);
		//echo $enlacesController;
		$respuesta =Paginas::enlacesPaginasModel($enlacesController);
		//echo $respuesta;
		require $respuesta; 
	}
	
	//MENU
	public function menuController(){
		$IdTipoUser=$_SESSION["UserTRPE"]["IdTypeUser"];
		$respuesta = homeModel::getList_permission_UserSistema($IdTipoUser,$_SESSION["UserTRPE"]["IdCompany"]);
		//print_r($respuesta);
		$Valor='';
		$Valor1='';$Valor2='';$Valor3='';$Valor4='';$Valor5='';$Valor6='';
		foreach ($respuesta as $row){
			if($row["Nivel1"]==1){
				$Valor1=$Valor1.'<div class="row ItemElmMenu1" style="background:'.$row["ColorFondo"].'">
										<a href="'.$row["Enlace"].'" class="'.$row["Clase"].'">
											<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
												<i class="'.$row["Icono"].' f-30"></i> </br>
												'.$row["Nombre"].'
											</div>
										</a>
									</div>';
			}
			else if($row["Nivel1"]==2){
					$Valor2=$Valor2.'<div class="col-xl-6 col-md-12 col-sm-12 col-xs-12 p-t-5">
											<a href="'.$row["Enlace"].'" class="'.$row["Clase"].'">
												<div class="row ItemElmMenu2">
													<i class="'.$row["Icono"].' f-30"></i> </br>
													'.$row["Nombre"].'
												</div>
											</a>
										</div>';
			}
			else if($row["Nivel1"]==3){
				
			}
			else if($row["Nivel1"]==4){
				$Valor4=$Valor4.'<div class="row ItemElmMenu">
										<a href="'.$row["Enlace"].'" class="'.$row["Clase"].'">
											<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
												<i class="fas fa-angle-double-right f-18"></i> <i class="fa fa-address-book-o" aria-hidden="true"></i>'.$row["Nombre"].'
											</div>
										</a>
								</div>';
			}
			else if($row["Nivel1"]==5){
					$Valor5=$Valor5.'<div class="row ItemElmMenu">
										<a href="'.$row["Enlace"].'" class="'.$row["Clase"].'">
											<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
												<i class="fas fa-angle-double-right f-18"></i> <i class="fa fa-address-book-o" aria-hidden="true"></i>'.$row["Nombre"].'
											</div>
										</a>
									</div>';
			}
			else if($row["Nivel1"]==6){
					$Valor6=$Valor6.'<div class="row ItemElmMenu">
										<a href="'.$row["Enlace"].'" class="'.$row["Clase"].'">
											<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
												<i class="fas fa-angle-double-right f-18"></i> <i class="fa fa-address-book-o" aria-hidden="true"></i>'.$row["Nombre"].'
											</div>
										</a>
									</div>';
			}
		}
		if($Valor1!=''){
			$Valor1='<div class="col-xl-2 col-md-4 col-sm-6 col-xs-12 p-l-30 p-r-30">
										<div class="row p-t-10 p-b-10 Titlemenu">
											Principal
										</div>
										'.$Valor1.'
					</div>';
		}
		if($Valor2!=''){
			$Valor2='<div class="col-xl-4 col-md-4 col-sm-6 col-xs-12 p-l-30 p-r-30">
										<div class="row p-t-10 p-b-10 Titlemenu">
											Registro
										</div>
										'.$Valor2.'
							</div>';
		}
		if($Valor3!=''){
			
		}
		if($Valor4!=''){
			$Valor4='<div class="col-xl-2 col-md-4 col-sm-6 col-xs-12 p-l-30 p-r-30">
										<div class="row p-t-10 p-b-10 Titlemenu">
											User y Caja
										</div>
										'.$Valor4.'
					</div>';
		}
		if($Valor5!=''){
			$Valor5='<div class="col-xl-2 col-md-4 col-sm-6 col-xs-12 p-l-30 p-r-30">
										<div class="row p-t-10 p-b-10 Titlemenu">
											Reportes
										</div>
										'.$Valor5.'
					</div>';
		}
		if($Valor6!=''){
			$Valor6='<div class="col-xl-2 col-md-4 col-sm-6 col-xs-12 p-l-30 p-r-30">
										<div class="row p-t-10 p-b-10 Titlemenu">
											Mantenimiento
										</div>
										'.$Valor6.'
					</div>';
		}
		
		$Valor=$Valor1.$Valor2.$Valor3.$Valor4.$Valor5.$Valor6;
		return $Valor;
	}
	public function almacenController(){
		$respuesta = homeModel::getList_UserAlm($_SESSION["UserTRPE"]["IdUser"],$_SESSION["UserTRPE"]["IdCompany"]);
		$Valor='';
		if(count($respuesta)>0){
			foreach ($respuesta as $row){
				$Valor=$Valor.'<option value="'.$row["IdAlmacen"].'" data-colorfondo="'.$row["ColorFondo"].'" data-colortexto="'.$row["ColorTexto"].'">'.$row["Almacen"].'</option>';
			}
		}else{
			$Valor=$Valor.'<option value="-1">Almacen</option>';
		}
		return $Valor;
	}
	public function combo_Almacen_Id(){
		$respuesta=array();
		if (isset($_GET['alm']) && $_GET['alm']!="undefined"){
			$valR=$_GET['alm'];
			$respuesta = homeModel::getList_Almacen_IdAlm($valR);
		}
		return $respuesta;
	}
	public function productController(){
		$respuesta = homeModel::getList_Mante_Productos();
		
		if(count($respuesta)>0){
			foreach ($respuesta as $row){
				echo '<tr>
						<td></td>
						<td>'.$row["Codigo"].'</td>
						<td>'.$row["Producto"].'</td>
						<td>'.$row["Marca"].'</td>
						<td>'.$row["Modelo"].'</td>
						<td>'.$row["Unidad"].'</td>
						<td>'.$row["Anio"].'</td>
						<td>'.$row["CodigoFabricante"].'</td>
						<td>'.$row["StockMinimo"].'</td>
						<td>'.$row["Est"].'</td>
					</tr>';
			}
		}
	}
	
	public function combo_Almacen_Venta(){
		$respuesta=array();
		$Comprobante='<option value="-1">Seleccione</option>';
		$TipoDoc='<option value="-1">Seleccione</option>';
		$Empresa='<option value="-1">Seleccione</option>';
		if (isset($_GET['alm']) && $_GET['alm']!="undefined"){
			$valR=$_GET['alm'];
			$respuesta = homeModel::getList_ventas($valR);
			//array("Alm"=>$Alm,"Comprobante"=>$Comprobante,"TipoDoc"=>$TipoDoc,"Empresa"=>$Empresa);
			$Comprobante=MvcController::Build_combo($respuesta["Comprobante"]);
			//$TipoDoc=MvcController::Build_combo($respuesta["TipoDoc"]);
			$Empresa=MvcController::Build_combo($respuesta["Empresa"]);
		}
		return array("Alm"=>$respuesta["Alm"],"Comprobante"=>$Comprobante,"TipoDoc"=>$TipoDoc,"Empresa"=>$Empresa);
	}
	public function Build_combo($Datos){
		$Valor='';
		if(count($Datos)>0){
			foreach ($Datos as $row){
				$Valor=$Valor.'<option value="'.$row["Id"].'">'.$row["Nombre"].'</option>';
			}
		}else{
			$Valor=$Valor.'<option value="-1">Seleccione</option>';
		}
		return $Valor;
	}
	/* controlador para reporte venta */
	public function combo_Almacen_ReportVenta(){
		$respuesta=array();
		$Empresa='<option value="-1">Seleccione</option>';
		if (isset($_GET['alm']) && $_GET['alm']!="undefined"){
			$valR=$_GET['alm'];
			$respuesta = homeModel::getList_ReportVentas($valR);
			$Empresa=MvcController::Build_combo($respuesta["Empresa"]);
		}
		return array("Alm"=>$respuesta["Alm"],"Empresa"=>$Empresa);
	}
	public function combo_ImportarProducto(){
		$respuesta = homeModel::getList_ExportarProducto();
		$Alm=MvcController::Build_combo($respuesta["Alm"]);
		return array("Alm"=>$Alm);
	}
	
	
}
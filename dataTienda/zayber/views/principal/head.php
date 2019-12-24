<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Zayber</title>
	
	<link rel="stylesheet" type="text/css" href="assets/css/jquery-ui.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	
	<link rel="stylesheet" type="text/css" href="assets/css/component.css">
	<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/pignose.calendar.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/c3.css">
	<link rel="stylesheet" type="text/css" href="assets/css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" type="text/css" href="assets/css/chosen.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/vex.css">
	<link rel="stylesheet" type="text/css" href="assets/css/vex-theme-os.css">
	<link rel="stylesheet" type="text/css" href="assets/css/alertify.core.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/alertify.default.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/all.css">
	
	<script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/jquery-resizable.js"></script>
	<script type="text/javascript" src="assets/js/jspdf.debug.js"></script>
	
	<script type="text/javascript" src="assets/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/js/dataTables.keyTable.js"></script>
	<script type="text/javascript" src="assets/js/dataTables.keyTable.js"></script>
	<link rel="shortcut icon" href="./assets/images/invoice.png">
<body>
	<div id="modal_Manten"></div><div id="modal_Secundary"></div>
	<script> var url_ajax_request = "services/index.php";</script>
	<div class="row claFondoHead p-t-10 p-b-10">
		<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xl-1 col-md-2 col-sm-2 col-xs-4">
				<a href="home" class="claTitleFecha">
					<i class="fa fa-home f-40"></i></br>Inicio
				</a>
			</div>

			<div class="col-xl-3 col-md-4 col-sm-5 col-xs-8 EmpresaSt center" id="headerEmpresaDatos">
				<span>CORPORACION ZAYBER</span></br> <strong>Sistema de ventas</strong>
			</div>
			<div class="col-xl-2 col-md-6 col-sm-5 col-xs-12 center" id="headerEmpresaAlmacenes">
				<label Id="IdLabelTitleAlmacen" class="claAlmName"></label>
				<select id="IdAlmacenPri" class="AlmSelect" name="nmregionvos">
				<?php 
					$controller = new MvcController();$pDatos=$controller->almacenController(); echo $pDatos; ?>
				</select>
			</div>
			<div class="col-xl-3 col-md-12 col-sm-12 col-xs-12 center" id="headerEmpresaUsuarioTypo">
				<?php //echo $_SESSION['UserTRPE']["TypeUser"] ?>
			</div>
			<div class="col-xl-2 col-md-10 col-sm-8 col-xs-6 usersys right" id="headerEmpresaUsuarioDatos">
				<h2>Bienvenido</br><strong id="IdUserr"><?php echo $_SESSION['UserTRPE']["nombre"] ?></strong></h2>
			</div>

			<div class="col-xl-1 col-md-2 col-sm-4 col-xs-6 right">
				<a href="login" class="claTitleFecha">
					<i class="fa fa-times f-40"></i></br>Salir
				</a>
			</div>
		</div>
	</div>

			
<div id="pcoded" class="pcoded">

<div class="pcoded-container navbar-wrapper">
<div class="pcoded-main-container claFondoMain">
<div class="pcoded-wrapper">

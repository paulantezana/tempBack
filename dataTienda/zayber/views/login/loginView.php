<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
	
	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Zayber</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript" src="assets/js/jquery-1.12.4.js"></script> 
</head>
<body>
	<div class="main-body claInicioS" style="height: 100%;">
		<div class="page-wrapper">
			<div class="page-body">
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-2 col-sm-2 col-xs-1"></div>
					<div class="col-xl-4 col-lg-4 col-md-8 col-sm-8 col-xs-10">
						<div class="row claRowBord">
							<form name="frmlogin" action="home" method="POST">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 claTitleInicio">
								Bienvenido a tu sistema de ventas</br>
								<span class="f-40">SKYStore </span>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 p-t-10">
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 p-t-10">
								Nombre de usuario</br>
								<input type="text" class="claInputIS" name="userFACTR"  placeholder="Escribe tu nombre de usuario"/>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 p-t-10">
								Contraseña</br>
								<input type="password" class="claInputIS" name="passFACTR" placeholder="Escribe tu contraseña"/>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 p-t-10">
								<button class="btn btn-danger btn-round btn-block claBtnIS">INICIAR SESION</button>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 center">
									<?php // if(!isset($_SESSION['nombreusuario'])){require 'btn.php'; }
									?>
									<?php if (!empty($enviar)): ?>
										 <div class="enviar">
											 <?php echo $enviar;  ?>
										 </div>
									<?php echo $enviado; ?> 
									<?php endif; ?>
									<br>
									<?php if(!empty($error)): ?>
										<br>
										<div class="error">                
											 <?php echo $error ?>
									   </div>
									<?php endif; ?>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
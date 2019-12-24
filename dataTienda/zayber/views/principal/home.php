<?php 
	//CONTRUIS MENU DEL USER
	$controller = new MvcController();
	$pDatos=$controller->menuController();
	//echo $pDatos;
	//print_r($pDatos);
?>
<div class="row">
	<?php echo $pDatos; ?>
<script src="./views/principal/home.js"></script>

	
	
	
	
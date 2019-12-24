<?php require 'principal/head.php';?>
	<div class="row claPrinFirtPadding" id="IdContentFirst">
	<?php
		$mvc=new MvcController();
		$mvc->enlacesPaginasController();
	?>
	</div>
	<div class="row" id="IdContentSecond">
	<?php 
		//require 'slide/slide.php'
	?>
	</div>
	<div class="row" id="IdContentThird">
	<?php 
		//$mvc=new MvcController();
		//$mvc->enlacesPaginasController();
	?>
	</div>
	<?php 
	//$mvc=new MvcController();
	//$mvc->enlacesPaginasController();
	
	require 'principal/footer.php'; 
?>
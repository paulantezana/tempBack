<?php 
	session_start();
	require_once("model/config/conexion.php");		
	require_once("model/functions_query.php");		
		
if (!isset($_SESSION['UserTRPE'])){
	//session_destroy();
	require "views/login/login.php";
}else{
	require_once 'model/enlaces.php';
	require_once 'model/homeModel/homeModel.php';
	
	require_once 'controller/homeController/homeController.php';
	
	$index = new MvcController();
	$index->plantilla();
}
?>

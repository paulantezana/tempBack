<?php
  session_start();

  require_once("config.php");

  $router = new Router();
  $conectarBD = new DataBaseConexion();
  $controller = new $router->controller($conectarBD->GetConexion(), $router->param);
  $method = $router->method;
  $controller->$method();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>OSE - Proyectos</title>
  <!-- <link rel="icon" href="/HananPacha/img/logo_skynet.png"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/bootstrap.bundle.js"></script>
  <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/Common.js"></script>
  <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/all.js"></script>
  <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/sweetalert2.js"></script>

  <link rel="stylesheet" type="text/css" href="<?= FOLDER_NAME ?>/Asset/Css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="<?= FOLDER_NAME ?>/Asset/Css/sweetalert2.css"/>
  <link rel="stylesheet" type="text/css" href="<?= FOLDER_NAME ?>/Asset/Css/StyleSheet.css"/>
</head>
<body style="background-color: white;">
<?php
if (isset($_COOKIE["MainMenu"])) {
  echo $_COOKIE["MainMenu"];
}else{
  header("Refresh:0");
}
?>
  <div class="container-fluid">
    <div class="row">
      <h3>Plantilla</h3>
    </div>
    <?php echo $content ?>
  </div>
</body>
<footer>
</footer>
</html>

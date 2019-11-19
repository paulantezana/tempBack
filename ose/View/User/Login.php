<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
  <title>OSE - Skynet</title>
  <!-- <link rel="icon" href="/HananPacha/img/logo_skynet.png"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

  <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/bootstrap.bundle.js"></script>
  <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/Common.js"></script>
  <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/all.js"></script>

  <link rel="stylesheet" type="text/css" href="<?= FOLDER_NAME ?>/Asset/Css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="<?= FOLDER_NAME ?>/Asset/Css/StyleSheet.css"/>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-6">
        <div class="card">
          <div class="card-body text-center">
            <h5 class="card-title">Autenticación</h5>
            <form class="login-form" action="<?= FOLDER_NAME ?>/UserLogin/Login" method="post">
              <div class="form-group">
                <i class="fas fa-at"></i>
                <input name="correo" type="email" class="form-control" placeholder="Correo electrónico" required="required" value="">
              </div>
              <div class="form-group">
                <i class="fas fa-key"></i>
                <input name="password" type="password" class="form-control" placeholder="Contraseña" required="required" value="">         
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block btn-lg" value="Acceder">
              </div>
              <div class="form-group">
                <?php if (isset($error)) {echo $error;} ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<footer>
</footer>
</html>
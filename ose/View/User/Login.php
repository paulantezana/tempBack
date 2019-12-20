<div class="d-flex justify-content-center">
    <div class="card" style="width: 400px">
        <div class="card-body pt-5 pb-5">
            <h4 class="card-title text-center mb-4">Iniciar Sesión</h4>
            <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>
            <form class="login-form" action="<?= FOLDER_NAME ?>/UserLogin/Login" method="post">
                <div class="form-group">
                    <label for="email"><i class="icon-envelop mr-2"></i>Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="password"><i class="icon-lock2 mr-2"></i>Contraseña</label>
                    <input name="password" type="password" id="password" class="form-control" required="required" >
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="Acceder">
                </div>
                <div class="text-center">
                    <a href="<?= FOLDER_NAME . '/UserLogin/RecoverPassword' ?>">¿Olvidaste la Contraseña?</a>
                    <div>¿No tienes cuenta? <a href="<?= FOLDER_NAME . '/UserLogin/Register' ?>">Regístrate</a></div>
                </div>
            </form>
        </div>
    </div>
</div>

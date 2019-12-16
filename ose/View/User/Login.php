<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Autenticación</h5>
                    <form class="login-form" action="<?= FOLDER_NAME ?>/UserLogin/Login" method="post">
                        <div class="form-group">
                            <label for="email"><i class="icon-envelop mr-2"></i>Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="correo" placeholder="Correo electrónico" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="icon-lock2 mr-2"></i>Contraseña</label>
                            <input name="password" type="password" id="password" class="form-control" placeholder="Contraseña" required="required" >
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" value="Acceder">
                        </div>
                        <a href="<?= FOLDER_NAME . '/UserLogin/RecoverPassword' ?>">¿Olvidaste la Contraseña?</a>
                        <div class="form-group">
                            <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

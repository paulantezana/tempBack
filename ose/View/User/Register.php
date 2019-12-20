<div class="d-flex justify-content-center">
    <div class="card" style="width: 800px">
        <div class="card-body pt-5 pb-5">
            <h4 class="text-center mb-4">Registrarse</h4>
            <?php require_once __DIR__ . '/Partial/AlertMessage.php'; ?>
            <form action="<?= FOLDER_NAME . '/UserLogin/Register' ?>" method="POST">
                <div class="form-group">
                    <label for="registerRuc"><i class="icon-briefcase mr-2"></i>RUC</label>
                    <input type="text" class="form-control" name="register[ruc]" id="registerRuc" required>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="registerEmail"><i class="icon-envelop mr-2"></i>Email</label>
                        <input type="email" class="form-control" id="registerEmail" name="register[email]">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="registerUserName"><i class="icon-users2 mr-2"></i>Nombre de usuario</label>
                        <input type="text" class="form-control" id="registerUserName" name="register[userName]">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="password"><i class="icon-lock2 mr-2"></i>Contraseña</label>
                        <input name="register[password]" type="password" id="password" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="passwordConfirm"><i class="icon-lock2 mr-2"></i>Confirmar Contraseña</label>
                        <input name="register[passwordConfirm]" type="password" id="passwordConfirm" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary" name="commit">Registrarse</button>
                </div>
            </form>
            <a href="<?= FOLDER_NAME . '/UserLogin'?>" class="btn btn-light btn-block">Login</a>
        </div>
    </div>
</div>

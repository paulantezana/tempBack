<div class="d-flex justify-content-center">
    <div class="card" style="width: 400px">
        <div class="card-body pt-5 pb-5">
            <h4 class="text-center mb-4">Recuperar Contraseña</h4>
            <?php require_once __DIR__ . '/Partial/AlertMessage.php'; ?>
            <?php if (($parameter['contentType'] === 'validateToken' && $parameter['messageType'] === 'success') || ($parameter['contentType'] === 'changePassword'  && $parameter['messageType'] === 'danger')):  ?>
                <form action="<?= FOLDER_NAME . '/UserLogin/RecoverPasswordValidate' ?>" method="POST">
                    <input type="hidden" name="userId" id="userId" value="<?php echo $parameter['user']['id_user'] ?? ''; ?>">
                    <div class="form-group">
                        <label for="password"><i class="icon-lock2 mr-2"></i>Contraseña</label>
                        <input name="password" type="password" id="password" class="form-control" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword"><i class="icon-lock2 mr-2"></i>Confirmar Contraseña</label>
                        <input name="confirmPassword" type="password" id="confirmPassword" class="form-control" placeholder="Confirmar Contraseña">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary" name="commit">Cambiar contraseña</button>
                    </div>
                </form>
            <?php endif; ?>
            <a href="<?= FOLDER_NAME . '/UserLogin'?>" class="btn btn-light btn-block">Login</a>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="card" style="width: 400px">
        <div class="card-body pt-5 pb-5">
            <h4 class="text-center mb-4">Recuperar Contraseña</h4>
            <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>
            <?php if (($parameter['messageType'] ?? '') !== 'success'): ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email"><i class="icon-envelop mr-2"></i>Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">
                            Ingresa tu correo electrónico para buscar tu cuenta
                        </small>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="commit" class="btn btn-primary btn-block">
                            <i class="icon-search4 mr-2"></i> Buscar
                        </button>
                    </div>
                </form>
            <?php endif; ?>
            <a href="<?= FOLDER_NAME . '/UserLogin'?>" class="btn btn-light btn-block mb-3">Login</a>
        </div>
    </div>
</div>

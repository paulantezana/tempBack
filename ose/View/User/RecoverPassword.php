<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Recuperar Contraseña</h5>
                    <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>
                    <?php if (($parameter['messageType'] ?? '') !== 'success'): ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="email"><i class="icon-envelop mr-2"></i>Ingresa tu correo electrónico para buscar tu cuenta</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" aria-describedby="emailHelp">
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
    </div>
</div>

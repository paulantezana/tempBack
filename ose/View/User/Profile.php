<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Perfil</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Seguridad</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <form action="<?php echo FOLDER_NAME . '/User/Profile' ?>" method="POST">
                        <div class="row mt-4">
                            <div class="form-group col-lg-6">
                                <label for="email" class="SnForm-label"><i class="icon-envelop mr-2"></i> Correo electrónico <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Nombre completo" value="<?= $parameter['user']['email'] ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="names" class="SnForm-label"><i class="icon-user mr-2"></i> Nombre completo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="names" name="names" placeholder="Nombre completo" value="<?= $parameter['user']['names'] ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phone" class="SnForm-label"><i class="icon-phone2 mr-2"></i> Teléfono <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono" value="<?= $parameter['user']['phone'] ?>">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="address" class="SnForm-label"><i class="icon-home2 mr-2"></i> Dirección</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="<?= $parameter['user']['address'] ?>">
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="submit" class="btn btn-primary" name="commit">
                                    <i class="icon-floppy-disk mr-2"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <form action="<?php echo FOLDER_NAME . '/User/Profile' ?>" method="POST">
                        <div class="row mt-4">
                            <div class="form-group col-lg-6">
                                <label for="password"><i class="icon-lock2 mr-2"></i> Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="confirmPassword"><i class="icon-lock2 mr-2"></i> Confirmar Contraseña <span class="text-danger">*</span></label>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirmar Contraseña" required>
                            </div>
                            <div class="form-group col-lg-12">
                                <button type="submit" class="btn btn-primary" name="commitChangePassword">
                                    <i class="icon-floppy-disk mr-2"></i> Guardar contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

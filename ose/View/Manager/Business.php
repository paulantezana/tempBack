<div class="container pb-3 pt-3">
    <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>
    <h1>Empresas</h1>
    <button onclick="Business.showModalCreate()" class="btn btn-primary">Nuevo</button>
    <div id="businessTable"></div>
    <script src="<?php echo FOLDER_NAME . '/Asset/Js/Manager/Business.js' ?>"></script>

    <!-- Modal -->
    <div class="modal fade" id="businessModal" tabindex="-1" role="dialog" aria-labelledby="businessModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="businessModalTitle">Empresa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="businessForm" onsubmit="Business.submit(event)">
                        <input type="hidden" name="businessId">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="businessRuc">R.U.C.</label>
                                <input type="text" class="form-control" id="businessRuc" name="businessRuc" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="businessSocialReason">Razón social</label>
                                <input type="text" class="form-control" id="businessSocialReason" name="businessSocialReason" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="businessCommercialReason">Nombre Comercial</label>
                                <input type="text" class="form-control" id="businessCommercialReason" name="businessCommercialReason" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="businessPhone">Teléfonos</label>
                                <input type="text" class="form-control" id="businessPhone" name="businessPhone" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="businessEmail">Email</label>
                                <input type="email" class="form-control" id="businessEmail" name="businessEmail" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="businessDetractionBankAccount">Cuenta bancaria de detraccion CCI</label>
                            <input type="text" class="form-control" id="businessDetractionBankAccount" name="business[detraction_bank_account]">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="userName">Usuario</label>
                                <input type="text" class="form-control" id="userName" name="userName">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="userPassword">Contraseña</label>
                                <input type="password" class="form-control" id="userPassword" name="userPassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="file" name="businessLogo" id="businessLogo"  accept="image/png,image/jpeg,image/jpg">
                            <label class="form-check-label" for="businessLogo">Logotipo en formato .JPG para Facturas (320px por 80px) menos de 20 KB </label>
                        </div>
                        <button type="submit" id="businessSubmit" class="btn btn-primary btn-block">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

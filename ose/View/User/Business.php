<div class="container pb-3 pt-3">
    <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>

    <form action="<?= FOLDER_NAME . '/Business/Update' ?>" method="POST" class="mb-4" enctype="multipart/form-data">
        <input type="hidden" value="<?= $parameter['business']['business_id'] ?? 0 ?>" name="business[business_id]">
        <div class="card mb-4">
            <div class="card-header">
                DATOS DEL EMISOR
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="ruc">RUC</label>
                        <input type="text" class="form-control <?= ($parameter['error']['ruc'] ?? false) ? 'is-invalid' : '' ?>"
                               id="ruc" name="business[ruc]" value="<?= $parameter['business']['ruc'] ?? '' ?>" required>
                        <div class="invalid-feedback">
                            <?= ($parameter['error']['ruc']['messages'] ?? false) ? $parameter['error']['ruc']['messages'][0] : ''  ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="socialReason">Razón social o nombre completo </label>
                        <input type="text" class="form-control <?= ($parameter['error']['social_reason'] ?? false) ? 'is-invalid' : '' ?>"
                               id="socialReason" name="business[social_reason]" value="<?= $parameter['business']['social_reason'] ?? '' ?>" required>
                        <div class="invalid-feedback">
                            <?= ($parameter['error']['social_reason']['messages'] ?? false) ? $parameter['error']['social_reason']['messages'][0] : ''  ?>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="commercialReason">Razón comercial (OPCIONAL)</label>
                        <input type="text" class="form-control" id="commercialReason" name="business[commercial_reason]" value="<?= $parameter['business']['commercial_reason'] ?? '' ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="phone">Teléfonos</label>
                        <input type="text" class="form-control" id="phone" name="business[phone]" value="<?= $parameter['business']['phone'] ?? '' ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="email">Email de esta empresa</label>
                        <input type="email" class="form-control" id="email" name="business[email]" value="<?= $parameter['business']['email'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="webSite">Página Web (OPCIONAL)</label>
                        <input type="text" class="form-control" id="webSite" name="business[web_site]" value="<?= $parameter['business']['web_site'] ?? '' ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="detractionBankAccount">Cuenta bancaria de detraccion CCI</label>
                        <input type="text" class="form-control" id="detractionBankAccount" name="business[detraction_bank_account]" value="<?= $parameter['business']['detraction_bank_account'] ?? '' ?>">
                    </div>
                </div>
                <div class="form-group form-check">
                    <?php $isChecked = ($parameter['business']['include_igv'] ?? false) ? 'checked' : ''; ?>
                    <input type="checkbox" <?= $isChecked ?> class="form-check-input" id="includeIgv" name="business[include_igv]">
                    <label class="form-check-label" for="includeIgv">Activar Precio Unitario (CON IGV), por defecto se usa el VALOR SIN IGV</label>
                </div>
<!---->
<!--                <div class="form-group form-check">-->
<!--                    --><?php
//                    $isChecked = $parameter['business']['continue_payment'] ?? false;
//                    $isChecked = $isChecked ? 'checked' : '';
//                    ?>
<!--                    <input type="checkbox" --><?//= $isChecked ?><!-- class="form-check-input" id="continuePayment" name="business[continue_payment]">-->
<!--                    <label class="form-check-label" for="continuePayment">Deshabilitar Continuar con el pago? (Punto de Venta y Compras)</label>-->
<!--                </div>-->
<!---->
<!--                <div class="form-group form-check">-->
<!--                    <label class="form-check-label" for="totalCalculationItem">Tipo de cálculo desde TOTAL en los items</label>-->
<!--                    <select name="business[total_calculation_item]" id="totalCalculationItem" class="form-control">-->
<!--                        <option --><?php //echo ($parameter['business']['total_calculation_item'] ?? '') == 'amount' ? 'selected' : '' ?><!-- value="amount">Modificar Cantidad</option>-->
<!--                        <option --><?php //echo ($parameter['business']['total_calculation_item'] ?? '') == 'unit_price' ? 'selected' : '' ?><!-- value="unit_price">Modificar Valor unitario</option>-->
<!--                    </select>-->
<!--                </div>-->
                <div class="col col-md-6">
                    <img
                            src="<?php echo FOLDER_NAME . '/' .  ($parameter['business']['logo'] ?? '') ?>" alt="logo emisor electronico"
                            style="width: 320px; height: 80px; background: #F5F5F5; display: block;"
                    >
                </div>
                <div class="form-group">
                    <input type="file" name="businessLogo" id="businessLogo"  accept="image/png,image/jpeg,image/jpg">
                    <label class="form-check-label" for="businessLogo">Logotipo en formato .JPG para Facturas (320px por 80px) menos de 20 KB </label>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="businessCommit">Guardar</button>
            </div>
        </div>
    </form>
</div>

<div class="container pt-5 pb-5">

    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>

    <div class="row mb-5">
        <h1>
            <span>⛒</span>
            <span>Comunicar de baja</span>
        </h1>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form action="<?= FOLDER_NAME . '/SaleVoided/NewSaleVoided'?>" method="POST">
                <div class="form-group">
                    <label for="saleVoidedSaleId">Buscar documento a anular</label>
                    <select class="selectpicker with-ajax filterSaleSearch" data-live-search="true" id="saleVoidedSaleId" name="saleVoided[saleId]" data-width="100%" required>
                        <?php if($parameter['saleVoided']['sale']['saleId'] ?? false) :  ?>
                            <option value="<?= $parameter['saleVoided']['sale']['saleId'] ?? 0?>" selected><?= $parameter['saleVoided']['sale']['description'] ?? ''?></option>
                        <?php endif; ?>
                    </select>
                    <div class="invalid-feedback saleVoidedSaleId-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="saleVoidedReason">Motivo</label>
                    <input type="text" class="form-control <?= ($parameter['error']['reason'] ?? false) ? 'is-invalid' : '' ?>"
                           id="saleVoidedReason" name="saleVoided[reason]" value="<?= $parameter['saleVoided']['reason'] ?? ''?>">
                    <div class="invalid-feedback">
                        <?= $parameter['error']['reason']['messages'][0] ?? '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" name="commit" id="jsSaleVoidedFormCommit" class="btn btn-primary btn-block">Crear Comunicación de baja</button>
                </div>
            </form>
        </div>
    </div>
</div>
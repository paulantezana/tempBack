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
            <form action="<?= FOLDER_NAME . '/SaleNoteVoided/NewSaleNoteVoided'?>" method="POST">
                <div class="form-group">
                    <label for="saleNoteVoidedSaleNoteId">Buscar documento a anular</label>
                    <select class="selectpicker with-ajax filterSaleNoteSearch" data-live-search="true" id="saleNoteVoidedSaleNoteId" name="saleNoteVoided[saleNoteId]" data-width="100%" required>
                        <?php if($parameter['saleNoteVoided']['saleNote']['saleNoteId'] ?? false) :  ?>
                            <option value="<?= $parameter['saleNoteVoided']['saleNote']['saleNoteId'] ?? 0?>" selected><?= $parameter['saleNoteVoided']['saleNote']['description'] ?? ''?></option>
                        <?php endif; ?>
                    </select>
                    <div class="invalid-feedback saleNoteVoidedSaleNoteId-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="saleNoteVoidedReason">Motivo</label>
                    <input type="text" class="form-control <?= ($parameter['error']['reason'] ?? false) ? 'is-invalid' : '' ?>"
                           id="saleNoteVoidedReason" name="saleNoteVoided[reason]" value="<?= $parameter['saleNoteVoided']['reason'] ?? ''?>">
                    <div class="invalid-feedback">
                        <?= $parameter['error']['reason']['messages'][0] ?? '' ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" name="commit" id="jsSaleNoteVoidedFormCommit" class="btn btn-primary btn-block">Crear Comunicación de baja</button>
                </div>
            </form>
        </div>
    </div>
</div>
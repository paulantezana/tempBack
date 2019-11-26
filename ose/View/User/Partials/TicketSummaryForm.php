<!-- Modal Cliente -->
<div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="summaryModalLabel">Generar resumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="summaryForm" action="<?= FOLDER_NAME . '/InvoiceSummary' ?>" method="POST">
                    <div class="form-group">
                        <label for="dateOfReference">Selecciona cuidadosamente el día.</label>
                        <input type="date" class="form-control" id="dateOfReference" name="dateOfReference">
                    </div>
                    <div class="form-group">
<!--                        <input type="submit" name="commit" value="Generar comprobante" class="btn btn-primary ml-4">-->
                        <button type="submit" class="btn btn-primary btn-block" name="dateOfReferenceCommit">GENERAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

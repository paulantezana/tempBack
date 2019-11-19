<div class="modal fade" id="summaryGeneralModal" tabindex="-1" role="dialog" aria-labelledby="summaryGeneralModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="summaryGeneralModalLabel">Proceso automático general</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Con esta opción se generara resúmenes diarios por cada cliente y se enviara a la SUNAT cada 500 comprobantes.</p>
                <form id="summaryForm" action="<?= FOLDER_NAME . '/Summary' ?>" method="POST">
                    <div class="form-group">
                        <label for="summaryInterval">Intervalo.</label>
                        <input type="number" min="1" max="500" class="form-control" id="summaryInterval" name="summary[interval]" value="499">
                    </div>
                    <div class="form-group">
                        <label for="summaryDateOfReference">Selecciona cuidadosamente el día.</label>
                        <input type="date" class="form-control" id="summaryDateOfReference" name="summary[dateOfReference]">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" name="summaryGeneralCommit">GENERAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
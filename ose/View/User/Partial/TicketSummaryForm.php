<!-- Modal Cliente -->
<div class="modal fade" id="summaryModal" tabindex="-1" role="dialog" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"><i class="icon-file-plus mr-2"></i> Generar resumen</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="summaryForm" action="<?= FOLDER_NAME . '/InvoiceSummary' ?>" method="POST">
                    <div class="form-group">
                        <label for="dateOfReference"><i class="icon-calendar2 mr-2"></i> Selecciona una Fecha:<span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" name="dateOfReference" id="dateOfReference" placeholder="Selecciona una Fecha" aria-label="Selecciona una Fecha" aria-describedby="dateOfReferenceRef">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="dateOfReferenceRef" onclick="GetInvoiceNotSummary()"><i class="icon-search4"></i></button>
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo</th>
                                <th>Serie</th>
                                <th>Correlativo</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr></tr>
                        </tbody>
                    </table>

                    <div class="text-right">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" name="dateOfReferenceCommit">Crear Resúmen de Boletas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="summaryCustomerModal" tabindex="-1" role="dialog" aria-labelledby="summaryCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="summaryCustomerModalLabel">Proceso automático por cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="summaryForm" action="<?= FOLDER_NAME . '/Summary' ?>" method="POST">
                    <p>Se generar los resúmenes diarios por el cliente o usuario seleccionado</p>
                    <div class="form-group">
                        <label for="summaryReferenceUser">Usuario</label>
                        <select class="custom-select" name="summary[referenceUser]"  id="summaryReferenceUser">
                            <?php  foreach ($parameter['user'] ?? [] as $row): ?>
                                <option value="<?= $row['id_user'] ?>"><?= $row['names'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="summaryInterval">Intervalo.</label>
                        <input type="number" min="1" max="500" class="form-control" id="summaryInterval" name="summary[interval]" value="499">
                    </div>
                    <div class="form-group">
                        <label for="summaryDateOfReference">Selecciona cuidadosamente el día.</label>
                        <input type="date" class="form-control" id="summaryDateOfReference" name="summary[dateOfReference]">
                    </div>
                    <div class="form-group">
                        <!--                        <input type="submit" name="commit" value="Generar comprobante" class="btn btn-primary ml-4">-->
                        <button type="submit" class="btn btn-primary btn-block" name="summaryCustomerCommit">GENERAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="summaryCustomModal" tabindex="-1" role="dialog" aria-labelledby="summaryCustomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="summaryCustomModalLabel">Resumen personalizado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="summaryForm" action="<?= FOLDER_NAME . '/Summary' ?>" method="POST">
                    <div class="form-group">
                        <label for="summaryUserReferenceId">Usuario</label>
                        <select class="custom-select" name="summary[userReferenceId]"  id="summaryUserReferenceId">
                            <?php  foreach ($parameter['user'] ?? [] as $row): ?>
                                <option value="<?= $row['id_user'] ?>"><?= $row['names'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr style="font-size: 14px">
                                    <th>Comprobante</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="detailCustomSummaryTableBody">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10">
                                        <div class="btn btn-primary btn-sm" id="addItemCustomSummary" data-itemtemplate="">Agregar Item</div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" name="summaryCustomCommit">GENERAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
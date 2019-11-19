<div class="container">
    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>
    <div class="card mt-4">
        <div class="card-body">
            <form action="" method="post">
                <input type="hidden" name="businessLocal[business_local_id]" value="<?= $parameter['businessLocal']['business_local_id'] ?? 0 ?>">
                <input type="hidden" name="businessLocal[business_id]" value="<?= $parameter['businessLocal']['business_id'] ?? 0 ?>">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="businessLocalSunatCode">Código Sunat</label>
                        <input type="text" name="businessLocal[sunat_code]" class="form-control" id="businessLocalSunatCode" value="<?= $parameter['businessLocal']['sunat_code'] ?? '' ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="businessLocalShortName">Nombre corto</label>
                        <input type="text" name="businessLocal[short_name]" class="form-control" id="businessLocalShortName" value="<?= $parameter['businessLocal']['short_name'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="businessLocalLocationCode">Ubigeo INEI</label>
                        <input type="text" name="businessLocal[location_code]" class="form-control" id="businessLocalLocationCode" value="<?= $parameter['businessLocal']['location_code'] ?? '' ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="businessLocalDepartment">Departamento</label>
                        <input type="text" name="businessLocal[department]" class="form-control" id="businessLocalDepartment" value="<?= $parameter['businessLocal']['department'] ?? '' ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="businessLocalProvince">Provincia</label>
                        <input type="text" name="businessLocal[province]" class="form-control" id="businessLocalProvince" value="<?= $parameter['businessLocal']['province'] ?? '' ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="businessLocalDistrict">Distrito</label>
                        <input type="text" name="businessLocal[district]" class="form-control" id="businessLocalDistrict" value="<?= $parameter['businessLocal']['district'] ?? '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="businessLocalAddress">Dirección exacta</label>
                    <input type="text" name="businessLocal[address]" class="form-control" id="businessLocalAddress" value="<?= $parameter['businessLocal']['address'] ?? '' ?>">
                </div>
                <div class="mb-5">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr style="font-size: 14px">
                                <th>Documento</th>
                                <th>Serie</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="businessLocalSeriesTableBody">
                            <?php foreach ($parameter['businessLocal']['item'] as $key => $row): ?>
                                <tr id="businessLocalItem<?= $key ?>" data-uniqueId="<?= $key ?>">
                                    <td>
                                        <select class="form-control form-control-sm" id="documentCode<?= $key ?>"
                                                name="businessLocal[item][<?= $key ?>][document_code]" required>
                                            <?php foreach ($parameter['documentTypeCode'] as $keyOpt => $rowOpt): ?>
                                                <?php if (($row['document_code'] ?? '') == $rowOpt['code']): ?>
                                                    <option value="<?= $rowOpt['code'] ?>" selected><?= $rowOpt['description'] ?></option>
                                                <?php else: ?>
                                                    <option value="<?= $rowOpt['code'] ?>"><?= $rowOpt['description'] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="businessLocal[item][<?= $key ?>][business_serie_id]" value="<?= isset($row['business_serie_id']) ? $row['business_serie_id'] : 0 ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" id="serie<?= $key ?>"
                                               name="businessLocal[item][<?= $key ?>][serie]" value="<?= isset($row['serie']) ? $row['serie'] : '1' ?>"  required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-light" title="Quitar item" onclick="BusinessLocal.removeItem(<?= $key ?>)">
                                            <i class="fas fa-times text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="btn btn-secondary btn-block btn-sm" data-itemtemplate="<?php echo htmlspecialchars(($parameter['itemTemplate'] ?? ''),ENT_QUOTES) ?>" onclick="BusinessLocal.addItem()" id="businessLocalAddItem">Agregar serie</div>

                </div>
                <div class="form-group">
                    <label for="businessLocalPdfInvoiceSize">Formato PDF</label>
                    <select name="businessLocal[pdf_invoice_size]" class="form-control" id="businessLocalPdfInvoiceSize" required>
                        <option value="A4" <?= ($parameter['businessLocal']['pdf_invoice_size'] ?? '') === 'A4' ? 'selected' : ''; ?>>TAMAÑO A4</option>
                        <option value="A5" <?= ($parameter['businessLocal']['pdf_invoice_size'] ?? '') === 'A5' ? 'selected' : ''; ?>>TAMAÑO A5 (MITAD DE A4)</option>
                        <option value="TICKET" <?= ($parameter['businessLocal']['pdf_invoice_size'] ?? '') === 'TICKET' ? 'selected' : ''; ?>>TAMAÑO TICKET</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="businessLocalPdfHeader">Texto en la CABECERA DEL PDF</label>
                    <input type="text" name="businessLocal[pdf_header]" class="form-control" id="businessLocalPdfHeader" value="<?= $parameter['businessLocal']['pdf_header'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label for="businessLocalDescription">Description</label>
                    <input type="text" name="businessLocal[description]" class="form-control" id="businessLocalDescription" value="<?= $parameter['businessLocal']['description'] ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="commit">Guardar</button>
            </form>
        </div>
    </div>
</div>

<script src="<?= FOLDER_NAME . '/Asset/Js/User/BusinessLocal.js'?>"></script>
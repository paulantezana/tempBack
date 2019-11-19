<!-- Modal Cliente -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="customerForm">
                    <input type="hidden" name="customer_id" readonly id="customerId">
                    <div class="form-group">
                        <label for="documentNumber">Número (RUC, DNI, Etc)</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="documentNumber" >
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="SearchPublicDocumentExtractor">
                                    Extraer
                                </button>
                            </div>
                            <div class="invalid-feedback documentNumber-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="identityDocumentCode">Tipo</label>
                        <select class="form-control" id="identityDocumentCode" >
                            <option value="">Elegir</option>
                            <?php foreach ($parameter['identityDocumentTypeCode'] ?? [] as $row): ?>
                                <option value="<?= $row['code']?>"><?= $row['description']?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback identityDocumentCode-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="social_reason">Razón social o nombre completo </label>
                        <input type="text" class="form-control" id="socialReason" >
                        <div class="invalid-feedback socialReason-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="commercialReason">Razón comercial (Marca)</label>
                        <input type="text" class="form-control" id="commercialReason">
                        <div class="invalid-feedback commercialReason-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="fiscalAddress">Dirección fiscal</label>
                        <input type="text" class="form-control" id="fiscalAddress">
                        <div class="invalid-feedback fiscalAddress-feedback"></div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="mainEmail">Email principal</label>
                                <input type="email" class="form-control" id="mainEmail">
                                <div class="invalid-feedback mainEmail-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="optionalEmail1">1er Email opcional</label>
                                <input type="email" class="form-control" id="optionalEmail1">
                                <div class="invalid-feedback optionalEmail1-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telefono</label>
                        <input type="text" min="0" class="form-control" id="telephone">
                        <div class="invalid-feedback telephone-feedback"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Cliente -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="customerModalLabel"><i class="icon-file-plus mr-2"></i> Registrar Nuevo Cliente</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="customerForm" onsubmit="Customer.submit(event)">
                    <input type="hidden" name="customer_id" readonly id="customerId">
                    <div class="form-group">
                        <label for="customerDocumentNumber"><i class="icon-user mr-2"></i>Número (RUC, DNI, Etc) <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="customerDocumentNumber" >
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="SearchPublicDocumentExtractor" onclick="Customer.searchPublicDocumentExtractor()">
                                    <i class="icon-search4"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback documentNumber-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="customerIdentityDocumentCode"><i class="icon-user mr-2"></i> Tipo de Documento de Identidad <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="customerIdentityDocumentCode" >
                            <option value="">Elegir</option>
                            <?php foreach ($parameter['identityDocumentTypeCode'] ?? [] as $row): ?>
                                <option value="<?= $row['code']?>"><?= $row['description']?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback identityDocumentCode-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="customerSocialReason"><i class="icon-users2 mr-2"></i> Razón social o nombre completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="customerSocialReason" >
                        <div class="invalid-feedback socialReason-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="customerCommercialReason"><i class="icon-users2 mr-2"></i> Razón comercial (Marca)</label>
                        <input type="text" class="form-control" id="customerCommercialReason">
                        <div class="invalid-feedback commercialReason-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="customerFiscalAddress"><i class="icon-address-book mr-2"></i> Dirección fiscal</label>
                        <input type="text" class="form-control" id="customerFiscalAddress">
                        <div class="invalid-feedback fiscalAddress-feedback"></div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="customerMainEmail"><i class="icon-envelop mr-2"></i> Email principal</label>
                                <input type="email" class="form-control" id="customerMainEmail">
                                <div class="invalid-feedback mainEmail-feedback"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="customerOptionalEmail1"><i class="icon-envelop mr-2"></i> 1er Email</label>
                                <input type="email" class="form-control" id="customerOptionalEmail1">
                                <div class="invalid-feedback optionalEmail1-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="customerTelephone"><i class="icon-phone2 mr-2"></i> Telefono</label>
                        <input type="text" min="0" class="form-control" id="customerTelephone">
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
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Nuevo producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="productForm">
                    <input type="hidden" readonly id="productProductId">
                    <div class="form-group">
                        <label for="productDescription">Nombre del producto o servicio </label>
                        <textarea class="form-control" id="productDescription" rows="2" required></textarea>
                        <div class="invalid-feedback productDescription-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="productProductCode">Código Producto SUNAT</label>
                        <select class="selectpicker with-ajax productCode" data-live-search="true" id="productProductCode" data-width="100%" required></select>
                        <div class="invalid-feedback productProduct_code-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="productUnitMeasureCode">Unidad de medida SUNAT</label>
                        <select id="productUnitMeasureCode" class="selectpicker with-ajax searchUnitMeasureTypeCode" data-live-search="true" data-width="100%" required></select>
                        <div class="invalid-feedback productUnitMeasureCode-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="productCurrencyCode">Moneda</label>
                        <select class="form-control" id="productCurrencyCode" required>
                            <?php foreach ($parameter['currencyTypeCode'] ?? [] as $row): ?>
                                <option value="<?= $row['code']?>"><?= $row['description']?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback productCurrencyCode-feedback"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="productUnitPricePurchase">COSTO unitario SIN IGV (costo de compra)</label>
                                <input type="number" step="any" class="form-control" id="productUnitPricePurchase">
                                <div class="invalid-feedback productUnitPricePurchase-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="productUnitPriceSale">VALOR VENTA unitario SIN IGV (al que se venderá)</label>
                                <input type="number" step="any" class="form-control" id="productUnitPriceSale">
                                <div class="invalid-feedback productUnitPriceSale-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="productUnitPricePurchaseIgv">Precio COMPRA unitario CON IGV (al que se compró)</label>
                                <input type="number" step="any" class="form-control" id="productUnitPricePurchaseIgv">
                                <div class="invalid-feedback productUnitPricePurchaseIgv-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="productUnitPriceSaleIgv">Precio VENTA unitario CON IGV (al que se venderá)</label>
                                <input type="number" step="any" class="form-control" id="productUnitPriceSaleIgv">
                                <div class="invalid-feedback productUnitPriceSaleIgv-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productAffectationIgvTypeCode">Tipo de afectación</label>
                        <select class="form-control" id="productAffectationIgvTypeCode">
                            <option value="">Seleccionar</option>
                            <?php foreach ($parameter['affectationIgvTypeCode'] ?? [] as $row): ?>
                                <option value="<?= $row['code']?>"><?= $row['description']?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback productAffectationIgvTypeCode-feedback"></div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="custom-control custom-switch" data-toggle="collapse" data-target="#collapseAdvancedProduct">
                            <input type="checkbox" class="custom-control-input" id="State1">
                            <label class="custom-control-label" for="State1">Opciones avanzadas</label>
                        </div>
                    </div>

                    <div class="collapse" id="collapseAdvancedProduct">
                        <div class="form-group">
                            <label for="productSystemIscTypeCode">Sistema de cálculo del ISC</label>
                            <select class="form-control" id="productSystemIscTypeCode">
                                <option value="">Seleccionar</option>
                                <?php foreach ($parameter['systemIscTypeCode'] ?? [] as $row): ?>
                                    <option value="<?= $row['code']?>"><?= $row['description']?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback productSystemIscTypeCode-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="productIsc">ISC</label>
                            <input type="number" step="any" class="form-control" id="productIsc">
                            <div class="invalid-feedback productIsc-feedback"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
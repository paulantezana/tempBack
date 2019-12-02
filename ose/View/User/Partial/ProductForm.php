<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="productFormContainer">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel"><i class="icon-file-plus mr-2"></i> Registrar Nuevo Producto/Servicio</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form onsubmit="Product.submit(event)" id="productForm">
                    <input type="hidden" readonly id="productId">
                    <div class="form-group">
                        <label for="productDescription"><i class="icon-file-text mr-2"></i> Nombre del producto o servicio <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="productDescription" required>
                        <div class="invalid-feedback productDescription-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="productProductCode"><i class="icon-box-add mr-2"></i> Código Producto SUNAT <span class="text-danger">*</span></label>
                        <select class="searchProductCode" id="productProductCode" required></select>
                        <div class="invalid-feedback productProduct_code-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="productUnitMeasureCode"><i class="icon-stairs-up mr-2"></i> Unidad de medida SUNAT <span class="text-danger">*</span></label>
                        <select class="searchUnitMeasureTypeCode" id="productUnitMeasureCode" required></select>
                        <div class="invalid-feedback productUnitMeasureCode-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="productAffectationIgvTypeCode"><i class="icon-percent mr-2"></i> Tipo de IGV <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="productAffectationIgvTypeCode">
                            <?php foreach ($parameter['affectationIgvTypeCode'] ?? [] as $row): ?>
                                <option value="<?= $row['code']?>"><?= $row['description']?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback productAffectationIgvTypeCode-feedback"></div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm">
                            <label for="productUnitPriceSale"><i class="icon-stack mr-2"></i> Precio Venta(Sin IGV)</label>
                            <input type="number" step="any" class="form-control" id="productUnitPriceSale">
                            <div class="invalid-feedback productUnitPriceSale-feedback"></div>
                        </div>
                        <div class="form-group col-sm">
                            <label for="productUnitPriceSaleIgv"><i class="icon-stack mr-2"></i> Precio Venta(Inc.IGV)</label>
                            <input type="number" step="any" class="form-control" id="productUnitPriceSaleIgv">
                            <div class="invalid-feedback productUnitPriceSaleIgv-feedback"></div>
                        </div>
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
                            <select class="form-control select2" id="productSystemIscTypeCode">
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
                    <div class="form-group text-right">
                        <button class="btn" data-dismiss="modal">CERRAR</button>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="productSubmit"><i class="icon-floppy-disk mr-2"></i>GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
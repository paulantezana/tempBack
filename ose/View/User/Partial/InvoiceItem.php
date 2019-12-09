<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 300px">Producto / Servicio</th>
                <th> <?php echo ($parameter['business']['include_igv'] ?? false) ? 'Precio Unit.' : 'VALOR Unit.' ?> </th>
                <th>Cantidad</th>
                <th>Afectación</th>
                <th>Sub Total</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="10">
                    <div class="btn btn-outline-primary btn-block" id="addItemInvoice" data-itemtemplate="<?php echo htmlspecialchars(($parameter['itemTemplate'] ?? ''),ENT_QUOTES) ?>">
                        <i class="icon-plus-circle2 mr-2"></i> Agregar Item
                    </div>
                </td>
            </tr>
        </tfoot>
        <tbody id="detailSaleTableBody">

        <?php foreach ($parameter['invoice']['item'] ?? [] as $key => $row): ?>
            <tr id="invoiceItem<?= $key ?>" data-uniqueId="<?= $key ?>">
                <td>
                    <select name="" id="productSearch<?= $key ?>">
                        <option value="<?= $row['product_code'] ?>"><?= $row['description'] ?></option>
                    </select>
                    <input type="hidden" id="description<?= $key ?>" name="invoice[item][<?= $key ?>][description]" value="<?= $row['description'] ?>" class="form-control form-control-sm">
                    <input type="hidden" id="productCode<?= $key ?>" name="invoice[item][<?= $key ?>][product_code]" value="<?= $row['product_code'] ?>">
                    <input type="hidden" id="unitMeasure<?= $key ?>" name="invoice[item][<?= $key ?>][unit_measure]" value="<?= $row['unit_measure'] ?>">
                </td>
                <td>
                    <input type="<?php echo ($parameter['business']['include_igv'] ?? false) ? 'hidden' : 'number' ?>" step="any" min="0" class="form-control form-control-sm <?= ($parameter['error']['item']['children'][$key]['unit_value'] ?? false) ? 'is-invalid' : '' ?>"
                           name="invoice[item][<?= $key ?>][unit_value]" id="unitValue<?= $key ?>" value="<?= $row['unit_value'] ?? '' ?>">
                    <input type="<?php echo ($parameter['business']['include_igv'] ?? false) ? 'number' : 'hidden' ?>" step="any" min="0" class="form-control form-control-sm <?= ($parameter['error']['item']['children'][$key]['unit_price'] ?? false) ? 'is-invalid' : '' ?>"
                           name="invoice[item][<?= $key ?>][unit_price]" id="unitPrice<?= $key ?>" value="<?= $row['unit_price'] ?? '' ?>">
                </td>
                <td>
                    <input type="number" step="any" class="form-control form-control-sm <?= ($parameter['error']['item']['children'][$key]['quantity'] ?? false) ? 'is-invalid' : '' ?>"
                           min="0"  name="invoice[item][<?= $key ?>][quantity]" id="quantity<?= $key ?>" value="<?= $row['quantity'] ?? '' ?>">
                </td>
                <td>
                    <select class="JsInvoiceAffectationItem <?= ($parameter['error']['item']['children'][$key] ?? false) ? 'is-invalid' : '' ?>"
                            name="invoice[item][<?= $key ?>][affectation_code]" id="affectation<?= $key ?>" required>
                        <?php foreach ($parameter['affectationIgvTypeCode'] ?? [] as $values): ?>
                            <option
                                value="<?= $values['code']?>"
                                <?php echo $values['code'] == $row['affectation_code'] ? 'selected' : '' ?>
                            ><?= $values['description']?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="hidden" readonly class="form-control form-control-sm JsInvoiceSubTotalItem" min="0" id="totalValueItemDecimal<?= $key ?>" value="<?= $row['total_value'] ?? '' ?>">
                    <input type="number" step="any" readonly class="form-control form-control-sm" min="0" id="totalValueItem<?= $key ?>" name="invoice[item][<?= $key ?>][total_value]" required value="<?= $row['total_value'] ?? '' ?>">
                </td>
                <td>
                    <input type="hidden" class="form-control form-control-sm JsInvoiceTotalItem" min="0" id="totalItemDecimal<?= $key ?>" value="<?= $row['total'] ?? '' ?>">
                    <input type="number" step="any" class="form-control form-control-sm" min="0" id="totalItem<?= $key ?>" name="invoice[item][<?= $key ?>][total]" required value="<?= $row['total'] ?? '' ?>">
                </td>
                <td>
                    <div style="display: flex;">
                        <button type="button" class="btn btn-sm btn-light" id="remove<?= $key ?>" title="Quitar item">
                            <i class="icon-cross text-danger"></i>
                        </button>
                        <button type="button" class="btn ml-1 btn-sm btn-light" id="dropdownMenuInvoiceItem" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent" title="Más opciones">
                            <i class="icon-menu9"></i>
                        </button>
                        <div class="dropdown-menu p-4" style="max-width: 350px" aria-labelledby="dropdownMenuInvoiceItem">
                            <div class="form-group">
                                <input type="checkbox" id="plasticBagTaxEnabled<?= $key ?>" name="invoice[item][<?= $key ?>][enabled_plastic_bag_tax]">
                                <label for="plasticBagTax<?= $key ?>">Impuesto a la Bolsa Plástica</label>
                                <div class="d-none" id="plasticBagRow<?= $key ?>">
                                    <input type="number" step="any" readonly class="form-control form-control-sm JsInvoicePlasticBagTax" id="plasticBagTax<?= $key ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="discount<?= $key ?>">Descuento (aplica al Subtotal)</label>
                                <input type="text" class="form-control form-control-sm JsInvoiceDiscountItem" name="invoice[item][<?= $key ?>][discount]" id="discount<?= $key ?>" value="<?= $row['discount'] ?? '' ?>">
                            </div>

                            <div id="iscRow<?= $key ?>" class="d-none">
                                <input type="hidden" readonly name="invoice[item][<?= $key ?>][system_isc_code]" id="systemIscCode<?= $key ?>" value="<?= $row['system_isc_code'] ?>">
                                <input type="hidden" readonly name="invoice[item][<?= $key ?>][total_base_isc]" id="totalBaseIsc<?= $key ?>" value="<?= $row['total_base_isc'] ?>">
                                <div class="form-group">
                                    <label for="taxIsc<?= $key ?>">ISC</label>
                                    <input type="text" class="form-control form-control-sm" name="invoice[item][<?= $key ?>][tax_isc]" id="taxIsc<?= $key ?>" value="<?= $row['tax_isc'] ?? '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="isc<?= $key ?>">ISC de la linea</label>
                                    <input type="text" readonly class="form-control form-control-sm JsInvoiceIscItem" name="invoice[item][<?= $key ?>][isc]" id="isc<?= $key ?>"  value="<?= $row['isc'] ?? '' ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="igv<?= $key ?>">IGV de la linea</label>
                                <input type="text" readonly class="form-control form-control-sm JsInvoiceIgvItem" name="invoice[item][<?= $key ?>][igv]" id="igv<?= $key ?>" value="<?= $row['igv'] ?>" >
                                <input type="hidden" readonly name="invoice[item][<?= $key ?>][total_base_igv]" id="totalBaseIgv<?= $key ?>" value="<?= $row['total_base_igv'] ?>">
                            </div>

                            <div class="row JSPrepaymentRow ${withPrepayment}">
                                <div class="col-12">
                                    <p class="small">
                                        Si es el <b>PRIMER ANTICIPO</b> dejar estos datos en blanco.
                                    </p>
                                    <p class="small">
                                        Si es una <b>DEDUCCIÓN DE ANTICIPO</b> el importe de este ITEM o LINEA es el total del pago
                                        anticipado y restará a los totales del documento.
                                    </p>
                                </div>
                                <div class="col-12">
                                    <div class="custom-control custom-switch form-group ">
                                        <input type="checkbox" class="custom-control-input JsPrepaymentRegulationItem" id="prepaymentRegulation<?= $key ?>" name="invoice[item][<?= $key ?>][prepayment_document_regulation]" >
                                        <label class="custom-control-label" for="prepaymentRegulation<?= $key ?>">¿Deducción de Anticipo?</label>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="prepaymentDocumentSerie<?= $key ?>">Serie</label>
                                    <input type="text" readonly class="form-control form-control-sm" name="invoice[item][<?= $key ?>][prepayment_document_serie]" id="prepaymentDocumentSerie<?= $key ?>">
                                </div>
                                <div class="form-group col-6">
                                    <label for="prepaymentDocumentCorrelative<?= $key ?>">Correlativo</label>
                                    <input type="text" readonly class="form-control form-control-sm" name="invoice[item][<?= $key ?>][prepayment_document_correlative]" id="prepaymentDocumentCorrelative<?= $key ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>

    </table>
</div>

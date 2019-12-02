<?php


class InvoiceTemplate
{
    public static function Item($business = [], $affectationIgvTypeCode = []){
        $affectationIgvTemplate = '';
        foreach ($affectationIgvTypeCode ?? [] as $row){
            $affectationIgvTemplate .= "<option value='{$row['code']}'>{$row['description']}</option>" . PHP_EOL;
        }

        $unitValueType = ($business['include_igv'] ?? false) ? 'hidden' : 'number';
        $unitPriceType = ($business['include_igv'] ?? false) ? 'number' : 'hidden';

        return '
        <tr id="invoiceItem${uniqueId}" data-uniqueId="${uniqueId}">
            <td>
                <select name="" id="productSearch${uniqueId}"></select>
                <input type="hidden" id="description${uniqueId}" name="invoice[item][${uniqueId}][description]">
                <input type="hidden" id="productCode${uniqueId}" name="invoice[item][${uniqueId}][product_code]">
                <input type="hidden" id="unitMeasure${uniqueId}" name="invoice[item][${uniqueId}][unit_measure]">
            </td>
            <td>
                <input type="' . $unitValueType . '" step="any" min="0" class="form-control form-control-sm" name="invoice[item][${uniqueId}][unit_value]" id="unitValue${uniqueId}">
                <input type="' . $unitPriceType . '" step="any" min="0" class="form-control form-control-sm" name="invoice[item][${uniqueId}][unit_price]" id="unitPrice${uniqueId}">
            </td>
            <td>
                <input type="number" step="any" class="form-control form-control-sm" value="1" min="0"  name="invoice[item][${uniqueId}][quantity]" id="quantity${uniqueId}">
            </td>
            <td>
                <select class="form-control form-control-sm JsInvoiceAffectationItem" name="invoice[item][${uniqueId}][affectation_code]" id="affectation${uniqueId}" required>
                    ' . $affectationIgvTemplate . '
                </select>
            </td>
            <td>
                <input type="hidden" readonly class="form-control form-control-sm JsInvoiceSubTotalItem" id="totalValueItemDecimal${uniqueId}">
                <input type="number" step="any" min="0" readonly class="form-control form-control-sm" id="totalValueItem${uniqueId}" name="invoice[item][${uniqueId}][total_value]" required>
            </td>
            <td>
                <input type="hidden" class="form-control form-control-sm JsInvoiceTotalItem" min="0" id="totalItemDecimal${uniqueId}">
                <input type="number" step="any" min="0" readonly class="form-control form-control-sm" min="0" id="totalItem${uniqueId}" name="invoice[item][${uniqueId}][total]" required>
            </td>
            <td>
                <div style="display: flex;">
                    <button type="button" class="btn btn-sm btn-light" id="remove${uniqueId}" title="Quitar item">
                        <i class="icon-cross text-danger"></i>
                    </button>
                    <button type="button" class="btn ml-1 btn-sm btn-light" id="dropdownMenuInvoiceItem" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent" title="Más opciones">
                        <i class="icon-menu9"></i>
                    </button>
                    <div class="dropdown-menu p-4" style="max-width: 350px" aria-labelledby="dropdownMenuInvoiceItem">
                        <div class="form-group">
                            <input type="checkbox" id="plasticBagTaxEnabled${uniqueId}" name="invoice[item][${uniqueId}][enabled_plastic_bag_tax]">
                            <label for="plasticBagTax${uniqueId}">Impuesto a la Bolsa Plástica</label>
                            <div class="d-none" id="plasticBagRow${uniqueId}">
                                <input type="number" step="any" readonly class="form-control form-control-sm JsInvoicePlasticBagTax" id="plasticBagTax${uniqueId}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="discount${uniqueId}">Descuento (aplica al Subtotal)</label>
                            <input type="text" class="form-control form-control-sm JsInvoiceDiscountItem" name="invoice[item][${uniqueId}][discount]" id="discount${uniqueId}">
                        </div>
                        <div class="form-group d-none">
                            <label for="charge${uniqueId}">Otros cargos</label>
                            <input type="text" class="form-control form-control-sm JsInvoiceChargeItem" name="invoice[item][${uniqueId}][charge]" id="charge${uniqueId}">
                        </div>
                        <div id="iscRow${uniqueId}" class="d-none">
                            <input type="hidden" readonly name="invoice[item][${uniqueId}][system_isc_code]" id="systemIscCode${uniqueId}">
                            <input type="hidden" readonly name="invoice[item][${uniqueId}][total_base_isc]" id="totalBaseIsc${uniqueId}">
                            <div class="form-group">
                                <label for="taxIsc${uniqueId}">ISC</label>
                                <input type="text" class="form-control form-control-sm" name="invoice[item][${uniqueId}][tax_isc]" id="taxIsc${uniqueId}">
                            </div>
                            <div class="form-group">
                                <label for="isc${uniqueId}">ISC de la linea</label>
                                <input type="text" readonly class="form-control form-control-sm JsInvoiceIscItem" name="invoice[item][${uniqueId}][isc]" id="isc${uniqueId}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="igv${uniqueId}">IGV de la linea</label>
                            <input type="text" readonly class="form-control form-control-sm JsInvoiceIgvItem" name="invoice[item][${uniqueId}][igv]" id="igv${uniqueId}">
                            <input type="hidden" readonly name="invoice[item][${uniqueId}][total_base_igv]" id="totalBaseIgv${uniqueId}">
                        </div>
                        <div id="otherTaxed${uniqueId}" class="d-none">
                            <div class="form-group">
                                <label for="percentageOtherTaxed${uniqueId}">Tasa de otros impuestos</label>
                                <input type="text" class="form-control form-control-sm JsInvoicePercentageOtherTaxedItem" name="invoice[item][${uniqueId}][percentage_other_taxed]" id="percentageOtherTaxed${uniqueId}">
                            </div>
                            <div class="form-group">
                                <label for="otherTaxed${uniqueId}">Otros impuestos</label>
                                <input type="hidden" class="form-control form-control-sm" name="invoice[item][${uniqueId}][total_base_other_taxed]" id="totalBaseOtherTaxed${uniqueId}">
                                <input type="text" class="form-control form-control-sm JsInvoiceOtherTaxedItem" name="invoice[item][${uniqueId}][other_taxed]" id="otherTaxed${uniqueId}">
                            </div>
                        </div>
                        <div class="row JSPrepaymentRow">
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
                                    <input type="checkbox" class="custom-control-input JsPrepaymentRegulationItem" id="prepaymentRegulation${uniqueId}" name="invoice[item][${uniqueId}][prepayment_regulation]" >
                                    <label class="custom-control-label" for="prepaymentRegulation${uniqueId}">¿Deducción de Anticipo?</label>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label for="prepaymentDocumentSerie${uniqueId}">Serie</label>
                                <input type="text" readonly class="form-control form-control-sm" name="invoice[item][${uniqueId}][prepayment_serie]" id="prepaymentDocumentSerie${uniqueId}">
                            </div>
                            <div class="form-group col-6">
                                <label for="prepaymentDocumentCorrelative${uniqueId}">Correlativo</label>
                                <input type="text" readonly class="form-control form-control-sm" name="invoice[item][${uniqueId}][prepayment_correlative]" id="prepaymentDocumentCorrelative${uniqueId}">
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        ';
    }
}

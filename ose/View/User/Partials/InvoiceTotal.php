<div class="row">
    <label for="invoiceGlobalDiscountPercentage" class="col-sm-8 col-form-label text-right">% Descuento Global</label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm" id="invoiceGlobalDiscountPercentage" name="invoice[global_discount_percentage]" value="<?= $parameter['invoice']['global_discount_percentage'] ?? '' ?>">
    </div>
</div>

<div class="row">
    <label for="invoiceGlobalDiscount" class="col-sm-8 col-form-label text-right">Descuento Global (-) </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm" id="invoiceGlobalDiscount">
    </div>
</div>

<div class="row">
    <label for="invoiceItemDiscount" class="col-sm-8 col-form-label text-right">Descuento por Item (-) </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm" id="invoiceItemDiscount">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalDiscount" class="col-sm-8 col-form-label text-right">Descuento Total (-) </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm" id="invoiceTotalDiscount" name="invoice[total_discount]">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalPrepayment" class="col-sm-8 col-form-label text-right">Anticipo (-) </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm" id="invoiceTotalPrepayment" name="invoice[total_prepayment]">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalExonerated" class="col-sm-8 col-form-label text-right">Exonerada </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_exonerated'] ?? false) ? 'is-invalid' : '' ?>"
               id="invoiceTotalExonerated" name="invoice[total_exonerated]">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalUnaffected" class="col-sm-8 col-form-label text-right">Inafecta </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_unaffected'] ?? false) ? 'is-invalid' : '' ?>"
               id="invoiceTotalUnaffected" name="invoice[total_unaffected]">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalExport" class="col-sm-8 col-form-label text-right">Exportación</label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_exportation'] ?? false) ? 'is-invalid' : '' ?>"
               id="invoiceTotalExport" name="invoice[total_exportation]">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalTaxed" class="col-sm-8 col-form-label text-right">Gravada </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_taxed'] ?? false) ? 'is-invalid' : '' ?>"
               id="invoiceTotalTaxed" name="invoice[total_taxed]">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalIsc" class="col-sm-8 col-form-label text-right">ISC </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm <?= ($parameter['error']['total_isc'] ?? false) ? 'is-invalid' : '' ?>"
               id="invoiceTotalIsc" name="invoice[total_isc]">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalIgv" class="col-sm-8 col-form-label text-right">IGV </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_igv'] ?? false) ? 'is-invalid' : '' ?>"
               id="invoiceTotalIgv" name="invoice[total_igv]">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalFree" class="col-sm-8 col-form-label text-right">Gratuita </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm <?= ($parameter['error']['total_free'] ?? false) ? 'is-invalid' : '' ?>"
               id="invoiceTotalFree" name="invoice[total_free]">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalCharge" class="col-sm-8 col-form-label text-right">Otros Cargos </label>
    <div class="col-sm-4">
        <input type="text" class="form-control form-control-sm <?= ($parameter['error']['total_charge'] ?? false) ? 'is-invalid' : '' ?>"
               id="invoiceTotalCharge" name="invoice[total_charge]" value="<?= $parameter['invoice']['total_charge'] ?? '' ?>">
    </div>
</div>

<div class="row">
    <label for="invoiceTotalPlasticBagTax" class="col-sm-8 col-form-label text-right">ICBPER </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm" id="invoiceTotalPlasticBagTax" name="invoice[total_plastic_bag_tax]" value="<?= $parameter['invoice']['total_plastic_bag_tax'] ?? '' ?>">
    </div>
</div>

<div class="form-group row">
    <label for="invoiceTotal" class="col-sm-8 col-form-label text-right">Total </label>
    <div class="col-sm-4">
        <input type="text" readonly class="form-control form-control-sm <?= ($parameter['error']['total'] ?? false) ? 'is-invalid' : '' ?>"
               id="invoiceTotal" name="invoice[total]">
    </div>
</div>

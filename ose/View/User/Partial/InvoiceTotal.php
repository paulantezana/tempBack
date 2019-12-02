<table class="table">
    <tbody>
        <tr>
            <th>Descuento Global (-)</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceGlobalDiscountText"></span>
                <input type="hidden" readonly class="form-control form-control-sm" id="invoiceGlobalDiscount">
            </td>
        </tr>
        <tr>
            <th>Descuento por Item (-)</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceItemDiscountText"></span>
                <input type="hidden" readonly class="form-control form-control-sm" id="invoiceItemDiscount">
            </td>
        </tr>
        <tr>
            <th>Descuento Total (-) </th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalDiscountText"></span>
                <input type="hidden" readonly class="form-control form-control-sm" id="invoiceTotalDiscount" name="invoice[total_discount]">
            </td>
        </tr>
        <tr>
            <th>Anticipo (-)</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalPrepaymentText"></span>
                <input type="hidden" readonly class="form-control form-control-sm" id="invoiceTotalPrepayment" name="invoice[total_prepayment]">
            </td>
        </tr>
        <tr>
            <th>Exonerada</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalExoneratedText"></span>
                <input type="hidden" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_exonerated'] ?? false) ? 'is-invalid' : '' ?>"
                       id="invoiceTotalExonerated" name="invoice[total_exonerated]">
            </td>
        </tr>
        <tr>
            <th>Inafecta</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalUnaffectedText"></span>
                <input type="hidden" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_unaffected'] ?? false) ? 'is-invalid' : '' ?>"
                       id="invoiceTotalUnaffected" name="invoice[total_unaffected]">
            </td>
        </tr>
        <tr>
            <th>Exportación</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalExportText"></span>
                <input type="hidden" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_exportation'] ?? false) ? 'is-invalid' : '' ?>"
                       id="invoiceTotalExport" name="invoice[total_exportation]">
            </td>
        </tr>
        <tr>
            <th>Gravada</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalTaxedText"></span>
                <input type="hidden" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_taxed'] ?? false) ? 'is-invalid' : '' ?>"
                       id="invoiceTotalTaxed" name="invoice[total_taxed]">
            </td>
        </tr>
        <tr>
            <th>ISC</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalIscText"></span>
                <input type="hidden" readonly class="form-control form-control-sm <?= ($parameter['error']['total_isc'] ?? false) ? 'is-invalid' : '' ?>"
                       id="invoiceTotalIsc" name="invoice[total_isc]">
            </td>
        </tr>
        <tr>
            <th>IGV</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalIgvText"></span>
                <input type="hidden" readonly class="form-control form-control-sm JsInvoiceTotals <?= ($parameter['error']['total_igv'] ?? false) ? 'is-invalid' : '' ?>"
                       id="invoiceTotalIgv" name="invoice[total_igv]">
            </td>
        </tr>
        <tr>
            <th>Gratuita</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalFreeText"></span>
                <input type="hidden" readonly class="form-control form-control-sm <?= ($parameter['error']['total_free'] ?? false) ? 'is-invalid' : '' ?>"
                       id="invoiceTotalFree" name="invoice[total_free]">
            </td>
        </tr>
        <tr>
            <th>ICBPER</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalPlasticBagTaxText"></span>
                <input type="hidden" readonly class="form-control form-control-sm" id="invoiceTotalPlasticBagTax" name="invoice[total_plastic_bag_tax]" value="<?= $parameter['invoice']['total_plastic_bag_tax'] ?? '' ?>">
            </td>
        </tr>
        <tr>
            <th>Total</th>
            <td class="text-right">
                <span class="jsCurrencySymbol">S/.</span>
                <span id="invoiceTotalText"></span>
                <input type="hidden" readonly class="form-control form-control-sm <?= ($parameter['error']['total'] ?? false) ? 'is-invalid' : '' ?>"
                       id="invoiceTotal" name="invoice[total]">
            </td>
        </tr>
    </tbody>
</table>
<div data-toggle="modal" data-target="#sgModalPSE" id="sgPSEStart">
    <i class="icon-help"></i>
</div>

<div class="modal fade" id="sgModalPSE" tabindex="-1" role="dialog" aria-labelledby="sgModalPSELabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="invoiceAdvancedOptionsLabel"><i class="icon-help mr-2"></i> Modo Guiado</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <input type="text" id="sgSearchInvoice" class="form-control" placeholder="¿Qué tipo de operación desea realizar?">
                </div>
                <table class="table" id="sgTableInvoice">
                    <tbody>
                    <tr id="sgInvoiceTaxed">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura gravada con IGV</td>
                    </tr>
                    <tr id="sgInvoiceFree">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura con venta gratuita</td>
                    </tr>
                    <tr id="sgInvoiceExonerated">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura con venta exonerada</td>
                    </tr>
                    <tr id="sgInvoiceUnaffected">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura con venta inafecta</td>
                    </tr>
                    <tr id="sgInvoiceExport">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura comercio exterior o exportación</td>
                    </tr>

                    <tr id="sgInvoiceGlobalDiscount">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura con descuento global</td>
                    </tr>
                    <tr id="sgInvoiceISC">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura gravada con ISC</td>
                    </tr>
                    <tr id="sgInvoiceByCurrency">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura en otras monedas</td>
                    </tr>
                    <tr id="sgInvoiceDetraction">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura sujeta a detracción</td>
                    </tr>
                    <tr id="sgInvoicePerception">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura sujeta a percepción</td>
                    </tr>
                    <tr id="sgInvoiceReferralGuide">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura guia</td>
                    </tr>
                    <tr id="sgInvoicePrepayment">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura con pagos anticipados</td>
                    </tr>
                    <tr id="sgInvoicePrepaymentRegulation">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Factura con regulacion de anticipo</td>
                    </tr>
                    <tr id="sgInvoiceTicketTaxed">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/InvoiceTiket.svg" alt="invoice"></td>
                        <td>Boleta gravada con IGV</td>
                    </tr>
                    <tr id="sgInvoiceTicketGlobalDiscount">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/InvoiceTiket.svg" alt="invoice"></td>
                        <td>Boleta con descuento global</td>
                    </tr>
                    <tr id="sgInvoiceTicketFree">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/InvoiceTiket.svg" alt="invoice"></td>
                        <td>Boleta con venta inafecta</td>
                    </tr>
                    <tr id="sgCreditNote">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/creditNote.svg" alt="invoice"></td>
                        <td>Nota de crédito</td>
                    </tr>
                    <tr id="sgDebitNote">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/debitNote.svg" alt="invoice"></td>
                        <td>Nota de debito</td>
                    </tr>
                    <tr id="sgInvoiceVoided">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Anular factura</td>
                    </tr>
                    <tr id="sgInvoiceTicketVoided">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/InvoiceTiket.svg" alt="invoice"></td>
                        <td>Anular Boleta</td>
                    </tr>
                    <tr id="sgReferralGuide">
                        <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                        <td>Guia de remisión</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

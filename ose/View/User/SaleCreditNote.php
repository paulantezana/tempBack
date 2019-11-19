<div class="container">

    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>

    <form action="<?= FOLDER_NAME . '/SaleNote/NewCreditNote' ?>" method="POST" id="invoiceForm" class="mt-5 mb-5">
        <div class="mb-4">
            <div>Documento eléctronico:</div>
            <h3><?= $parameter['documentTypeCode']['description'] ?? ''?></h3>
            <input type="hidden" class="form-control" name="invoice[document_code]" value="<?= $parameter['documentTypeCode']['code'] ?? '' ?>" id="invoiceDocumentCode">
            <input type="hidden" value="<?= $parameter['business']['include_igv'] ?? ''?>" id="businessIncludeIgv">
        </div>

        <div class="card mb-4">
            <div class="card-body">

                <div class="font-weight-bold">DOCUMENTO A MODIFICAR:</div>
                <hr>
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="invoiceSaleDocumentCode">Tipo Doc.Electrónico:</label>
                        <select class="form-control" id="invoiceSaleDocumentCode" name="invoice[sale_update][document_code]">
                            <option value="03" <?= ($parameter['invoice']['sale_update']['document_code'] ?? false) == "03" ? 'selected' : '' ?>>BOLETA</option>
                            <option value="01" <?= ($parameter['invoice']['sale_update']['document_code'] ?? false) == "01" ? 'selected' : '' ?>>FACTURA</option>
                        </select>
                    </div>

                    <!--                    <input type="hidden" name="invoice[sale_update][sale_id]" value="--><?//= $parameter['invoice']['sale_update']['sale_id'] ?? '' ?><!--">-->

                    <div class="form-group col-md-3">
                        <label for="invoiceSaleSerie">Serie:</label>
                        <input type="text" class="form-control" id="invoiceSaleSerie" name="invoice[sale_update][serie]" value="<?= $parameter['invoice']['sale_update']['serie'] ?? '' ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="invoiceSaleCorrelative">Correlativo:</label>
                        <input type="text" class="form-control" id="invoiceSaleCorrelative" name="invoice[sale_update][correlative]" value="<?= $parameter['invoice']['sale_update']['correlative'] ?? '' ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="invoiceSaleCreditNoteCode">Motivo</label>
                        <select class="form-control" id="invoiceSaleCreditNoteCode" name="invoice[sale_update][credit_note_code]" >
                            <option value="">Elegir</option>
                            <?php foreach ($parameter['creditNoteType'] ?? [] as $row): ?>
                                <option value="<?= $row['code']?>" <?= ($parameter['invoice']['sale_update']['credit_note_code'] ?? '') == $row['code'] ? 'selected' : '' ?> >
                                    <?= $row['description']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-5 bg-white">
            <div class="card-body">

                <?php require_once __DIR__ . '/Partials/InvoiceHeader.php' ?>

                <?php require_once __DIR__ . '/Partials/InvoiceItem.php' ?>

                <div class="row mb-2">
                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-1" name="invoice[jungle_product]" <?= ($parameter['invoice']['jungle_product'] ?? false) ? 'checked' : ''  ?> >
                                    <label for="checkbox-1" class="custom-control-label">¿Bienes Region Selva?</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-2" name="invoice[jungle_service]" <?= ($parameter['invoice']['jungle_service'] ?? false) ? 'checked' : ''  ?> >
                                    <label for="checkbox-2" class="custom-control-label">¿Servicios Region Selva?</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-3" name="invoice[detraction]" <?= ($parameter['invoice']['detraction'] ?? false) ? 'checked' : ''  ?> >
                                    <label for="checkbox-3" class="custom-control-label">¿Detracción?</label>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <?php require_once __DIR__ . '/Partials/InvoiceTotal.php';?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="invoiceObservation">Observaciones</label>
                    <textarea type="text" class="form-control" id="invoiceObservation" name="invoice[observation]" cols="30" rows="2"><?= $parameter['invoice']['observation'] ?? '' ?></textarea>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-auto mr-auto">

            </div>
            <div class="col-auto">
                <input type="submit" name="save_draft" value="Guardar como borrador" class="btn btn-light">
                <input type="submit" name="commit" id="jsInvoiceFormCommit" value="Generar comprobante" class="btn btn-primary ml-4">
            </div>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/Partials/ProductForm.php';
require_once __DIR__ . '/Partials/CustomerForm.php';
?>

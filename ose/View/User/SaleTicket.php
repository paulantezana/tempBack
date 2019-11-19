<div class="container">

    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>

    <form action="<?= FOLDER_NAME . '/Sale/NewTicket' ?>" method="POST" class="mt-4 mb-4">

        <div class="mb-4">
            <div>Documento eléctronico:</div>
            <h3><?= $parameter['documentTypeCode']['description'] ?? ''?></h3>
            <input type="hidden" class="form-control" name="invoice[document_code]" value="<?= $parameter['documentTypeCode']['code'] ?? '' ?>" id="invoiceDocumentCode">
            <input type="hidden" value="<?= $parameter['business']['include_igv'] ?? ''?>" id="businessIncludeIgv">
        </div>

        <div class="card mb-5 bg-white">
            <div class="card-body">

                <?php require_once __DIR__ . '/Partials/InvoiceHeader.php' ?>

                <?php require_once __DIR__ . '/Partials/InvoiceItem.php' ?>

                <div class="row mb-2">
                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-1" name="invoice[jungle_product]" <?= ($parameter['invoice']['jungle_product'] ?? false) ? 'checked' : ''  ?> >
                                    <label for="checkbox-1" class="custom-control-label">¿Bienes Region Selva?</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-2" name="invoice[jungle_service]" <?= ($parameter['invoice']['jungle_service'] ?? false) ? 'checked' : ''  ?> >
                                    <label for="checkbox-2" class="custom-control-label">¿Servicios Region Selva?</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-3" name="invoice[detraction]" <?= ($parameter['invoice']['detraction'] ?? false) ? 'checked' : ''  ?> >
                                    <label for="checkbox-3" class="custom-control-label">¿Detracción?</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" name="invoice[perception_enabled]" id="invoicePerceptionEnable" data-toggle="collapse" data-target="#collapseInvoicePerception" aria-expanded="false">
                                    <label class="custom-control-label" for="invoicePerceptionEnable">Percepción</label>
                                </div>
                                <div class="collapse" id="collapseInvoicePerception">
                                    <div class="form-group">
                                        <label for="invoicePerceptionCode">Tipo de percepcion</label>
                                        <select class="form-control form-control-sm" name="invoice[perception_code]" id="invoicePerceptionCode">
                                            <option value="">Elegir</option>
                                            <?php foreach ($parameter['perceptionTypeCode'] ?? [] as $row): ?>
                                                <option value="<?= $row['code'] ?>" data-percentage="<?= $row['percentage'] ?>"><?php echo $row['percentage'] . '% ' . $row['description'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
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

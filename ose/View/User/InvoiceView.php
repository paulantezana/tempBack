<div class="container">
    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>
    <div class="mt-5 mb-5">
        <h5 class="mb-3"><?= $parameter['invoice']['document_type_code_description']  ?></h5>
        <div class="btn btn-group" style="padding: 0">
            <div class="btn btn-primary JsSaleShowPdf" onclick="DocumentPrinter.showModal('<?php //$parameter['invoice']['pdf_url']  ?>', true)" >Imprimir</div>
            <div class="btn btn-light JsSaleShowPdf" onclick="DocumentPrinter.showModal('<?php //$parameter['invoice']['pdf_url']  ?>', false)">VER PDF</div>
            <div class="btn btn-light" data-toggle="modal" data-target="#saleSendEmailModal">Enviar Email</div>
            <div class="dropdown">
                <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Más acciones
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="<?php echo  FOLDER_NAME . '/InvoiceVoided/NewSaleVoided?SaleId=' . ($parameter['invoice']['invoice_id'] ) ?>">ANULAR O COMUNICAR DE BAJA</a>
                    <a class="dropdown-item" href="#">DESCARGAR XML</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">

        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-auto mr-auto">
                    <?= $parameter['invoice']['document_type_code_description']  ?> - <?= $parameter['invoice']['operation_type_code_description']  ?>
                </div>
                <div class="col-auto">
                    <h3>
                        No.
                        <span><?php echo ($parameter['invoice']['serie'] ) . ' - ' . ($parameter['invoice']['correlative'] ?? 1) ?></span>
                    </h3>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-auto mr-auto">
                    <div><?= $parameter['invoice']['customer_social_reason']  ?></div>
                    <div><?= $parameter['invoice']['customer_document_number']  ?></div>
                </div>
                <div class="col-auto">

                    <div>
                        <ul>
                            <li>
                                Fecha de emision
                                <span class="font-weight-bold">
                                    <?= $parameter['invoice']['date_of_issue'] ?>
                                </span>
                            </li>
                            <li>
                                Fecha de expiracion
                                <span class="font-weight-bold">
                                    <?= $parameter['invoice']['date_of_due'] ?>
                                </span>
                            </li>
                            <li>
                                Tipo de operacion
                                <span class="font-weight-bold">
                                    <?= $parameter['invoice']['operation_type_code_description'] ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-3">
                <table class="table">
                    <thead>
                        <tr style="font-size: 14px">
                            <th>UM</th>
                            <th>Detalle</th>
                            <th>Precio U</th>
                            <th>Cantidad</th>
                            <th>ISC</th>
                            <th>IGV</th>
                            <th>Otro Impuesto</th>
                            <th>Sub Total</th>
                            <th>Descuento</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parameter['invoiceItem'] ?? [] as $key => $row): ?>
                            <tr id="invoiceItem<?= $key ?>" data-uniqueId="<?= $key ?>">
                                <td><?= $row['unit_measure'] ?></td>
                                <td><?= $row['description'] ?></td>
                                <td><?= $row['unit_price'] ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td><?= $row['isc']?></td>
                                <td><?= $row['igv'] ?></td>
                                <td><?= $row['other_taxed'] ?></td>
                                <td><?= $row['total_value'] ?></td>
                                <td><?= $row['discount'] ?></td>
                                <td><?= $row['total'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="row mb-5">
                <div class="col-auto mr-auto">

                </div>
                <div class="col-auto">
                    <table>
                        <tbody>
                            <?php if ($parameter['invoice']['global_discount_percentage'] > 0): ?>
                                <tr>
                                    <td>% Descuento Global</td>
                                    <td class="font-weight-bold"><?= $parameter['invoice']['global_discount_percentage'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($parameter['invoice']['total_prepayment'] > 0): ?>
                                <tr>
                                    <td>Total anticipo</td>
                                    <td class="font-weight-bold"><?= $parameter['invoice']['total_prepayment'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($parameter['invoice']['total_exportation'] > 0): ?>
                                <tr>
                                    <td>Total exportacion</td>
                                    <td class="font-weight-bold"><?= $parameter['invoice']['total_exportation'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($parameter['invoice']['total_exonerated'] > 0): ?>
                                <tr>
                                    <td>Total exonerado</td>
                                    <td class="font-weight-bold"><?= $parameter['invoice']['total_exonerated'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td>Total gravada</td>
                                <td class="font-weight-bold"><?= $parameter['invoice']['total_taxed'] ?></td>
                            </tr>
                            <?php if ($parameter['invoice']['total_unaffected'] > 0): ?>
                                <tr>
                                    <td>Total inafecto</td>
                                    <td class="font-weight-bold"><?= $parameter['invoice']['total_unaffected'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($parameter['invoice']['total_isc'] > 0): ?>
                                <tr>
                                    <td>ISC</td>
                                    <td class="font-weight-bold"><?= $parameter['invoice']['total_isc'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($parameter['invoice']['total_igv'] > 0): ?>
                                <tr>
                                    <td>IGV</td>
                                    <td class="font-weight-bold"><?= $parameter['invoice']['total_igv'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($parameter['invoice']['total_free'] > 0): ?>
                                <tr>
                                    <td>Total gratuito</td>
                                    <td class="font-weight-bold"><?= $parameter['invoice']['total_free'] ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td>Total</td>
                                <td class="font-weight-bold"><?= $parameter['invoice']['total'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col">
                    <?= $parameter['invoice']['observation']  ?>
                </div>
            </div>

            <div class="row d-flex justify-content-center">
                <a href="<?= FOLDER_NAME . '/sale' ?>" class="btn btn-primary ml-4">
                    Realizar Otra Venta!
                </a>
                <a href="<?= FOLDER_NAME . '/sale' ?>" class="btn btn-light ml-4">
                    Ver Lista Documentos >
                </a>
            </div>

        </div>
    </div>

</div>

<?php
    require_once __DIR__ . '/Partials/DocumentPrinterModal.php';
    require_once __DIR__ . '/Partials/SaleSendEmailModal.php'
?>


    <div class="container">
        <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>
        <div class="mt-5 mb-5">
            <h5 class="mb-3"><?= $parameter['invoice']['voucher_type_description'] ?? '' ?></h5>
            <div class="btn btn-group" style="padding: 0">
                <div class="btn btn-primary JsSaleShowPdf" onclick="DocumentPrinter.showModal('<?= $parameter['invoice']['pdf_url']  ?>', true)" >Imprimir</div>
                <div class="btn btn-light JsSaleShowPdf" onclick="DocumentPrinter.showModal('<?= $parameter['invoice']['pdf_url']  ?>', false)">VER PDF</div>

                <div class="btn btn-light">Enviar Email</div>
                <div class="dropdown">
                    <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Más acciones
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">ANULAR O COMUNICAR DE BAJA</a>
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
                    <?= $parameter['invoice']['document_type_code_description'] ?? '' ?> - <?= $parameter['invoice']['operation_type_code_description'] ?? '' ?>
                </div>
                <div class="col-auto">
                    <h3>
                        No.
                        <span><?php echo ($parameter['invoice']['serie'] ?? '') . ' - ' . ($parameter['invoice']['correlative'] ?? 1) ?></span>
                    </h3>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-auto mr-auto">
                    <div><?= $parameter['invoice']['customer_social_reason'] ?? '' ?></div>
                    <div><?= $parameter['invoice']['customer_document_number'] ?? '' ?></div>
                </div>
                <div class="col-auto">

                    <div>
                        <ul>
                            <li>
                                Fecha de emision
                                <span class="font-weight-bold">
                                    <?php
                                    if (isset($parameter['invoice']['broadcast_date'])){
                                        echo date('d/m/Y',strtotime($parameter['invoice']['broadcast_date']));
                                    }
                                    ?>
                                </span>
                            </li>
                            <li>
                                Fecha de expiracion
                                <span class="font-weight-bold">
                                    <?php
                                    if (isset($parameter['invoice']['broadcast_date'])){
                                        echo date('d/m/Y',strtotime($parameter['invoice']['expiration_date']));
                                    }
                                    ?>
                                </span>
                            </li>
                            <li>
                                Tipo de operacion
                                <span class="font-weight-bold">
                                    <?= $parameter['invoice']['operation_type_code_description'] ?? ''  ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table">
                    <thead>
                    <tr style="font-size: 14px">
                        <th>Producto - Servicio (CATÁLOGO)</th>
                        <th>Detalle adicional</th>
                        <th>Precio U</th>
                        <th>Cantidad</th>
                        <th>Descuento por item</th>
                        <th>Tipo de IGV</th>
                        <th>IGV En Linea</th>
                        <th>Sub Total</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($parameter['detailSale'] ?? [] as $key => $row): ?>
                        <tr id="invoiceItem<?= $key ?>" data-uniqueId="<?= $key ?>">
                            <td><?= $row['product_description'] ?? '' ?></td>
                            <td><?= $row['description'] ?? ''  ?></td>
                            <td><?= $row['unit_price'] ?? ''  ?></td>
                            <td><?= $row['quantity'] ?? ''  ?></td>
                            <td><?= $row['discount'] ?? ''  ?></td>
                            <td><?= $row['affectation_code'] ?? '' ?></td>
                            <td><?= $row['igv'] ?? ''  ?></td>
                            <td><?= $row['subtotal'] ?? ''  ?></td>
                            <td><?= $row['total'] ?? ''  ?></td>
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
                        <tr>
                            <td>% Descuento Global</td>
                            <td class="font-weight-bold"><?= $parameter['invoice']['global_discount_percentage'] ?? 0 ?></td>
                        </tr>
                        <!--                            <tr>-->
                        <!--                                <td>Descuento Global (-)</td>-->
                        <!--                                <td>--><?//= $parameter['invoice']['global_discount_percentage'] ?? 0 ?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Descuento por Item (-)</td>-->
                        <!--                                <td>--><?//= $parameter['invoice']['total_free'] ?? 0 ?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Descuento Total (-)</td>-->
                        <!--                                <td>--><?//= $parameter['invoice']['total_free'] ?? 0 ?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr>-->
                        <!--                                <td>Anticipo (-)</td>-->
                        <!--                                <td>--><?//= $parameter['invoice']['total_free'] ?? 0 ?><!--</td>-->
                        <!--                            </tr>-->
                        <tr>
                            <td>Exonerada</td>
                            <td class="font-weight-bold"><?= $parameter['invoice']['total_exonerated'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Inafecta</td>
                            <td class="font-weight-bold"><?= $parameter['invoice']['total_unaffected'] ?? 0 ?></td>
                        </tr>
                        <!--                            <tr>-->
                        <!--                                <td>Gravada</td>-->
                        <!--                                <td>--><?//= $parameter['invoice']['total_taxed'] ?? 0 ?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                                <tr>-->
                        <!--                                    <td>IGV</td>-->
                        <!--                                    <td>--><?//= $parameter['invoice']['total_free'] ?? 0 ?><!--</td>-->
                        <!--                                </tr>-->
                        <tr>
                            <td>Total Gratuida</td>
                            <td class="font-weight-bold"><?= $parameter['invoice']['total_free'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Otros Cargos</td>
                            <td class="font-weight-bold"><?= $parameter['invoice']['other_charges'] ?? 0 ?></td>
                        </tr>
                        <tr>
                            <td>Total Onerosa</td>
                            <td class="font-weight-bold"><?= $parameter['invoice']['total'] ?? 0 ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col">
                    <?= $parameter['invoice']['observation'] ?? '' ?>
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

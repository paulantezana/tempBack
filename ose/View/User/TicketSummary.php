    <div class="container pt-5 pb-5">
        <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>

        <div class="row mb-5">
            <div class="col-auto mr-auto">
                <h1>
                    <span>🖶 </span>
                    <span>Resúmenes de Boletas de Venta</span>
                </h1>
            </div>
            <div class="col-auto d-flex align-items-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#summaryModal">
                    Generar resumen diario
                </button>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" data-toggle="collapse" data-target="#collapseAdvancedOptions" aria-expanded="false">
                    <label class="custom-control-label" for="customSwitch1">Ver Opciones Avanzadas:</label>
                </div>
                <div class="collapse" id="collapseAdvancedOptions">
                    <form action="<?= FOLDER_NAME . '/InvoiceSummary'?>" method="GET" class="mt-4">
                        <div class="form-row">
                            <div class="form-group col-lg-3">
                                <label for="filterStartDate">Fecha inicio</label>
                                <input type="date" class="form-control" name="filter[startDate]" id="filterStartDate" value="<?= $parameter['filter']['startDate'] ?? null ?>">
                            </div>

                            <div class="form-group col-lg-3">
                                <label for="filterEndDate">Fecha final</label>
                                <input type="date" class="form-control" name="filter[endDate]" id="filterEndDate" value="<?= $parameter['filter']['endDate'] ?? null ?>">
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="<?= FOLDER_NAME . '/InvoiceSummary'?>" class="btn btn-light">Mostrar Todo</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="breadcrumb-line breadcrumb-line-component mb-2">
                    <ul class="breadcrumb bg-light">
                        <li><img style="max-width: 30px;" src="<?= FOLDER_NAME . '/Asset/Images/sunat_logo.png'?>" class="position-left"><span class="text-semibold">Estados SUNAT: </span></li>
                        <li class="ml-3"> <i class="fas fa-check text-success"></i> Aceptado</li>
                        <li class="ml-3"> <i class="fas fa-times-circle text-danger"></i> Rechazado</li>
                        <li class="ml-3"> <i class="fas fa-sync-alt text-warning"></i> Pendiente de Envío</li>
                    </ul>
                </div>
                <div class="table-responsive mb-4">
                    <table class="table table-striped">
                        <thead>
                            <tr style="font-size: 14px">
                                <th>NUMERO</th>
                                <th>FECHA DE GENERACIÓN	</th>
                                <th>FECHA DE EMISIÓN DE DOCUMENTOS</th>
                                <th>DOCUMENTOS</th>
                                <th>TICKET (SUNAT)</th>
                                <th>PDF</th>
                                <th>XML</th>
                                <th>CDR</th>
                                <th>ESTADO EN LA SUNAT</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($parameter['summary']['data'] ?? [] as $row):
                                $sunatResponseCode = ($row['sunat_response_code'] ?? '');
                        ?>
                            <tr>
                                <td><?= $row['number'] ?? '' ?></td>
                                <td><?= $row['date_of_issue'] ?? '' ?></td>
                                <td><?= $row['date_of_reference'] ?? '' ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="JsDetailTicketSummaryModal(<?= $row['ticket_summary_id'] ?? 0 ?>)" data-toggle="modal">Ver Boletas</button>
                                </td>
                                <td><?= $row[''] ?? ''?></td>
                                <td>
                                    <?php if ($row['pdf_url'] != ''): ?>
                                        <button class="btn btn-sm btn-light" onclick="JsSaleShowPdf('<?= $row['pdf_url'] ?? '' ?>', false)"><i class="fas fa-file-pdf text-danger"></i></button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['xml_url'] != ''): ?>
                                        <a
                                                href="<?= $row['xml_url'] ?? '' ?>"
                                                download="<?php $fileName = explode('/', $row['xml_url'] ?? ''); echo  'XML-'. $fileName[count($fileName) - 1]?>"
                                                class="btn btn-sm btn-light"
                                        >
                                            <i class="fas fa-file-code text-success"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($sunatResponseCode == '0' && $row['cdr_url'] != '' ) : ?>
                                        <a
                                            href="<?= $row['cdr_url'] ?? '' ?>"
                                            download="<?php $fileName = explode('/', $row['cdr_url'] ?? ''); echo  'CDR-'. $fileName[count($fileName) - 1]?>"
                                            class="btn btn-sm btn-light"
                                        >
                                            <span class="text-primary">CDR</span>
                                        </a>
                                    <?php elseif ($row['sunat_state'] == 3): ?>
                                        <a href="<?=  FOLDER_NAME . '/InvoiceSummary' ?>">
                                            <i class="fas fa-chevron-circle-right text-primary"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php if ($row['sunat_state'] == 1): ?>
                                                <?php if ($row['document_code'] == '01'): ?>
                                                    <i class="fas fa-sync-alt text-warning"></i>
                                                    <div class="spinner-border spinner-border-sm text-warning" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php elseif ($row['document_code'] == '03'): ?>
                                                    <i class="fas fa-chevron-circle-right text-primary"></i>
                                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php endif; ?>
                                            <?php elseif ($row['sunat_state'] == 2): ?>
                                                <i class="fas fa-chevron-circle-right text-primary"></i>
                                            <?php elseif ($sunatResponseCode === '0' && $row['sunat_state'] == 3): ?>
                                                <i class="fas fa-check text-success"></i>
                                            <?php elseif ($row['sunat_state'] == 4): ?>
                                                <i class="fas fa-times-circle text-danger"></i>
                                            <?php else: ?>
                                                <div class="spinner-border spinner-border-sm" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            <?php endif;?>
                                        </button>
                                        <?php if ($row['sunat_state'] != 4): ?>
                                            <ul class="dropdown-menu">
                                                <li><a href="" class="dropdown-item">Enviado A Sunat: ✔</a></li>
                                                <li><a href="" class="dropdown-item">Aceptada por la SUNAT: ✔</a></li>
                                                <li>
                                                    <a href="" class="dropdown-item">
                                                        <span>Código:</span>
                                                        <span class="badge badge-success"> <?= $sunatResponseCode ?></span>
                                                    </a>
                                                </li>
                                                <li><a href="" class="dropdown-item">
                                                        <span>Descripción:</span>
                                                        <span><?= $row['sunat_response_description'] ?? '' ?></span>
                                                    </a></li>
                                                <li><a href="" class="dropdown-item">Otros: <span>-</span> </a></li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Consultar estado a la SUNAT</a>
                                            <a class="dropdown-item" href="http://www.sunat.gob.pe/ol-ti-itconsvalicpe/ConsValiCpe.htm">VALIDÉZ de CPE</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item <?php if(($parameter['summary']['current'] ?? 0) <= 1){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if(($parameter['summary']['current'] ?? 0) <= 1){ echo '#'; } else { echo "?page=".(($parameter['summary']['current'] ?? 0) - 1); } ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                        </li>
                        <?php for ($i=1; $i <= $parameter['summary']['pages'] ?? 1; $i++): if ($i == $parameter['summary']['current'] ?? 1): ?>
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?> <span class="sr-only">(current)</span></a>
                            </li>
                        <?php else:  ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                        <?php endif; endfor; ?>
                        <li class="page-item <?php if(($parameter['summary']['current'] ?? 0) >= ($parameter['summary']['pages'] ?? 0)){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if(($parameter['summary']['current'] ?? 0) >= ($parameter['summary']['pages'] ?? 0)){ echo '#'; } else { echo "?page=".(($parameter['summary']['current'] ?? 0) + 1); } ?>">Siguiente</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>

    </div>

<?php
    require_once __DIR__ . '/Partial/TicketSummaryForm.php';
    require_once __DIR__ . '/Partial/DocumentPrinterModal.php';
    require_once __DIR__ . '/Partial/DetailTicketSummaryModal.php';
?>

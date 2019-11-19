<div class="container pt-5 pb-5">
    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>
    <div class="row mb-5">
        <div class="col-auto mr-auto">
            <h1>
                <span><i class="fas fa-list"></i> Comunicaciones de Baja</span>
            </h1>
        </div>

        <div class="col-auto d-flex align-items-center">
            <div class="btn-group">
                <a href="<?= FOLDER_NAME . '/SaleVoided/NewSaleVoided' ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo</a>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" data-toggle="collapse" data-target="#collapseAdvancedOptions" aria-expanded="false">
                <label class="custom-control-label" for="customSwitch1">Ver Opciones Avanzadas:</label>
            </div>
            <div class="collapse" id="collapseAdvancedOptions">
                <form action="<?= FOLDER_NAME . '/SaleVoided'?>" method="GET" class="mt-4">
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
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
                    <a href="<?= FOLDER_NAME . '/SaleVoided'?>" class="btn btn-light">Mostrar Todo</a>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="breadcrumb-line breadcrumb-line-component mb-2">
                <ul class="breadcrumb bg-light">
                    <li><img style="max-width: 30px;" src="<?= FOLDER_NAME . '/Asset/Images/sunat_logo.png'?>" class="position-left"><span class="text-semibold">Estados SUNAT: </span></li>
                    <li class="ml-3"> <i class="fas fa-check text-success"></i> Aceptado</li>
                    <li class="ml-3"> <i class="fas fa-sync-alt text-warning"></i> Pendiente de Envío</li>
                </ul>
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr style="font-size: 14px">
                        <th>NUMERO DE ANULACIÓN</th>
                        <th>FECHA DE BAJA</th>
                        <th>FECHA DE DOCUMENTO</th>
                        <th>DOCUMENTO</th>
                        <th>MOTIVO</th>
                        <th>TIKET (SUNAT)	</th>
                        <th>PDF</th>
                        <th>XML</th>
                        <th>CDR</th>
                        <th>ESTADO EN LA SUNAT</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($parameter['saleVoided']['data'] ?? [] as $key => $row ):
                                $sunatResponseCode = ($row['sunat_response_code'] ?? '');
                                $textColor = $sunatResponseCode === '0' ? 'success' : 'danger';
                        ?>
                            <tr>
                                <td><?= $row['correlative'] ?></td>
                                <td><?= $row['date_of_issue'] ?? '' ?></td>
                                <td><?= $row['sale_date_of_issue'] ?? '' ?></td>
                                <td><?php echo $row['sale_document_code_description'] . ' ' . $row['sale_serie'] . '-' .  $row['sale_correlative'] ?></td>
                                <td><?= $row['reason'] ?? '' ?></td>
                                <td><?= $row['ticket'] ?? 0 ?></td>
                                <td>
                                    <?php if ($row['pdf_url'] != ''): ?>
                                        <button class="btn btn-sm btn-light" onclick="DocumentPrinter.showModal('<?= $row['pdf_url'] ?? '' ?>', false)" title="PDF"><i class="fas fa-file-pdf text-danger"></i></button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['xml_url'] != ''): ?>
                                        <a
                                                href="<?= $row['xml_url'] ?? '' ?>"
                                                download="<?php $fileName = explode('/', $row['xml_url'] ?? ''); echo  'XML-'. $fileName[count($fileName) - 1]?>"
                                                class="btn btn-sm btn-light"
                                                title="XML"
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
                                                title="CDR"
                                        >
                                            <span class="text-primary">CDR</span>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Estado SUNAT">
                                            <?php if ($row['sale_document_code'] == '01'): ?>
                                                <?php if ($row['sunat_state'] == 1 || $row['sunat_state'] == 2): ?>
                                                    <i class="fas fa-sync-alt text-warning"></i>
                                                    <div class="spinner-border spinner-border-sm text-warning" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php elseif ($sunatResponseCode === '0' && $row['sunat_state'] == 3): ?>
                                                    <i class="fas fa-check text-success"></i>
                                                <?php elseif ($row['sunat_state'] == 4): ?>
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                <?php else: ?>
                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php endif;?>
                                            <?php elseif ($row['sale_document_code'] == '03'): ?>
                                                <?php if ($row['sunat_state'] == 1 || $row['sunat_state'] == 2): ?>
                                                    <i class="fas fa-chevron-circle-right text-primary"></i>
                                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php elseif ($row['sunat_state'] == 3): ?>
                                                    <i class="fas fa-chevron-circle-right text-primary"></i>
                                                <?php elseif ($row['sunat_state'] == 4): ?>
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                <?php else: ?>
                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php endif;?>
                                            <?php endif; ?>
                                        </button>
                                        <div class="dropdown-menu">
                                            <?php if ($row['sale_document_code'] === '01'): ?>
                                                <div style="padding: 1rem">
                                                    <table class="table table-sm no-border" style="width: 400px">
                                                        <tbody class="text-<?= $textColor ?>">
                                                        <tr>
                                                            <td>Enviado A Sunat:</td>
                                                            <td><?php echo $sunatResponseCode == '0' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Aceptada por la SUNAT:</td>
                                                            <td><?php echo $sunatResponseCode == '0' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Código:</td>
                                                            <td><?= $sunatResponseCode ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Descripción:</td>
                                                            <td><?= $row['sunat_response_description'] ?? '' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Otros:</td>
                                                            <td><?= $row['sunat_error_message'] ?></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php elseif ($row['sale_document_code'] === '03'): ?>
                                                <div style="padding: 1rem">
                                                    <table class="table table-sm no-border" style="width: 400px">
                                                        <tbody>
                                                        <tr>
                                                            <td>Este documento se enviará a la SUNAT en un Resumen Diario al día siguiente.</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Aceptada por a SUNAT:</td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Otros:</td>
                                                            <td><?= $row['sunat_error_message'] ?></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group ">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Opciones" >
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item text-danger" href="<?= FOLDER_NAME . '/SaleVoided/ResendSaleVoided?SaleVoidedId=' . $row['sale_voided_id'] ?>"> <i class="fas fa-file-alt"></i> Consultar o recuperar constancia</a>
<!--                                            <a class="dropdown-item" href="--><?//= FOLDER_NAME . '/SaleVoided/ResendSaleVoided?SaleVoidedId=' . $row['sale_voided_id'] ?><!--"> Consultar estado a la SUNAT</a>-->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php
                $currentPage = $parameter['saleVoided']['current'] ?? 1;
                $totalPage = $parameter['saleVoided']['pages'] ?? 1;
                $limitPage = $parameter['saleVoided']['limit'] ?? 10;
                $additionalQuery = '';
                $linksQuantity = 3;

                if ($totalPage > 1){
                    $lastPage       = $totalPage;
                    $startPage      = (( $currentPage - $linksQuantity ) > 0 ) ? $currentPage - $linksQuantity : 1;
                    $endPage        = (( $currentPage + $linksQuantity ) < $lastPage ) ? $currentPage + $linksQuantity : $lastPage;

                    $htmlPaginate       = '<nav aria-label="..."><ul class="pagination">';

                    $class      = ( $currentPage == 1 ) ? "disabled" : "";
                    $htmlPaginate       .= '<li class="page-item ' . $class . '"><a href="?limit=' . $limitPage . '&page=' . ( $currentPage - 1 ) . $additionalQuery . '" class="page-link">Anterior</a></li>';

                    if ( $startPage > 1 ) {
                        $htmlPaginate   .= '<li class="page-item"><a href="?limit=' . $limitPage . '&page=1' . $additionalQuery . '" class="page-link">1</a></li>';
                        $htmlPaginate   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }

                    for ( $i = $startPage ; $i <= $endPage; $i++ ) {
                        $class  = ( $currentPage == $i ) ? "active" : "";
                        $htmlPaginate   .= '<li class="page-item ' . $class . '"><a href="?limit=' . $limitPage . '&page=' . $i . $additionalQuery . '" class="page-link">' . $i . '</a></li>';
                    }

                    if ( $endPage < $lastPage ) {
                        $htmlPaginate   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        $htmlPaginate   .= '<li><a href="?limit=' . $limitPage . '&page=' . $lastPage . $additionalQuery . '" class="page-link">' . $lastPage . '</a></li>';
                    }

                    $class      = ( $currentPage == $lastPage || $totalPage == 0) ? "disabled" : "";
                    $htmlPaginate       .= '<li class="page-item ' . $class . '"><a href="?limit=' . $limitPage . '&page=' . ( $currentPage + 1 ) . $additionalQuery . '" class="page-link">Siguiente</a></li>';

                    $htmlPaginate       .= '</ul></nav>';

                    echo  $htmlPaginate;
                }
            ?>

        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/Partials/DocumentPrinterModal.php';
?>
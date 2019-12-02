<div class="container pt-5 pb-5">
    <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>
    <div class="row mb-5">
        <div class="col-auto mr-auto">
            <h1>
                <span>🖶 </span>
                <span>Notas de crédito y débito</span>
            </h1>
        </div>

        <div class="col-auto d-flex align-items-center">
            <a href="#" class="btn btn-light">Exportar</a>
            <div class="dropdown ml-2">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuNewInvoice" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Emitir comprobante (CPE)
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuNewInvoice">
                    <a href="<?= FOLDER_NAME . '/InvoiceNote/NewCreditNote' ?>" class="dropdown-item">Nueva NOTA DE CRÉDITO</a>
                    <a href="<?= FOLDER_NAME . '/InvoiceNote/NewDebitNote' ?>" class="dropdown-item">Nueva NOTA DE DÉBITO</a>
                </div>
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
                <form action="<?= FOLDER_NAME . '/InvoiceNote'?>" method="GET" class="mt-4">
                    <div class="form-row">
                        <div class="form-group col-lg-3">
                            <label for="filterDocumentCode">Tipo de comprobante</label>
                            <select class="form-control" id="filterDocumentCode" name="filter[documentCode]">
                                <option value="">Filtrar por tipo</option>
                                <?php foreach ($parameter['documentTypeCode'] ?? [] as $row): ?>
                                    <?php if ( ($parameter['filter']['documentCode'] ?? '') == $row['code'] ) :  ?>
                                        <option value="<?= $row['code']?>" selected><?= $row['description']?></option>
                                    <?php else:  ?>
                                        <option value="<?= $row['code']?>"><?= $row['description']?></option>
                                    <?php endif;  ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="filterCustomer">Entidad</label>
                            <select class="selectpicker with-ajax searchCustomer" id="filterCustomer" name="filter[customer]" data-live-search="true" data-width="100%">
                                <?php if(($parameter['filter']['customer']['customer_id'] ?? false)) :  ?>
                                    <option value="<?= $parameter['filter']['customer']['customer_id'] ?? 0?>" selected><?= $parameter['filter']['customer']['description'] ?? ''?></option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="filterStartDate">Fecha inicio</label>
                            <input type="date" class="form-control" name="filter[startDate]" id="filterStartDate" value="<?= $parameter['filter']['startDate'] ?? null ?>">
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="filterEndDate">Fecha final</label>
                            <input type="date" class="form-control" name="filter[endDate]" id="filterEndDate" value="<?= $parameter['filter']['endDate'] ?? null ?>">
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="filterSaleSearch">Buscar documento por serie / número</label>
                            <select class="selectpicker with-ajax filterSaleNoteSearch" id="filterSaleSearch" name="filter[saleSearch]" data-live-search="true" data-width="100%">
                                <?php if($parameter['filter']['saleSearch']['sale_id'] ?? false) :  ?>
                                    <option value="<?= $parameter['filter']['saleSearch']['sale_id'] ?? 0?>" selected><?= $parameter['filter']['saleSearch']['description'] ?? ''?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="btn-group col-lg-4">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="<?= FOLDER_NAME . '/Invoice'?>" class="btn btn-light">Mostrar Todo</a>
                        </div>
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
                    <li class="ml-3"> <i class="fas fa-chevron-circle-right text-primary"></i> Resumen </li>
                    <li class="ml-3"> <i class="fas fa-sync-alt text-warning"></i> Pendiente de Envío</li>
                    <li class="ml-3"> <i class="fas fa-times-circle text-danger"></i> Comunicación de Baja (Anulado)</li>
                </ul>
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr style="font-size: 14px">
                        <th style="width: 100px" >FECHA</th>
                        <th>SERIE</th>
                        <th>NUM.</th>
                        <th>RUC/DNI/ETC</th>
                        <th style="width: 400px">DENOMINACIÓN</th>
                        <th>M</th>
                        <th>TOTAL ONEROSA</th>
                        <th>TOTAL GRATUITA</th>
                        <th>ENVIADO AL CLIENTE?</th>
                        <th>IMPRIMIR</th>
                        <th>PDF</th>
                        <th>XML</th>
                        <th>CDR</th>
                        <th>ESTADO EN LA SUNAT</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $totalInvoice = 0;
                    $totalTicket = 0;
                    $totalDebitNote = 0;
                    $totalCreditNote = 0;

//                    var_dump($parameter['saleNote']['data']);

                    foreach ($parameter['saleNote']['data'] ?? [] as $row):
                        $cDate = date_create($row['date_of_issue']);
                        $cDate = date_format($cDate, 'Y-m-d');


                        switch ($row['document_code']){
                            case '01';
                                $totalInvoice += (float)$row['total'];
                                break;
                            case '03';
                                $totalTicket += (float)$row['total'];
                                break;
                            default:
                                break;
                        }

                        $sunatResponseCode = ($row['sunat_response_code'] ?? '');
                        $textColor = $sunatResponseCode === '0' ? 'success' : 'danger';
                        ?>
                        <tr>
                            <td><?= $cDate ?></td>
                            <td><?= $row['serie'] ?? '' ?></td>
                            <td><?= $row['correlative'] ?? '' ?></td>
                            <td><?= $row['document_number'] ?? '' ?></td>
                            <td><?= $row['social_reason'] ?? '' ?></td>
                            <td><?= $row['currency_type'] ?? '' ?></td>
                            <td><?= $row['total'] ?? 0 ?></td>
                            <td><?= $row['total_free'] ?? 0 ?></td>
                            <td>
                                <?php if (($row['sent_to_client'] ?? '')  != ''): ?>
                                    <i class="fas fa-check"></i>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['pdf_url'] != ''): ?>
                                    <button class="btn btn-sm btn-light" onclick="DocumentPrinter.showModal('<?= $row['pdf_url'] ?? '' ?>', true)">Imprimir</button>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['pdf_url'] != ''): ?>
                                    <button class="btn btn-sm btn-light" onclick="DocumentPrinter.showModal('<?= $row['pdf_url'] ?? '' ?>', false)"><i class="fas fa-file-pdf text-danger"></i></button>
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
                                <?php if ($row['sale_document_code'] === '01' && $sunatResponseCode == '0' && $row['cdr_url'] != '' ) : ?>
                                    <a
                                        href="<?= $row['cdr_url'] ?? '' ?>"
                                        download="<?php $fileName = explode('/', $row['cdr_url'] ?? ''); echo  'CDR-'. $fileName[count($fileName) - 1]?>"
                                        class="btn btn-sm btn-light"
                                        title="CDR"
                                    >
                                        <span class="text-primary">CDR</span>
                                    </a>
                                <?php elseif ($row["sale_document_code"] == '03' && $row['sunat_state'] == 3): ?>
                                    <a href="<?=  FOLDER_NAME . '/InvoiceSummary' ?>" title="Ver resumen" style="font-size: 0.85rem">
                                        <i class="fas fa-chevron-circle-right text-primary"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </button>
                                    <ul class="dropdown-menu">
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
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group ">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/InvoiceNote/View?SaleNoteId=' . $row['sale_note_id'] ?>"> <i class="fas fa-eye"></i> Ver detalles</a>
                                        <?php if (($row['sunat_state'] == 1 || $row['sunat_state'] == 2) && $row['sale_document_code'] === '01' ): ?>
                                            <a class="dropdown-item text-danger" href="<?= FOLDER_NAME . '/InvoiceNote/ResendInvoice?SaleNoteId=' . $row['sale_note_id'] ?>"> <i class="fas fa-file-alt"></i> Consultar o recuperar constancia</a>
                                        <?php endif; if (($row['sunat_state'] ?? 0) >= 1 && ($row['sunat_state'] ?? 0) < 4): ?>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#saleSendEmailModal"> <i class="fas fa-envelope"></i>  Enviar a un email personalizado</a>
                                        <?php endif; if (($row['sunat_state'] == 3 && $row['sale_document_code'] == '01') || (($row['sunat_state'] == 2 || $row['sunat_state'] == 3) && $row['sale_document_code'] == '03')): ?>
                                            <a class="dropdown-item text-danger" href="<?= FOLDER_NAME . '/InvoiceNoteVoided/NewSaleNoteVoided?SaleNoteId=' . $row['sale_note_id'] ?>"> <i class="fas fa-times-circle"></i> ANULAR o COMUNICAR DE BAJA</a>
                                        <?php endIf;?>
                                        <a class="dropdown-item text-success" href="http://www.sunat.gob.pe/ol-ti-itconsvalicpe/ConsValiCpe.htm?E=20490086278&T=03&R=16766987&S=B003&N=47&F=15/08/2019&T=260.0" target="_blank"> <i class="fas fa-check"></i> Verificar en la SUNAT la validéz del CPE</a>
                                        <a class="dropdown-item text-success" href="http://www.sunat.gob.pe/ol-ti-itconsverixml/ConsVeriXml.htm" target="_blank"> <i class="fas fa-check"></i> Verificar XML en la SUNAT</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6" class="text-right">Total de NOTAS DE CRÉDITO:</td>
                        <td><?= $totalCreditNote ?></td>
                        <td colspan="7"></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Total de NOTAS DE DÉDITO:</td>
                        <td><?= $totalDebitNote ?></td>
                        <td colspan="7"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <?php
                $currentPage = $parameter['saleNote']['current'] ?? 1;
                $totalPage = $parameter['saleNote']['pages'] ?? 1;
                $limitPage = $parameter['saleNote']['limit'] ?? 10;
                $additionalQuery = '';
                $linksQuantity = 3;

                if ($totalPage > 1) {
                    $lastPage = $totalPage;
                    $startPage = (($currentPage - $linksQuantity) > 0) ? $currentPage - $linksQuantity : 1;
                    $endPage = (($currentPage + $linksQuantity) < $lastPage) ? $currentPage + $linksQuantity : $lastPage;

                    $htmlPaginate = '<nav aria-label="..."><ul class="pagination">';

                    $class = ($currentPage == 1) ? "disabled" : "";
                    $htmlPaginate .= '<li class="page-item ' . $class . '"><a href="?limit=' . $limitPage . '&page=' . ($currentPage - 1) . $additionalQuery . '" class="page-link">Anterior</a></li>';

                    if ($startPage > 1) {
                        $htmlPaginate .= '<li class="page-item"><a href="?limit=' . $limitPage . '&page=1' . $additionalQuery . '" class="page-link">1</a></li>';
                        $htmlPaginate .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }

                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $class = ($currentPage == $i) ? "active" : "";
                        $htmlPaginate .= '<li class="page-item ' . $class . '"><a href="?limit=' . $limitPage . '&page=' . $i . $additionalQuery . '" class="page-link">' . $i . '</a></li>';
                    }

                    if ($endPage < $lastPage) {
                        $htmlPaginate .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        $htmlPaginate .= '<li><a href="?limit=' . $limitPage . '&page=' . $lastPage . $additionalQuery . '" class="page-link">' . $lastPage . '</a></li>';
                    }

                    $class = ($currentPage == $lastPage || $totalPage == 0) ? "disabled" : "";
                    $htmlPaginate .= '<li class="page-item ' . $class . '"><a href="?limit=' . $limitPage . '&page=' . ($currentPage + 1) . $additionalQuery . '" class="page-link">Siguiente</a></li>';

                    $htmlPaginate .= '</ul></nav>';

                    echo $htmlPaginate;

                }
            ?>

        </div>
    </div>

</div>

<?php require_once __DIR__ . '/Partial/DocumentPrinterModal.php' ?>

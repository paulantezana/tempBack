<div class="container pt-4 pb-4">

    <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>


    <div class="row mb-4">
        <div class="col-auto mr-auto">
            <h1>
                <span>🖶 </span>
                <span>Ventas</span>
            </h1>
        </div>
        <div class="col-auto d-flex align-items-center">
            <div class="btn-group">
                <a href="#" class="btn btn-light">Exportar</a>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuNewInvoice" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Emitir comprobante (CPE)
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuNewInvoice">
                        <a href="<?= FOLDER_NAME . '/Invoice/NewInvoice' ?>" class="dropdown-item">Nueva FACTURA</a>
                        <a href="<?= FOLDER_NAME . '/Invoice/NewTicket' ?>" class="dropdown-item">Nueva BOLETA DE VENTA</a>
                    </div>
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
                <form action="<?= FOLDER_NAME . '/Invoice'?>" method="GET" class="mt-4">
                    <div class="form-row">
                        <div class="form-group col-lg-3">
                            <label for="filterDocumentCode"><i class="icon-file-text mr-2"></i> Tipo de comprobante</label>
                            <select class="form-control select2" id="filterDocumentCode" name="filter[documentCode]">
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
                            <label for="filterCustomer"><i class="icon-users mr-2"></i> Cliente</label>
                            <select class="searchCustomer" id="filterCustomer" name="filter[customer]" data-live-search="true" data-width="100%">
                                <?php if(($parameter['filter']['customer']['documentNumber'] ?? false)) :  ?>
                                    <option value="<?= $parameter['filter']['customer']['documentNumber'] ?? 0?>" selected><?= $parameter['filter']['customer']['description'] ?? ''?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="filterStartDate"><i class="icon-calendar mr-2"></i> Rango de Fechas</label>
                            <input type="date" class="form-control" name="filter[startDate]" id="filterStartDate" value="<?= $parameter['filter']['startDate'] ?? null ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="filterEndDate">Fecha final</label>
                            <input type="date" class="form-control" name="filter[endDate]" id="filterEndDate" value="<?= $parameter['filter']['endDate'] ?? null ?>">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="filterInvoiceSearch"><i class="icon-barcode2 mr-2"></i> Buscar documento por serie / número</label>
                            <select class="invoiceSearch" id="filterInvoiceSearch" name="filter[invoiceSearch]" data-live-search="true" data-width="100%">
                                <?php if($parameter['filter']['invoiceSearch']['invoiceId'] ?? false) :  ?>
                                    <option value="<?= $parameter['filter']['invoiceSearch']['invoiceId'] ?? 0?>" selected><?= $parameter['filter']['invoiceSearch']['description'] ?? ''?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="btn-group col-lg-4">
                            <button type="submit" class="btn btn-primary"><i class="icon-filter4 mr-2"></i> Filtrar</button>
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
                    <li><img style="max-width: 30px;" src="<?= FOLDER_NAME . '/Asset/Images/sunat_logo.png'?>" class="mr-2"><span class="text-semibold">Estados SUNAT: </span></li>
                    <li class="ml-3"> <i class="icon-checkmark font-weight-bold text-success mr-2"></i> Aceptado</li>
                    <li class="ml-3"> <i class="icon-spinner4 text-primary font-weight-bold mr-2"></i> Resumen </li>
                    <li class="ml-3"> <i class="icon-spinner11 text-success font-weight-bold  mr-2"></i>  Pendiente de Envío</li>
                    <li class="ml-3"> <i class="icon-cancel-circle2 text-danger font-weight-bold  mr-2"></i> Comunicación de Baja (Anulado)</li>
                </ul>
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-striped ">
                    <thead>
                        <tr style="font-size: 14px">
                            <th>FECHA</th>
                            <th>Comprovante</th>
                            <th>Cliente</th>
                            <th>M</th>
                            <th>Total Onerosa</th>
                            <th>Total Gratuita</th>
                            <th>Enviado al cliente</th>
                            <th>PDF</th>
                            <th>XML</th>
                            <th>CDR</th>
                            <th>Estado en la Sunat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totalInvoice = 0;
                            $totalTicket = 0;

                        foreach ($parameter['invoice']['data'] ?? [] as $row):
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

                            $textColor = $row['response_code'] === '0' ? 'success' : 'danger';
                        ?>
                            <tr class="<?= ($row['invoice_state_id'] ?? 0) == 4 ? 'table-danger' : '' ?>">
                                <td><?= $cDate ?></td>
                                <td><?php echo  "{$row['document_type_code_description']}: {$row['serie']} - {$row['correlative'] }" ?></td>
                                <td>
                                    <div><?= $row['customer_document_number'] ?? '' ?></div>
                                    <div><?= $row['customer_social_reason'] ?? '' ?></div>
                                </td>
                                <td><?= $row['currency_type'] ?? '' ?></td>
                                <td><?= $row['total'] ?? 0 ?></td>
                                <td><?= $row['total_free'] ?? 0 ?></td>
                                <td>
                                    <?php if ($row['customer_sent_to_client']): ?>
                                        <i class="icon-checkmark mr-2" title="Enviado al cliente"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['pdf_url'] != ''): ?>
                                        <button class="btn btn-sm btn-light" onclick="DocumentPrinter.showModal('..<?= $row['pdf_url'] ?? '' ?>', false)" title="PDF"><i class="icon-file-pdf text-danger"></i></button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['xml_url'] != ''): ?>
                                        <a
                                            href="..<?= $row['xml_url'] ?? '' ?>"
                                            download="<?php $fileName = explode('/', $row['xml_url'] ?? ''); echo  'XML-'. $fileName[count($fileName) - 1]?>"
                                            class="btn btn-sm btn-light"
                                            title="XML"
                                        >
                                            <i class="icon-file-xml text-success"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['document_code'] === '01' && $row['response_code'] == '0' && $row['cdr_url'] != '' ) : ?>
                                        <a
                                            href="..<?= $row['cdr_url'] ?? '' ?>"
                                            download="<?php $fileName = explode('/', $row['cdr_url'] ?? ''); echo  'CDR-'. $fileName[count($fileName) - 1]?>"
                                            class="btn btn-sm btn-light"
                                            title="CDR"
                                        >
                                            <span class="text-primary">CDR</span>
                                        </a>
                                    <?php elseif ($row["document_code"] == '03' && $row['invoice_state_id'] == 3): ?>
                                        <a href="<?=  FOLDER_NAME . '/InvoiceSummary' ?>" title="Ver resumen" style="font-size: 0.85rem">
                                            <i class="icon-spinner4 text-primary mr-2"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Estado SUNAT">
                                            <?php if ($row['document_code'] == '01'): ?>
                                                <?php if ($row['invoice_state_id'] == 1 || $row['invoice_state_id'] == 2): ?>
                                                    <i class="icon-spinner11 text-warning  mr-2"></i>
                                                    <div class="spinner-border spinner-border-sm text-warning" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php elseif ($row['response_code'] === '0' && $row['invoice_state_id'] == 3): ?>
                                                    <i class="icon-checkmark mr-2 text-success"></i>
                                                <?php elseif ($row['invoice_state_id'] == 4): ?>
                                                    <i class="icon-cancel-circle2 text-danger mr-2"></i>
                                                <?php else: ?>
                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php endif;?>
                                            <?php elseif ($row['document_code'] == '03'): ?>
                                                <?php if ($row['invoice_state_id'] == 1 || $row['invoice_state_id'] == 2): ?>
                                                    <i class="icon-spinner4 text-primary mr-2"></i>
                                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php elseif ($row['invoice_state_id'] == 3): ?>
                                                    <i class="icon-spinner4 text-primary mr-2"></i>
                                                <?php elseif ($row['invoice_state_id'] == 4): ?>
                                                    <i class="icon-cancel-circle2 text-danger mr-2"></i>
                                                <?php else: ?>
                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                <?php endif;?>
                                            <?php endif; ?>
                                        </button>
                                            <div class="dropdown-menu">
                                                <?php if ($row['document_code'] === '01'): ?>
                                                    <div style="padding: 1rem">
                                                        <table class="table table-sm no-border" style="width: 400px">
                                                            <tbody class="text-<?= $textColor ?>">
                                                                <tr>
                                                                    <td>Enviado A Sunat:</td>
                                                                    <td><?php echo $row['response_code'] == '0' ? '<i class="icon-checkmark mr-2"></i>' : '<i class="fas fa-times"></i>' ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Aceptada por la SUNAT:</td>
                                                                    <td><?php echo $row['response_code'] == '0' ? '<i class="icon-checkmark mr-2"></i>' : '<i class="fas fa-times"></i>' ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Código:</td>
                                                                    <td><?= $row['response_code'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Descripción:</td>
                                                                    <td><?= $row['response_message'] ?? '' ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Otros:</td>
                                                                    <td><?= $row['other_message'] ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php elseif ($row['document_code'] === '03'): ?>
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
                                                                    <td><?= $row['other_message'] ?></td>
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
                                        <button class="btn btn-light btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Opciones" >
                                            <i class="icon-menu9"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= FOLDER_NAME . '/Invoice/View?InvoiceId=' . $row['invoice_id'] ?>"> <i class="icon-file-eye mr-2"></i> Ver detalles</a>
                                            <?php if (($row['invoice_state_id'] == 1 || $row['invoice_state_id'] == 2) && $row['document_code'] === '01' ): ?>
                                                <a class="dropdown-item text-danger" href="<?= FOLDER_NAME . '/Invoice/ResendInvoice?InvoiceId=' . $row['invoice_id'] ?>"><i class="icon-spinner11 text-success  mr-2"></i> Consultar o recuperar constancia</a>
                                            <?php endif; if (($row['invoice_state_id'] ?? 0) >= 1 && ($row['invoice_state_id'] ?? 0) < 4): ?>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#invoiceSendEmailModal"><i class="icon-envelop mr-2"></i>  Enviar a un email personalizado</a>
                                                <a class="dropdown-item" href="<?= FOLDER_NAME . '/InvoiceNote/NewCreditNote?InvoiceId=' . $row['invoice_id'] ?>"> <i class="icon-file-text mr-2"></i> Generar NOTA DE CREDITO</a>
                                                <a class="dropdown-item" href="<?= FOLDER_NAME . '/InvoiceNote/NewDebitNote?InvoiceId=' . $row['invoice_id'] ?>"> <i class="icon-file-text mr-2"></i> Generar NOTA DE DEBITO</a>
                                                <a class="dropdown-item" href="<?= FOLDER_NAME . '/ReferralGuide/NewGuide?InvoiceId=' . $row['invoice_id']  ?>"> <i class="icon-file-text mr-2"></i> Generar GUIA DE REMISIÓN</a>
                                            <?php endif; if (($row['invoice_state_id'] == 3 && $row['document_code'] == '01') || (($row['invoice_state_id'] == 2 || $row['invoice_state_id'] == 3) && $row['document_code'] == '03')): ?>
                                                <a class="dropdown-item text-danger" href="<?= FOLDER_NAME . '/InvoiceVoided/NewInvoiceVoided?InvoiceId=' . $row['invoice_id'] ?>"><i class="icon-cancel-circle2 text-danger mr-2"></i> ANULAR o COMUNICAR DE BAJA</a>
                                            <?php endIf;?>
                                            <a class="dropdown-item text-success" href="#" target="_blank"> <img src="<?= FOLDER_NAME . '/Asset/Images/sunat_logo.png'?>" height="16px" class="mr-2"> Verificar en la SUNAT la validéz del CPE</a>
                                            <a class="dropdown-item text-success" href="#" target="_blank"> <img src="<?= FOLDER_NAME . '/Asset/Images/sunat_logo.png'?>" height="16px" class="mr-2"> Verificar XML en la SUNAT</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-right">Total de FACTURAS:</td>
                            <td><?= $totalInvoice ?></td>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right">Total de BOLETAS DE VENTAS:</td>
                            <td><?= $totalTicket ?></td>
                            <td colspan="7"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?php
                $currentPage = $parameter['invoice']['current'] ?? 1;
                $totalPage = $parameter['invoice']['pages'] ?? 1;
                $limitPage = $parameter['invoice']['limit'] ?? 10;
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
    require_once __DIR__ . '/Partial/InvoiceSendEmailModal.php';
    require_once __DIR__ . '/Partial/DocumentPrinterModal.php';
?>

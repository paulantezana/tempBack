 <div class="container pt-5 pb-5">
     <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>

    <div class="row mb-5">
        <div class="col-auto mr-auto">
            <h1>
                <span>🖶 </span>
                <span>Guías de Remisión</span>
            </h1>
        </div>
        <div class="col-auto d-flex align-items-center btn-group">
            <a href="#" class="btn btn-light">Exportar</a>
            <a href="<?= FOLDER_NAME . '/ReferralGuide/NewGuide' ?>" class="btn btn-primary">Nueva Guía de Remisión</a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch1" data-toggle="collapse" data-target="#collapseAdvancedOptions" aria-expanded="false">
                <label class="custom-control-label" for="customSwitch1">Ver Opciones Avanzadas:</label>
            </div>
            <div class="collapse" id="collapseAdvancedOptions">
                <form action="<?= FOLDER_NAME . '/ReferralGuide'?>" method="GET" class="mt-4">
                <div class="form-row">

                    <div class="form-group col-lg-3">
                        <label for="filterCustomerId">Entidad</label>
                        <select class="selectpicker with-ajax searchCustomer" id="filterCustomerId" name="filterCustomerId" data-live-search="true" data-width="100%">
                            <?php if(($parameter['filter']['filterCustomer']['customer_id'] ?? false)) :  ?>
                                <option value="<?= $parameter['filter']['filterCustomer']['customer_id']?>" selected><?= $parameter['filter']['filterCustomer']['description']?></option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="filterReferralGuideId">Buscar por guía</label>
                        <select class="selectpicker with-ajax searchReferralGuide" id="filterReferralGuideId" name="filterReferralGuideId" data-live-search="true" data-width="100%">
                            <?php if(($parameter['filter']['filterReferralGuide']['referral_guide_id']) ?? false) :  ?>
                                <option value="<?= $parameter['filter']['filterReferralGuide']['referral_guide_id']?>" selected><?= $parameter['filter']['filterReferralGuide']['description']?></option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="filterStartDate">Fecha inicio</label>
                        <input type="date" class="form-control" name="filterStartDate" id="filterStartDate" value="<?= $_GET['filterStartDate'] ?? null ?>">
                    </div>

                    <div class="form-group col-lg-3">
                        <label for="filterEndDate">Fecha final</label>
                        <input type="date" class="form-control" name="filterEndDate" id="filterEndDate" value="<?= $_GET['filterEndDate'] ?? null ?>">
                    </div>

                    <div class="col-lg-4 btn-group">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="<?= FOLDER_NAME . '/ReferralGuide'?>" class="btn btn-light">Mostrar Todo</a>
                    </div>

                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr style="font-size: 14px">
                            <th style="width: 100px" >Fecha</th>
                            <th>Tipo</th>
                            <th>Serie</th>
                            <th>Num.</th>
                            <th style="width: 400px">Entidad</th>
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
                            foreach (($parameter['referralGuide']['data'] ?? []) as $row):
                                $sunatResponseCode = '0';
                                $textColor = $sunatResponseCode === '0' ? 'success' : 'danger';
                        ?>
                            <tr>
                                <td><?= $row['date_of_issue'] ?? '' ?></td>
                                <td><?= $row['document_code'] ?? '' ?></td>
                                <td><?= $row['serie'] ?? '' ?></td>
                                <td><?= $row['correlative'] ?? '' ?></td>
                                <td><?= $row['customer_social_reason'] ?? '' ?></td>
                                <td>
                                    <?php if (($row['sent_to_client'] ?? '')  != ''): ?>
                                        <i class="fas fa-check" title="Enviado al cliente"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['pdf_url'] != ''): ?>
                                        <button class="btn btn-sm btn-light" onclick="DocumentPrinter.showModal('<?= $row['pdf_url'] ?? '' ?>', true)" title="Imprimir PDF">Imprimir</button>
                                    <?php endif; ?>
                                </td>
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
                                    <?php if ($row['cdr_url'] != '' ) : ?>
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
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                        </button>
                                        <ul class="dropdown-menu">
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
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group ">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Opciones" >
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item text-danger" href="<?= FOLDER_NAME . '/ReferralGuide/ResendReferralGuide?GuideId=' . $row['referral_guide_id'] ?>"> <i class="fas fa-file-alt"></i> Consultar o recuperar constancia</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>

            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item <?php if(($parameter['referralGuide']['current'] ?? 0) <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if(($parameter['referralGuide']['current'] ?? 0) <= 1){ echo '#'; } else { echo "?page=".(($parameter['referralGuide']['current'] ?? 0) - 1); } ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                    </li>
                    <?php for ($i=1; $i <= $parameter['referralGuide']['pages'] ?? 1; $i++): if ($i == $parameter['referralGuide']['current'] ?? 1): ?>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?> <span class="sr-only">(current)</span></a>
                        </li>
                    <?php else:  ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endif; endfor; ?>
                    <li class="page-item <?php if(($parameter['referralGuide']['current'] ?? 0) >= ($parameter['referralGuide']['pages'] ?? 0)){ echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if(($parameter['referralGuide']['current'] ?? 0) >= ($parameter['referralGuide']['pages'] ?? 0)){ echo '#'; } else { echo "?page=".(($parameter['referralGuide']['current'] ?? 0) + 1); } ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>
<?php
    require_once __DIR__ . '/Partials/ReferralGuideSendEmailModal.php';
    require_once __DIR__ . '/Partials/ReferralGuideModal.php';
    require_once __DIR__ . '/Partials/DocumentPrinterModal.php';
?>

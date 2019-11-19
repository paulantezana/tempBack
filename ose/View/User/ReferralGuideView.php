<div class="container">
    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>
    <div class="mt-5 mb-5">
        <h5 class="mb-3"><?= $parameter['guide']['voucher_type_description'] ?? '' ?></h5>
        <div class="btn btn-group" style="padding: 0">
            <div class="btn btn-primary" onclick="ReferralGuideShowPdf('<?= $parameter['guide']['pdf_url'] ?? '' ?>', true)">Imprimir</div>
            <div class="btn btn-light" onclick="ReferralGuideShowPdf('<?= $parameter['guide']['pdf_url'] ?? '' ?>', false)">VER PDF</div>
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#referralGuideSendEmailModal">Enviar Email</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">

        </div>
    </div>

    <div class="card mb-5">
        <div class="card-body">

            <div class="card mb-4">
                <div class="card-header">
                    DATOS DEL TRASLADO
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">FECHA EMISIÓN: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['date_of_issue'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">FECHA INICIO DE TRASLADO: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['transfer_start_date'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">MOTIVO DE TRASLADO: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['transfer_code'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">MODALIDAD DE TRANSPORTE: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['transport_code'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">PESO BRUTO TOTAL (KGM): </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['total_gross_weight'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">NÚMERO DE BULTOS: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['number_packages'] ?? '' ?></div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    DATOS DEL TRANSPORTISTA
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $cDocIndex = array_search($parameter['guide']['carrier_document_code'] ?? '', array_column($identityDocumentTypeCode ?? [],'code')); ?>
                        <div class="col-md-6 text-right font-weight-bold"><?= $parameter['identityDocumentTypeCode'][$cDocIndex]['description'] ?? '' ?></div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['carrier_document_number'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">Denominacion: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['carrier_denomination'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">Placa numero: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['carrier_plate_number'] ?? '' ?></div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    DATOS DEL CONDUCTOR
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $dDocIndex = array_search($parameter['guide']['driver_document_code'] ?? '', array_column($identityDocumentTypeCode ?? [],'code')); ?>
                        <div class="col-md-6 text-right font-weight-bold"><?= $parameter['identityDocumentTypeCode'][$dDocIndex]['description'] ?? '' ?></div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['driver_document_number'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">Nombre completo del conductor: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['driver_full_name'] ?? '' ?></div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    PUNTO DE PARTIDA
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">UBIGEO dirección de partida: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['location_starting_code'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">Dirección del punto de partida: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['address_starting_point'] ?? '' ?></div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    PUNTO DE LLEGADA
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">UBIGEO dirección de salida: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['location_arrival_code'] ?? '' ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-right font-weight-bold">Dirección del punto de llegada: </div>
                        <div class="col-md-6 text-left "><?= $parameter['guide']['address_arrival_point'] ?? '' ?></div>
                    </div>
                </div>
            </div>

            <p><?= $parameter['guide']['observations'] ?? '' ?></p>
        </div>
    </div>

</div>

<?php
    require_once __DIR__ . '/Partials/ReferralGuideSendEmailModal.php';
    require_once __DIR__ . '/Partials/ReferralGuideModal.php';
?>
<div class="container">

    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>

    <form action="<?= FOLDER_NAME . '/Invoice/NewTicket' ?>" method="POST" class="mt-4 mb-4">

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

                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-xl-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-1" name="invoice[jungle_product]" <?= ($parameter['invoice']['jungle_product'] ?? false) ? 'checked' : ''  ?> >
                                            <label for="checkbox-1" class="custom-control-label">¿Bienes Region Selva?</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-2" name="invoice[jungle_service]" <?= ($parameter['invoice']['jungle_service'] ?? false) ? 'checked' : ''  ?> >
                                            <label for="checkbox-2" class="custom-control-label">¿Servicios Region Selva?</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-4 <?php echo ($parameter['invoice']['detraction_enabled'] ?? false) ? '' : 'd-none'  ?>" id="InvoiceDetractionEnableRow">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="invoice[detraction_enabled]"
                                                   id="invoiceDetractionEnable" data-toggle="collapse" data-target="#collapseInvoiceDetraction" <?php echo ($parameter['invoice']['detraction_enabled'] ?? false) ? 'checked' : ''  ?> aria-expanded="false">
                                            <label class="custom-control-label" for="invoiceDetractionEnable">¿Detracción?</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-4 <?php echo ($parameter['invoice']['detraction_enabled'] ?? false) ? 'd-none' : ''  ?>" id="InvoicePerceptionEnableRow">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="invoice[perception_enabled]"
                                                   id="invoicePerceptionEnable" data-toggle="collapse" data-target="#collapseInvoicePerception" <?php echo ($parameter['invoice']['perception_enabled'] ?? false) ? 'checked' : ''  ?> aria-expanded="false">
                                            <label class="custom-control-label" for="invoicePerceptionEnable">Percepción</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="invoice[referral_guide_enabled]"
                                                   id="invoiceGuideEnable" data-toggle="collapse" data-target="#collapseInvoiceGuide" <?php echo ($parameter['invoice']['referral_guide_enabled'] ?? false) ? 'checked' : ''  ?> aria-expanded="false">
                                            <label class="custom-control-label" for="invoiceGuideEnable">Guia</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="invoice[itinerant_enable]"
                                                   id="invoiceItinerantEnable" data-toggle="collapse" data-target="#collapseItinerant" <?php echo ($parameter['invoice']['itinerant_enable'] ?? false) ? 'checked' : ''  ?> aria-expanded="false">
                                            <label class="custom-control-label" for="invoiceItinerantEnable">Emisor itinerante</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="collapse <?php echo ($parameter['invoice']['detraction_enabled'] ?? false) ? 'show' : ''  ?>" id="collapseInvoiceDetraction">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="invoiceSubjectDetractionCode">Tipo de detracción</label>
                                            <select class="form-control form-control-sm <?= ($parameter['error']['subject_detraction_code'] ?? false) ? 'is-invalid' : ''  ?>" id="invoiceSubjectDetractionCode"
                                                    name="invoice[subject_detraction_code]">
                                                <option value="">Elegir</option>
                                                <?php foreach ($parameter['subjectDetractionCode'] ?? [] as $row) : ?>
                                                    <option value="<?= $row['code'] ?>" <?php echo ($parameter['invoice']['subject_detraction_code'] ?? false) == $row['code'] ? 'selected' : '' ?>>
                                                        <?= $row['description'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['subject_detraction_code'] ?? false) ? $parameter['error']['subject_detraction_code']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="invoiceDetractionPercentage">Porcentaje </label>
                                            <input type="number" step="any" class="form-control form-control-sm <?= ($parameter['error']['detraction_percentage'] ?? false) ? 'is-invalid' : ''  ?>" id="invoiceDetractionPercentage"
                                                   name="invoice[detraction_percentage]" value="<?= $parameter['invoice']['detraction_percentage'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_percentage'] ?? false) ? $parameter['error']['detraction_percentage']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="detractionLocationStartingCode">Ubigeo Origen</label>
                                            <select class="selectpicker with-ajax geographicalLocationSearch <?= ($parameter['error']['detraction_location_starting_code'] ?? false) ? 'is-invalid' : ''  ?>" data-live-search="true" id="detractionLocationStartingCode" data-width="100%"
                                                    name="invoice[detraction_location_starting_code]">
                                                <option value="">Buscar ubigeo</option>
                                                <?php if (($parameter['invoice']['location_starting']['code'] ?? false)) :  ?>
                                                    <option value="<?= $parameter['invoice']['location_starting']['code'] ?>" selected><?= $parameter['invoice']['location_starting']['description'] ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="detractionAddressStartingPoint">Dirección Origen</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_address_starting_point'] ?? false) ? 'is-invalid' : ''  ?>" id="detractionAddressStartingPoint"
                                                   name="invoice[detraction_address_starting_point]" value="<?= $parameter['invoice']['detraction_address_starting_point'] ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="detractionLocationArrivalCode">Ubigeo Destino</label>
                                            <select class="selectpicker with-ajax geographicalLocationSearch <?= ($parameter['error']['detraction_location_arrival_code'] ?? false) ? 'is-invalid' : ''  ?> " data-live-search="true" id="detractionLocationArrivalCode" data-width="100%"
                                                    name="invoice[detraction_location_arrival_code]">
                                                <option value="">Buscar ubigeo</option>
                                                <?php if (($parameter['guide']['location_arrival']['code'] ?? false)) :  ?>
                                                    <option value="<?= $parameter['invoice']['location_arrival']['code'] ?>" selected><?= $parameter['invoice']['location_arrival']['description'] ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="detractionAddressArrivalPoint">Dirección Destino</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_address_arrival_point'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionAddressArrivalPoint" value="<?= $parameter['invoice']['detraction_address_arrival_point'] ?? '' ?>"
                                                   name="invoice[detraction_address_arrival_point]">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 form-group">
                                            <label for="detractionAddressArrivalPoint">Valor Referencial Servicio de Transporte</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_referral_value'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionAddressArrivalPoint" value="<?= $parameter['invoice']['detraction_referral_value'] ?? '' ?>"
                                                   name="invoice[detraction_referral_value]">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_referral_value'] ?? false) ? $parameter['error']['detraction_referral_value']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label for="detractionAddressArrivalPoint">Valor Referencia Carga Efectiva</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_effective_load'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionAddressArrivalPoint" value="<?= $parameter['invoice']['detraction_effective_load'] ?? '' ?>"
                                                   name="invoice[detraction_effective_load]" >
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_effective_load'] ?? false) ? $parameter['error']['detraction_effective_load']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label for="detractionAddressArrivalPoint">Valor Referencial Carga Útil</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_useful_load'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionAddressArrivalPoint" value="<?= $parameter['invoice']['detraction_useful_load'] ?? '' ?>"
                                                   name="invoice[detraction_useful_load]" >
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_useful_load'] ?? false) ? $parameter['error']['detraction_useful_load']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="detractionAddressArrivalPoint">Detalle del Viaje</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_travel_detail'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionAddressArrivalPoint" value="<?= $parameter['invoice']['detraction_travel_detail'] ?? '' ?>"
                                                   name="invoice[detraction_travel_detail]" >
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_travel_detail'] ?? false) ? $parameter['error']['detraction_travel_detail']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="JsRowHydro">
                                        <div class="col-lg-4 form-group">
                                            <label for="detractionBoatRegistration">Matrícula Embarcación</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_boat_registration'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionBoatRegistration" value="<?= $parameter['invoice']['detraction_boat_registration'] ?? '' ?>"
                                                   name="invoice[detraction_boat_registration]">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_boat_registration'] ?? false) ? $parameter['error']['detraction_boat_registration']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label for="detractionBoatName">Nombre Embarcación</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_boat_name'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionBoatName" value="<?= $parameter['invoice']['detraction_boat_name'] ?? '' ?>"
                                                   name="invoice[detraction_boat_name]" >
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_boat_name'] ?? false) ? $parameter['error']['detraction_boat_name']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label for="detractionSpeciesKind">Tipo Especie vendida</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_species_kind'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionSpeciesKind" value="<?= $parameter['invoice']['detraction_species_kind'] ?? '' ?>"
                                                   name="invoice[detraction_species_kind]">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_species_kind'] ?? false) ? $parameter['error']['detraction_species_kind']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label for="detractionDeliveryAddress">Lugar de descarga</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_delivery_address'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionDeliveryAddress" value="<?= $parameter['invoice']['detraction_delivery_address'] ?? '' ?>"
                                                   name="invoice[detraction_delivery_address]">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_delivery_address'] ?? false) ? $parameter['error']['detraction_delivery_address']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label for="detractionQuantity">Cantidad de la Especie vendida</label>
                                            <input type="text" class="form-control form-control-sm <?= ($parameter['error']['detraction_quantity'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionQuantity" value="<?= $parameter['invoice']['detraction_quantity'] ?? '' ?>"
                                                   name="invoice[detraction_quantity]" >
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_quantity'] ?? false) ? $parameter['error']['detraction_quantity']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 form-group">
                                            <label for="detractionDeliveryDate">Fecha de descarga</label>
                                            <input type="date" class="form-control form-control-sm <?= ($parameter['error']['detraction_delivery_date'] ?? false) ? 'is-invalid' : ''  ?> " id="detractionDeliveryDate" value="<?= $parameter['invoice']['detraction_delivery_date'] ?? '' ?>"
                                                   name="invoice[detraction_delivery_date]" >
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['detraction_delivery_date'] ?? false) ? $parameter['error']['detraction_delivery_date']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="collapse <?php echo ($parameter['invoice']['perception_enabled'] ?? false) ? 'show' : ''  ?>" id="collapseInvoicePerception">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="invoicePerceptionCode">Tipo de percepcion</label>
                                        <select class="form-control form-control-sm <?= ($parameter['error']['perception_code'] ?? false) ? 'is-invalid' : ''  ?>" name="invoice[perception_code]" id="invoicePerceptionCode">
                                            <option value="">Elegir</option>
                                            <?php foreach ($parameter['perceptionTypeCode'] ?? [] as $row): ?>
                                                <option value="<?= $row['code'] ?>" data-percentage="<?= $row['percentage'] ?>" <?php echo ($parameter['invoice']['perception_code'] ?? false) == $row['code'] ? 'selected' : '' ?>>
                                                    <?php echo $row['percentage'] . '% ' . $row['description'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?php echo ($parameter['error']['perception_code'] ?? false) ? $parameter['error']['perception_code']['messages'][0] : '' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="collapse <?php echo ($parameter['invoice']['referral_guide_enabled'] ?? false) ? 'show' : ''  ?>" id="collapseInvoiceGuide">
                            <div class="card mb-4">
                                <div class="card-body">

                                    <p>DATOS DEL TRASLADO</p>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="transferCode">Motivo de traslado</label>
                                            <select class="form-control selectpicker <?= ($parameter['error']['transfer_code'] ?? false) ? 'is-invalid' : ''  ?>" id="transferCode" name="invoice[referral_guide][transfer_code]" data-live-search="true">
                                                <option value="">Elegir</option>
                                                <?php foreach ($parameter['transferReasonCode'] ?? [] as $row) : ?>
                                                    <option value="<?= $row['code'] ?>" <?php echo ($parameter['invoice']['referral_guide']['transfer_code'] ?? false) == $row['code'] ? 'selected' : '' ?>>
                                                        <?= $row['description'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['transfer_code'] ?? false) ? $parameter['error']['transfer_code']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="transportCode">Tipo de transporte</label>
                                            <select class="form-control selectpicker <?= ($parameter['error']['transport_code'] ?? false) ? 'is-invalid' : ''  ?>" id="transportCode" name="invoice[referral_guide][transport_code]" data-live-search="true">
                                                <option value="">Elegir</option>
                                                <?php foreach ($parameter['transportModeCode'] ?? [] as $row) : ?>
                                                    <option value="<?= $row['code'] ?>" <?php echo ($parameter['invoice']['referral_guide']['transport_code'] ?? false) == $row['code'] ? 'selected' : '' ?>>
                                                        <?= $row['description'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['transport_code'] ?? false) ? $parameter['error']['transport_code']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="transferStartDate">Fecha de inicio de traslado</label>
                                            <input type="date" class="form-control <?= ($parameter['error']['transfer_start_date'] ?? false) ? 'is-invalid' : ''  ?>" id="transferStartDate" name="invoice[referral_guide][transfer_start_date]" value="<?= date('Y-m-d') ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['transfer_start_date'] ?? false) ? $parameter['error']['transfer_start_date']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="totalGrossWeight">Peso bruto total (KGM)</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['total_gross_weight'] ?? false) ? 'is-invalid' : ''  ?>" id="totalGrossWeight" name="invoice[referral_guide][total_gross_weight]" value="<?= $parameter['invoice']['referral_guide']['total_gross_weight'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['total_gross_weight'] ?? false) ? $parameter['error']['total_gross_weight']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                    </div>

                                    <p>DATOS DEL TRANSPORTISTA</p>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label for="carrierDocumentCode">Tipo de documento</label>
                                            <select class="form-control selectpicker <?= ($parameter['error']['carrier_document_code'] ?? false) ? 'is-invalid' : ''  ?>" id="carrierDocumentCode" name="invoice[referral_guide][carrier_document_code]" data-live-search="true">
                                                <option value="">Elegir</option>
                                                <?php foreach ($parameter['identityDocumentTypeCode'] ?? [] as $row) : ?>
                                                    <option value="<?= $row['code'] ?>" <?php echo ($parameter['invoice']['referral_guide']['carrier_document_code'] ?? false) == $row['code'] ? 'selected' : '' ?>>
                                                        <?= $row['description'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['carrier_document_code'] ?? false) ? $parameter['error']['carrier_document_code']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="carrierDocumentNumber">Documento numero</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['carrier_document_number'] ?? false) ? 'is-invalid' : ''  ?>" id="carrierDocumentNumber" name="invoice[referral_guide][carrier_document_number]" value="<?= $parameter['invoice']['referral_guide']['carrier_document_number'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['carrier_document_number'] ?? false) ? $parameter['error']['carrier_document_number']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="carrierDenomination">Denominacion</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['carrier_denomination'] ?? false) ? 'is-invalid' : ''  ?>" id="carrierDenomination" name="invoice[referral_guide][carrier_denomination]" value="<?= $parameter['invoice']['referral_guide']['carrier_denomination'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['carrier_denomination'] ?? false) ? $parameter['error']['carrier_denomination']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="carrierPlateNumber">Placa numero</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['carrier_plate_number'] ?? false) ? 'is-invalid' : ''  ?>" id="carrierPlateNumber" name="invoice[referral_guide][carrier_plate_number]" value="<?= $parameter['invoice']['referral_guide']['carrier_plate_number'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['carrier_plate_number'] ?? false) ? $parameter['error']['carrier_plate_number']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                    </div>

                                    <p>DATOS DEL CONDUCTOR</p>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="driverDocumentCode">Tipo de documento del conductor</label>
                                            <select class="selectpicker form-control <?= ($parameter['error']['driver_document_code'] ?? false) ? 'is-invalid' : ''  ?>" id="driverDocumentCode" name="invoice[referral_guide][driver_document_code]" data-live-search="true">
                                                <option value="">Elegir</option>
                                                <?php foreach ($parameter['identityDocumentTypeCode'] ?? [] as $row) : ?>
                                                    <option value="<?= $row['code'] ?>" <?php echo ($parameter['invoice']['referral_guide']['driver_document_code'] ?? false) == $row['code'] ? 'selected' : '' ?>>
                                                        <?= $row['description'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['driver_document_code'] ?? false) ? $parameter['error']['driver_document_code']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="driverDocumentNumber">Conductor documento numero</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['driver_document_number'] ?? false) ? 'is-invalid' : ''  ?>" id="driverDocumentNumber" name="invoice[referral_guide][driver_document_number]" value="<?= $parameter['invoice']['referral_guide']['driver_document_number'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['driver_document_number'] ?? false) ? $parameter['error']['driver_document_number']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="driverFullName">Nombre completo del conductor</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['driver_full_name'] ?? false) ? 'is-invalid' : ''  ?>" id="driverFullName" name="invoice[referral_guide][driver_full_name]" value="<?= $parameter['invoice']['referral_guide']['driver_full_name'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['driver_full_name'] ?? false) ? $parameter['error']['driver_full_name']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                    </div>

                                    <p>PUNTO DE PARTIDA</p>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="locationStartingCode">UBIGEO dirección de partida</label>
                                            <select class="selectpicker with-ajax geographicalLocationSearch <?= ($parameter['error']['location_starting_code'] ?? false) ? 'is-invalid' : ''  ?>" data-live-search="true" id="locationStartingCode" data-width="100%" name="invoice[referral_guide][location_starting_code]">
                                                <option value="">Buscar ubigeo</option>
                                                <?php if (($parameter['guide']['location_starting']['code'] ?? false)) :  ?>
                                                    <option value="<?= $parameter['guide']['location_starting']['code'] ?>" selected><?= $parameter['guide']['location_starting']['description'] ?></option>
                                                <?php endif; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['location_starting_code'] ?? false) ? $parameter['error']['location_starting_code']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="addressStartingPoint">Dirección del punto de partida</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['address_starting_point'] ?? false) ? 'is-invalid' : ''  ?>" id="addressStartingPoint" name="invoice[referral_guide][address_starting_point]" value="<?= $parameter['invoice']['referral_guide']['address_starting_point'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['address_starting_point'] ?? false) ? $parameter['error']['address_starting_point']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                    </div>

                                    <p>PUNTO DE LLEGADA</p>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="locationExitCode">UBIGEO dirección de salida</label>
                                            <select class="selectpicker with-ajax geographicalLocationSearch <?= ($parameter['error']['location_arrival_code'] ?? false) ? 'is-invalid' : ''  ?> " data-live-search="true" id="locationExitCode" data-width="100%" name="invoice[referral_guide][location_arrival_code]">
                                                <option value="">Buscar ubigeo</option>
                                                <?php if (($parameter['guide']['location_arrival']['code'] ?? false)) :  ?>
                                                    <option value="<?= $parameter['guide']['location_arrival']['code'] ?>" selected><?= $parameter['guide']['location_arrival']['description'] ?></option>
                                                <?php endif; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['location_arrival_code'] ?? false) ? $parameter['error']['location_arrival_code']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="addressArrivalPoint">Dirección del punto de llegada</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['address_arrival_point'] ?? false) ? 'is-invalid' : ''  ?> " id="addressArrivalPoint" name="invoice[referral_guide][address_arrival_point]" value="<?= $parameter['invoice']['referral_guide']['address_arrival_point'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['address_arrival_point'] ?? false) ? $parameter['error']['address_arrival_point']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="collapse <?php echo ($parameter['invoice']['itinerant_enable'] ?? false) ? 'show' : ''  ?>" id="collapseItinerant">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="locationItinerantLocation">UBIGEO</label>
                                            <select class="selectpicker with-ajax geographicalLocationSearch <?= ($parameter['error']['itinerant_location'] ?? false) ? 'is-invalid' : ''  ?>"
                                                    data-live-search="true" id="locationItinerantLocation" data-width="100%" name="invoice[itinerant_location]">
                                                <option value="">Buscar ubigeo</option>
                                                <?php if (($parameter['invoice']['itinerant_location']['code'] ?? false)) :  ?>
                                                    <option value="<?= $parameter['invoice']['itinerant_location']['code'] ?>" selected><?= $parameter['invoice']['itinerant_location']['description'] ?></option>
                                                <?php endif; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['itinerant_location'] ?? false) ? $parameter['error']['itinerant_location']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="invoiceItinerantAddress">Dirección</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['itinerant_address'] ?? false) ? 'is-invalid' : ''  ?> " id="invoiceItinerantAddress"
                                                   name="invoice[itinerant_address]" value="<?= $parameter['invoice']['itinerant_address'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['itinerant_address'] ?? false) ? $parameter['error']['itinerant_address']['messages'][0] : '' ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="invoiceItinerantUrbanization">Urbanizacion</label>
                                            <input type="text" class="form-control <?= ($parameter['error']['itinerant_urbanization'] ?? false) ? 'is-invalid' : ''  ?> " id="invoiceItinerantUrbanization"
                                                   name="invoice[itinerant_urbanization]" value="<?= $parameter['invoice']['itinerant_urbanization'] ?? '' ?>">
                                            <div class="invalid-feedback">
                                                <?php echo ($parameter['error']['itinerant_urbanization'] ?? false) ? $parameter['error']['itinerant_urbanization']['messages'][0] : '' ?>
                                            </div>
                                        </div>
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

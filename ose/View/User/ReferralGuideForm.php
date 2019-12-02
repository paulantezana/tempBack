    <div class="container">
        <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>

        <form action="<?= FOLDER_NAME . '/ReferralGuide/NewGuide'?>" method="POST" class="mb-4 mt-4">
            <div class="mb-4">
                <div>Documento eléctronico:</div>
                <h3><?= $parameter['documentTypeCode']['description'] ?? ''?></h3>
                <input type="hidden" class="form-control" name="guide[document_code]" value="<?= $parameter['documentTypeCode']['code'] ?? '' ?>">
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="selectCustomerSearch">Cliente</label>
                                <div class="input-group">
                                    <select class="selectpicker with-ajax searchCustomer <?= ($parameter['error']['customer_id'] ?? false) ? 'is-invalid' : ''  ?>" data-live-search="true" id="selectCustomerSearch" name="guide[customer_id]">
                                        <option value="">Buscar cliente</option>
                                        <?php if (isset($parameter['guide']['customer']['customer_id'])): ?>
                                            <option value="<?= $parameter['guide']['customer']['customer_id'] ?? ''?>" selected >
                                                <?php echo ($parameter['guide']['customer']['document_number'] ?? '') . ' ' . ($parameter['guide']['customer']['social_reason'] ?? '') ?>
                                            </option>
                                        <?php endif; ?>
                                    </select>
                                    <div class="input-group-prepend">
                                        <button class="btn btn-primary btn-sm" type="button" id="invoiceNewCustomer">Nuevo</button>
                                    </div>
                                    <div class="invalid-feedback">
<!--                                        --><?//= ($parameter['error']['customer_id'] ?? false) ? $parameter['error']['customer_id'][0] : ''  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <label for="serie" class="col-sm-8 col-form-label text-right">Serie</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm <?= ($parameter['error']['serie'] ?? false) ? 'is-invalid' : ''  ?>" id="serie" name="guide[serie]" value="<?= $parameter['correlativeSerie'] ?? '' ?>">
                                    <div class="invalid-feedback">
<!--                                        --><?//= ($parameter['error']['serie'] ?? false) ? $parameter['error']['serie'][0] : ''  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="correlative" class="col-sm-8 col-form-label text-right">Correlativo</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm <?= ($parameter['error']['correlative'] ?? false) ? 'is-invalid' : ''  ?>" id="correlative" name="guide[correlative]" value="<?= $parameter['correlative'] ?? '' ?>">
                                    <div class="invalid-feedback">
<!--                                        --><?//= ($parameter['error']['correlative'] ?? false) ? $parameter['error']['correlative'][0] : ''  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="guideDateOfIssue" class="col-sm-8 col-form-label text-right ">Fecha emisión</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control form-control-sm <?= ($parameter['error']['date_of_issue'] ?? false) ? 'is-invalid' : ''  ?>" id="guideDateOfIssue" name="guide[date_of_issue]" value="<?= date('Y-m-d') ?>" >
                                    <div class="invalid-feedback">
<!--                                        --><?//= ($parameter['error']['broadcast_date'] ?? false) ? $parameter['error']['date_of_issue'][0] : ''  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr style="font-size: 14px">
                                <th>Producto - Servicio (CATÁLOGO)</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="referralGuideTableBody">
                            <?php foreach ($parameter['guide']['item'] ?? [] as $key => $row): ?>
                                <tr id="referralGuideItem<?= $key ?>" data-uniqueId="<?= $key ?>">
                                    <td>
                                        <select class="selectpicker with-ajax" data-live-search="true" data-width="100%" id="selectProduct<?= $key ?>" name="guide[item][<?= $key ?>][product_id]" required>
                                            <option value="<?= $row['product_code'] ?? '' ?>" selected><?= $row['description'] ?? '' ?></option>
                                        </select>
                                        <input type="hidden" id="productCode<?= $key ?>" name="guide[item][<?= $key ?>][product_code]" value="<?= $row['product_code'] ?>">
                                        <input type="hidden" id="unitMeasure<?= $key ?>" name="guide[item][<?= $key ?>][unit_measure]" value="<?= $row['unit_measure'] ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="guide[item][<?= $key ?>][description]" value="<?= $row['description'] ?? '' ?>">
                                    </td>
                                    <td>
                                        <input type="number" step="any" min="0" class="form-control form-control-sm" name="guide[item][<?= $key ?>][quantity]" id="quantity<?= $key ?>" value="<?= $row['quantity'] ?? '' ?>" required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-light" id="remove<?= $key ?>" title="Quitar item">
                                            <i class="fas fa-times text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <?php if (isset($parameter['error']['item'])): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $parameter['error']['item'] ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="btn btn-primary btn-sm" id="addItemReferralGuide">Agregar linea o item</div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    DATOS DEL TRASLADO
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="transferCode">Motivo de traslado</label>
                            <select class="form-control selectpicker <?= ($parameter['error']['transfer_code'] ?? false) ? 'is-invalid' : ''  ?>" id="transferCode" name="guide[transfer_code]" data-live-search="true">
                                <option value="">Elegir</option>
                                <?php foreach ($parameter['transferReasonCode'] ?? [] as $row): ?>
                                    <option
                                        value="<?= $row['code']?>"
                                        <?php echo ($parameter['guide']['transfer_code'] ?? false ) == $row['code'] ? 'selected' : '' ?>
                                    >
                                        <?= $row['description']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['transfer_code'] ?? false) ? $parameter['error']['transfer_code'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="transportCode">Tipo de transporte</label>
                            <select class="form-control selectpicker <?= ($parameter['error']['transport_code'] ?? false) ? 'is-invalid' : ''  ?>" id="transportCode" name="guide[transport_code]" data-live-search="true">
                                <option value="">Elegir</option>
                                <?php foreach ($parameter['transportModeCode'] ?? [] as $row): ?>
                                    <option
                                        value="<?= $row['code']?>"
                                        <?php echo ($parameter['guide']['transport_code'] ?? false ) == $row['code'] ? 'selected' : '' ?>
                                    >
                                        <?= $row['description']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['transport_code'] ?? false) ? $parameter['error']['transport_code'][0] : ''  ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="transferStartDate">Fecha de inicio de traslado</label>
                            <input type="date" class="form-control <?= ($parameter['error']['transfer_start_date'] ?? false) ? 'is-invalid' : ''  ?>" id="transferStartDate" name="guide[transfer_start_date]" value="<?= date('Y-m-d') ?>">
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['transfer_start_date'] ?? false) ? $parameter['error']['transfer_start_date'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="totalGrossWeight">Peso bruto total (KGM)</label>
                            <input type="text" class="form-control <?= ($parameter['error']['total_gross_weight'] ?? false) ? 'is-invalid' : ''  ?>" id="totalGrossWeight" name="guide[total_gross_weight]" value="<?= $parameter['guide']['total_gross_weight'] ?? '' ?>">
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['total_gross_weight'] ?? false) ? $parameter['error']['total_gross_weight'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="numberPackages">Numero de bultos</label>
                            <input type="text" class="form-control <?= ($parameter['error']['number_packages'] ?? false) ? 'is-invalid' : ''  ?>" id="numberPackages" name="guide[number_packages]" value="<?= $parameter['guide']['number_packages'] ?? '' ?>">
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['number_packages'] ?? false) ? $parameter['error']['number_packages'][0] : ''  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    DATOS DEL TRANSPORTISTA
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label for="carrierDocumentCode">Tipo de documento</label>
                            <select class="form-control selectpicker <?= ($parameter['error']['carrier_document_code'] ?? false) ? 'is-invalid' : ''  ?>" id="carrierDocumentCode" name="guide[carrier_document_code]" data-live-search="true">
                                <option value="">Elegir</option>
                                <?php foreach ($parameter['identityDocumentTypeCode'] ?? [] as $row): ?>
                                    <option
                                        value="<?= $row['code']?>"
                                        <?php echo ($parameter['guide']['carrier_document_code'] ?? false ) == $row['code'] ? 'selected' : '' ?>
                                    >
                                        <?= $row['description']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['carrier_document_code'] ?? false) ? $parameter['error']['carrier_document_code'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="carrierDocumentNumber">Documento numero</label>
                            <input type="text" class="form-control <?= ($parameter['error']['carrier_document_number'] ?? false) ? 'is-invalid' : ''  ?>" id="carrierDocumentNumber" name="guide[carrier_document_number]" value="<?= $parameter['guide']['carrier_document_number'] ?? '' ?>">
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['carrier_document_number'] ?? false) ? $parameter['error']['carrier_document_number'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="carrierDenomination">Denominacion</label>
                            <input type="text" class="form-control <?= ($parameter['error']['carrier_denomination'] ?? false) ? 'is-invalid' : ''  ?>" id="carrierDenomination" name="guide[carrier_denomination]" value="<?= $parameter['guide']['carrier_denomination'] ?? '' ?>">
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['carrier_denomination'] ?? false) ? $parameter['error']['carrier_denomination'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="carrierPlateNumber">Placa numero</label>
                            <input type="text" class="form-control <?= ($parameter['error']['carrier_plate_number'] ?? false) ? 'is-invalid' : ''  ?>" id="carrierPlateNumber" name="guide[carrier_plate_number]" value="<?= $parameter['guide']['carrier_plate_number'] ?? '' ?>">
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['carrier_plate_number'] ?? false) ? $parameter['error']['carrier_plate_number'][0] : ''  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    DATOS DEL CONDUCTOR
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="driverDocumentCode">Tipo de documento del conductor</label>
                            <select class="selectpicker form-control <?= ($parameter['error']['driver_document_code'] ?? false) ? 'is-invalid' : ''  ?>" id="driverDocumentCode" name="guide[driver_document_code]" data-live-search="true">
                                <option value="">Elegir</option>
                                <?php foreach ($parameter['identityDocumentTypeCode'] ?? [] as $row): ?>
                                    <option
                                        value="<?= $row['code']?>"
                                        <?php echo ($parameter['guide']['driver_document_code'] ?? false ) == $row['code'] ? 'selected' : '' ?>
                                    >
                                        <?= $row['description']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['driver_document_code'] ?? false) ? $parameter['error']['driver_document_code'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="driverDocumentNumber">Conductor documento numero</label>
                            <input type="text" class="form-control <?= ($parameter['error']['driver_document_number'] ?? false) ? 'is-invalid' : ''  ?>" id="driverDocumentNumber" name="guide[driver_document_number]" value="<?= $parameter['guide']['driver_document_number'] ?? '' ?>">
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['driver_document_number'] ?? false) ? $parameter['error']['driver_document_number'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="driverFullName">Nombre completo del conductor</label>
                            <input type="text" class="form-control <?= ($parameter['error']['driver_full_name'] ?? false) ? 'is-invalid' : ''  ?>" id="driverFullName" name="guide[driver_full_name]" value="<?= $parameter['guide']['driver_full_name'] ?? '' ?>">
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['driver_full_name'] ?? false) ? $parameter['error']['driver_full_name'][0] : ''  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    PUNTO DE PARTIDA
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="locationStartingCode">UBIGEO dirección de partida</label>
                            <select class="selectpicker with-ajax geographicalLocationSearch <?= ($parameter['error']['location_starting_code'] ?? false) ? 'is-invalid' : ''  ?>" data-live-search="true" id="locationStartingCode" data-width="100%" name="guide[location_starting_code]">
                                <option value="">Buscar ubigeo</option>
                                <?php if(($parameter['guide']['location_starting']['code'] ?? false)) :  ?>
                                    <option value="<?= $parameter['guide']['location_starting']['code']?>" selected><?= $parameter['guide']['location_starting']['description']?></option>
                                <?php endif; ?>
                            </select>
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['location_starting_code'] ?? false) ? $parameter['error']['location_starting_code'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="addressStartingPoint">Dirección del punto de partida</label>
                            <input type="text" class="form-control <?= ($parameter['error']['address_starting_point'] ?? false) ? 'is-invalid' : ''  ?>" id="addressStartingPoint" name="guide[address_starting_point]" value="<?= $parameter['guide']['address_starting_point'] ?? '' ?>">
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['address_starting_point'] ?? false) ? $parameter['error']['address_starting_point'][0] : ''  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    PUNTO DE LLEGADA
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="locationExitCode">UBIGEO dirección de salida</label>
                            <select class="selectpicker with-ajax geographicalLocationSearch <?= ($parameter['error']['location_arrival_code'] ?? false) ? 'is-invalid' : ''  ?> " data-live-search="true" id="locationExitCode" data-width="100%" name="guide[location_arrival_code]">
                                <option value="">Buscar ubigeo</option>
                                <?php if(($parameter['guide']['location_arrival']['code'] ?? false)) :  ?>
                                    <option value="<?= $parameter['guide']['location_arrival']['code']?>" selected><?= $parameter['guide']['location_arrival']['description']?></option>
                                <?php endif; ?>
                            </select>
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['location_arrival_code'] ?? false) ? $parameter['error']['location_arrival_code'][0] : ''  ?>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="addressArrivalPoint">Dirección del punto de llegada</label>
                            <input type="text" class="form-control <?= ($parameter['error']['address_arrival_point'] ?? false) ? 'is-invalid' : ''  ?> " id="addressArrivalPoint" name="guide[address_arrival_point]" value="<?= $parameter['guide']['address_arrival_point'] ?? '' ?>" required >
                            <div class="invalid-feedback">
<!--                                --><?//= ($parameter['error']['address_arrival_point'] ?? false) ? $parameter['error']['address_arrival_point'][0] : ''  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <label for="observations">Observaciones</label>
                        <textarea type="text" class="form-control" id="observations" name="guide[observations]" cols="30" rows="2"><?= $parameter['guide']['observations'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-auto mr-auto">

                </div>
                <div class="col-auto">
                    <input type="submit" name="commit" value="Crear Guía de Remisión" class="btn btn-primary ml-4">
                </div>
            </div>

        </form>
    </div>
<?php
    require_once __DIR__ . '/Partial/ProductForm.php';
?>

<div class="row">

    <div class="col-auto mr-auto">
        <div class="btn-group btn-group-sm mb-3">
            <div class="btn btn-light" data-toggle="modal" data-target="#invoiceAdditionalModal">Adicionales</div>
            <div class="btn btn-light" data-toggle="modal" data-target="#invoiceReferralGuide">Guía de remisión Física</div>
            <div class="btn btn-light" data-toggle="modal" data-target="#invoiceAdvancedOptions">Opciones Avanzadas</div>
        </div>
    </div>

    <div class="col-auto">
    </div>
</div>

<hr>

<div class="row mb-5">
    <div class="form-group col-md-4">
        <label for="selectCustomerSearch">Cliente</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-primary btn-sm" type="button" id="invoiceNewCustomer">Nuevo</button>
            </div>
            <select class="selectpicker with-ajax searchCustomer" data-live-search="true" id="selectCustomerSearch" name="invoice[customer_id]" required>
                <?php if (isset($parameter['invoice']['customer']['customer_id'])): ?>
                    <option value="<?= $parameter['invoice']['customer']['customer_id'] ?? ''?>" selected >
                        <?php echo ($parameter['invoice']['customer']['document_number'] ?? '') . ' ' . ($parameter['invoice']['customer']['social_reason'] ?? '') ?>
                    </option>
                <?php endif; ?>
            </select>
        </div>
    </div>
<!--    <div class="form-group col-md-4">-->
<!--        <label for="invoiceCustomerIdentityDocumentNumber">Cliente</label>-->
<!--        <div class="input-group">-->
<!--            <div class="input-group-prepend">-->
<!--                <button class="btn btn-primary btn-sm" type="button" id="invoiceNewCustomer">Nuevo</button>-->
<!--            </div>-->
<!--            <select class="selectpicker with-ajax searchCustomer" data-live-search="true" id="invoiceCustomerIdentityDocumentNumber" name="invoice[customer][document_number]" required>-->
<!--                --><?php //if (isset($parameter['invoice']['customer']['customer_id'])): ?>
<!--                    <option value="--><?//= $parameter['invoice']['customer']['customer_id'] ?? ''?><!--" selected >-->
<!--                        --><?php //echo ($parameter['invoice']['customer']['document_number'] ?? '') . ' ' . ($parameter['invoice']['customer']['social_reason'] ?? '') ?>
<!--                    </option>-->
<!--                --><?php //endif; ?>
<!--            </select>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="form-group col-md-3">-->
<!--        <label for="invoiceCustomerIdentityDocumentCode">Tipo Doc.Ident</label>-->
<!--        <select class="form-control" id="invoiceCustomerIdentityDocumentCode" name="invoice[customer][identity_document_code]">-->
<!--            --><?php //foreach ($parameter['identityDocumentTypeCode'] ?? [] as $row): ?>
<!--                <option value="--><?//= $row['code']?><!--">--><?//= $row['description']?><!--</option>-->
<!--            --><?php //endforeach; ?>
<!--        </select>-->
<!--    </div>-->
<!--    <div class="form-group col-md-5">-->
<!--        <label for="invoiceCustomerIdentityDocumentCode">Razón Social:</label>-->
<!--        <input type="text" class="form-control" id="invoiceCustomerIdentityDocumentCode" name="invoice[customer][social_reason]">-->
<!--    </div>-->
</div>

<div class="modal fade" id="invoiceReferralGuide" tabindex="-1" role="dialog" aria-labelledby="invoiceReferralGuideLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceReferralGuideLabel">Guía de Remisión</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table mb-5">
                    <tbody id="invoiceReferralGuideTableBody">
                    <?php foreach ($parameter['invoice']['guide'] ?? [] as $key => $row): ?>
                        <tr id="referralGuideItem<?= $key?>" data-uniqueId="<?= $key?>">
                            <td>
                                <label for="type<?= $key?>">Tipo</label>
                                <select class="form-control form-control-sm" id="type<?= $key?>" name="invoice[guide][<?= $key?>][document_code]" required>
                                    <option value="09">GUÍA DE REMISIÓN REMITENTE</option>
                                    <option value="31">GUÍA DE REMISIÓN TRANSPORTISTA</option>
                                </select>
                            </td>
                            <td>
                                <label for="serie<?= $key ?>">Serie - Número</label>
                                <input type="text" class="form-control form-control-sm" id="serie<?= $key ?>" name="invoice[guide][<?= $key ?>][serie]" value="<?= $row['serie'] ?? '' ?>" required>
                            </td>
                            <td>
                                <div class="btn btn-danger btn-sm mt-4" onclick="ReferralGuidePhysical.removeItem('<?= $key ?>')" >Quitar</div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <div class="btn btn-primary btn-sm"
                                     onclick="ReferralGuidePhysical.addItem()"
                                     data-itemtemplate="<?php echo htmlspecialchars(($parameter['referralGuideTemplate'] ?? ''),ENT_QUOTES) ?>"
                                     id="ReferralGuidePhysicalAddItem">Agregar Guía de Remisión</div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" aria-label="Close">ACEPTAR</button>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Additional General -->
<div class="modal fade" id="invoiceAdditionalModal" tabindex="-1" role="dialog" aria-labelledby="invoiceAdditionalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceAdditionalModalLabel">Adicionales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="invoicePurchaseOrder">Órden de Compra/Servicio</label>
                    <input type="text" class="form-control" id="invoicePurchaseOrder" name="invoice[purchase_order]" value="<?= $parameter['invoice']['purchase_order'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="invoiceVehiclePlate">Placa de vehículo. Venta de combustible o mantenimiento</label>
                    <input type="text" class="form-control" id="invoiceVehiclePlate" name="invoice[vehicle_plate]" value="<?= $parameter['invoice']['vehicle_plate'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="invoiceTerm">Condiciones de pago (Ejemplo: 15 días)</label>
                    <input type="text" class="form-control" id="invoiceTerm" name="invoice[term]" value="<?= $parameter['invoice']['term'] ?? '' ?>">
                </div>

                <button type="submit" class="btn btn-primary btn-block" data-dismiss="modal" aria-label="Close">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Invoice print print modal -->
<div class="modal fade" id="invoiceAdvancedOptions" tabindex="-1" role="dialog" aria-labelledby="invoiceAdvancedOptionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceAdvancedOptionsLabel">Obciones Avanzadas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                        <label for="invoiceOperationCode">Tipo de operación</label>
                        <select class="form-control <?= ($parameter['error']['operation_code'] ?? false) ? 'is-invalid' : '' ?>"
                                id="invoiceOperationCode" name="invoice[operation_code]">
                            <?php foreach ($parameter['operationTypeCode'] ?? [] as $row): ?>
                                <option
                                    value="<?= $row['code']?>"
                                    <?= $row['code'] == ($parameter['invoice']['operation_code'] ?? false) ? 'selected' : '' ?>
                                >
                                    <?= $row['description'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                        <label for="invoiceCurrencyCode">Moneda</label>
                        <select class="form-control <?= ($parameter['error']['currency_code'] ?? false) ? 'is-invalid' : '' ?>"
                                id="invoiceCurrencyCode" name="invoice[currency_code]">
                            <?php foreach ($parameter['currencyTypeCode'] ?? [] as $row): ?>
                                <option
                                    value="<?= $row['code']?>"
                                    <?= $row['code'] == ($parameter['invoice']['currency_code'] ?? 'PEN') ? 'selected' : '' ?>
                                >
                                    <?= $row['description']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                        <label for="invoiceChangeType">Tipo de cambio</label>
                        <input type="text" class="form-control <?= ($parameter['error']['change_type'] ?? false) ? 'is-invalid' : '' ?>"
                               id="invoiceChangeType" name="invoice[change_type]" value="<?= $parameter['invoice']['change_type'] ?? '' ?>" >
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                        <label for="invoiceSerie">Serie</label>
                        <select  class="form-control <?= ($parameter['error']['serie'] ?? false) ? 'is-invalid' : '' ?>"
                                 name="invoice[serie]" id="invoiceSerie">
                            <option value="<?= $parameter['correlativePrefix'] ?? ''?>"><?= $parameter['correlativePrefix'] ?? ''?></option>
                        </select>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                        <label for="invoiceCorrelative">Correlativo</label>
                        <input type="number" readonly class="form-control <?= ($parameter['error']['correlative'] ?? false) ? 'is-invalid' : '' ?>"
                               min="0" id="invoiceCorrelative" value="<?= $parameter['correlative'] ?? ''  ?>" name="invoice[correlative]" >
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                        <label for="invoiceDateOfIssue">Fecha emisión</label>
                        <input type="date" class="form-control <?= ($parameter['error']['date_of_issue'] ?? false) ? 'is-invalid' : '' ?>"
                               id="invoiceDateOfIssue" name="invoice[date_of_issue]" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                        <label for="invoiceDateOfDue">Fecha de Venc.</label>
                        <input type="date" class="form-control <?= ($parameter['error']['date_of_due'] ?? false) ? 'is-invalid' : '' ?>"
                               id="invoiceDateOfDue" name="invoice[date_of_due]" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-3 form-group">
                        <label for="invoicePdfFormat">Formato de PDF</label>
                        <select name="invoice[pdf_format]" class="form-control <?= ($parameter['error']['pdf_format'] ?? false) ? 'is-invalid' : '' ?>"
                                id="invoicePdfFormat">
                            <option value="" selected  >POR DEFECTO</option>
                            <option value="A4" <?= ($parameter['invoice']['pdf_format'] ?? '') === 'A4' ? 'selected' : ''; ?>>TAMAÑO A4</option>
                            <option value="A5" <?= ($parameter['invoice']['pdf_format'] ?? '') === 'A5' ? 'selected' : ''; ?>>TAMAÑO A5 (MITAD DE A4)</option>
                            <option value="TICKET" <?= ($parameter['invoice']['pdf_format'] ?? '') === 'TICKET' ? 'selected' : ''; ?>>TAMAÑO TICKET</option>
                        </select>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary btn-block" data-dismiss="modal" aria-label="Close">Aceptar</button>
            </div>
        </div>
    </div>
</div>

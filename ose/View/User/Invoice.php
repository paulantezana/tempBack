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

    <div id="invoiceContainer">
        <div class="card mb-3">
            <div class="card-body">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" data-toggle="collapse" data-target="#collapseAdvancedOptions" aria-expanded="false">
                    <label class="custom-control-label" for="customSwitch1">Filtro:</label>
                </div>
                <div class="collapse" id="collapseAdvancedOptions">
                    <form action="<?= FOLDER_NAME . '/Invoice'?>" method="GET" class="mt-4">
                        <div class="form-row">
                            <div class="form-group col-lg-3">
                                <label for="filterDocumentCode"><i class="icon-file-text mr-2"></i> Tipo de comprobante</label>
                                <select class="form-control select2" id="filterDocumentCode">
                                    <option value="">Filtrar por tipo</option>
                                    <?php foreach ($parameter['documentTypeCode'] ?? [] as $row): ?>
                                        <option value="<?= $row['code']?>"><?= $row['description']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="filterCustomerDocumentNumber"><i class="icon-users mr-2"></i> Cliente</label>
                                <select class="searchCustomer" id="filterCustomerDocumentNumber"></select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="filterRangeDate"><i class="icon-calendar mr-2"></i> Rango de Fechas</label>
                                <input id="filterRangeDate" type="text" class="form-control">
                                <input type="hidden" id="filterStartDate" name="filter[startDate]">
                                <input type="hidden" id="filterEndDate" name="filter[endDate]">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="filterInvoiceId"><i class="icon-barcode2 mr-2"></i> Buscar documento por serie / número</label>
                                <select class="invoiceSearch" id="filterInvoiceId"></select>
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
                <div id="invoiceTable"></div>
            </div>
        </div>
    </div>

</div>

<script src="<?= FOLDER_NAME . '/Asset/Js/User/Invoice.js'?>"></script>

<?php
    require_once __DIR__ . '/Partial/InvoiceSendEmailModal.php';
    require_once __DIR__ . '/Partial/DocumentPrinterModal.php';
?>

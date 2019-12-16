<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>OSE Skynet</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?=FOLDER_NAME . '/Asset/Css/Icomoon/styles.css'?>">

<!--    <link rel="apple-touch-icon" sizes="57x57" href="--><?//=FOLDER_NAME . '/Asset/Images/appleIcon57x57.png'?><!--">-->
<!--    <link rel="apple-touch-icon" sizes="60x60" href="--><?//=FOLDER_NAME . '/Asset/Images/appleIcon60x60.png'?><!--">-->
<!--    <link rel="apple-touch-icon" sizes="72x72" href="--><?//=FOLDER_NAME . '/Asset/Images/appleIcon72x72.png'?><!--">-->
<!--    <link rel="apple-touch-icon" sizes="76x76" href="--><?//=FOLDER_NAME . '/Asset/Images/appleIcon76x76.png'?><!--">-->
<!--    <link rel="apple-touch-icon" sizes="114x114" href="--><?//=FOLDER_NAME . '/Asset/Images/appleIcon114x114.png'?><!--">-->
<!--    <link rel="apple-touch-icon" sizes="120x120" href="--><?//=FOLDER_NAME . '/Asset/Images/appleIcon120x120.png'?><!--">-->
<!--    <link rel="apple-touch-icon" sizes="144x144" href="--><?//=FOLDER_NAME . '/Asset/Images/appleIcon144x144.png'?><!--">-->
<!--    <link rel="apple-touch-icon" sizes="152x152" href="--><?//=FOLDER_NAME . '/Asset/Images/appleIcon152x152.png'?><!--">-->
<!--    <link rel="apple-touch-icon" sizes="180x180" href="--><?//=FOLDER_NAME . '/Asset/Images/appleIcon180x180.png'?><!--">-->
<!--    <link rel="icon" type="image/png" sizes="192x192" href="--><?//=FOLDER_NAME . '/Asset/Images/androidIcon192x192.png'?><!--">-->
<!--    <link rel="icon" type="image/png" sizes="32x32" href="--><?//=FOLDER_NAME . '/Asset/Images/favicon32x32.png'?><!--">-->
<!--    <link rel="icon" type="image/png" sizes="96x96" href="--><?//=FOLDER_NAME . '/Asset/Images/favicon96x96.png'?><!--">-->
<!--    <link rel="icon" type="image/png" sizes="16x16" href="--><?//=FOLDER_NAME . '/Asset/Images/favicon16x16.png'?><!--">-->
<!--    <link rel="manifest" href="--><?//=FOLDER_NAME . '/Asset/Images/manifest.json'?><!--">-->
<!--    <meta name="msapplication-TileColor" content="#DC3545">-->
<!--    <meta name="msapplication-TileImage" content="--><?//='/Asset/Images/msIcon144x144.png'?><!--">-->
<!--    <meta name="theme-color" content="#DC3545">-->

    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/bootstrap.min.css'?>">
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/daterangepicker.css'?>">
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/flexdatalist.min.css'?>">
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/select2.min.css'?>">
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/sweetalert2.min.css'?>">
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/skyGuide.css"'?>"/>
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/StyleSheet.css'?>">

    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/jquery.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/bootstrap.bundle.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/moment.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/daterangepicker.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/flexdatalist.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/select2.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/sweetalert2.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/skyGuide.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/blockui.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/Common.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/User/UserCore.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/SkyGuideInvoice.js'?>"></script>
</head>
<body style="background: #F9FAFD">
    <div class="layout-container">
        <div class="layout-header border-bottom">
            <?php require_once __DIR__ . '/menu.php'?>
        </div>
        <div class="layout-main">
            <?php echo $content ?? '' ?>
        </div>
        <div class="layout-footer">
            <div class="container">

            </div>
        </div>
    </div>

    <div data-toggle="modal" data-target="#sgModalPSE" id="sgPSEStart">
        <i class="icon-help"></i>
    </div>

    <div class="modal fade" id="sgModalPSE" tabindex="-1" role="dialog" aria-labelledby="sgModalPSELabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="invoiceAdvancedOptionsLabel"><i class="icon-help mr-2"></i> Modo Guiado</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="sgSearchInvoice" class="form-control" placeholder="¿Qué tipo de operación desea realizar?">
                    </div>
                    <table class="table" id="sgTableInvoice">
                        <tbody>
                            <tr id="sgInvoiceTaxed">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura gravada con IGV</td>
                            </tr>
                            <tr id="sgInvoiceFree">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura con venta gratuita</td>
                            </tr>
                            <tr id="sgInvoiceExonerated">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura con venta exonerada</td>
                            </tr>
                            <tr id="sgInvoiceUnaffected">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura con venta inafecta</td>
                            </tr>
                            <tr id="sgInvoiceExport">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura comercio exterior o exportación</td>
                            </tr>

                            <tr id="sgInvoiceGlobalDiscount">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura con descuento global</td>
                            </tr>
                            <tr id="sgInvoiceISC">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura gravada con ISC</td>
                            </tr>
                            <tr id="sgInvoiceByCurrency">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura en otras monedas</td>
                            </tr>
                            <tr id="sgInvoiceDetraction">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura sujeta a detracción</td>
                            </tr>
                            <tr id="sgInvoicePerception">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura sujeta a percepción</td>
                            </tr>
                            <tr id="sgInvoiceReferralGuide">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura guia</td>
                            </tr>
                            <tr id="sgInvoicePrepayment">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura con pagos anticipados</td>
                            </tr>
                            <tr id="sgInvoicePrepaymentRegulation">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Factura con regulacion de anticipo</td>
                            </tr>
                            <tr id="sgInvoiceTicketTaxed">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/InvoiceTiket.svg" alt="invoice"></td>
                                <td>Boleta gravada con IGV</td>
                            </tr>
                            <tr id="sgInvoiceTicketGlobalDiscount">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/InvoiceTiket.svg" alt="invoice"></td>
                                <td>Boleta con descuento global</td>
                            </tr>
                            <tr id="sgInvoiceTicketFree">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/InvoiceTiket.svg" alt="invoice"></td>
                                <td>Boleta con venta inafecta</td>
                            </tr>
                            <tr id="sgCreditNote">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/creditNote.svg" alt="invoice"></td>
                                <td>Nota de crédito</td>
                            </tr>
                            <tr id="sgDebitNote">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/debitNote.svg" alt="invoice"></td>
                                <td>Nota de debito</td>
                            </tr>
                            <tr id="sgInvoiceVoided">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Anular factura</td>
                            </tr>
                            <tr id="sgInvoiceTicketVoided">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/InvoiceTiket.svg" alt="invoice"></td>
                                <td>Anular Boleta</td>
                            </tr>
                            <tr id="sgReferralGuide">
                                <td><img src="<?= FOLDER_NAME ?>/Asset/Images/Invoice.svg" alt="invoice"></td>
                                <td>Guia de remisión</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php // FOLDER_NAME . '/Asset/Js/User/Invoice.js'?>"></script>
</body>
</html>

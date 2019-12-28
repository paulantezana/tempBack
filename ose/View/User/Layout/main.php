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

    <body>
        <div class="UserLayout UserLayoutL1" id="UserLayout">
            <div class="UserLayout-header">
                <?php require_once __DIR__ . '/menu.php'?>
            </div>
            <div class="UserLayout-main">
                <?php echo $content ?? '' ?>
            </div>
            <aside class="UserLayout-sidebar UserSidebar-wrapper" id="UserSidebar">
                <div class="UserSidebar-content">
                    <div class="UserSidebar-brand">
                        <a href="<?= FOLDER_NAME ?>">
                            <img src="<?= FOLDER_NAME . '/Asset/Images/logo.png' ?>" alt="logo" width="48px" class="mr-2">
                            <span class="UserSidebar-brandName">Sky Facts <span>Facturación electrónica</span></span>
                        </a>
                    </div>
                    <div class="UserSidebar-header">

                    </div>
                    <ul class="UserSidebar-menu">
                        <li class="UserSidebar-title">General</li>
                        <li class="UserSidebar-dropdown">
                            <a href="#">
                                <i class="icon-cart-add mr-2"></i>
                                <span>Comprobantes</span>
                            </a>
                            <ul class="UserSidebar-submenu">
                                <li>
                                    <a href="<?= FOLDER_NAME . '/Invoice' ?>"><i class="icon-list2 mr-2"></i> Listar Ventas</a>
                                </li>
                                <li>
                                    <a href="<?= FOLDER_NAME . '/InvoiceNote' ?>"><i class="icon-list2 mr-2"></i> Listar NC ND</a>
                                </li>
                                <li>
                                    <a href="<?= FOLDER_NAME . '/Invoice/NewInvoice' ?>"> <i class="icon-plus2 mr-2"></i> Nueva FACTURA</a>
                                </li>
                                <li>
                                    <a href="<?= FOLDER_NAME . '/Invoice/NewTicket' ?>"> <i class="icon-plus2 mr-2"></i> Nueva BOLETA DE VENTA</a>
                                </li>
                                <li>
                                    <a href="<?= FOLDER_NAME . '/InvoiceNote/NewCreditNote' ?>"> <i class="icon-plus2 mr-2"></i> Nueva NOTA DE CRÉDITO</a>
                                </li>
                                <li>
                                    <a href="<?= FOLDER_NAME . '/InvoiceNote/NewDebitNote' ?>"> <i class="icon-plus2 mr-2"></i> Nueva NOTA DE DÉBITO</a>
                                </li>
                            </ul>
                        </li>

                        <li class="UserSidebar-dropdown">
                            <a href="#">
                                <i class="icon-make-group mr-2"></i>
                                <span>
                                    <span>Resumenes</span>
                                    <span class="badge badge-pill badge-success">Nuevo</span>
                                </span>
                            </a>
                            <ul class="UserSidebar-submenu">
                                <li>
                                    <a href="<?= FOLDER_NAME . '/InvoiceSummary' ?>"><i class="icon-list2 mr-2"></i> Resúmenes diarios de Boletas</a>
                                </li>
                            </ul>
                        </li>

                        <li class="UserSidebar-dropdown">
                            <a href="#">
                                <i class="icon-magazine mr-2"></i>
                                <span>
                                    <span>Guias</span>
                                    <span class="badge badge-pill badge-success">Nuevo</span>
                                </span>
                            </a>
                            <ul class="UserSidebar-submenu">
                                <li>
                                    <a href="<?= FOLDER_NAME . '/ReferralGuide' ?>"><i class="icon-plus2 mr-2"></i> Ver Guías de Remisión</a>
                                </li>
                                <li>
                                    <a href="<?= FOLDER_NAME . '/ReferralGuide/NewGuide' ?>"><i class="icon-list2 mr-2"></i> Nueva Guía de remisión</a>
                                </li>
                            </ul>
                        </li>

                        <li class="UserSidebar-dropdown">
                            <a href="#">
                                <i class="icon-blocked mr-2"></i>
                                <span>Anulaciones</span>
                            </a>
                            <ul class="UserSidebar-submenu">
                                <li>
                                    <a href="<?= FOLDER_NAME . '/ReferralGuide' ?>"><i class="icon-plus2 mr-2"></i> Ver Guías de Remisión</a>
                                </li>
                                <li>
                                    <a href="<?= FOLDER_NAME . '/ReferralGuide/NewGuide' ?>"><i class="icon-list2 mr-2"></i> Nueva Guía de remisión</a>
                                </li>
                            </ul>
                        </li>

                        <li class="UserSidebar-title">Configuración</li>
                        <li class="UserSidebar-dropdown">
                            <a href="#">
                                <i class="icon-list3 mr-2"></i>
                                <span>Mantenimiento</span>
                            </a>
                            <ul class="UserSidebar-submenu">
                                <li>
                                    <a href="<?= FOLDER_NAME . '/Customer' ?>"><i class="icon-users2 mr-2"></i> Clientes</a>
                                </li>
                                <li>
                                    <a href="<?= FOLDER_NAME . '/Product' ?>"><i class="icon-box mr-2"></i> Productos</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-office mr-2"></i>
                                <span>
                                    <span>Empresa</span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-home7 mr-2"></i>
                                <span>Locales y serie</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-code mr-2"></i>
                                <span>API</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </body>
</html>

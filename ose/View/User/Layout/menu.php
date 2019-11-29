<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand" href="<?= FOLDER_NAME ?>">
            <img src="https://www.skynetcusco.com/wp-content/uploads/2016/11/logosky2017.png" height="30" alt="">
        </a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Comprobantes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <h6 class="dropdown-header">Ventas</h6>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/Invoice' ?>">☰ Ver Facturas, Boletas</a>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/Invoice/NewInvoice' ?>">＋ Nueva FACTURA</a>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/Invoice/NewTicket' ?>">＋ Nueva BOLETA DE VENTA</a>
                        <h6 class="dropdown-header">Notas</h6>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/InvoiceNote' ?>">☰ Ver Notas de Crédito y Débito</a>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/InvoiceNote/NewCreditNote' ?>">＋ Nueva NOTA DE CRÉDITO</a>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/InvoiceNote/NewDebitNote' ?>">＋ Nueva NOTA DE DÉBITO</a>
                        <h6 class="dropdown-header">Resumen Diario Boletas</h6>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/InvoiceSummary' ?>">☰ Resúmenes diarios de Boletas</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Guias
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/ReferralGuide' ?>">☰ Ver Guías de Remisión</a>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/ReferralGuide/NewGuide' ?>">＋ Emitir Guía de remisión</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Anulaciones
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/InvoiceVoided' ?>">Comunicación de Baja</a>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/InvoiceNoteVoided' ?>">Comunicación de Baja ND NC</a>
<!--                        <a class="dropdown-item" href="--><?//= FOLDER_NAME . '/Invoice/NewInvoice' ?><!--">Reversión de Retenciones</a>-->
<!--                        <a class="dropdown-item" href="--><?//= FOLDER_NAME . '/Invoice/NewInvoice' ?><!--">Reversión de Percepciones</a>-->
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mantenimiento
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/Customer' ?>">Clientes</a>
                        <a class="dropdown-item" href="<?= FOLDER_NAME . '/Product' ?>">Productos</a>
                    </div>
                </li>
                <li class="nav-item">

                </li>
            </ul>
            <div class="nav-var-right my-2 my-lg-0">
                <ul class="navbar-nav">
                    <li class="nav-item">:
                        <?php if (isset($_SESSION[ENVIRONMENT]) && $_SESSION[ENVIRONMENT]): ?>
                            <button class="btn btn-sm btn-success">PRODUCCION</button>
                        <?php else: ?>
                            <button class="btn btn-sm btn-danger">AMBIENTE DE PRUEBAS</button>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Configuración
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= FOLDER_NAME  . '/User/Profile'?>"><i class="fas fa-user"></i> Mi Perfil</a>
                            <a class="dropdown-item" href="<?= FOLDER_NAME  . '/BusinessLocal'?>"><i class="fas fa-home"></i> Locales y Series</a>
                            <a class="dropdown-item" href="<?= FOLDER_NAME  . '/BusinessLocal/Api'?>"><i class="fas fa-home"></i> API</a>
                            <a class="dropdown-item" href="<?= FOLDER_NAME  . '/User/Profile'?>"><i class="fas fa-cog"></i> Soporte</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= FOLDER_NAME . '/Business/update' ?>"> <i class="fas fa-cog"></i> Configurar empresa</a>
                            <a class="dropdown-item" href="<?= FOLDER_NAME . '/User/CloseSession' ?>"> <i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>

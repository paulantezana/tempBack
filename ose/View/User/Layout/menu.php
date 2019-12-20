<header class="navbar navbar-expand-sm UserHeader">
    <div id="UserSidebar-toggle" class="UserHeader-action mr-2">
        <i class="icon-paragraph-justify3"></i>
    </div>
    <button class="navbar-toggler UserHeader-action" type="button" data-toggle="collapse" data-target="#HeaderNavBar" aria-controls="HeaderNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="icon-cog7"></i>
    </button>
    <div class="collapse navbar-collapse ml-auto" id="HeaderNavBar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <select name="" id="businessCurrentLocalInfo" class="form-control select2"></select>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="<?= FOLDER_NAME . '/Business/update' ?>" class="nav-link SunatState mr-3" href="#" id="businessEnvironmentInfo"></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="UserDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?= FOLDER_NAME . '/Asset/Images/user.svg' ?>" alt="avatar" width="32px" class="mr-2"><span>Usuario</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="UserDropdown">
                    <a class="dropdown-item" href="<?= FOLDER_NAME  . '/User/Profile'?>"><i class="icon-user-plus mr-2"></i> Mi Perfil</a>
                    <a class="dropdown-item" href="<?= FOLDER_NAME  . '/BusinessLocal'?>"><i class="icon-home2 mr-2"></i> Locales y Series</a>
                    <a class="dropdown-item" href="<?= FOLDER_NAME  . '/BusinessLocal/Api'?>"><i class="icon-code mr-2"></i> API</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= FOLDER_NAME . '/Business/update' ?>"> <i class="icon-cog mr-2"></i> Configurar empresa</a>
                    <a class="dropdown-item" href="<?= FOLDER_NAME . '/User/CloseSession' ?>"> <i class="icon-switch2 mr-2"></i> Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </div>
</header>

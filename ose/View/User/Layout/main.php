<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>OSE Skynet</title>

    <link rel="stylesheet" href="<?= FOLDER_NAME . '/Asset/Css/bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= FOLDER_NAME . '/Asset/Css/StyleSheet.css' ?>">
    <link rel="stylesheet" href="<?= FOLDER_NAME . '/Asset/Css/bootstrap-select/bootstrap-select.min.css' ?>">
    <link rel="stylesheet" href="<?= FOLDER_NAME . '/Asset/Css/bootstrap-select-ajax/ajax-bootstrap-select.min.css' ?>">

    <link rel="stylesheet" href="<?= FOLDER_NAME . '/Asset/Css/sweetalert2.min.css' ?>">
    <script src="<?= FOLDER_NAME ?>/Asset/Js/Helper/Common.js"></script>
    <script src="<?= FOLDER_NAME . '/Asset/Js/Helper/jquery-3.4.1.js'?>"></script>
</head>
<body style="background: #F9FAFD">
<div class="layout-container">
    <div class="layout-header border-bottom">
        <?php require_once __DIR__ . '/menu.php' ?>
    </div>
    <div class="layout-main">
    </div>
    <div class="layout-footer">
        <div class="container">
            <?php echo $content ?? '' ?>
        </div>
    </div>
    </div>

    <script src="<?= FOLDER_NAME . '/Asset/Js/Helper/bootstrap.bundle.js'?>"></script>
    <script src="<?= FOLDER_NAME . '/Asset/Js/Helper/all.js'?>"></script>
    <script src="<?= FOLDER_NAME . '/Asset/Js/Helper/sweetalert2.min.js' ?>"></script>

    <script src="<?= FOLDER_NAME . '/Asset/Js/Helper/bootstrap-select/bootstrap-select.min.js'?>"></script>
    <script src="<?= FOLDER_NAME . '/Asset/Js/Helper/bootstrap-select-ajax/ajax-bootstrap-select.min.js'?>"></script>
    <script src="<?= FOLDER_NAME . '/Asset/Js/Helper/bootstrap-select-ajax/locale/ajax-bootstrap-select.es-ES.js'?>"></script>

    <script src="<?= FOLDER_NAME . '/Asset/Js/User/Invoice.js'?>"></script>
    </body>
</html>

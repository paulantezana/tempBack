<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>OSE Skynet</title>

    <link rel="apple-touch-icon" sizes="57x57" href="<?=FOLDER_NAME . '/Asset/Images/appleIcon57x57.png'?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=FOLDER_NAME . '/Asset/Images/appleIcon60x60.png'?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=FOLDER_NAME . '/Asset/Images/appleIcon72x72.png'?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=FOLDER_NAME . '/Asset/Images/appleIcon76x76.png'?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=FOLDER_NAME . '/Asset/Images/appleIcon114x114.png'?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=FOLDER_NAME . '/Asset/Images/appleIcon120x120.png'?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=FOLDER_NAME . '/Asset/Images/appleIcon144x144.png'?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=FOLDER_NAME . '/Asset/Images/appleIcon152x152.png'?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=FOLDER_NAME . '/Asset/Images/appleIcon180x180.png'?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?=FOLDER_NAME . '/Asset/Images/androidIcon192x192.png'?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=FOLDER_NAME . '/Asset/Images/favicon32x32.png'?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=FOLDER_NAME . '/Asset/Images/favicon96x96.png'?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=FOLDER_NAME . '/Asset/Images/favicon16x16.png'?>">
    <link rel="manifest" href="<?=FOLDER_NAME . '/Asset/Images/manifest.json'?>">
    <meta name="msapplication-TileColor" content="#DC3545">
    <meta name="msapplication-TileImage" content="<?='/Asset/Images/msIcon144x144.png'?>">
    <meta name="theme-color" content="#DC3545">

    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/bootstrap.min.css'?>">
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/flexdatalist.min.css'?>">
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/select2.min.css'?>">
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/sweetalert2.min.css'?>">
    <link rel="stylesheet" href="<?=FOLDER_NAME . '/Asset/Css/StyleSheet.css'?>">

    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/jquery.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/bootstrap.bundle.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/flexdatalist.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/select2.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/sweetalert2.min.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/Common.js'?>"></script>
    <script src="<?=FOLDER_NAME . '/Asset/Js/Helper/all.js'?>"></script>
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
                Copyright  © <?= date('Y') ?> Skynet cusco
            </div>
        </div>
    </div>
    <script src="<?php // FOLDER_NAME . '/Asset/Js/User/Invoice.js'?>"></script>
</body>
</html>

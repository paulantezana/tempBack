<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/jquery.min.js"></script>
    <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?= FOLDER_NAME ?>/Asset/Js/Helper/Common.js"></script>

    <link rel="stylesheet" type="text/css" href="<?= FOLDER_NAME ?>/Asset/Css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="<?= FOLDER_NAME ?>/Asset/Css/Icomoon/styles.css"/>
    <link rel="stylesheet" type="text/css" href="<?= FOLDER_NAME ?>/Asset/Css/StyleSheet.css"/>
</head>
<body>
    <div class="BasicLayout">
        <div class="BasicLayout-header">
            <div class="text-center">
                <img src="<?= FOLDER_NAME . '/Asset/Images/logo.png' ?>" alt="" height="42px" class="mb-2">
                <div class="text-black-50">Facturación electrónica.</div>
            </div>
        </div>
        <div class="BasicLayout-main">
            <?php echo $content ?? '' ?>
        </div>
        <div class="BasicLayout-footer text-center pt-4 pb-4">
            <div>
                <img src="<?= FOLDER_NAME . '/Asset/Images/verify.png' ?>" alt="" height="64px">
            </div>
            <div class="text-black-50">Copyright © <?php echo date('Y') ?> Skynet cusco </div>
        </div>
    </div>
</body>
</html>

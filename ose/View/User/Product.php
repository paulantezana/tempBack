<div class="container">
    <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>
    <h5 class="mb-3 mt-4 font-weight-bold"><i class="icon-arrow-left52 mr-2"></i> LISTA DE ARTÍCULOS</h5>
    <div class="card mt-4">
        <div class="card-body" id="productContainer">
            <div class="mb-4">
                <button class="btn btn-primary" onclick="Product.showModalCreate()" > <i class="icon-plus-circle2 mr-2"></i> Nuevo Producto/Servicio</button>
            </div>
            <div id="productTable"></div>
        </div>
    </div>
</div>

<script src="<?= FOLDER_NAME . '/Asset/Js/User/Product.js'?>"></script>

<?php require_once __DIR__ . '/Partial/ProductForm.php'; ?>

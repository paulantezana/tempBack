<div class="container">
    <?php require_once __DIR__ . '/Partial/AlertMessage.php' ?>
    <div class="card mt-4">
        <div class="card-body" id="customerContainer">
            <div class="mb-4">
                <div class="mb-3"><i class="icon-arrow-left52 mr-2"></i>  LISTA DE CLIENTES</div>
                <button class="btn btn-primary font-weight-bold" onclick="Customer.showModalCreate()" > <i class="icon-plus-circle2 mr-2"></i> Nuevo Customero/Servicio</button>
            </div>
            <div id="customerTable"></div>
        </div>
    </div>
</div>

<script src="<?= FOLDER_NAME . '/Asset/Js/User/Customer.js'?>"></script>

<?php require_once __DIR__ . '/Partial/CustomerForm.php'; ?>
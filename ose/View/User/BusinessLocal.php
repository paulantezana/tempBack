<div class="container">
    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>
    <div class="card mt-4">
        <div class="card-body">
            <span>Locales</span>
            <hr>
            <div class="mb-4">
                <div>
                    <a href="<?= FOLDER_NAME . '/BusinessLocal/Form' ?>" class="btn btn-primary"> <i class="fas fa-save"></i> Nuevo</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr style="font-size: 14px">
                        <th>Código Único</th>
                        <th>Descripción</th>
                        <th>Ubigero (INEI)</th>
                        <th>Dirección exacta</th>
                        <th>Departamento</th>
                        <th>Provincia</th>
                        <th>Distrito</th>
                        <th>Tipos de comprobantes y series asignados</th>
                        <th>Formato de PDF</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($parameter['businessLocal'] as $row): ?>
                        <tr>
                            <td><?= $row['sunat_code']  ?></td>
                            <td><?= $row['short_name']  ?></td>
                            <td><?= $row['location_code'] ?></td>
                            <td><?= $row['address']  ?></td>
                            <td><?= $row['department']  ?></td>
                            <td><?= $row['province']  ?></td>
                            <td><?= $row['district']  ?></td>
                            <td></td>
                            <td><?= $row['pdf_invoice_size']  ?></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bars"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="<?php echo FOLDER_NAME . '/BusinessLocal/Form?businessLocalId=' . $row['business_local_id'] ?>"><i class="fas fa-pen"></i>  Editar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
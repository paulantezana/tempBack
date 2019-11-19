<div class="container">
    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>
    <div class="card mt-4">
        <div class="card-body">
            <span><i class="fas fa-list"></i>  LISTA DE CLIENTES</span>
            <hr>
            <div class="row mb-4">
                <div class="col-auto mr-auto">
                    <div class="btn-group">
                        <button class="btn btn-primary"  id="customerBtnNew"> <i class="fas fa-save"></i> Nuevo</button>
                    </div>
                </div>
                <div class="col-auto">

                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr style="font-size: 1rem">
                            <th>Tipo</th>
                            <th>Número</th>
                            <th>Denominación / Nombres</th>
                            <th>Dirección Fiscal</th>
                            <th>Emails</th>
                            <th>Teléfonos</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parameter['customers']['data'] ?? [] as $row): ?>
                            <tr>
                                <td><?= $row['identity_document_type_code_description'] ?? '' ?></td>
                                <td><?= $row['document_number'] ?? '' ?></td>
                                <td><?= $row['social_reason'] ?? '' ?></td>
                                <td><?= $row['fiscal_address'] ?? '' ?></td>
                                <td><?= $row['main_email'] ?? '' ?></td>
                                <td><?= $row['telephone'] ?? '' ?></td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-bars"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item jsCustomerEdit" href="#" data-id="<?= $row['customer_id'] ?? 0 ?>" ><i class="fas fa-pen"></i>  Editar</a>
                                            <a class="dropdown-item jsCustomerDelete" href="#" data-id="<?= $row['customer_id'] ?? 0 ?>" ><i class="fas fa-trash"></i>  Eliminar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item <?php if(($parameter['customers']['current'] ?? 0) <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if(($parameter['customers']['current'] ?? 0) <= 1){ echo '#'; } else { echo "?page=".(($parameter['customers']['current'] ?? 0) - 1); } ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                    </li>
                    <?php for ($i=1; $i <= $parameter['customers']['pages'] ?? 1; $i++): if ($i == $parameter['customers']['current'] ?? 1): ?>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?> <span class="sr-only">(current)</span></a>
                        </li>
                    <?php else:  ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endif; endfor; ?>
                    <li class="page-item <?php if(($parameter['customers']['current'] ?? 0) >= ($parameter['customers']['pages'] ?? 0)){ echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if(($parameter['customers']['current'] ?? 0) >= ($parameter['customers']['pages'] ?? 0)){ echo '#'; } else { echo "?page=".(($parameter['customers']['current'] ?? 0) + 1); } ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/Partials/CustomerForm.php'; ?>
<div class="container">
    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>
    <div class="card mt-4">
        <div class="card-body">
            <span><i class="fas fa-list"></i>  Cuentas bancarias</span>
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
                        <th>MONEDA</th>
                        <th>TIPO</th>
                        <th>BANCO</th>
                        <th>TITULAR</th>
                        <th>NUMERO</th>
                        <th>CCI</th>
                        <th>DESCRIPCIÓN</th>
                        <th>ACTIVO?</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($parameter['bankAccount']['data'] ?? [] as $row): ?>
                        <tr>
                            <td><?= $row['currency_code']  ?></td>
                            <td><?= $row['account_type']  ?></td>
                            <td><?= $row['name_bank']  ?></td>
                            <td><?= $row['headline']  ?></td>
                            <td><?= $row['account_number']  ?></td>
                            <td><?= $row['cci']  ?></td>
                            <td><?= $row['description']  ?></td>
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
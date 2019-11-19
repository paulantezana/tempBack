<div class="container">
    <?php require_once __DIR__ . '/Partials/AlertMessage.php' ?>
    <div class="card mt-4">
        <div class="card-body">
            <span><i class="fas fa-list"></i>  LISTA DE ARTÍCULOS</span>
            <hr>
            <div class="row mb-4">
                <div class="col-auto mr-auto">
                    <div class="btn-group">
                        <button class="btn btn-primary"  id="productBtnNew"> <i class="fas fa-save"></i> Nuevo</button>
                    </div>
                </div>
                <div class="col-auto">
<!--                    <input type="search" name="search" id="search" class="form-control">-->
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr style="font-size: 14px">
                            <th>DESCRIPCIÓN</th>
                            <th>UNIDAD DE MEDIDA</th>
                            <th>MONEDA</th>
                            <th>COSTO UNITARIO DE COMPRA (SIN IGV)</th>
                            <th>VALOR UNITARIO DE VENTA (SIN IGV)</th>
                            <th>PRECIO UNITARIO DE COMPRA (CON IGV)</th>
                            <th>PRECIO UNITARIO DE VENTA (CON IGV)</th>
                            <th>TIPO DE AFECTACIÓN (IGV)</th>
                            <th>CÓDIGO PRODUCTO SUNAT</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($parameter['products']['data'] ?? [] as $row): ?>
                        <tr>
                            <td><?= $row['description'] ?? '' ?></td>
                            <td><?= $row['unit_measure_code'] ?? '' ?></td>
                            <td><?= $row['currency_code'] ?? '' ?></td>
                            <td><?= $row['unit_price_purchase'] ?? '' ?></td>
                            <td><?= $row['unit_price_sale'] ?? '' ?></td>
                            <td><?= $row['unit_price_purchase_igv'] ?? '' ?></td>
                            <td><?= $row['unit_price_sale_igv'] ?? '' ?></td>
                            <td><?= $row['affectation_igv_type_code_description'] ?? '' ?></td>
                            <td><?= $row['product_code_description'] ?? '' ?></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-primary btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bars"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item jsProductEdit" href="#" data-id="<?= $row['product_id'] ?? 0 ?>" ><i class="fas fa-pen"></i>  Editar</a>
                                        <a class="dropdown-item jsProductDelete" href="#" data-id="<?= $row['product_id'] ?? 0 ?>" ><i class="fas fa-trash"></i>  Eliminar</a>
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
                    <li class="page-item <?php if(($parameter['products']['current'] ?? 0) <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if(($parameter['products']['current'] ?? 0) <= 1){ echo '#'; } else { echo "?page=".(($parameter['products']['current'] ?? 0) - 1); } ?>" tabindex="-1" aria-disabled="true">Anterior</a>
                    </li>
                    <?php for ($i=1; $i <= $parameter['products']['pages'] ?? 1; $i++): if ($i == $parameter['products']['current'] ?? 1): ?>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?> <span class="sr-only">(current)</span></a>
                        </li>
                    <?php else:  ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php endif; endfor; ?>
                    <li class="page-item <?php if(($parameter['products']['current'] ?? 0) >= ($parameter['products']['pages'] ?? 0)){ echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php if(($parameter['products']['current'] ?? 0) >= ($parameter['products']['pages'] ?? 0)){ echo '#'; } else { echo "?page=".(($parameter['products']['current'] ?? 0) + 1); } ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/Partials/ProductForm.php'; ?>
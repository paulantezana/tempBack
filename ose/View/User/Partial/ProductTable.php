<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre del producto o servicio</th>
                <th>Unidad de medida</th>
                <th>Precio Venta(Sin IGV)</th>
                <th>Precio Venta(con IGV)</th>
                <th>Tipo de afectacion (IGV)</th>
                <th>Código Producto SUNAT</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($parameter['product']['data'] as $row) : ?>
            <tr>
                <td><?= $row['description'] ?></td>
                <td><?= $row['unit_measure_code_description'] ?></td>
                <td><?= $row['unit_price_sale'] ?></td>
                <td><?= $row['unit_price_sale_igv'] ?></td>
                <td><?= $row['affectation_code_description'] ?></td>
                <td><?= $row['product_code'] ?></td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-menu9"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" onclick="Product.showModalUpdate(<?= $row['product_id'] ?>)">
                                <i class="icon-pencil4 mr-2"></i> Editar
                            </a>
                            <a class="dropdown-item" href="#" onclick="Product.delete(<?= $row['product_id'] ?>,'<?= $row['description'] ?>')">
                                <i class="icon-trash mr-2"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-auto mr-auto">
        Mostrando <?php echo $parameter['product']['current']; ?> a <?php echo $parameter['product']['limit']; ?> de <?php echo $parameter['product']['pages']; ?> entradas
    </div>
    <div class="col-auto">
        <?php
        $currentPage = $parameter['product']['current'];
        $totalPage = $parameter['product']['pages'];
        $limitPage = $parameter['product']['limit'];
        $additionalQuery = '';
        $linksQuantity = 3;

        if ($totalPage > 1) {
            $lastPage       = $totalPage;
            $startPage      = (($currentPage - $linksQuantity) > 0) ? $currentPage - $linksQuantity : 1;
            $endPage        = (($currentPage + $linksQuantity) < $lastPage) ? $currentPage + $linksQuantity : $lastPage;
            $htmlPaginate       = '<nav aria-label="..."><ul class="pagination">';
            $class      = ($currentPage == 1) ? "disabled" : "";
            $htmlPaginate       .= '<li class="page-item ' . $class . '"><a href="#" onclick="Product.list(\''.($currentPage - 1). '\',\''.$limitPage.'\')" class="page-link"><span aria-hidden="true">&laquo;</span></a></li>';
            if ($startPage > 1) {
                $htmlPaginate   .= '<li class="page-item"><a href="#" onclick="Product.list(\'1\',\''.$limitPage.'\')" class="page-link">1</a></li>';
                $htmlPaginate   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            for ($i = $startPage; $i <= $endPage; $i++) {
                $class  = ($currentPage == $i) ? "active" : "";
                $htmlPaginate   .= '<li class="page-item ' . $class . '"><a href="#" onclick="Product.list(\''.$i. '\',\''.$limitPage.'\')" class="page-link">' . $i . '</a></li>';
            }
            if ($endPage < $lastPage) {
                $htmlPaginate   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
                $htmlPaginate   .= '<li><a href="#" onclick="Product.list(\''.$lastPage. '\',\''.$limitPage.'\')" class="page-link">' . $lastPage . '</a></li>';
            }
            $class      = ($currentPage == $lastPage || $totalPage == 0) ? "disabled" : "";
            $htmlPaginate       .= '<li class="page-item ' . $class . '"><a href="#" onclick="Product.list(\''.($currentPage + 1). '\',\''.$limitPage.'\')" class="page-link"><span aria-hidden="true">&raquo;</span></a></li>';
            $htmlPaginate       .= '</ul></nav>';
            echo  $htmlPaginate;
        }
        ?>
    </div>
</div>


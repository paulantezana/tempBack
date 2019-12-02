<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Tipo de Documento</th>
            <th>N° Documento</th>
            <th>Razón Social / Nombre Completo</th>
            <th>Email</th>
            <th>Telefono</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($parameter['customer']['data'] as $row) : ?>
            <tr>
                <td><?= $row['created_at'] ?></td>
                <td><?= $row['identity_document_type_code_description'] ?></td>
                <td><?= $row['document_number'] ?></td>
                <td><?= $row['social_reason'] ?></td>
                <td><?= $row['main_email'] ?></td>
                <td><?= $row['telephone'] ?></td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-light" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-menu9"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" onclick="Customer.showModalUpdate(<?= $row['customer_id'] ?>)">
                                <i class="icon-pencil4 mr-2"></i> Editar
                            </a>
                            <a class="dropdown-item" href="#" onclick="Customer.delete(<?= $row['customer_id'] ?>,'<?= $row['social_reason'] ?>')">
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
        Mostrando <?php echo $parameter['customer']['current']; ?> a <?php echo $parameter['customer']['limit']; ?> de <?php echo $parameter['customer']['pages']; ?> entradas
    </div>
    <div class="col-auto">
        <?php
        $currentPage = $parameter['customer']['current'];
        $totalPage = $parameter['customer']['pages'];
        $limitPage = $parameter['customer']['limit'];
        $additionalQuery = '';
        $linksQuantity = 3;

        if ($totalPage > 1) {
            $lastPage       = $totalPage;
            $startPage      = (($currentPage - $linksQuantity) > 0) ? $currentPage - $linksQuantity : 1;
            $endPage        = (($currentPage + $linksQuantity) < $lastPage) ? $currentPage + $linksQuantity : $lastPage;
            $htmlPaginate       = '<nav aria-label="..."><ul class="pagination">';
            $class      = ($currentPage == 1) ? "disabled" : "";
            $htmlPaginate       .= '<li class="page-item ' . $class . '"><a href="#" onclick="Customer.list(\''.($currentPage - 1). '\',\''.$limitPage.'\')" class="page-link"><span aria-hidden="true">&laquo;</span></a></li>';
            if ($startPage > 1) {
                $htmlPaginate   .= '<li class="page-item"><a href="#" onclick="Customer.list(\'1\',\''.$limitPage.'\')" class="page-link">1</a></li>';
                $htmlPaginate   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
            for ($i = $startPage; $i <= $endPage; $i++) {
                $class  = ($currentPage == $i) ? "active" : "";
                $htmlPaginate   .= '<li class="page-item ' . $class . '"><a href="#" onclick="Customer.list(\''.$i. '\',\''.$limitPage.'\')" class="page-link">' . $i . '</a></li>';
            }
            if ($endPage < $lastPage) {
                $htmlPaginate   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
                $htmlPaginate   .= '<li><a href="#" onclick="Customer.list(\''.$lastPage. '\',\''.$limitPage.'\')" class="page-link">' . $lastPage . '</a></li>';
            }
            $class      = ($currentPage == $lastPage || $totalPage == 0) ? "disabled" : "";
            $htmlPaginate       .= '<li class="page-item ' . $class . '"><a href="#" onclick="Customer.list(\''.($currentPage + 1). '\',\''.$limitPage.'\')" class="page-link"><span aria-hidden="true">&raquo;</span></a></li>';
            $htmlPaginate       .= '</ul></nav>';
            echo  $htmlPaginate;
        }
        ?>
    </div>
</div>


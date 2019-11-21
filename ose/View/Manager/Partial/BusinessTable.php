<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Logo</th>
                <th>RUC</th>
                <th>Razon social</th>
                <th>Email</th>
                <th>Cuenta de detracion</th>
                <th>Produción</th>
                <th style="width: 100px"></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($parameter['business']['data'] as $row) : ?>
            <tr class="<?php echo ($row['environment'] ? 'table-success' : '') ?>">
                <td>
                    <img src="<?php echo FOLDER_NAME . '/' . $row['logo'] ?>" alt="" height="32">
                </td>
                <td><?= $row['ruc'] ?></td>
                <td><?= $row['social_reason'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['detraction_bank_account'] ?></td>
                <td><?= $row['environment'] ?></td>
                <td>
                    <button type="button" class="btn btn-sm jsBusinessOption" onclick="Business.showModalUpdate(<?= $row['business_id'] ?>)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button" class="btn btn-sm jsBusinessOption" onclick="Business.delete(<?= $row['business_id'] ?>,'<?= $row['social_reason'] ?>')">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
    $currentPage = $parameter['business']['current'];
    $totalPage = $parameter['business']['pages'];
    $limitPage = $parameter['business']['limit'];
    $additionalQuery = '';
    $linksQuantity = 3;
    if ($totalPage > 1) {
        $lastPage       = $totalPage;
        $startPage      = (($currentPage - $linksQuantity) > 0) ? $currentPage - $linksQuantity : 1;
        $endPage        = (($currentPage + $linksQuantity) < $lastPage) ? $currentPage + $linksQuantity : $lastPage;
        $htmlPaginate       = '<nav aria-label="..."><ul class="pagination">';
        $class      = ($currentPage == 1) ? "disabled" : "";
        $htmlPaginate       .= '<li class="page-item ' . $class . '"><a href="#" onclick="Business.list(\''.($currentPage - 1). '\',\''.$limitPage.'\')" class="page-link"><span aria-hidden="true">&laquo;</span></a></li>';
        if ($startPage > 1) {
            $htmlPaginate   .= '<li class="page-item"><a href="#" onclick="Business.list(\'1\',\''.$limitPage.'\')" class="page-link">1</a></li>';
            $htmlPaginate   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        for ($i = $startPage; $i <= $endPage; $i++) {
            $class  = ($currentPage == $i) ? "active" : "";
            $htmlPaginate   .= '<li class="page-item ' . $class . '"><a href="#" onclick="Business.list(\''.$i. '\',\''.$limitPage.'\')" class="page-link">' . $i . '</a></li>';
        }
        if ($endPage < $lastPage) {
            $htmlPaginate   .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
            $htmlPaginate   .= '<li><a href="#" onclick="Business.list(\''.$lastPage. '\',\''.$limitPage.'\')" class="page-link">' . $lastPage . '</a></li>';
        }
        $class      = ($currentPage == $lastPage || $totalPage == 0) ? "disabled" : "";
        $htmlPaginate       .= '<li class="page-item ' . $class . '"><a href="#" onclick="Business.list(\''.($currentPage + 1). '\',\''.$limitPage.'\')" class="page-link"><span aria-hidden="true">&raquo;</span></a></li>';
        $htmlPaginate       .= '</ul></nav>';
        echo  $htmlPaginate;
    }
?>

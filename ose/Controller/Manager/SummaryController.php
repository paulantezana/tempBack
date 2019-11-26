<?php

require_once MODEL_PATH . 'Manager/Summary.php';
require_once MODEL_PATH . 'Manager/user.php';
require_once MODEL_PATH . 'User/Invoiceice.php';
require_once MODEL_PATH . 'User/DetailTicketSummary.php';

require_once CONTROLLER_PATH . 'Helper/SummaryManager.php';

class SummaryController
{
    protected $connection;
    private $summaryModel;
    private $userModel;
    public function __construct($connection ,$Parameters)
    {
        $this->summaryModel = new Summary($connection);
        $this->userModel = new userClass($connection);
        $this->connection=$connection;
    }

    public function Exec(){
        $message = '';
        $messageType = '';
        $error = [];

        $page = $_GET['page'] ?? 0;
        if (!$page){
            $page = 1;
        }

        if (isset($_POST['summaryGeneralCommit'])){
            $buildSummary = new SummaryManager($this->connection);
            $summaryCommit = $_POST['summary'] ?? [];
            $resBuSummary =  $buildSummary->ByAllInvoice($summaryCommit['dateOfReference'] ?? null, $summaryCommit['interval'] ?? 500);

            if ($resBuSummary->success){
                $messageType = 'success';
                $message = $resBuSummary->successMessage;
            } else {
                $message = $resBuSummary->errorMessage;
                $messageType = 'error';
            }
        } else if (isset($_POST['summaryCustomerCommit'])){
            $buildSummary = new SummaryManager($this->connection);
            $summaryCommit = $_POST['summary'] ?? [];
            $resBuSummary = $buildSummary->ByUserInvoice(
                $summaryCommit['userReferenceId'] ?? 0,
                $summaryCommit['dateOfReference'] ?? null,
                $summaryCommit['interval'] ?? 500
            );

            if ($resBuSummary->success){
                $messageType = 'success';
                $message = $resBuSummary->successMessage;
            } else {
                $message = $resBuSummary->errorMessage;
                $messageType = 'error';
            }
        } else if (isset($_POST['summaryCustomCommit'])){
            $buildSummary = new SummaryManager($this->connection);
            $summaryCommit = $_POST['summary'] ?? [];
            $summaryItem = $summaryCommit['item'] ?? [];
            $userReferenceId = $summaryCommit['userReferenceId'] ?? 0;

            $ids = array_map(function ($item){
                return $item['sale_id'];
            }, $summaryItem);

            $saleModel = new Invoice($this->connection);
            $sale = $saleModel->GetByIds($ids,$userReferenceId)->result;

            $newSummaryItem = array_map(function ($item) use ($sale){
                $index = array_search($item['sale_id'], array_column($sale, 'sale_id'));
                return array_merge($item,['date_of_issue' => $sale[$index]['date_of_issue'] ?? '']);
            }, $summaryItem);

            $resBuSummary =  $buildSummary->ByInvoice(
                $newSummaryItem ?? [],
                $summaryCommit['userReferenceId'] ?? 0
            );
            if ($resBuSummary->success){
                $messageType = 'success';
                $message = sprintf("EL resumen se generó exitosamente.");
            } else {
                $message = $resBuSummary->errorMessage;
                $messageType = 'error';
            }
        }

        $filter = $_GET['filter'] ?? [];

        $summaryModel = new Summary($this->connection);
        $summary = $summaryModel->paginate(
            $page,
            $filter
        );
        $user = $this->userModel->GetAllUser();

        $parameter['user'] = $user;
        $parameter['summary'] = $summary;
        $parameter['filter'] = $filter;
        $parameter['error'] = $error;
        $parameter['message'] = $message;
        $parameter['messageType'] = $messageType;

        $content = requireToVar(VIEW_PATH . "Manager/Summary.php", $parameter);
        require_once(VIEW_PATH. "Manager/Layout/main.php");
    }

    public function SearchByReferenceUser(){
        $search = $_POST['q'] ?? '';
        $userReferenceId = $_POST['userReferenceId'] ?? '';
        $data = $this->summaryModel->SearchByUserReferenceId($search, (int)$userReferenceId);
        echo json_encode($data);
    }
    public function DetailTicketSummary(){
        header('Content-Type: application/json; charset=UTF-8');

        $postData = file_get_contents("php://input");
        $body = json_decode($postData, true);
        $ticketSummaryId = $body['ticket_summary_id'];

        $detailTicketSummaryModel = new DetailTicketSummary($this->connection);
        $data = $detailTicketSummaryModel->GetByTicketSummaryId($ticketSummaryId);

        echo json_encode($data);
    }
}

<?php

require_once MODEL_PATH . 'User/TicketSummary.php';
require_once MODEL_PATH . 'User/DetailTicketSummary.php';
require_once MODEL_PATH . 'User/Sale.php';
require_once MODEL_PATH . 'User/Business.php';

require_once CONTROLLER_PATH . 'Helper/SummaryManager.php';

class TicketSummaryController
{
    private $connection;
    private $param;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
    }

    public function Exec(){
        try{
            $message = '';
            $messageType = '';
            $error = [];

            $page = $_GET['page'] ?? 0;
            if (!$page){
                $page = 1;
            }

            if (isset($_POST['dateOfReferenceCommit'])){
                $dateOfReference = $_POST['dateOfReference'] ?? '';
                if ($dateOfReference){
                    $resSummary = $this->BuildSummary($dateOfReference);
                    if (!$resSummary->success){
                        $message = $resSummary->errorMessage;
                        $messageType = 'error';
                    }else{
                        $message = $resSummary->successMessage;
                        $messageType = 'success';
                    }
                }
            }

            $filter = $_GET['filter'] ?? [];

            $summaryModel = new TicketSummary($this->connection);
            $summary = $summaryModel->paginate(
                $page,
                10,
                $filter,
                $_COOKIE['CurrentBusinessLocal']
            );

            $parameter['summary'] = $summary;
            $parameter['filter'] = $filter;
            $parameter['error'] = $error;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;

            $content = requireToVar(VIEW_PATH . "User/TicketSummary.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
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

    private function GeneratePdf(int $ticketSummaryID) : array {
        $ticketSummaryModel = new TicketSummary($this->connection);
        $companyModel = new Business($this->connection);

        $ticketSummary = $ticketSummaryModel -> GetById($ticketSummaryID);
        $company = $companyModel -> GetByUserId();

        // Datos temporales => deberia consultar del local donde se emite el documento electronico
        $company = array_merge($company,[
            'address' => 'AV. HUASCAR NRO. 224 DPTO. 303',
            'region' => 'CUSCO',
            'province' => 'CUSCO',
            'district' => 'WANCHAQ',
            'email' => 'info@skynetcusco.com',
            'telephone' => '084601425',
            'phone' => '979706609',
            'web_site' => 'www.skynetcusco.com',
        ]);

        $generateTicketPDF = new DocumentManager();
//        $directory = $generateTicketPDF->Build();
//        return $ticketSummaryModel->UpdateById($ticketSummaryID,[
//            'pdf_url'=> $directory
//        ]);
    }

    private function BuildSummary($lastDay) {
        $res = new Result();
        try{
            $buildSummary = new SummaryManager($this->connection);
            $resBuildSummary = $buildSummary->ByUserInvoice($_SESSION[SESS],$lastDay);
            if(!$resBuildSummary->success){
                throw new Exception($resBuildSummary->errorMessage);
            }

            $res->successMessage = $resBuildSummary->successMessage ?? '';
            $res->success = true;
        }catch (Exception $e){
            $res->errorMessage = $e->getMessage();
            $res->success = false;
        }
        return $res;
    }
}

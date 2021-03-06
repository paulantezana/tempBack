<?php

require_once MODEL_PATH . 'User/InvoiceSummary.php';
require_once MODEL_PATH . 'User/InvoiceSummaryItem.php';
require_once MODEL_PATH . 'User/Invoice.php';
require_once MODEL_PATH . 'User/Business.php';

require_once CONTROLLER_PATH . 'Helper/SummaryManager.php';

class InvoiceSummaryController
{
    private $connection;
    private $param;
    private $invoice;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;
        $this->invoice = new Invoice($this->connection);
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

            $summaryModel = new InvoiceSummary($this->connection);
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

            $content = requireToVar(VIEW_PATH . "User/InvoiceSummary.php", $parameter);
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

        $detailTicketSummaryModel = new InvoiceSummaryItem($this->connection);
        $data = $detailTicketSummaryModel->GetByTicketSummaryId($ticketSummaryId);

        echo json_encode($data);
    }

    public function GetInvoiceNotSummary(){
        $res = new Result();
        try{
            $dateOfIssue = $_POST['dateOfIssue'];
            $localID = $_COOKIE['CurrentBusinessLocal'];

            $customer = $this->invoice->NotDailySummaryByLocalId($dateOfIssue, $localID);
            if(count($customer) == 0){
                throw new Exception('No se encontro ningun documento');
            }

            $res->result = $customer;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    private function GeneratePdf(int $ticketSummaryID) {
        // $ticketSummaryModel = new InvoiceSummary($this->connection);
        // $companyModel = new Business($this->connection);

        // $ticketSummary = $ticketSummaryModel -> GetById($ticketSummaryID);
        // $company = $companyModel -> GetByUserId();

        // // Datos temporales => deberia consultar del local donde se emite el documento electronico
        // $company = array_merge($company,[
        //     'address' => 'AV. HUASCAR NRO. 224 DPTO. 303',
        //     'region' => 'CUSCO',
        //     'province' => 'CUSCO',
        //     'district' => 'WANCHAQ',
        //     'email' => 'info@skynetcusco.com',
        //     'telephone' => '084601425',
        //     'phone' => '979706609',
        //     'web_site' => 'www.skynetcusco.com',
        // ]);

        // $generateTicketPDF = new DocumentManager();
//        $directory = $generateTicketPDF->Build();
//        return $ticketSummaryModel->UpdateById($ticketSummaryID,[
//            'pdf_url'=> $directory
//        ]);
        return [];
    }

    private function BuildSummary($lastDay) {
        $res = new Result();
        try{
            $buildSummary = new SummaryManager($this->connection);

            $localId = $_COOKIE['CurrentBusinessLocal'];
            $resBuildSummary = $buildSummary->ByLocalInvoice($localId, $lastDay);
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

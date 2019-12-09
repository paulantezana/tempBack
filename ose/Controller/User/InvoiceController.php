<?php

//require_once MODEL_PATH . 'User/CatAdditionalLegendCode.php';
require_once MODEL_PATH . 'User/CatAffectationIgvTypeCode.php';
require_once MODEL_PATH . 'User/CatSubjectDetractionCode.php';
require_once MODEL_PATH . 'User/CatTransferReasonCode.php';
require_once MODEL_PATH . 'User/CatTransportModeCode.php';
require_once MODEL_PATH . 'User/CatCurrencyTypeCode.php';
require_once MODEL_PATH . 'User/CatDocumentTypeCode.php';
require_once MODEL_PATH . 'User/CatIdentityDocumentTypeCode.php';
require_once MODEL_PATH . 'User/CatOperationTypeCode.php';
require_once MODEL_PATH . 'User/Invoice.php';
require_once MODEL_PATH . 'User/Customer.php';
require_once MODEL_PATH . 'User/InvoiceItem.php';
require_once MODEL_PATH . 'User/Product.php';
require_once MODEL_PATH . 'User/CatCreditNoteTypeCode.php';
require_once MODEL_PATH . 'User/CatDebitNoteTypeCode.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/CatSystemIscTypeCode.php';
require_once MODEL_PATH . 'User/BusinessSerie.php';
require_once MODEL_PATH . 'User/CatPerceptionTypeCode.php';
require_once MODEL_PATH . 'User/CatGeographicalLocationCode.php';

require_once CONTROLLER_PATH . 'Helper/InvoiceTemplate.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceValidate.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceBuild.php';

class InvoiceController
{
    protected $connection;
    private $param;
    private $invoiceModel;
    private $invoiceItemModel;
    private $customerModel;
    private $businessModel;
    private $productModel;

    public function __construct(PDO $connection, $param)
    {
        $this->connection = $connection;
        $this->param = $param;

        $this->invoiceModel = new Invoice($this->connection);
        $this->invoiceItemModel = new InvoiceItem($this->connection);
        $this->customerModel = new Customer($this->connection);
        $this->businessModel = new Business($this->connection);
        $this->productModel = new Product($this->connection);
    }

    public function Exec(){
        try{
            $page = $_GET['page'] ?? 0;
            if (!$page){
                $page = 1;
            }

            $filterDocumentCode = $_GET['filter']['documentCode'] ?? '';
            $filterCustomer = $_GET['filter']['customer'] ?? 0;
            $filterStartDate = $_GET['filter']['startDate'] ?? '';
            $filterEndDate = $_GET['filter']['endDate'] ?? '';
            $filterInvoiceSearch = $_GET['filter']['invoiceSearch'] ?? 0;

            $documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
            $documentTypeCode = $documentTypeCodeModel->ByInCodes(['01','03']);

            // Filter
            $customerDescription = '';
            if ($filterCustomer){
                $data = $this->customerModel->GetByDocumentNumber([
                    'documentNumber' => $filterCustomer,
                    'businessId' =>  $this->businessModel->GetByUserId($_SESSION[SESS])['business_id'],
                ]);
                $customerDescription = $data['social_reason'];
            }

            $invoiceDescription = '';
            if ($filterInvoiceSearch){
                $data = $this->invoiceModel->GetById($filterInvoiceSearch);
                $index = array_search($data['document_code'], array_column($documentTypeCode, 'code'));
                $invoiceDescription = "{$documentTypeCode[$index]['description']}: {$data['serie']}-{$data['correlative']}";
            }

            $parameter['filter'] = [
                'documentCode' => $filterDocumentCode,
                'customer' => [
                    'documentNumber' => $filterCustomer,
                    'description' => $customerDescription,
                ],
                'startDate' => $filterStartDate,
                'endDate' => $filterEndDate,
                'invoiceSearch' => [
                    'invoiceId' => $filterInvoiceSearch,
                    'description' => $invoiceDescription,
                ]
            ];

            $parameter['invoice'] = $this->invoiceModel->Paginate(
                $page,
                10,
                [
                    'documentCode' => $filterDocumentCode,
                    'customerDocumentNumber' => $filterCustomer,
                    'startDate' => $filterStartDate,
                    'endDate' => $filterEndDate,
                    'invoiceSearch' => $filterInvoiceSearch,
                ]
            );
            $parameter['documentTypeCode'] = $documentTypeCode;

            $content = requireToVar(VIEW_PATH . "User/Invoice.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function Table(){
        try {
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            $filter = isset($_POST) ? $_POST : [];
            $parameter['invoice'] = $this->invoiceModel->Paginate(
                $page,
                $limit,
                $filter
            );

            echo requireToVar(VIEW_PATH . "User/Partial/InvoiceTable.php", $parameter);
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function ResendInvoice(){
        try{
            $invoiceId = $_GET['InvoiceId'] ?? 0;
            if(!$invoiceId){
                header('Location: ' . FOLDER_NAME . '/Invoice');
            }

            $invoiceBuild = new InvoiceBuild($this->connection);
            $resRunDoc = $invoiceBuild->BuildDocument($invoiceId,$_SESSION[SESS]);
            if ($resRunDoc->success){
                header('Location: ' . FOLDER_NAME . '/Invoice/View?InvoiceId=' . $invoiceId . '&message=' . 'El documento se guardó y se envió a la SUNAT exitosamente' . '&messageType=success');
            } else {
                header('Location: ' . FOLDER_NAME . '/Invoice/View?InvoiceId=' . $invoiceId . '&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function NewInvoice(){
        try{
            $error = [];
            $message = "";
            $messageType = "";
            $invoice = $_POST['invoice'] ?? [];

            if (isset($_POST['commit'])){
                try{
                    if (empty($invoice)){
                        throw new Exception('No hay ningun campo');
                    }

                    $invoice['itinerant_enable'] = ($invoice['itinerant_enable'] ?? false) == 'on' ? 1 : 0;
                    $invoice['prepayment_regulation'] = ($invoice['prepayment_regulation'] ?? false) == 'on' ? 1 : 0;
                    $invoice['time_of_issue'] = date('H:i:s');

                    $legend = [];
                    if ($invoice['jungle_product'] ?? 0 === 'on'){
                        array_push($legend,2001);
                    }
                    if ($invoice['jungle_service'] ?? 0){
                        array_push($legend,2002);
                    }
                    $invoice['legend'] = $legend;

                    $invoice['percentage_igv'] = 18.00;
                    $invoice['total_value'] = $invoice['total_unaffected'] + $invoice['total_taxed'] + $invoice['total_exonerated'];

                    $invoice['guide_array'] = [];
                    if (isset($invoice['guide'])){
                        foreach ($invoice['guide'] as $key => $value){
                            array_push($invoice['guide_array'],$value);
                        }
                    }

                    $validateInput = $this->ValidateInput($invoice);
                    $error = $validateInput->error;
                    if (!$validateInput->success){
                        throw new Exception($validateInput->errorMessage);
                    }
                    $invoiceId = $this->invoiceModel->Insert($invoice, $_SESSION[SESS], $_COOKIE['CurrentBusinessLocal']);

                    $invoiceBuild = new InvoiceBuild($this->connection);
                    $resRunDoc = $invoiceBuild->BuildDocument($invoiceId,$_SESSION[SESS]);
                   if ($invoiceId >= 1 && $resRunDoc->success){
                           header('Location: ' . FOLDER_NAME . '/Invoice/View?InvoiceId=' . $invoiceId . '&message=' . urlencode('El documento se guardó y se envió a la SUNAT exitosamente') . '&messageType=success');
                       } else {
                           header('Location: ' . FOLDER_NAME . '/Invoice/View?InvoiceId=' . $invoiceId . '&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
                       }
                    return;
                }catch (Exception $exception){
                    $message = $exception->getMessage(). $exception->getTraceAsString();
                    $messageType = 'danger';
                }
            }

            $affectationIgvTypeCodeModel = new CatAffectationIgvTypeCode($this->connection);
            $systemIscTypeCodeModel = new CatSystemIscTypeCode($this->connection);
            $currencyTypeCodeModel = new CatCurrencyTypeCode($this->connection);
            $documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
            $identityDocumentTypeCodeModel = new CatIdentityDocumentTypeCode($this->connection);
            $operationTypeCodeModel = new CatOperationTypeCode($this->connection);
            $perceptionTypeCodeModel = new CatPerceptionTypeCode($this->connection);
            $transferReasonCodeModel = new CatTransferReasonCode($this->connection);
            $transportModeCodeModel = new CatTransportModeCode($this->connection);
            $subjectDetractionCode = new CatSubjectDetractionCode($this->connection);

            $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->GetAll();
            $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();
            $parameter['documentTypeCode'] = $documentTypeCodeModel->GetBy('code','01');
            $parameter['currencyTypeCode'] = $currencyTypeCodeModel->getAll();
            $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->getAll();
            $parameter['operationTypeCode'] = $operationTypeCodeModel->getAll();
            $parameter['perceptionTypeCode'] = $perceptionTypeCodeModel->getAll();
            $parameter['transferReasonCode'] = $transferReasonCodeModel->getAll();
            $parameter['transportModeCode'] = $transportModeCodeModel->getAll();
            $parameter['subjectDetractionCode'] = $subjectDetractionCode->getAll();
            $parameter['business'] = $this->businessModel->GetByUserId($_SESSION[SESS]);
            $parameter['productList'] = $this->productModel->GetAllByBusinessId($parameter['business']['business_id']);

            $documentCorrelativeModel = new BusinessSerie($this->connection);
            $correlative = $documentCorrelativeModel->GetNextCorrelative([
                'localId' => $_COOKIE['CurrentBusinessLocal'],
                'documentCode' => '01',
            ]);

            $parameter['correlative'] = $correlative['correlative'] + 1;
            $parameter['correlativePrefix'] = $correlative['serie'];
            $parameter['invoice'] = $invoice;
            $parameter['error'] = $error;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;
            $parameter['itemTemplate'] = InvoiceTemplate::Item($parameter['business'],$parameter['affectationIgvTypeCode']);
            $parameter['referralGuideTemplate'] = $this->GetReferralGuideTemplate();

            $content = requireToVar(VIEW_PATH . "User/NewInvoice.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function NewTicket(){
        try{
            $error = [];
            $message = "";
            $messageType = "";
            $invoice = $_POST['invoice'] ?? [];

            if (isset($_POST['commit'])){
                try{
                    if (empty($invoice)){
                        throw new Exception('No hay ningun campo');
                    }

                    $invoice['itinerant_enable'] = ($invoice['itinerant_enable'] ?? false) == 'on' ? 1 : 0;
                    $invoice['prepayment_regulation'] = ($invoice['prepayment_regulation'] ?? false) == 'on' ? 1 : 0;
                    $invoice['time_of_issue'] = date('H:i:s');

                    $legend = [];
                    if ($invoice['jungle_product'] ?? 0 === 'on'){
                        array_push($legend,2001);
                    }
                    if ($invoice['jungle_service'] ?? 0){
                        array_push($legend,2002);
                    }
                    $invoice['legend'] = $legend;

                    $invoice['percentage_igv'] = 18.00;
                    $invoice['total_value'] = $invoice['total_unaffected'] + $invoice['total_taxed'] + $invoice['total_exonerated'];

                    $invoice['guide_array'] = [];
                    if (isset($invoice['guide'])){
                        foreach ($invoice['guide'] as $key => $value){
                            array_push($invoice['guide_array'],$value);
                        }
                    }

                    $validateInput = $this->ValidateInput($invoice);
                    $error = $validateInput->error;
                    if (!$validateInput->success){
                        throw new Exception($validateInput->errorMessage);
                    }

                    $invoiceId = $this->invoiceModel->Insert($invoice, $_SESSION[SESS], $_COOKIE['CurrentBusinessLocal']);
                    $invoiceBuild = new InvoiceBuild($this->connection);
                    $resRunDoc = $invoiceBuild->BuildDocument($invoiceId, $_SESSION[SESS]);

                   if ($invoiceId >= 1 && $resRunDoc->success){
                       header('Location: ' . FOLDER_NAME . '/Invoice/View?InvoiceId=' . $invoiceId . '&message=' . urlencode('El documento se guardó y se envió a la SUNAT exitosamente') . '&messageType=success');
                   } else {
                       header('Location: ' . FOLDER_NAME . '/Invoice/View?InvoiceId=' . $invoiceId . '&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
                   }
                   return;
                }catch (Exception $exception){
                    $message = $exception->getMessage();
                    $messageType = 'danger';
                }
            }

            $affectationIgvTypeCodeModel = new CatAffectationIgvTypeCode($this->connection);
            $systemIscTypeCodeModel = new CatSystemIscTypeCode($this->connection);
            $currencyTypeCodeModel = new CatCurrencyTypeCode($this->connection);
            $documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
            $identityDocumentTypeCodeModel = new CatIdentityDocumentTypeCode($this->connection);
            $operationTypeCodeModel = new CatOperationTypeCode($this->connection);
            $perceptionTypeCodeModel = new CatPerceptionTypeCode($this->connection);

            $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->GetAll();
            $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();
            $parameter['documentTypeCode'] = $documentTypeCodeModel->GetBy('code','03');
            $parameter['currencyTypeCode'] = $currencyTypeCodeModel->getAll();
            $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->getAll();
            $parameter['operationTypeCode'] = $operationTypeCodeModel->getAll();
            $parameter['perceptionTypeCode'] = $perceptionTypeCodeModel->getAll();
            $parameter['business'] = $this->businessModel->GetByUserId($_SESSION[SESS]);
            $parameter['productList'] = $this->productModel->GetAllByBusinessId($parameter['business']['business_id']);

            $documentCorrelativeModel = new BusinessSerie($this->connection);
            $correlative = $documentCorrelativeModel->GetNextCorrelative([
                'localId' => $_COOKIE['CurrentBusinessLocal'],
                'documentCode' => '03',
            ]);

            $parameter['correlative'] = $correlative['correlative'] + 1;
            $parameter['correlativePrefix'] = $correlative['serie'];
            $parameter['invoice'] = $invoice;
            $parameter['error'] = $error;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;
            $parameter['itemTemplate'] = InvoiceTemplate::Item($parameter['business'],$parameter['affectationIgvTypeCode']);
            $parameter['referralGuideTemplate'] = $this->GetReferralGuideTemplate();

            $content = requireToVar(VIEW_PATH . "User/NewTicket.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function View(){
        try{
            $invoiceId = $_GET['InvoiceId'] ?? 0;
            if(!$invoiceId){
                return;
            }
            $message = $_GET['message'] ?? '';
            $messageType = $_GET['messageType'] ?? '';
            $messageType = ($messageType == 'success') ? 'success' : ($messageType == 'error' ? 'danger' : '');

            $invoice = $this->invoiceModel->summaryById($invoiceId);
            $parameter['invoiceItem'] = $this->invoiceItemModel->ByInvoiceIdSummary($invoiceId);
            $parameter['invoice'] = $invoice;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;

            $content = requireToVar(VIEW_PATH . "User/InvoiceView.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function Search(){
        $res = new Result();
        try{
            $q = $_POST['q'] ?? '';
            $search['search'] = $q;

            $search['localId'] = $_COOKIE['CurrentBusinessLocal'];
            $response = $this->invoiceModel->searchBySerieCorrelative($search);

            $res->result = $response;
            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        echo json_encode($res);
    }

    private function ValidateInput(array $invoice) {
        $invoiceValidate = new InvoiceValidate($invoice, $this->connection);
        return $invoiceValidate->getResult();
    }

    private function GetReferralGuideTemplate(){
        return '<tr id="referralGuideItem${uniqueId}">
            <td>
                <label for="type${uniqueId}"><i class="icon-profile mr-2"></i> Tipo</label>
                <select class="form-control form-control-sm" id="type${uniqueId}" name="invoice[guide][${uniqueId}][document_code]" required>
                    <option value="09">GUÍA DE REMISIÓN REMITENTE</option>
                    <option value="31">GUÍA DE REMISIÓN TRANSPORTISTA</option>
                </select>
            </td>
            <td>
                <label for="serie${uniqueId}"><i class="icon-barcode2 mr-2"></i> Serie - Número</label>
                <input type="text" placeholder="####-######" class="form-control" id="serie${uniqueId}" name="invoice[guide][${uniqueId}][serie]" required>
            </td>
            <td>
                <div class="btn btn-danger mt-4" onclick="ReferralGuidePhysical.removeItem(\'${uniqueId}\')"><i class="icon-cross2 mr-2"></i>Quitar</div>
            </td>
        </tr>';
    }
}

<?php

require_once MODEL_PATH . 'User/CatAffectationIgvTypeCode.php';
require_once MODEL_PATH . 'User/CatCurrencyTypeCode.php';
require_once MODEL_PATH . 'User/CatDocumentTypeCode.php';
require_once MODEL_PATH . 'User/CatIdentityDocumentTypeCode.php';
require_once MODEL_PATH . 'User/CatOperationTypeCode.php';
require_once MODEL_PATH . 'User/Invoice.php';
require_once MODEL_PATH . 'User/InvoiceNote.php';
require_once MODEL_PATH . 'User/Customer.php';
require_once MODEL_PATH . 'User/InvoiceItem.php';
require_once MODEL_PATH . 'User/InvoiceNoteItem.php';
require_once MODEL_PATH . 'User/Product.php';
require_once MODEL_PATH . 'User/CatCreditNoteTypeCode.php';
require_once MODEL_PATH . 'User/CatDebitNoteTypeCode.php';
require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/CatSystemIscTypeCode.php';
require_once MODEL_PATH . 'User/BusinessSerie.php';

require_once CONTROLLER_PATH . 'Helper/InvoiceTemplate.php';
require_once CONTROLLER_PATH . 'Helper/InvoiceValidate.php';

require_once CONTROLLER_PATH . 'Helper/InvoiceNoteBuild.php';

class InvoiceNoteController
{
    private $connection;
    private $invoiceNoteModel;
    private $detailInvoiceNoteModel;
    private $customerModel;
    private $productModel;
    private $businessModel;
    private $creditNoteTypeCodeModel;
    private $debitNoteTypeCodeModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;

        $this->invoiceNoteModel = new InvoiceNote($this->connection);
        $this->detailInvoiceNoteModel = new InvoiceNoteItem($this->connection);
        $this->customerModel = new Customer($this->connection);
        $this->productModel = new Product($this->connection);
        $this->businessModel = new Business($this->connection);

        $this->creditNoteTypeCodeModel = new CatCreditNoteTypeCode($this->connection);
        $this->debitNoteTypeCodeModel = new CatDebitNoteTypeCode($this->connection);
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
            $filterInvoiceNoteSearch = $_GET['filter']['invoiceNoteSearch'] ?? 0;

            $invoiceNoteModel = new InvoiceNote($this->connection);
            $documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
            $customerModel = new Customer($this->connection);

            $documentTypeCode = $documentTypeCodeModel->ByInCodes(['07','08']);

            // Filter
            $customerDescription = '';
            if ($filterCustomer){
                $data = $customerModel->GetById($filterCustomer);
                $customerDescription = $data['document_number'] . ' ' . $data['social_reason'];
            }

            $invoiceDescription = '';
            if ($filterInvoiceNoteSearch){
                $data = $invoiceNoteModel->GetById($filterInvoiceNoteSearch);
                $index = array_search($data['document_code'], array_column($documentTypeCode, 'code'));
                $invoiceDescription = "{$data['serie']}-{$data['correlative']} ( {$documentTypeCode[$index]['description']} ) {$data['date_of_issue']}";
            }

            $parameter['filter'] = [
                'documentCode' => $filterDocumentCode,
                'customer' => [
                    'customer_id' => $filterCustomer,
                    'description' => $customerDescription,
                ],
                'startDate' => $filterStartDate,
                'endDate' => $filterEndDate,
                'invoiceSearch' => [
                    'invoice_id' => $filterInvoiceNoteSearch,
                    'description' => $invoiceDescription,
                ]
            ];

            $parameter['invoiceNote'] = $invoiceNoteModel->paginate(
                $page,
                10,
                [
                    'documentCode' => $filterDocumentCode,
                    'customerID' => $filterCustomer,
                    'startDate' => $filterStartDate,
                    'endDate' => $filterEndDate,
                    'invoiceSearch' => $filterInvoiceNoteSearch,
                ]
            );
            $parameter['documentTypeCode'] = $documentTypeCode;

            $content = requireToVar(VIEW_PATH . "User/InvoiceNote.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function ResendInvoice(){
        try{
            $invoiceNoteId = $_GET['InvoiceNoteId'] ?? 0;
            if(!$invoiceNoteId){
                header('Location: ' . FOLDER_NAME . '/InvoiceNote');
            }

            $resRunDoc = $this->BuildDocument($invoiceNoteId);
            if ($resRunDoc->success){
                header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?InvoiceNoteId=' . $invoiceNoteId . '&message=' . 'El documento se guardó y se envió a la SUNAT exitosamente' . '&messageType=success');
            }else{
                header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?InvoiceNoteId=' . $invoiceNoteId . '&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function JsonSearch(){
        $search = $_POST['q'] ?? '';

        $data = $this->invoiceNoteModel->searchBySerieCorrelative($search);

        echo json_encode([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function NewCreditNote(){
        try{
            $error = [];
            $message = "";
            $messageType = "";
            $invoice = $_POST['invoice'] ?? [];

            $invoiceModel = new Invoice($this->connection);

            // cuando se envia un parametro InvoiceId desde la url
            $invoiceId = $_GET['InvoiceId'] ?? 0;
            if ($invoiceId && is_numeric($invoiceId) ){
                $invoice = $invoiceModel -> GetById($invoiceId);
                if ($invoice){
                    $invoiceId = $invoice['invoice_id'];
                    $serie = $invoice['serie'];
                    $correlative = $invoice['correlative'];
                    $documentCode = $invoice['document_code'];
                    $customer = [
                        'social_reason' => $invoice['customer_social_reason'],
                        'document_number' => $invoice['customer_document_number'],
                        'identity_document_code' => $invoice['customer_identity_document_code'],
                        'fiscal_address' => $invoice['customer_fiscal_address'],
                    ];

                    unset($invoice['invoice_id']);
                    unset($invoice['serie']);
                    unset($invoice['correlative']);
                    unset($invoice['document_code']);
                    unset($invoice['customer_social_reason']);
                    unset($invoice['customer_document_number']);
                    unset($invoice['customer_identity_document_code']);
                    unset($invoice['customer_fiscal_address']);

                    $invoice['invoice_update'] = [
                        'invoice_id' => $invoiceId,
                        'serie' => $serie,
                        'correlative' => $correlative,
                        'document_code' => $documentCode,
                        'customer' => $customer
                    ];

                    $invoice['customer'] = $customer;
                    $invoice['guide'] = json_decode($invoice['guide'],true);

                    $invoiceItemModel = new InvoiceItem($this->connection);
                    $invoice['item'] = $invoiceItemModel->ByInvoiceIdSummary($invoiceId);
                }
            }

            if (isset($_POST['commit'])){
                try{
                    if (empty($invoice)){
                        throw new Exception('No hay ningun campo');
                    }

                    $invoiceModel = new Invoice($this->connection);
                    $invoiceId  = $invoiceModel -> ExistDocument(
                        $invoice['invoice_update']['correlative'],
                        $invoice['invoice_update']['serie'],
                        $invoice['invoice_update']['document_code']
                    );
                    if (!$invoiceId){
                        throw new Exception('El documento que hace referecnia no existe');
                    }
                    $invoice['reason_update_code'] = $invoice['invoice_update']['credit_note_code'];
                    $invoice['invoice_id'] = $invoiceId;

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

//                    $validateInput = $this->ValidateInput($invoice);
//                    $error = $validateInput->error;
//                    if (!$validateInput->success){
//                        throw new Exception($validateInput->errorMessage);
//                    }

                    $invoiceNoteId = $this->invoiceNoteModel->Insert($invoice, $_SESSION[SESS], $_COOKIE['CurrentBusinessLocal']);
                    $invoiceBuild = new InvoiceNoteBuild($this->connection);
                    $resRunDoc = $invoiceBuild->BuildDocument($invoiceNoteId, $_SESSION[SESS]);

                    // ALL SUCCESS
                    if ($invoiceNoteId >= 1 && $resRunDoc->errorMessage === ''){
                        header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?InvoiceNoteId=' . $invoiceNoteId . '&message=' . urlencode('El documento se guardó exitosamente') . '&messageType=success');
                        return;
                    } else{
                        header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?InvoiceId=' . $invoiceNoteId . '&message=' . urlencode($resRunDoc->errorMessag) . '&messageType=error');
                        return;
                    }
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
            $creditNoteTypeModel = new CatCreditNoteTypeCode($this->connection);
            $businessModel = new Business($this->connection);

            $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->GetAll();
            $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();
            $parameter['documentTypeCode'] = $documentTypeCodeModel->GetBy('code','07');
            $parameter['currencyTypeCode'] = $currencyTypeCodeModel->getAll();
            $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->getAll();
            $parameter['operationTypeCode'] = $operationTypeCodeModel->getAll();
            $parameter['creditNoteType'] = $creditNoteTypeModel->getAll();
            $parameter['business'] = $businessModel->GetByUserId($_SESSION[SESS]);
            $parameter['productList'] = $this->productModel->GetAllByBusinessId($parameter['business']['business_id']);

            $documentCorrelativeModel = new BusinessSerie($this->connection);
            $correlative = $documentCorrelativeModel->GetNextCorrelative([
                'localId' => $_COOKIE['CurrentBusinessLocal'],
                'documentCode' => '07',
            ]);

            $parameter['correlative'] = $correlative['correlative'] + 1;
            $parameter['correlativePrefix'] = $correlative['serie'];
            $parameter['invoice'] = $invoice;
            $parameter['error'] = $error;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;
            $parameter['itemTemplate'] = InvoiceTemplate::Item($parameter['business'],$parameter['affectationIgvTypeCode']);
            $parameter['referralGuideTemplate'] = $this->GetReferralGuideTemplate();

            $content = requireToVar(VIEW_PATH . "User/NewInvoiceCreditNote.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function NewDebitNote(){
        try{
            $error = [];
            $message = "";
            $messageType = "";
            $invoice = $_POST['invoice'] ?? [];

            $invoiceModel = new Invoice($this->connection);

            // cuando se envia un parametro InvoiceId desde la url
            $invoiceId = $_GET['InvoiceId'] ?? 0;
            if ($invoiceId && is_numeric($invoiceId) ){
                $invoice = $invoiceModel -> GetById($invoiceId);
                if ($invoice){
                    $invoiceId = $invoice['invoice_id'];
                    $serie = $invoice['serie'];
                    $correlative = $invoice['correlative'];
                    $documentCode = $invoice['document_code'];
                    $customer = [
                        'social_reason' => $invoice['customer_social_reason'],
                        'document_number' => $invoice['customer_document_number'],
                        'identity_document_code' => $invoice['customer_identity_document_code'],
                        'fiscal_address' => $invoice['customer_fiscal_address'],
                    ];

                    unset($invoice['invoice_id']);
                    unset($invoice['serie']);
                    unset($invoice['correlative']);
                    unset($invoice['document_code']);
                    unset($invoice['customer_social_reason']);
                    unset($invoice['customer_document_number']);
                    unset($invoice['customer_identity_document_code']);
                    unset($invoice['customer_fiscal_address']);

                    $invoice['invoice_update'] = [
                        'invoice_id' => $invoiceId,
                        'serie' => $serie,
                        'correlative' => $correlative,
                        'document_code' => $documentCode,
                        'customer' => $customer
                    ];

                    $invoice['customer'] = $customer;
                    $invoice['guide'] = json_decode($invoice['guide'],true);

                    $invoiceItemModel = new InvoiceItem($this->connection);
                    $invoice['item'] = $invoiceItemModel->ByInvoiceIdSummary($invoiceId);
                }
            }

            if (isset($_POST['commit'])){
                try{
                    if (empty($invoice)){
                        throw new Exception('No hay ningun campo');
                    }

                    $invoiceModel = new Invoice($this->connection);
                    $invoiceId  = $invoiceModel -> ExistDocument(
                        $invoice['invoice_update']['correlative'],
                        $invoice['invoice_update']['serie'],
                        $invoice['invoice_update']['document_code']
                    );
                    if (!$invoiceId){
                        throw new Exception('El documento que hace referecnia no existe');
                    }
                    $invoice['reason_update_code'] = $invoice['invoice_update']['credit_note_code'];
                    $invoice['invoice_id'] = $invoiceId;

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

//                    $validateInput = $this->ValidateInput($invoice);
//                    $error = $validateInput->error;
//                    if (!$validateInput->success){
//                        throw new Exception($validateInput->errorMessage);
//                    }

                    $invoiceNoteId = $this->invoiceNoteModel->Insert($invoice, $_SESSION[SESS], $_COOKIE['CurrentBusinessLocal']);
                    $invoiceBuild = new InvoiceNoteBuild($this->connection);
                    $resRunDoc = $invoiceBuild->BuildDocument($invoiceNoteId, $_SESSION[SESS]);

                    // ALL SUCCESS
                    if ($invoiceNoteId >= 1 && $resRunDoc->errorMessage === ''){
                        header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?InvoiceNoteId=' . $invoiceNoteId . '&message=' . urlencode('El documento se guardó exitosamente') . '&messageType=success');
                        return;
                    } else{
                        header('Location: ' . FOLDER_NAME . '/InvoiceNote/View?InvoiceNoteId=' . $invoiceNoteId . '&message=' . urlencode($resRunDoc->errorMessage) . '&messageType=error');
                        return;
                    }
                }catch (Exception $exception){
                    $message = $exception->getMessage() . $exception->getTraceAsString();
                    $messageType = 'danger';
                }
            }

            $affectationIgvTypeCodeModel = new CatAffectationIgvTypeCode($this->connection);
            $systemIscTypeCodeModel = new CatSystemIscTypeCode($this->connection);
            $currencyTypeCodeModel = new CatCurrencyTypeCode($this->connection);
            $documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
            $identityDocumentTypeCodeModel = new CatIdentityDocumentTypeCode($this->connection);
            $operationTypeCodeModel = new CatOperationTypeCode($this->connection);
            $debitNoteTypeCodeModel = new CatDebitNoteTypeCode($this->connection);
            $businessModel = new Business($this->connection);

            $parameter['affectationIgvTypeCode'] = $affectationIgvTypeCodeModel->GetAll();
            $parameter['systemIscTypeCode'] = $systemIscTypeCodeModel->getAll();
            $parameter['documentTypeCode'] = $documentTypeCodeModel->GetBy('code','08');
            $parameter['currencyTypeCode'] = $currencyTypeCodeModel->getAll();
            $parameter['identityDocumentTypeCode'] = $identityDocumentTypeCodeModel->getAll();
            $parameter['operationTypeCode'] = $operationTypeCodeModel->getAll();
            $parameter['creditNoteType'] = $debitNoteTypeCodeModel->getAll();
            $parameter['business'] = $businessModel->GetByUserId($_SESSION[SESS]);
            $parameter['productList'] = $this->productModel->GetAllByBusinessId($parameter['business']['business_id']);

            $documentCorrelativeModel = new BusinessSerie($this->connection);
            $correlative = $documentCorrelativeModel->GetNextCorrelative([
                'localId' => $_COOKIE['CurrentBusinessLocal'],
                'documentCode' => '08',
            ]);

            $parameter['correlative'] = $correlative['correlative'] + 1;
            $parameter['correlativePrefix'] = $correlative['serie'];
            $parameter['invoice'] = $invoice;
            $parameter['error'] = $error;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;
            $parameter['itemTemplate'] = InvoiceTemplate::Item($parameter['business'],$parameter['affectationIgvTypeCode']);
            $parameter['referralGuideTemplate'] = $this->GetReferralGuideTemplate();

            $content = requireToVar(VIEW_PATH . "User/NewInvoiceDebitNote.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function View(){
        try{
            $invoiceNoteId = $_GET['InvoiceNoteId'] ?? 0;
            if(!$invoiceNoteId){
                return;
            }
            $message = $_GET['message'] ?? '';
            $messageType = $_GET['messageType'] ?? '';
            $messageType = ($messageType == 'success') ? 'success' : ($messageType == 'error' ? 'danger' : '');

            $invoice = $this->invoiceNoteModel->SummaryById($invoiceNoteId);
            $parameter['detailInvoiceNote'] = $this->detailInvoiceNoteModel->ByInvoiceNoteIdSummary($invoiceNoteId);
            $parameter['invoice'] = $invoice;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;

            $content = requireToVar(VIEW_PATH . "User/InvoiceNoteView.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function ValidateInput(array $invoice) {
        $collector = new InvoiceValidate($invoice, $this->connection);
        return $collector->getResult();
    }

    private function GetReferralGuideTemplate(){
        return '<tr id="referralGuideItem${uniqueId}">
            <td>
                <label for="type${uniqueId}">Tipo</label>
                <select class="form-control form-control-sm" id="type${uniqueId}" name="invoice[guide][${uniqueId}][document_code]" required>
                    <option value="1">GUÍA DE REMISIÓN REMITENTE</option>
                    <option value="2">GUÍA DE REMISIÓN TRANSPORTISTA</option>
                </select>
            </td>
            <td>
                <label for="serie${uniqueId}">Serie - Número</label>
                <input type="text" class="form-control form-control-sm" id="serie${uniqueId}" name="invoice[guide][${uniqueId}][serie]" required>
            </td>
            <td>
                <div class="btn btn-danger btn-sm mt-4" onclick="ReferralGuidePhysical.removeItem(\'${uniqueId}\')">Quitar</div>
            </td>
        </tr>';
    }
}

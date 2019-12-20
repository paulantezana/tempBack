<?php

require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/BusinessLocal.php';
require_once MODEL_PATH . 'User/BusinessSerie.php';
require_once MODEL_PATH . 'User/CatDocumentTypeCode.php';

require_once CONTROLLER_PATH . 'Helper/ApiSign.php';

class BusinessLocalController
{
    private $connection;
    private $businessModel;
    private $businessLocalModel;
    private $documentTypeCodeModel;
    private $businessSerieModel;

    public function __construct($connection, $param)
    {
        $this->connection = $connection;
        $this->businessModel = new Business($this->connection);
        $this->businessLocalModel = new BusinessLocal($this->connection);
        $this->documentTypeCodeModel = new CatDocumentTypeCode($this->connection);
        $this->businessSerieModel = new BusinessSerie($this->connection);
    }

    public function Exec()
    {
        try{
            $business = $this->businessModel->GetByUserId($_SESSION[SESS]);

            $parameter['businessLocal'] = $this->businessLocalModel->GetAllByBusinessId($business['business_id']);
            $content = requireToVar(VIEW_PATH . "User/BusinessLocal.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function Api()
    {
        try{
            $business = $this->businessModel->GetByUserId($_SESSION[SESS]);
            if(isset($_POST['commit'])){
                $payload = [
                    'localId' => $business['business_id'],
                    'userId' => $_SESSION[SESS],
                    'businessId' => $_POST['businessLocalId'],
                ];

                $token = ApiSign::encode($payload);
                $this->businessLocalModel->UpdateById($_POST['businessLocalId'],[
                    'api_token' => $token
                ]);
            }

            $businessLocal = $this->businessLocalModel->GetAllByBusinessId($business['business_id']);
            $businessLocalApi = [];
            foreach ($businessLocal as $row) {
                $protocol = stripos($_SERVER['REQUEST_SCHEME'], 'https') === 0 ? 'https://' : 'http://';
                $hostName = $_SERVER['SERVER_NAME'];
                $currentUrl = $protocol . $hostName . FOLDER_NAME;
                $row['api_url'] = $currentUrl . '/ApiRequest?token=' . $row['api_token'];
                array_push($businessLocalApi,$row);
            }
            $parameter['businessLocalApi'] = $businessLocalApi;

            $content = requireToVar(VIEW_PATH . "User/BusinessLocalApi.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    public function Form(){
        try{
            $error = [];
            $message = "";
            $messageType = "";
            $businessLocal = [];

            // Edit
            if (isset($_GET['businessLocalId'])){
                $businessLocal = $this->businessLocalModel->GetById($_GET['businessLocalId']);
                $businessLocal['item'] = $this->businessSerieModel->GetAllByBusinessLocalId($businessLocal['business_local_id']);
            }

            // Save
            if (isset($_POST['commit'])){
                $businessLocal = $_POST['businessLocal'];
                $this->businessLocalModel->Save($businessLocal,$_SESSION[SESS]);
                header('Location: ' . FOLDER_NAME . '/BusinessLocal');
            }

            // New
            if(!isset($_POST['commit']) && !isset($_GET['businessLocalId'])){
                $businessLocal['item'] = $this->documentTypeCodeModel->GetAll();
            }

            // View HTML
            $parameter['businessLocal'] = $businessLocal;

            $business = $this->businessModel->GetByUserId($_SESSION[SESS]);
            $parameter['businessLocal']['business_id'] = $business['business_id'];
            $parameter['documentTypeCode'] = $this->documentTypeCodeModel->GetAll();;
            $parameter['itemTemplate'] = $this->GetItemTemplate($parameter['documentTypeCode']);

            $parameter['error'] = $error;
            $parameter['message'] = $message;
            $parameter['messageType'] = $messageType;

            $content = requireToVar(VIEW_PATH . "User/BusinessLocalForm.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }

    private function GetItemTemplate($documentTypeCode){
        $documentTypeCodeTemplate = '';
        foreach ($documentTypeCode ?? [] as $row){
            $documentTypeCodeTemplate .= "<option value='{$row['code']}'>{$row['description']}</option>" . PHP_EOL;
        }

        return '<tr id="businessLocalItem${uniqueId}" data-uniqueId="${uniqueId}">
            <td>
                <select class="form-control select2" id="documentCode${uniqueId}" name="businessLocal[item][${uniqueId}][document_code]" required>
                    ' . $documentTypeCodeTemplate . '
                </select>
                <input type="hidden" name="businessLocal[item][${uniqueId}][business_serie_id]" value="0">
            </td>
            <td>
                <input type="text" class="form-control" name="businessLocal[item][${uniqueId}][serie]" id="serie${uniqueId}" required>
            </td>
            <td>
                <button type="button" class="btn btn-light" title="Quitar item" onclick="BusinessLocalRemoveItem(${uniqueId})">
                    <i class="icon-trash-alt text-danger"></i>
                </button>
            </td>
        </tr>';
    }
}

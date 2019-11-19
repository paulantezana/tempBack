<?php

require_once MODEL_PATH . 'User/Business.php';
require_once MODEL_PATH . 'User/BusinessLocal.php';
require_once MODEL_PATH . 'User/BusinessSerie.php';
require_once MODEL_PATH . 'User/DocumentTypeCode.php';

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
        $this->documentTypeCodeModel = new DocumentTypeCode($this->connection);
        $this->businessSerieModel = new BusinessSerie($this->connection);
    }

    public function Exec()
    {
        try{
            $parameter['businessLocal'] = $this->businessLocalModel->GetAll();
            $content = requireToVar(VIEW_PATH . "User/BusinessLocal.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e){
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
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
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function GetItemTemplate($documentTypeCode){
        $documentTypeCodeTemplate = '';
        foreach ($documentTypeCode ?? [] as $row){
            $documentTypeCodeTemplate .= "<option value='{$row['code']}'>{$row['description']}</option>" . PHP_EOL;
        }

        return '<tr id="businessLocalItem${uniqueId}" data-uniqueId="${uniqueId}">
            <td>
                <select class="form-control form-control-sm" id="documentCode${uniqueId}" name="businessLocal[item][${uniqueId}][document_code]" required>
                    ' . $documentTypeCodeTemplate . '
                </select>
                <input type="hidden" name="businessLocal[item][${uniqueId}][business_serie_id]" value="0">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" name="businessLocal[item][${uniqueId}][serie]" id="serie${uniqueId}" required>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-light" title="Quitar item" onclick="BusinessLocal.removeItem(${uniqueId})">
                    <i class="fas fa-times text-danger"></i>
                </button>
            </td>
        </tr>';
    }
}

<?php
    require_once MODEL_PATH . 'User/Business.php';

    class BusinessController
    {
        private $connection;
        private $param;
        private $businessModel;

        public function __construct($connection, $param)
        {
            $this->connection = $connection;
            $this->param = $param;
            $this->businessModel = new Business($this->connection);;
        }

        public function Update(){
            try{
                $parameter = [];
                try{
                    if (isset($_POST['businessCommit'])){
                        $business = $_POST['business'];
                        $business['include_igv'] = ($business['include_igv'] ?? false) == 'on' ? true : false;
                        $business['continue_payment'] = ($business['continue_payment'] ?? false) == 'on' ? true : false;

                        // Business
                        $validate = $this->BusinessValidate($business);
                        if (!$validate->success){
                            $parameter['error'] = $validate->error;
                            throw new Exception($validate->errorMessage);
                        }
                        $this->businessModel->Save($business);

                        // Upload Logo
                        if (isset($_FILES['businessLogo'])){
                            if($_FILES['businessLogo']['tmp_name']){
                                $businessLogo = $_FILES['businessLogo'];
                                $validate = $this->BusinessValidateLogo($businessLogo);
                                if (!$validate->success){
                                    $parameter['error'] = $validate->error;
                                    throw new Exception($validate->errorMessage);
                                }
    
                                if(!($businessLogo['tmp_name'] ?? '') == ''){
                                    $rootPath = dirname(getcwd());
                                    $folderName = '/Assets/Images/';
                                    if (!file_exists($rootPath . $folderName)) {
                                        mkdir($rootPath . $folderName);
                                    }
    
                                    $filesName = 'L' . $business['ruc'] . '-' . $business['business_id'] . '.' . pathinfo($businessLogo['name'])['extension'];
                                    if(!copy($businessLogo['tmp_name'], $rootPath . $folderName . $filesName)){
                                        throw new Exception("Error al subir el logo", 1);
                                    }
    
                                    $this->businessModel->UpdateById($business['business_id'],[
                                        'logo' => '..' . $folderName . $filesName,
                                    ]);
                                }
                            }
                        }
                        
                        $parameter['message'] = 'El registro se actualizo exitosamente';
                        $parameter['messageType'] = 'success';
                    }
                } catch (Exception $e){
                    $parameter['message'] = $e->getMessage();
                    $parameter['messageType'] = 'error';
                }

                $parameter['business'] = $this->businessModel->GetByUserId($_SESSION[SESS]);
                $content = requireToVar(VIEW_PATH . "User/Business.php", $parameter);
                require_once(VIEW_PATH. "User/Layout/main.php");
            } catch (Exception $e) {
                echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
            }
        }

        public function BusinessValidate($business){
            $collector = new ErrorCollector();
            if (!ValidateRUC($business['ruc'] ?? '')){
                $collector->addError('ruc','Número de RUC invalido');
            }
            if (trim($business['social_reason'] ?? '') == ''){
                $collector->addError('social_reason','No se especificó la razón social');
            }
            if (trim($business['phone'] ?? '') == ''){
                $collector->addError('phone','No se especificó la el teléfonos');
            }
            if (trim($business['detraction_bank_account'] ?? '') != ''){
                if (trim(strlen($business['detraction_bank_account']) != 20)){
                    $collector->addError('detraction_bank_account','Cuenta bancaria de detraccion CCI es inválido (20 caracteres)');
                }
            }
            return $collector->getResult();
        }

        public function BusinessValidateLogo($file){
            $collector = new ErrorCollector();
            if(($file['tmp_name'] ?? '') === ''){
                $collector->addError('businessLogo','No se encontró ningún archivo');
            }
            if(((int)($file['size'] ?? 0)) > 20 * 1028){
                $collector->addError('businessLogo','El logo debe ser menor que 20 KB');
            }
            if(!($file['type'] === 'image/png' || $file['type'] === 'image/jpg' || $file['type'] === 'image/jpeg' )){

                $collector->addError('businessLogo','Logotipo El formato debe ser PNG, JPG o JPEG');
            }
            return $collector->getResult();
        }
    }

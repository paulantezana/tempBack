<?php

require_once(MODEL_PATH.'User/User.php');
require_once(MODEL_PATH.'User/Business.php');
require_once(MODEL_PATH.'User/BusinessLocal.php');
require_once(CONTROLLER_PATH.'Helper/Services/PeruService.php');

class LoginController
{
    private $connection;
    private $userModel;
    private $businessModel;
    private $businessLocalModel;

    public function __construct(PDO $connection)
    {
        $this->connection=$connection;
        $this->userModel = new User($connection);
        $this->businessModel = new Business($connection);
        $this->businessLocalModel = new BusinessLocal($connection);
    }

    public function Exec()
    {
        $parameter = [];
        $content = requireToVar(VIEW_PATH . "User/Login.php", $parameter);
        require_once(VIEW_PATH. "User/Layout/BasicLayout.php");
    }

    public function Login()
    {
        try {
            try {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = $this->userModel->Login($email,$password);
                $responseApp = $this->StartApp($user);
                if (!$responseApp->success){
                    session_destroy();
                    throw new Exception($responseApp->errorMessage);
                }

                require_once(CONTROLLER_PATH . $_SESSION[CONTROLLER_GROUP]  . "HomeController.php");
                $homeController = new HomeController();
                $homeController->exec();
            }catch (Exception $e){
                $parameter['message'] =  $e->getMessage();
                $parameter['messageType'] = 'danger';

                $content = requireToVar(VIEW_PATH . "User/Login.php", $parameter);
                require_once(VIEW_PATH. "User/Layout/BasicLayout.php");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function Register(){
        try {
            $resView = new Result();
            $resView->message = '';
            $resView->messageType = '';
            $resView->error = [];

            if (isset($_POST['commit'])) {
                $this->connection->beginTransaction();
                try {
                    $register = $_POST['register'];
                    $validate = $this->validateRegister($register);

                    if (!$validate->success) {
                        $resView->error = $validate->error;
                        throw new Exception($validate->errorMessage);
                    }

                    $user = $this->businessModel->GetBy('ruc', $register['ruc']);
                    if ($user){
                        throw new Exception('Este ruc ya está registrado en el sistema');
                    }

                    $peruResult = PeruService::queryRUC($register['ruc']);
                    if (!$peruResult->success){
                        throw new Exception($peruResult->errorMessage);
                    }

                    $userId = $this->userModel->Insert([
                        "password" => $register['password'],
                        "email" => $register['email'],
                        "ruc" => $register['ruc'],
                        "address" => '',
                        "phone" => '',
                        "names" => $register['userName'],
                        "state" => true,
                        "userRoleId" => 1,
                    ], 1);

                    $businessId = $this->businessModel->Insert([
                        'includeIgv' => false,
                        'continuePayment' => false,
                        'ruc' => $register['ruc'],
                        'socialReason' => $peruResult['socialReason'],
                        'commercialReason' => '',
                        'email' => $register['email'],
                        'phone' => '',
                        'detractionBankAccount' => '',
                    ], $userId);

                    $businessLocalId = $this->businessLocalModel->Insert([
                        'shortName' => 'Local principal',
                        'sunatCode' => '',
                        'locationCode' => '',
                        'address' => '',
                        'pdfInvoiceSize' => 'A4',
                        'pdfHeader' => 'Email: ' . $register['email'],
                        'description' => '',
                        'businessId' => $businessId,
                        'item' => [
                            [
                                'serie' => 'F001',
                                'documentCode' => '01',
                                'contingency' => 0,
                            ],
                            [
                                'serie' => 'FC01',
                                'documentCode' => '07',
                                'contingency' => 0,
                            ],
                            [
                                'serie' => 'FD01',
                                'documentCode' => '08',
                                'contingency' => 0,
                            ],
                            [
                                'serie' => 'B001',
                                'documentCode' => '03',
                                'contingency' => 0,
                            ],
                            [
                                'serie' => 'BC01',
                                'documentCode' => '07',
                                'contingency' => 0,
                            ],
                            [
                                'serie' => 'BD01',
                                'documentCode' => '08',
                                'contingency' => 0,
                            ],
                            [
                                'serie' => 'T001',
                                'documentCode' => '09',
                                'contingency' => 0,
                            ],
                        ]
                    ], $userId);

                    $this->connection->commit();
                    $loginUser = $this->userModel->GetById($userId);
                    $responseApp = $this->StartApp($loginUser);
                    if (!$responseApp->success) {
                        session_destroy();
                        throw new Exception($responseApp->errorMessage);
                    }
                    require_once(CONTROLLER_PATH . $_SESSION[CONTROLLER_GROUP]  . "HomeController.php");
                    $homeController = new HomeController();
                    $homeController->exec();
                    return;
                } catch (Exception $e) {
                    $this->connection->rollBack();
                    $resView->message = $e->getMessage();
                    $resView->messageType = 'danger';
                }
            }

            $parameter['message'] = $resView->message;
            $parameter['error'] = $resView->error;
            $parameter['messageType'] = $resView->messageType;

            $content = requireToVar(VIEW_PATH . "User/Register.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/BasicLayout.php");
        } catch (Exception $e) {
            echo $e->getMessage() . $e->getTraceAsString();
        }
    }

    public function RecoverPassword(){
        try{
            $resView = new Result();
            $resView->message = '';
            $resView->messageType = '';

            if (isset($_POST['commit'])){
                try {
                    $email = $_POST['email'] ?? '';
                    if (($email) == '') {
                        throw new Exception('Falta ingresar el correo');
                    }
                    $user = $this->userModel->GetBy('email',$email);
                    if (!$user){
                        throw new Exception('Este correo electrónico no está registrado.');
                    }

                    $currentDate = date('Y-m-d H:i:s');
                    $token = hash('sha256', $currentDate . $user['id_user'] . $user['email']);
                    $this->userModel->UpdateById($user['id_user'],[
                        'recover_key' => $token,
                        'recover_key_request_date' => $currentDate,
                    ]);

                    if (!$this->SendEmail([
                        'to' => $user['email'],
                        'token' => $token,
                    ])){
                        throw new Exception('No se pudo enviar el correo electrónico.');
                    }

                    $resView->message = 'Hemos Enviado el Enlace de Recuperación del Contraseña a tu Correo Electrónico.';
                    $resView->messageType = 'success';
                } catch (Exception $exception){
                    $resView->message = $exception->getMessage();
                    $resView->messageType = 'danger';
                }
            }

            $parameter['message'] = $resView->message;
            $parameter['messageType'] = $resView->messageType;

            $content = requireToVar(VIEW_PATH . "User/RecoverPassword.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/BasicLayout.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    public function RecoverPasswordValidate(){
        try {
            $resView = new Result();
            $resView->message = '';
            $resView->messageType = '';
            $resView->contentType = 'validateToken';

            $user = [];
            $currentDate = date('Y-m-d H:i:s');

            // change password
            if (isset($_GET['token'])){
                $resView->contentType = 'validateToken';
                $token = $_GET['token'];
                try {
                    $user = $this->userModel->GetBy('recover_key', $token);
                    if (!$user){
                        throw new Exception('Token invalido o expirado');
                    }

                    $diff = strtotime($currentDate) - strtotime($user['recover_key_request_date']);
                    if (($diff / 60) > 120){
                        throw new Exception('Token expirado');
                    }

                    $resView->message = 'Token valido cambie su contraseña';
                    $resView->messageType = 'success';
                }catch (Exception $e){
                    $resView->message = $e->getMessage();
                    $resView->messageType = 'danger';
                }
            } else if (isset($_POST['commit'])){
                $resView->contentType = 'changePassword';
                try {
                    $password = $_POST['password'];
                    $confirmPassword = $_POST['confirmPassword'];
                    $user['id_user'] = $_POST['userId'] ?? 0;
                    if (!($confirmPassword === $password)){
                        throw new Exception('Las contraseñas no coinciden');
                    }
                    if (!$user['id_user']){
                        throw new Exception('Usuario no especificado.');
                    }

                    $password = hash('sha256', $password);
                    $this->userModel->UpdateById($user['id_user'],[
                        "updated_at" => $currentDate,
                        "updated_user_id" => $user['id_user'],

                        'password' => $password,
                        'recover_key' => '',
                    ]);

                    $resView->message = 'Cambio de contraseña exitosa';
                    $resView->messageType = 'success';
                } catch (Exception $e){
                    $resView->message = $e->getMessage();
                    $resView->messageType = 'danger';
                }
            }

            $parameter['message'] = $resView->message;
            $parameter['messageType'] = $resView->messageType;
            $parameter['contentType'] = $resView->contentType;
            $parameter['user'] = $user;

            $content = requireToVar(VIEW_PATH . "User/RecoverPasswordValidate.php", $parameter);
            require_once(VIEW_PATH. "User/Layout/BasicLayout.php");
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function StartApp($user){
        $res = new Result();
        try{
            $_SESSION[SESS] = $user['id_user'];
            $_SESSION[SESS_ROLE] = $user['id_rol'];

            $businessModel = new Business($this->connection);
            $businessLocalModel = new BusinessLocal($this->connection);

            // Set Current local
            $business = $businessModel->GetByUserId($user['id_user']);
            $businessLocal = $businessLocalModel->GetAllByBusinessId($business['business_id']);
            if (count($businessLocal) === 0){
                throw new Exception('Este usuario no está asignado a ningún local de una empresa comuníquese con el administrador.');
            }
            $_SESSION[CURRENT_LOCAL] = $businessLocal[0]['business_local_id'];

            // Set Menu
            $menu = $this->userModel->GetMenuByRoleId($user['id_rol']);

            $res->success = true;
        } catch (Exception $e){
            $res->errorMessage = $e->getMessage();
        }
        return $res;
    }

    private function SendEmail($mailContent){
        $protocol = stripos($_SERVER['REQUEST_SCHEME'], 'https') === 0 ? 'https://' : 'http://';
        $hostName = $_SERVER['SERVER_NAME'];
        $currentUrl = $protocol . $hostName . FOLDER_NAME . '/UserLogin/RecoverPasswordValidate';
        $tokenUrl = $currentUrl . '?token='. $mailContent['token'];

        $to  = $mailContent['to'];
        $subject = 'Recupera tu Contraseña';
        $message = "
        <div style='background: #F9FAFC;padding: 5rem 0; text-align: center;'>
            <div style='max-width:590px!important; width:590px; background: white;padding: 2rem;margin: auto;'>
                <img src='https://www.skynetcusco.com/wp-content/uploads/2016/11/logosky2017.png' alt='logo' width='42px'>
                <h2>¿Olvidaste tu contraseña?</h2>
                <p>Recientemente se solicitó un cambio de contraseña en tu cuenta. Si no fuiste tú, Ignora este mensaje y sigue realizando sus ventas en Skynet</p>
                <p>Si deseas hacer el cambio, haz click en el siguiente botón.</p>
                <a href='{$tokenUrl}' target='_blank'>
                    <div style=\"background: #007BFF; color: white; display: inline-block; padding: .7rem; text-decoration: none; border-radius: 4px;\">Cambiar contraseña</div>
                </a>
                <div>
                    <a href='{$tokenUrl}' target='_blank'>{$tokenUrl}</a>
                </div>
            </div>
            <p style='margin-top: 3rem;'>© 2019 Skynet</p>
        </div>";

        $header  = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        $header .= 'To: Mary <'.$to.'>' . "\r\n";
        $header .= 'From: Contacto Skynet <cumples@example.com>' . "\r\n";
        return mail($to, $subject, $message, $header);
    }

    private function validateRegister($body)
    {
        $collector = new ErrorCollector();
        if (($body['email'] ?? '') == '') {
            $collector->addError('email', 'Falta ingresar el correo electrónico');
        }
        if (($body['userName'] ?? '') == '') {
            $collector->addError('userName', 'Falta ingresar el nombre de usuario');
        }
        if (($body['password'] ?? '') == '') {
            $collector->addError('password', 'Falta ingresar la contraseña');
        }
        if (($body['passwordConfirm'] ?? '') == '') {
            $collector->addError('passwordConfirm', 'Falta ingresar la confirmación contraseña');
        }
        if ($body['password'] != $body['passwordConfirm']) {
            $collector->addError('password', 'Las contraseñas no coinciden');
        }
        // Advanced Validate
        if (!ValidateRUC($body['ruc'] ?? '')){
            $collector->addError('ruc', 'RUC Invalido');
        }
        return $collector->getResult();
    }
}

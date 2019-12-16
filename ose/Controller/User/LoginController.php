<?php

require_once(MODEL_PATH.'User/User.php');
require_once(MODEL_PATH.'User/Business.php');
require_once(MODEL_PATH.'User/BusinessLocal.php');

class LoginController
{
    protected $connection;
    private $userModel;
    public function __construct(PDO $connection)
    {
        $this->userModel = new User($connection);
        $this->connection=$connection;
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
            $message = "";
            $messageType = "";

            $email=$_POST['correo'];
            $password=$_POST['password'];
            $data=$this->userModel->Login($email,$password);
            if ($data) {
                $this->SetBusinessLocal();
                require_once(CONTROLLER_PATH . $_SESSION[CONTROLLER_GROUP]  . "HomeController.php");
                $homeController = new HomeController();
                $homeController->exec();
            } else{
                $parameter['message'] = 'Error en autenticación.';
                $parameter['messageType'] = 'danger';

                $content = requireToVar(VIEW_PATH . "User/Login.php", $parameter);
                require_once(VIEW_PATH. "User/Layout/BasicLayout.php");
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }
    }

    private function SetBusinessLocal(){
        try{
            $businessModel = new Business($this->connection);
            $businessLocalModel = new BusinessLocal($this->connection);

            $business = $businessModel->GetByUserId($_SESSION[SESS]);
            $businessLocal = $businessLocalModel->GetAllByBusinessId($business['business_id']);

            $_SESSION[ENVIRONMENT] = $business['environment'];

            setcookie('BusinessLocal', json_encode($businessLocal), time() + (86400 * 1), "/");
            setcookie('CurrentBusinessLocal', $businessLocal[0]['business_local_id'] . '', time() + (86400 * 1), "/");
        } catch (Exception $e){
            echo $e->getMessage();
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

                    $this->SendEmail([
                        'to' => $user['email'],
                        'token' => $token,
                    ]);

                    $resView->message = 'El correo electrónico de confirmación de restablecimiento de contraseña se envió a su correo electrónico.';
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
                    echo $diff / 60;
                    if (($diff / 60) > 120){
                        throw new Exception('Token expirado');
                    }

                    $resView->message = 'Cambie su contraseña';
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
                <a href='{$tokenUrl}' target='_blank'>{$tokenUrl}</a>
            </div>
            <p style='margin-top: 3rem;'>© 2019 Skynet</p>
        </div>";

        $header  = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        $header .= 'To: Mary <jhoel_kl2@outlook.com>' . "\r\n";
        $header .= 'From: Contacto Skynet <cumples@example.com>' . "\r\n";
        mail($to, $subject, $message, $header);
    }
}

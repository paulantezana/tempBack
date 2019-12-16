<?php

require_once(MODEL_PATH.'User/User.php');

class UserController
{
    protected $connection;
    private $userModel;
    public function __construct(PDO $connection)
    {
        $this->userModel = new User($connection);
        $this->connection = $connection;
    }

    public function CloseSession(){
        unset($_SESSION[SESS]);
        unset($_SESSION[USER_TYPE]);
        session_destroy();
        setcookie('MainMenu', "",  time() - 10, "/");
        setcookie('BusinessLocal', "",  time() - 10, "/");
        setcookie('CurrentBusinessLocal', "",  time() - 10, "/");
        header("Location: " . FOLDER_NAME . "/UserLogin");
        exit;
    }

    public function Profile(){
        try {
            $resView = new Result();
            $resView->message = '';
            $resView->messageType = '';

            try {
                $currentDate = date('Y-m-d H:i:s');

                if (isset($_POST['commit'])) {
                    if (($_POST['email']) == '') {
                        throw new Exception('Falta ingresar el correo');
                    }
                    if (($_POST['names']) == '') {
                        throw new Exception('Falta ingresar el nombre completo');
                    }
                    if (($_POST['phone']) == '') {
                        throw new Exception('Falta ingresar el telefono');
                    }

                    $this->userModel->UpdateById((int) $_SESSION[SESS], [
                        "updated_at" => $currentDate,
                        "updated_user_id" => $_SESSION[SESS],

                        'email' => $_POST['email'],
                        'names' => $_POST['names'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'],
                    ]);
                    $resView->message = 'El registro se actualizó exitosamente';
                    $resView->messageType = 'success';

                } else if (isset($_POST['commitChangePassword'])) {

                    $password = $_POST['password'];
                    $confirmPassword = $_POST['confirmPassword'];
                    if (!($confirmPassword === $password)){
                        throw new Exception('Las contraseñas no coinciden');
                    }

                    $this->userModel->UpdateById((int) $_SESSION[SESS], [
                        "updated_at" => $currentDate,
                        "updated_user_id" => $_SESSION[SESS],

                        'password' => hash('sha256', $password),
                    ]);
                    $resView->message = 'La contraseña fue cambiada exitosamente.';
                    $resView->messageType = 'success';
                }
            } catch (Exception $e) {
                $resView->message = $e->getMessage();
                $resView->messageType =  'danger';
            }

            $parameter['user'] = $this->userModel->GetById($_SESSION[SESS]);;
            $parameter['message'] = $resView->message;
            $parameter['messageType'] = $resView->messageType;

            $content = requireToVar(VIEW_PATH . "User/Profile.php",$parameter);
            require_once(VIEW_PATH. "User/Layout/main.php");
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }
}

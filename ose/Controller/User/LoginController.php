<?php

require_once(MODEL_PATH.'User/User.php');
require_once(MODEL_PATH.'User/Business.php');
require_once(MODEL_PATH.'User/BusinessLocal.php');

class LoginController
{
    protected $connection;
    private $userModel;
    public function __construct(PDO $connection,$Parameters)
    {
        $this->userModel = new User($connection);
        $this->connection=$connection;
    }
    public function Exec()
    {
        require_once(VIEW_PATH."User/Login.php");
    }
    public function Login()
    {
        $email=$_POST['correo'];
        $password=$_POST['password'];
        //autenticacion
        $data=$this->userModel->Login($email,$password);
      if ($data) {
        $this->SetBusinessLocal();
        require_once(CONTROLLER_PATH . $_SESSION[CONTROLLER_GROUP]  . "HomeController.php");
        $homeController = new HomeController();
        $homeController->exec();
      }
      else{
        $error = "Error en autenticación.";
        require_once(VIEW_PATH."User/Login.php");
      }
    }
    private function SetBusinessLocal(){
        try{
            $businessModel = new Business($this->connection);
            $businessLocalModel = new BusinessLocal($this->connection);

            $business = $businessModel->GetByUserId($_SESSION[SESS]);
            $businessLocal = $businessLocalModel->GetAllByBusinessId($business['business_id']);

            setcookie('BusinessLocal', json_encode($businessLocal), time() + (86400 * 1), "/");
            setcookie('CurrentBusinessLocal', $businessLocal[0]['business_local_id'] . '', time() + (86400 * 1), "/");
        } catch (Exception $e){
            echo $e->getMessage();
        }
    }
}

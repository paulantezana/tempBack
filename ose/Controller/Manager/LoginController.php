<?php
require_once(MODEL_PATH.'Manager/user.php');
class LoginController
{

    protected $db;
    private $userClass;
    public function __construct(PDO $DbConection,$Parameters)
    {
        $this->userClass = new userClass($DbConection);
        $this->db=$DbConection;
    }

  public function Exec()
  {
    require_once(VIEW_PATH."Manager/Login.php");
  }

  public function Login()
  {
    $email=$_POST['correo'];
    $password=$_POST['password'];
    //autenticacion
    $data=$this->userClass->userLogin($email,$password);
    if ($data) {
      require_once(CONTROLLER_PATH . $_SESSION[CONTROLLER_GROUP]  . "HomeController.php");
      $homeController = new HomeController($this->db);
      $homeController->exec();
    }
    else{
      $error = "Error en autenticación.";
      require_once(VIEW_PATH."Manager/Login.php");
    }
  }
}
?>
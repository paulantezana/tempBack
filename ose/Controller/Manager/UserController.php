<?php
require_once(MODEL_PATH.'Manager/user.php');
class UserController
{
  protected $db;
  private $user;
  public function __construct($DbConection,$Parameters)
  {
    $this->user = new userClass($DbConection);
    $this->db=$DbConection;
  }

  public function Exec()
  {
    ValidateFunctionRol($this->db,'usuario','index','/OSE-skynet/ose/','500');
    $parameter[0] = $this->user->ListRols();
    //$contenido = requireToVar(VIEW_PATH."Manager/Partial/UserTable.php", $parameter);
    $content = requireToVar(VIEW_PATH."Manager/User.php", $parameter);
	  require_once(VIEW_PATH."Manager/Layout/main.php");
  }
  public function ListUsers()
  {
    $parameter[0] = $this->user->ListUsers();
    require_once(VIEW_PATH."Manager/Partial/UserTable.php");
  }
  public function RegisterUser(){
      try{
        ValidateFunctionRol($this->db,'usuario','agregar','/','500');
        $User=$_POST['User'];
        $ValidateInputs=$this->ValidateData($User);
        if ($ValidateInputs['result']) {
          //validar tipo de usuario
          $AnswerRegistration = $this->user->UserRegistration($User);
          echo json_encode(array('result' => true, 'mesagge' => $AnswerRegistration));
        }else{
          echo json_encode($ValidateInputs);
        }
      } catch (Exception $e){
          echo json_encode(array('result' => false, 'mesagge' => $e->getMessage()));
      }
  }
  public function UpdateUser(){
    ValidateFunctionRol($this->db,'usuario','editar','/','500');
    $UserUpdate=$_POST['User'];
    $ValidateInputs=$this->ValidateData($UserUpdate);
    if ($ValidateInputs['result']) {
      //validar tipo de usuario
      $AnswerRegistration=$this->user->UpdateUser($UserUpdate);
      echo json_encode($AnswerRegistration);
    }else{
      echo json_encode($ValidateInputs);
    }
  }
  public function GetUser(){
    ValidateFunctionRol($this->db,'usuario','editar','/','500');
    $IdUser=$_GET['idUserUpdate'];
    if ($IdUser!='') {
      $GetDataUser=$this->user->GetDataUser($IdUser);
      echo json_encode($GetDataUser);
    }
  }
  public function ValidateData(array $User){
    $result=true;
    $mesagge='';
    if (trim($User['names'])=='') {
      $result=false;
      $mesagge.='falta ingresar nombre <br/>';
    }
    if (trim($User['email'])=='') {
      $result=false;
      $mesagge.='falta ingresar Correo Electronico <br/>';
    }
    if (trim($User['phone'])=='') {
      $result=false;
      $mesagge.='falta ingresar Telefono <br/>';
    }
    if (trim($User['address'])=='') {
      $result=false;
      $mesagge.='falta ingresar Direccion <br/>';
    }
    if (trim($User['typeUser'])=='') {
      $result=false;
      $mesagge.='falta ingresar Tipo de Usuario <br/>';
    }
    if (trim($User['password'])=='') {
      $result=false;
      $mesagge.='falta ingresar Contraseña <br/>';
    }
    return array("result"=>$result,"mesagge"=>$mesagge);
  }
  public function DeleteUser(){
    ValidateFunctionRol($this->db,'usuario','eliminar','/','500');
    $IdUser=$_GET['idUserDelete'];
    if ($IdUser!='') {
      $GetDataUser=$this->user->DeleteUser($IdUser);
      echo json_encode($GetDataUser);
    }
  }
  public function CloseSession(){
    unset($_SESSION[SESS]);
    unset($_SESSION[SESS_ROLE]);
    session_destroy();
    setcookie('MainMenu', "",  time() - 10, "/");
    header("Location: http://localhost/OSE-skynet/ose/ManagerLogin");
    exit;
  }
}
?>

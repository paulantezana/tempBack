<?php 
require_once(MODEL_PATH.'Manager/Permission.php');
class PermissionController
{
  protected $db;
  private $PermissionClass;
  public function __construct($DbConection,$Parameters)
  {
    $this->PermissionClass = new PermissionClass($DbConection);
    $this->db=$DbConection;
  }

  public function Exec()
  {
    ValidateFunctionRol($this->db,'roles','index','/','500');
    $parameter[0]=$this->PermissionClass->ListRoles();
    $parameter[1]=$this->PermissionClass->ListPermissions();
    $content = requireToVar(VIEW_PATH."Manager/Permission.php", $parameter);
	  require_once(VIEW_PATH."Manager/Layout/main.php");
  }
  public function GetPermissionsRol(){
    ValidateFunctionRol($this->db,'roles','editar','/','500');
    $IdRol=$_GET['IdRol'];
    $RolPermission=$this->PermissionClass->GetPermissionsRol($IdRol);
    echo json_encode($RolPermission);
  }
  public function UpdatePermissions(){
    ValidateFunctionRol($this->db,'roles','editar','/','500');
    $PartialPermissions=$_POST['PartialPermissions'];
    $idRol=$_POST['idRol'];
    $AnswerUpdate=$this->PermissionClass->UpdatePermissionsRol($PartialPermissions,$idRol);    
    echo json_encode($AnswerUpdate);
  }
}
?>
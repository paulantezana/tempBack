<?php
class PermissionClass
{
    protected $db;
    public function __construct($DbConection)
    {
      $this->db=$DbConection;
    }
  
    public function ListRoles()
    {
        $query = $this->db->prepare("SELECT * FROM roles");  
        $query->execute();
        $data=$query->fetchAll();
        return $data;  
    }
    public function ListPermissions(){
        $query = $this->db->prepare("SELECT * FROM permissions");  
        $query->execute();
        $data=$query->fetchAll();
        return $data;  
    }
    public function GetPermissionsRol($IdRol){
        $query = $this->db->prepare("SELECT id_rol,id_permission FROM `permission_role` WHERE `id_rol`=:IdRol ORDER BY `id_permission` ASC");  
        $query->bindParam(':IdRol',$IdRol);
        $query->execute();
        $data=$query->fetchAll();
        return $data;  
    }
    public function UpdatePermissionsRol($PartialPermissions,$idRol){
        $validate=false;
        $message='';
        try {
            $queryUpdate=$this->db->beginTransaction();
            
            $queryDelete = $this->db->prepare("DELETE FROM permission_role WHERE `id_rol`=:IdRol");  
            $queryDelete->bindParam(':IdRol',$idRol);
            if ($queryDelete->execute()) {
                $validate=true;
            }else{
                $validate=false;
                $message='error al eliminar';
            }
            foreach ($PartialPermissions as $key => $Permission) {
                $insertQuery=$this->db->prepare("INSERT INTO permission_role(id_permission,id_rol) VALUES(:id_permission,:id_rol)");  
                $insertQuery->bindParam(':id_permission',$Permission);
                $insertQuery->bindParam(':id_rol',$idRol);
                if ($insertQuery->execute()) {
                    $validate=true;
                }else{
                    $validate=false;
                    $message='error al insertar';
                }
            }
            if ($validate) {
                $this->db->commit();
            }else{
                $this->db->rollBack();
            }
        } 
        catch (Exception $e) 
        {
            $validate=false;
            $message=$e;
        }
        return array('result' => $validate,'mesagge' => $message);
    }
}

?>
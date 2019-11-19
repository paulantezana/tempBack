<?php


class User
{
    protected $db;
    public function __construct(PDO $db)
    {
        $this->db=$db;
    }

    public function Login($Email,$password)
    {
        $hash_password= hash('sha256', $password);
        $queryUser = $this->db->prepare("SELECT id_user,id_rol,names FROM users WHERE email=:email AND password=:password AND state=1");
        $queryUser->bindParam(':email',$Email);
        $queryUser->bindParam(':password',$hash_password);
        $queryUser->execute();
        $data=$queryUser->fetch();
        if($data)
        {
            $queryPermission = $this->db->prepare("SELECT p.`name`,p.`module`,GROUP_CONCAT(p.`function`) AS funcionts FROM `permission_role` pr INNER JOIN `permissions` p ON pr.`id_permission`=p.`id_permission` WHERE pr.`id_rol`=:idRol GROUP BY p.`module`, p.`name`");
            $queryPermission->bindParam(':idRol',$data['id_rol']);
            $queryPermission->execute();
            $dataMenu=$queryPermission->fetchAll();
            $this->GenerateMenus($dataMenu);
            $_SESSION[SESS]=$data['id_user'];
            $_SESSION[USER_TYPE]=$data['id_rol'];
            return true;
        }
        else
        {
            return false;
        }
    }
    public function GenerateMenus($Menu){
        require_once(VIEW_PATH."Manager/Layout/menu.php");
    }
}
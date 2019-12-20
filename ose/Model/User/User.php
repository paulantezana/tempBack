<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class User extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("users","id_user",$db);
    }

    public function Login($Email,$password)
    {
        try {
            $hashPassword= hash('sha256', $password);
            $stmt = $this->db->prepare("SELECT id_user,id_rol,names FROM users WHERE email=:email AND password=:password AND state=1");
            $stmt->execute([
                ':email' => $Email,
                ':password' => $hashPassword,
            ]);
            if($stmt->rowCount() == 0){
                throw new Exception("El usuario o contraseñas es icorrecta");
            }

            return $stmt->fetch();

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function Insert($user, $userId){
        try{
            $currentDate = date('Y-m-d H:i:s');
            $sql = "INSERT INTO users (id_rol, names, email, phone, ruc, address, id_document_type, password, state,
                                    created_at, updated_at, created_user_id, updated_user_id)
                                VALUES (:id_rol, :names, :email, :phone, :ruc, :address, :id_document_type, :password, :state,
                                    :created_at, :updated_at, :created_user_id, :updated_user_id)";
            $stmt = $this->db->prepare($sql);
            $hashPassword= hash('sha256', $user['password']);
            if(!$stmt->execute([
                ':id_rol' => $user['userRoleId'],
                ':names' => $user['names'],
                ':email' => $user['email'],
                ':phone' => $user['phone'],
                ':ruc' => $user['ruc'],
                ':address' => $user['address'],
                ':id_document_type' => '',
                ':password' => $hashPassword,
                ':state' => $user['state'],
                ':created_at' => $currentDate,
                ':updated_at' => $currentDate,
                ':created_user_id' => $userId,
                ':updated_user_id' => $userId,
            ])){
                throw new Exception('No se pudo insertar el registro');
            }
            return (int)$this->db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception('Line: ' . $e->getLine() . ' ' . $e->getMessage());
        }
    }

    public function GetMenuByRoleId($userRoleId){
        try {
            $stmt = $this->db->prepare("SELECT p.`name`,p.`module`,GROUP_CONCAT(p.`function`) AS funcionts FROM `permission_role` pr INNER JOIN `permissions` p ON pr.`id_permission`=p.`id_permission` WHERE pr.`id_rol`=:idRol GROUP BY p.`module`, p.`name`");
            $stmt->execute([
                ':idRol' => $userRoleId
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception('Line: ' . $e->getLine() . ' ' . $e->getMessage());
        }
    }
}

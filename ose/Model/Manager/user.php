<?php
class userClass
{
    protected $db;
    public function __construct($DbConection)
    {
      $this->db=$DbConection;
    }

    public function userLogin($Email,$password)
    {
        $hash_password= hash('sha256', $password);
        $queryUser = $this->db->prepare("SELECT id_user,id_rol,names FROM users WHERE email=:email AND password=:password AND state=1");
        $queryUser->bindParam(':email',$Email);
        $queryUser->bindParam(':password',$hash_password);
        $queryUser->execute();
        $data=$queryUser->fetch();
        if($data)
        {
          $queryPermission = $this->db->prepare("SELECT p.`name`,p.`module`,GROUP_CONCAT(p.`function`) AS funcionts FROM `permission_role` pr INNER JOIN `permissions` p ON pr.`id_permission`=p.`id_permission` WHERE pr.`id_rol`=:idRol GROUP BY p.`module`");
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
    public function ListUsers(){
      try{
        $queryUser = $this->db->prepare("SELECT u.`id_user`,u.`id_rol`,u.`names`,u.`email`,u.`phone`,r.`name` AS rol,u.state FROM `users` u INNER JOIN roles r ON u.`id_rol`=r.`id_rol`");
        $queryUser->execute();
        $dataUser=$queryUser->fetchAll();
        return $dataUser;
      }
      catch(Exception $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
    }
    public function ListRols(){
      try{
        $queryRol = $this->db->prepare("SELECT * FROM `roles`");
        $queryRol->execute();
        $dataUser=$queryRol->fetchAll();
        return $dataUser;
      }
      catch(Exception $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
    }
    public function userRegistration($User)
    {
      try{
        $queryRegister = $this->db->prepare("SELECT COUNT(email) AS nro FROM users WHERE email=:email ");
        $queryRegister->bindParam(':email',$User['email']);
        $queryRegister->execute();
        $data=$queryRegister->fetch();
        if($data['nro']<1)
        {
          $stmt = $this->db->prepare("INSERT INTO users(id_rol,names,email,phone,ruc,address,id_document_type,password,state) VALUES (:id_rol,:names,:email,:phone,:ruc,:address,:id_document_type,:password,:state)");
          $stmt->bindParam(':id_rol',$User['typeUser']);
          $stmt->bindParam(':names',$User['names']);
          $stmt->bindParam(':email',$User['email']);
          $stmt->bindParam(':phone',$User['phone']);
          $stmt->bindParam(':ruc',$User['ruc']);
          $stmt->bindParam(':address',$User['address']);
          $stmt->bindParam(':id_document_type',$User['typeUser']);
          $hash_password= hash('sha256', $User['password']);
          $stmt->bindParam(':password',$hash_password);
          $stmt->bindParam(':state',$User['state']);
          if(!$stmt->execute()){
            throw new Exception("Error en la consulta de insertar.");
          }
            $userId = (int)$this->db->lastInsertId();
            return $userId;
        }
        else
        {
            throw new Exception("El Email ya existe.");
        }
      } catch (Exception $e) {
          throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
      }
    }
    public function GetDataUser($IdUser){
      try{
        $queryUser = $this->db->prepare("SELECT `id_rol`,`names`,`email`,`phone`,state,ruc,address FROM `users` WHERE id_user=:idUser");
        $queryUser->bindParam(':idUser',$IdUser);
        $queryUser->execute();
        $dataUser=$queryUser->fetch();
        return $dataUser;
      }
      catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
      }
    }
    public function UpdateUser($User){
      $message='';
      $answer=true;
      try{
          $stmt = $this->db->prepare("UPDATE users SET  id_rol=:id_rol,names=:names,email=:email,phone=:phone,ruc=:ruc,address=:address,password=:password,updated_at=current_timestamp(),state=:state WHERE id_user=:id_user");
          $stmt->bindParam(':id_rol',$User['typeUser']);
          $stmt->bindParam(':names',$User['names']);
          $stmt->bindParam(':email',$User['email']);
          $stmt->bindParam(':phone',$User['phone']);
          $stmt->bindParam(':ruc',$User['ruc']);
          $stmt->bindParam(':address',$User['address']);
          $hash_password= hash('sha256', $User['password']);
          $stmt->bindParam(':password',$hash_password);
          $stmt->bindParam(':state',$User['state']);
          $stmt->bindParam(':id_user',$User['id']);
          if($stmt->execute()){

          } else{
            throw new Exception("Error al actualizar.");
          }
          $answer=true;
      }
      catch(PDOException $e) {
        $message = $e->getMessage().' desde pdoexception';
        $answer=false;
      }
      catch(Exception $e) {
        $message = $e->getMessage().' desde exception';
        $answer=false;
      }
      return array('result' => $answer,'mesagge' => $message);
    }
    public function DeleteUser($User){

    }
    // Create by paul
    public function GetAllUser(){
        $queryUser = $this->db->prepare("SELECT u.`id_user`, u.`names` FROM users as u WHERE u.state = 1");
        $queryUser->execute();
        return $queryUser->fetchAll();
    }
}

?>

<?php


class UserController
{
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
        $message = '';
        $messageType = 'info';
        $currentDate = date('Y-m-d H:i:s');

        $parameter = array();

        $content = requireToVar(VIEW_PATH . "User/Profile.php",$parameter);
        require_once(VIEW_PATH. "User/Layout/main.php");
    }
}
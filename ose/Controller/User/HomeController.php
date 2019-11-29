<?php
class HomeController
{

    public function Exec()
    {
        $content = requireToVar(VIEW_PATH."User/Home.php", []);
        require_once(VIEW_PATH."User/Layout/main.php");
    }
}

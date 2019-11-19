<?php
class DataBaseConexion{

    private $conexion;

    public function __construct()
    {
//        $this->conexion = new PDO('mysql:host=localhost;dbname=ose', 'root', '');
        $this->conexion = new PDO('mysql:host=localhost;dbname=corporac_ose', 'corporac_ose', '5ac8yr7IRRkH');
        $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conexion->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $this->conexion->exec("SET CHARACTER SET UTF8");
    }

    public function GetConexion(){
        return $this->conexion;
    }
}
?>

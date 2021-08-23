<?php
    function conexion() {
        //include("./pdoconfig.php");
        try {
            $conexion = new PDO("mysql:host=localhost;dbname=womanstore", 'root', '');
            return $conexion;
        }
        catch(PDOException $err) {
            $mensaje = die("Error en la conexion de la base : " . $err->getMessage());
            $error = "Error";
            return $error;
        }
    }
?>
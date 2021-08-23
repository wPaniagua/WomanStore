<?php
    include("./dbconexion.php");
    if(function_exists($_GET['f'])) { $_GET['f'](); }   
    
        function obtenerFilas() {
            //$filasArray = array();
            $sql = "SELECT * FROM categorias";
            $conexion = conexion();
            $estado = $conexion -> prepare($sql);
            $resultado = $estado -> execute();
            if($resultado != false) {
                $filasArray = $estado -> fetchAll();
                echo json_encode($filasArray);
                
            }
            else
                echo "No se obtuvieron resultados";
        }

        function insertarDato() {
            try {
                $sql = "INSERT INTO `categorias`(`Id`,`nombre`, `correo`) VALUES (7, 'Maria', AES_ENCRYPT('asdsddasd', 'encryPass'))";
                $conexion = conexion();
                $estado = $conexion -> prepare($sql);
                /*$estado -> bindParam(':Id', $_POST['id']);
                $estado -> bindParam(':nombre', $_POST['nombre']);
                $estado -> bindParam(':correo', AES_ENCRYPT($_POST['correo'], 'encryPass'));*/
                $resultado = $estado -> execute();
                if($resultado != false)
                    echo "Ingresado Correctamente";
                else
                    echo "No se ingreso";
            }
            catch(PDOException $err) {
                die("No se ingreso el usuario " . $err->getMessage());
            }
        }
    
?>
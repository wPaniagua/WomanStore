<?php
    //Recibir las peticiones del clientes
    header("Content-Type: application/json");
    require_once("../clases/class-usuario.php");
    switch($_SERVER['REQUEST_METHOD']){
        case 'POST'://inicio de sesion
            if(isset($_GET['id'])){
                session_start();
                $nom = "../img-usuarios/".$_FILES['foto']['name'];
                copy($_FILES['foto']['tmp_name'], $nom);
                Usuario::guardarFoto($nom, $_SESSION['correo']);
            }
            else{
                if(isset($_GET['correo'])){
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    Usuario::inicioSesion($_GET['correo'], $_POST['email'], $_POST['password']);
                }
                else{//guardar un usario
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $usuario = new Usuario($_POST['nombre'], $_POST['apellido'], $_POST['correo'],
                    $_POST['password'], $_POST['telefono'], $_POST['fecha'], $_POST['direccion']);
                    $usuario -> guardar();
                }
            }
        break;
        case 'GET'://obtener un usuario
            if(isset($_GET['correo']))
                echo "Retornar Correo " . $_GET['correo'];
            else{
                if(isset($_GET['id'])){ //cerrar sesion
                    Usuario::cerrarSesion();
                }
                else//Obtner todos los usuarios
                    echo "Retorno todos los usuarios";
            }
        break;
        case 'PUT'://actualizar un usuario
            $_PUT = json_decode(file_get_contents('php://input'), true);
            $usuario = new Usuario($_PUT['nombre'], $_PUT['apellido'], $_PUT['correo'],
                $_PUT['password'], $_PUT['telefono'], $_PUT['fecha'], $_PUT['direccion']);
                $usuario -> actualizar();
        break;
        case 'DELETE'://eliminar usuario
            echo "Elimino el usuario por el id " . $_GET['id'];
        break;
    }
?>
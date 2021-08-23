<?php
    //Recibir las peticiones del clientes
    header("Content-Type: application/json");
    require_once("../clases/class-publicaciones.php");
    switch($_SERVER['REQUEST_METHOD']){
        case 'POST'://guardar una publicacion
            $_POST = json_decode(file_get_contents('php://input'), true);
            $publicacion = new Publicaciones($_POST['titulo'], $_POST['descripcion'], $_POST['fecha'],
            $_POST['hora'], $_POST['precio'], $_POST['idcategoria'], $_POST['idestado'], $_POST['idusuario']);
            $publicacion -> guardar();
        break;
        case 'GET'://obtener una publicacion
            if(isset($_GET['id']))
                Publicaciones::obtenerPorCategorias($_GET['id']);
            else{//Obtner todos las publicaciones
                Publicaciones::obtenerTodo();
            }
        break;
        case 'PUT'://actualizar un usuario
            $_PUT = json_decode(file_get_contents('php://input'), true);
        break;
        case 'DELETE'://eliminar usuario
            echo "Elimino el usuario por el id " . $_GET['id'];
        break;
    }
?>
<?php
    include("../data/dbconexion.php");
    class Usuario {
        private $nombre; 
        private $apellido; 
        private $correo; 
        private $password;
        private $telefono;
        private $fechaNacimiento;
        private $direccion;

        public function __construct($nombre, $apellido, $correo, 
        $password, $telefono, $fechaNacimiento, $direccion)
        {
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->correo = $correo;
            $this->password = $password;
            $this->telefono = $telefono;
            $this->fechaNacimiento = $fechaNacimiento;
            $this->direccion = $direccion;
        }

        public function guardar() {
            try{
                $sqlmail = "SELECT `nombre`, `apellido` FROM `usuarios` WHERE correo ='$this->correo'";
                $conexion = conexion();
                if($conexion != "Error"){
                    $estado = $conexion -> prepare($sqlmail);
                    $resultado = $estado -> execute();
                    if($resultado != false){
                        $filasMail = $estado -> fetchAll(PDO::FETCH_OBJ);
                        if($filasMail != null){
                            $respuesta ['mensaje'] = "Correo existente";
                            echo json_encode($respuesta);
                        }
                        else{
                            $sql = "INSERT INTO `usuarios`(`nombre`, `apellido`, `correo`, `password`, 
                            `telefono`, `fechaNacimiento`, `direccion`, `roles_idroles`) 
                            VALUES ('$this->nombre','$this->apellido','$this->correo',AES_ENCRYPT('$this->password', 'encryPass'),
                            '$this->telefono','$this->fechaNacimiento','$this->direccion',1);";
                             $estado = $conexion -> prepare($sql);
                             $resultado = $estado -> execute();
                             if($resultado != false){
                                 session_start();
                                 $_SESSION['correo'] = $this->correo;
                                $respuesta = "Ingresado Correctamente";
                                echo json_encode($respuesta);
                             }
                        }
                    }
                    else{
                        $respuesta = "No se ingreso";
                        echo json_encode($respuesta);
                    }
                }
                else{
                    $respuesta = "Error en la conexion";
                    echo json_encode($respuesta);
                }
            }
            catch(PDOException $err){
                die("No se ingreso el usuario " . $err->getMessage());
            }
        }

        public static function inicioSesion($correo, $email, $passw) {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                try { 
                    $sql = "SELECT `idusuarios`, `nombre`, `apellido`, `correo`, AES_DECRYPT(`password`, 'encryPass') as `pass`
                    FROM `usuarios` WHERE correo = '$email';";
                    $conexion = conexion();
                    if($conexion != "Error"){
                        $estado = $conexion -> prepare($sql);
                        $resultado = $estado -> execute();
                        if($resultado != false){
                            $filasArray = $estado -> fetchAll(PDO::FETCH_OBJ);
                            //De aqui no paso
                            session_start();
                            foreach($filasArray as $fila){
                                $_SESSION['id'] = $fila -> idusuarios;
                                $_SESSION['nombre'] = $fila -> nombre;
                                $_SESSION['apellido'] = $fila -> apellido;
                                $_SESSION['correo'] = $fila -> correo;
                                $_SESSION['password'] = $fila -> pass;
                            }
                            if($_SESSION['correo'] == $email and $_SESSION['password'] == $passw)
                                echo json_encode($_SESSION);
                            else{
                                $respuesta ['mensaje'] = "No se encontro el usuario";
                                echo json_encode($respuesta);
                            }
                        }
                        else{
                            $respuesta ['mensaje'] = "No se encontro el usuario";
                            echo json_encode($respuesta);
                        }
                    }
                    else{
                        $respuesta ['mensaje'] = "Error en la conexion";
                        echo json_encode($respuesta);
                    }
                }
                catch(PDOException $err){
                    $respuesta ['mensaje'] = die("No se encontro el usuario" . $err->getMessage());
                    echo json_encode($respuesta);
                }
            }
            else{
                $respuesta ['mensaje'] = "Correo no valido";
                echo json_encode($respuesta);
            }
            
        }
        
        public static function cerrarSesion(){
            @session_start();
            session_destroy();
            echo "Cerrar Sesion";
        }

        public function actualizar(){
            $sql1 = "SELECT `idusuarios` FROM `usuarios` WHERE correo = '$this->correo'";
            $conexion = conexion();
            if($conexion != "Error"){
                $estado = $conexion -> prepare($sql1);
                $resultado = $estado -> execute();
                if($resultado != false){
                    $filasArray = $estado -> fetchAll(PDO::FETCH_OBJ);
                    foreach($filasArray as $fila){
                        $id = $fila -> idusuarios;
                    }
                    $sql="UPDATE `usuarios` SET`nombre` = '$this->nombre', 
                    `apellido` = '$this->apellido', `correo` = '$this->correo', 
                    `password` = AES_ENCRYPT('$this->password','encryPass'), `telefono` = '$this->telefono', 
                    `fechaNacimiento` = '$this->fechaNacimiento', `direccion` = '$this->direccion' 
                    WHERE `usuarios`.`idusuarios` = $id;";
                    $sql2="";
                    $estado = $conexion -> prepare($sql);
                    $resultado = $estado -> execute();
                    if($resultado != false){
                        session_start();
                        $_SESSION['id'] = $id;
                        $respuesta ['mensaje'] = "Actualizado";
                        echo json_encode($respuesta);
                    }
                }
                else{
                    $respuesta ['mensaje'] = "Usuario no encontrado";
                    echo json_encode($respuesta);
                }
            }
            else{
                $respuesta ['mensaje'] = "Error en la conexion";
                echo json_encode($respuesta);
            }
        }

        public static function guardarFoto($nom, $corr){
            header("Content-Type: text/html");
            $sql1 = "SELECT `idusuarios` FROM `usuarios` WHERE correo = '$corr';";
            $conexion = conexion();
            if($conexion != "Error"){
                $estado = $conexion -> prepare($sql1);
                $resultado = $estado -> execute();
                if($resultado != false){
                    $filasArray = $estado -> fetchAll(PDO::FETCH_OBJ);
                    foreach($filasArray as $fila){
                        session_start();
                        $_SESSION['id'] = $fila -> idusuarios;
                        $id = $_SESSION['id'];
                    }
                    $sql = "INSERT INTO  `fotousuario`(`url`, `usuarios_idusuarios`) 
                    VALUE('$nom', '$id')";
                    if($conexion != "Error"){
                        $estado = $conexion -> prepare($sql);
                        $resultado = $estado -> execute();
                        if($resultado != false){
                            $respuesta ['mensaje'] = "Ingreso Correctamente";
                            header("location: ../../frontend/publicaciones.php");
                        }
                        else{
                            $respuesta ['mensaje'] = "No se actualizo";
                            echo json_encode($respuesta);
                        }
                    }
                        
                }
                else{
                    $respuesta ['mensaje'] = "Usuario no encontrado";
                    echo json_encode($respuesta);
                }
            }
            else{
                $respuesta ['mensaje'] = "Error en la conexion";
                echo json_encode($respuesta);
            }
        }
    }
?>
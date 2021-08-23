<?php
    include("../data/dbconexion.php");
    class Publicaciones{
        private $titulo;
        private $descripcion;
        private $fecha;
        private $hora;
        private $precio;
        private $idCategoria;
        private $idEstado;
        private $idUsuario;

        public function __construct($titulo, $descripcion, $fecha, $hora, $precio, $idCategoria, $idEstado, $idUsuario)
        {
            $this->titulo = $titulo;
            $this->descripcion = $descripcion;
            $this->fecha = $fecha;
            $this->hora = $hora;
            $this->precio = $precio;
            $this->idCategoria = $idCategoria;
            $this->idEstado = $idEstado;
            $this->idUsuario = $idUsuario;
        }

        function guardar(){
            //gaurdar publicacion
            try{
                $sql = "INSERT INTO `publicaciones` (`titulo`, `descripcion`, `fecha`, `hora`,
                `precio`, `categoria_idcategoria`, `estados_idestados`, `usuarios_idusuarios`) 
                VALUES ('$this->titulo', '$this->descripcion', '$this->fecha', '$this->hora', '$this->precio', '$this->idCategoria', '$this->idEstado', '$this->idUsuario')";
                $conexion = conexion();
                if($conexion != "Error"){
                    $estado = $conexion -> prepare($sql);
                    $resultado = $estado -> execute();
                    if($resultado != false)
                        echo "Ingresado Correctamente";
                    else
                        echo "No se ingreso";
                }
                else
                    echo "Error en la conexion";
            }
            catch(PDOException $err){
                die("No se ingreso" . $err->getMessage());
            }
        }

        public static function obtenerPorCategorias($id){
            try{
                $sql = "SELECT `idpublicaciones`, `titulo`, `descripcion`, `fecha`, `hora`, 
                `precio`, `categoria_idcategoria` as `idcat`, `estados_idestados` as 
                `idestados`, `usuarios_idusuarios` as `iduser`, fotospublicaciones.url as `url` 
                FROM `publicaciones` INNER JOIN fotospublicaciones 
                ON publicaciones.idpublicaciones = fotospublicaciones.publicaciones_idpublicaciones 
                WHERE categoria_idcategoria = $id ORDER BY fecha, hora;";
                $conexion = conexion();
                $descripcion = [];
                    if($conexion != "Error"){
                        $estado = $conexion -> prepare($sql);
                        $resultado = $estado -> execute();
                        if($resultado != false){
                            $filasArray = $estado -> fetchAll(PDO::FETCH_ASSOC);
                            foreach($filasArray as $fila){
                                $descripcion [] = array(
                                    "id" => $fila['idpublicaciones'],
                                   "titulo" => $fila['titulo'],
                                    "descripcion" => $fila['descripcion'],
                                    "fecha" => $fila['fecha'],
                                    "hora" => $fila['hora'],
                                    "precio" => $fila['precio'],
                                    "categoria" => $fila['idcat'],
                                    "estados" => $fila['idestados'],
                                    "usuario" => $fila['iduser'],
                                    "url" => $fila['url']
                                );
                            }
                            echo json_encode($descripcion);
                        }
                        else{
                            $respuesta ['mensaje'] = "No se encontro la publicacion";
                            echo json_encode($respuesta);
                        }
                    }
                    else{
                        $respuesta ['mensaje'] = "Error en la conexion";
                        echo json_encode($respuesta);
                    }
            }
            catch(PDOException $err){
            $respuesta ['mensaje'] = die("No se encontro la publicacion" . $err->getMessage());
            echo json_encode($respuesta);
            }
        }

        public static function obtenerTodo(){
            //"Obtener todas las publicaciones";
            try{
                $sql = "SELECT `idpublicaciones`, `titulo`, `descripcion`, `fecha`, `hora`, 
                `precio`, `categoria_idcategoria` as `idcat`, `estados_idestados` as 
                `idestados`, `usuarios_idusuarios` as `iduser`, fotospublicaciones.url as `url` 
                FROM `publicaciones` INNER JOIN fotospublicaciones 
                ON publicaciones.idpublicaciones = fotospublicaciones.publicaciones_idpublicaciones 
                ORDER BY fecha, hora;";
                $conexion = conexion();
                $descripcion = [];
                if($conexion != "Error"){
                    $estado = $conexion -> prepare($sql);
                    $resultado = $estado -> execute();
                    if($resultado != false){
                        $filasArray = $estado -> fetchAll(PDO::FETCH_OBJ);
                        foreach($filasArray as $fila){
                            $descripcion [] = array(
                                "id" => $fila -> idpublicaciones,
                               "titulo" => $fila -> titulo,
                                "descripcion" => $fila -> descripcion,
                                "fecha" => $fila -> fecha,
                                "hora" => $fila -> hora,
                                "precio" => $fila -> precio,
                                "categoria" => $fila -> idcat,
                                "estados" => $fila -> idestados,
                                "usuario" => $fila -> iduser,
                                "url" => $fila -> url
                            );
                        }
                        echo json_encode($descripcion);
                    }
                    else{
                        $respuesta ['mensaje'] = "No se encontro la publicacion";
                        echo json_encode($respuesta);
                    }
                }
                else{
                    $respuesta ['mensaje'] = "Error en la conexion";
                    echo json_encode($respuesta);
                }
            }
            catch(PDOException $err){
            $respuesta ['mensaje'] = die("No se encontro la publicacion" . $err->getMessage());
            echo json_encode($respuesta);
            }
        }
    }
?>
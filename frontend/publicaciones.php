<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("location: error.html");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/estilos.css">
    <script src="./js/all.min.js"></script>
    <title>Publicaciones</title>
</head>
<body id="fondo">
    <nav class="navbar navbar-light bg-light" style="background-color: #C9F1FD;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./img/Icono.png" alt="">
                <label style="color: #ED217C;"><h3>Woman Store</h3></label></a>
            <a href="./perfil.html"><img src="./img/naruto.jpg" class="imagen-perfil" alt=""></a>
            <a href="./crear-publicacion.html">Crear</a>
            <button class="btn" onclick="cerrarSesion()"><i class="fa-solid fa-file-import"></i>Cerrar Sesion</button>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <h1 class="h3 mb-3 fw-normal">Categorias</h1>
                <div class="btn-group-vertical">
                    <button class="btn btn-primary boton" onclick="obtenerPublicaciones()">Todas</button><br>
                    <button class="btn btn-primary boton" onclick="obtenerPorCategoria(1)">Camisas</button><br>
                    <button class="btn btn-primary boton" onclick="obtenerPorCategoria(2)">Pantalones</button><br>
                    <button class="btn btn-primary boton" onclick="obtenerPorCategoria(6)">Vestidos</button><br>
                    <button class="btn btn-primary boton" onclick="obtenerPorCategoria(3)">Carteras</button><br>
                    <button class="btn btn-primary boton" onclick="obtenerPorCategoria(5)">Zapatos</button><br>
                    <button class="btn btn-primary boton" onclick="obtenerPorCategoria(8)">Accesorios</button><br>
                    <button class="btn-primary btn boton" onclick="obtenerPorCategoria(4)">Maquillaje</button><br>
                </div> 
            </div>
            <div class="col-9">
                <div id="publicaciones">
                    <section class="rounded mx-auto d-block">
                    </section> <br>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/axios.min.js"></script>
    <script src="./js/control-publicaciones.js"></script>
    <script src="./js/controlador-sesion.js"></script>
</body>
</html>
<?php

session_start();
if(!isset($_SESSION['usuario'])){
    header("Location:../index.php");
}else{
    if($_SESSION['usuario']=="ok"){
        $nombreUsuario = $_SESSION['nombreUsuario'];
    }
}

?>



<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">

    <title>Inicio</title>
</head>

<body>

    <?php
    $url = 'http://' . $_SERVER['HTTP_HOST'] . '/'
    ?>

    <div class="container">
        <nav class="navbar navbar-expand navbar-light bg-light">
            <div class="nav navbar-nav">
                <a class="nav-item nav-link" href="#">Administrador</a>
                <a class="nav-item nav-link" href="<?php echo $url; ?>admin/inicio.php">Inicio</a>
                <a class="nav-item nav-link" href="<?php echo $url; ?>admin/section/productos.php">Libros</a>
                <a class="nav-item nav-link" href="<?php echo $url; ?>admin/section/cerrar.php">Cerrar</a>
                <a class="nav-item nav-link" href="<?php echo $url; ?>">Ver sitio web</a>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="row">
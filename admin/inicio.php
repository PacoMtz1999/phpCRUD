<?php include('./template/header.php'); ?>

<div class="col-md-12">
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-4">Bienvenido: <?php echo $nombreUsuario; ?></h1>
            <p class="lead">Sistema de administracion de los libros</p>
            <hr class="my-4">
            <button class="btn btn-info btn-lg"><a href="./section/productos.php" role="button">Administrar</a></button>
        </div>
    </div>
</div>

<?php include('./template/footer.php'); ?>
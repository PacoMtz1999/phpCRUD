<?php include('template/header.php'); ?>

<title>Libros</title>

<style>
    p{
        text-align: justify;
    }
</style>

<?php

include('./admin/config/db.php');

$sentenciaSQL = $conexion->prepare("SELECT * FROM `libros`");
$sentenciaSQL->execute();
$listarLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="display-3">Lista de libros disponibles</h1>
<p>Si vas a hacer uso de los ejemplos en los libros para un proyecto tuyo, da los créditos suficientes a (los) autor(es) del libro en cuestión.</p>



<?php foreach($listarLibros as $libro){ ?>

<div class="col-md-3">
    <div class="card">
        <img src="./img/<?php echo $libro['imagen']?>" class="card-img-top">
        <div class="card-body">
            <h5 class="card-title"><?php echo $libro['nombre']?></h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <button class="btn btn-primary"><a href="https://goalkicker.com/" target="_blank">Ver mas</a></button>
        </div>
    </div>
</div>

<?php } ?>


<?php include('template/footer.php'); ?>
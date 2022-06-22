<?php include('../template/header.php'); ?>

<?php

$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
$imagen = (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

/* echo $id."<br/>";
echo $nombre."<br/>";
echo $imagen."<br/>";
echo $accion."<br/>"; */

include('../config/db.php');

/*ACCIONES*/

switch ($accion) {
    case "add":
        //echo "Agregar";
        $sentenciaSQL = $conexion->prepare("INSERT INTO `libros`(`nombre`, `imagen`) VALUES (:nombre,:imagen);");
        $sentenciaSQL->bindParam(':nombre', $nombre);


        /*ALMACENANDO LA IMAGEN*/
        $fecha = new DateTime();
        $nombreArchivo = ($imagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["imagen"]['name'] : "imagen.jpg";
        $tmpImagen = $_FILES['imagen']['tmp_name'];

        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }

        $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
        $sentenciaSQL->execute();

        header("Location:productos.php");
        break;
    case "modify":
        $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id_libro=:id");
        $sentenciaSQL->bindParam(':nombre', $nombre);
        $sentenciaSQL->bindParam(':id', $id);
        $sentenciaSQL->execute();
        //echo "Modificar";

        if ($imagen != "") {

            $fecha = new DateTime();
            $nombreArchivo = ($imagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["imagen"]['name'] : "imagen.jpg";
            $tmpImagen = $_FILES['imagen']['tmp_name'];
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM `libros` WHERE id_libro=:id");
            $sentenciaSQL->bindParam(':id', $id);
            $sentenciaSQL->execute();
            $datosLibro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($datosLibro["imagen"]) && ($datosLibro["imagen"] != "imagen.jpg")) {
                if (file_exists("../../img/" . $datosLibro["imagen"])) {
                    unlink("../../img/" . $datosLibro["imagen"]);
                }
            }


            $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id_libro=:id");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id', $id);
            $sentenciaSQL->execute();
        }
        header("Location:productos.php");
        break;
    case "cancel":
        header("Location:productos.php");
        //echo "Cancelar";
        break;
    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM `libros` WHERE id_libro=:id");
        $sentenciaSQL->bindParam(':id', $id);
        $sentenciaSQL->execute();
        $datosLibro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $nombre = $datosLibro['nombre'];
        $imagen = $datosLibro['imagen'];
        //echo "Seleccionar";
        break;
    case "Borrar":

        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM `libros` WHERE id_libro=:id");
        $sentenciaSQL->bindParam(':id', $id);
        $sentenciaSQL->execute();
        $datosLibro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($datosLibro["imagen"]) && ($datosLibro["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img/" . $datosLibro["imagen"])) {
                unlink("../../img/" . $datosLibro["imagen"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM `libros` WHERE id_libro=:id");
        $sentenciaSQL->bindParam(':id', $id);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        //echo "Borrar";
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM `libros`");
$sentenciaSQL->execute();
$listarLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- NO DESHABILITAR LOS CAMPOS DEL FORMULARIO -->


<div class="col-md-5">
    <div class="card">
        <div class="card-header text-center">Datos del libro</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="id" class="form-label">ID</label>
                    <input type="text" name="id" class="form-control" value="<?php echo $id; ?>" require readonly>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>" require>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen:</label> <br>

                    <?php if ($imagen != "") { ?>

                        <img class="img-tumbnail rounded" src="../../img/<?php echo $imagen ?>" alt="libro" width="50">

                    <?php } ?>


                    <input type="file" name="imagen" class="form-control">
                </div>
                <div class="btn-group" role="group">
                    <button type="submit" value="add" name="accion" class="btn btn-success" <?php echo ($accion == "Seleccionar") ? " disabled" : ""; ?>>Agregar</button>
                    <button type="submit" value="modify" name="accion" class="btn btn-warning" <?php echo ($accion != "Seleccionar") ? " disabled" : ""; ?>>Modificar</button>
                    <button type="submit" value="cancel" name="accion" class="btn btn-info" <?php echo ($accion != "Seleccionar") ? " disabled" : ""; ?>>Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="col-md-7">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($listarLibros as $libro) {
            ?>
                <tr>
                    <td><?php echo $libro['id_libro']; ?></td>
                    <td><?php echo $libro['nombre']; ?></td>
                    <td>
                        <img class="img-tumbnail rounded" src="../../img/<?php echo $libro['imagen']; ?>" alt="libro" width="50">
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $libro['id_libro']; ?>">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</div>




<?php include('../template/footer.php'); ?>
<?php

$host = 'localhost';
$db = 'sitio';
$usuario = 'root';
$contraseña = 'root';
$port = 8889;

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db;port=$port", $usuario, $contraseña);
    if ($conexion) {
        //echo "Conectado";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

if(!puedeGestionarUsuarios()){
    header("Location: ../formularios/gestion.php");
    exit();
}

$nombre = $_REQUEST["fnombre"];
$usuario = $_REQUEST["fusuario"];
$password = $_REQUEST["fpassword"];
$rol = $_REQUEST["frol"];

$sql = "INSERT INTO usuarios
        (usuario, password, nombre, rol, estado)
        VALUES
        ('$usuario', '$password', '$nombre', '$rol', 'Activo')";

mysqli_query($conexion, $sql);

mysqli_close($conexion);

header("Location: ../formularios/usuarios.php");
exit();
?>
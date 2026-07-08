<?php
session_start();
/** @var mysqli $conexion */
include("../bd/conexion.php");

$usuario = $_REQUEST["fusuario"];
$password = $_REQUEST["fpassword"];

$sql = "SELECT *
        FROM usuarios
        WHERE usuario = '$usuario'
        AND password = '$password'";

$resultado = mysqli_query($conexion, $sql);

if(mysqli_num_rows($resultado) > 0){

    $fila = mysqli_fetch_assoc($resultado);

    $_SESSION["usuario"] = $fila["usuario"];
    $_SESSION["nombre"] = $fila["nombre"];
    $_SESSION["rol"] = $fila["rol"];

    header("Location: ../formularios/gestion.php");
    exit();

}else{

    header("Location: login.php?error=1");
    exit();
}

mysqli_close($conexion);
?>
<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

if(!puedeGestionarUsuarios()){
    header("Location: ../formularios/gestion.php");
    exit();
}

$id_usuario = $_REQUEST["fid_usuario"];
$estadoActual = $_REQUEST["festado"];

if($estadoActual == "Activo"){
    $nuevoEstado = "Baja";
}else{
    $nuevoEstado = "Activo";
}

$sql = "UPDATE usuarios
        SET estado = '$nuevoEstado'
        WHERE id_usuario = $id_usuario";

mysqli_query($conexion, $sql);

mysqli_close($conexion);

header("Location: ../formularios/usuarios.php");
exit();
?>
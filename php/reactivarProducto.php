<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

$codigo = $_REQUEST["fcodigo"];

/* Buscar información del producto */
$sqlBuscar = "SELECT *
              FROM productos
              WHERE codigo = $codigo";

$resultadoBuscar = mysqli_query($conexion, $sqlBuscar);
$fila = mysqli_fetch_assoc($resultadoBuscar);

/* Reactivar producto */
$sql = "UPDATE productos
        SET estado = 'Activo'
        WHERE codigo = $codigo";

$resultado = mysqli_query($conexion, $sql);

/* Guardar movimiento en historial */
if($resultado){

    $usuario = $_SESSION["usuario"];
    $nombreUsuario = $_SESSION["nombre"];
    $rol = $_SESSION["rol"];

    $sqlHistorial = "INSERT INTO historial_movimientos
    (usuario, nombre_usuario, rol, accion, codigo_producto, producto, detalle, fecha)
    VALUES
    ('$usuario',
     '$nombreUsuario',
     '$rol',
     'Reactivación de producto',
     '$codigo',
     '".$fila["nombre"]."',
     'Se reactivó el producto ".$fila["nombre"]."',
     NOW())";

    mysqli_query($conexion, $sqlHistorial);
}

mysqli_close($conexion);

header("Location: ../formularios/inventario.php");
exit();
?>















<!-- aqui va apertura de php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

$codigo = $_REQUEST["fcodigo"];

$sql = "UPDATE productos
        SET estado = 'Activo'
        WHERE codigo = $codigo";

mysqli_query($conexion, $sql);

mysqli_close($conexion);

header("Location: ../formularios/inventario.php");
exit();
 aqui va el cierre-->



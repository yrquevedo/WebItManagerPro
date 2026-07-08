<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

if(!puedeEliminar()){
    header("Location: ../formularios/inventario.php");
    exit();
}

/** @var mysqli $conexion */
include("../bd/conexion.php");

$codigo = $_REQUEST["fcodigo"];

/* Primero buscamos el producto */
$sqlBuscar = "SELECT *
              FROM productos
              WHERE codigo = $codigo";

$resultadoBuscar = mysqli_query($conexion, $sqlBuscar);
$fila = mysqli_fetch_assoc($resultadoBuscar);

/* Damos de baja */
$sql = "UPDATE productos
        SET estado = 'Baja'
        WHERE codigo = $codigo";

$resultado = mysqli_query($conexion, $sql);

/* Guardamos en historial */
if($resultado){

    $usuario = $_SESSION["usuario"];
    $nombreUsuario = $_SESSION["nombre"];
    $rol = $_SESSION["rol"];

    $sqlHistorial = "INSERT INTO historial_movimientos
    (usuario, nombre_usuario, rol, accion, codigo_producto, producto, detalle, fecha)
    VALUES
    ('$usuario', '$nombreUsuario', '$rol',
    'Baja de producto', '$codigo',
    '".$fila["nombre"]."',
    'Se dio de baja el producto ".$fila["nombre"]."',
    NOW())";

    mysqli_query($conexion, $sqlHistorial);
}


// este codigo lo tenia antes de el de arriba
// /* Primero buscamos los datos del producto */
// $sqlBuscar = "SELECT *
//               FROM productos
//               WHERE codigo = $codigo";

// $resultadoBuscar = mysqli_query($conexion, $sqlBuscar);
// $fila = mysqli_fetch_assoc($resultadoBuscar);

// /* Después damos de baja el producto */
// $sql = "UPDATE productos
//         SET estado = 'Baja'
//         WHERE codigo = $codigo";

// $resultado = mysqli_query($conexion, $sql);

// //aqui va la parte d historial  movimientos
// $sqlProducto = "SELECT *
//                 FROM productos
//                 WHERE codigo = $codigo";

// $resultadoProducto = mysqli_query($conexion, $sqlProducto);
// $fila = mysqli_fetch_assoc($resultadoProducto);

// $usuario = $_SESSION["usuario"];
// $nombreUsuario = $_SESSION["nombre"];
// $rol = $_SESSION["rol"];

// $sqlHistorial = "INSERT INTO historial_movimientos
// (usuario, nombre_usuario, rol, accion, codigo_producto, producto, detalle, fecha)
// VALUES
// ('$usuario', '$nombreUsuario', '$rol', 'Baja de producto', '$codigo', '".$fila["nombre"]."',
// 'Se dio de baja el producto ".$fila["nombre"]."', NOW())";

// mysqli_query($conexion, $sqlHistorial);



?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Producto dado de baja</title>

<link rel="stylesheet" href="../css/style.css?v=60">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>

<aside class="sidebar">
    <div class="brand">
        <i class="bi bi-pc-display"></i>
        <div>
            <h2>It Manager Pro</h2>
            <p>Panel interno</p>
        </div>
    </div>

    <p class="usuario-logueado">
        <i class="bi bi-person-check"></i>
        <?php echo $_SESSION["nombre"]; ?>
    </p>

    <p class="rol-logueado">
        <?php echo $_SESSION["rol"]; ?>
    </p>



    <nav class="menu">
        <a href="../index.html"><i class="bi bi-house"></i> Inicio</a>
        <a href="../formularios/gestion.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="../formularios/inventario.php"><i class="bi bi-box-seam"></i> Inventario</a>
        <a href="../formularios/registro.html"><i class="bi bi-plus-circle"></i> Registrar producto</a>
        <a href="../formularios/actualizar.html"><i class="bi bi-pencil-square"></i> Actualizar producto</a>
        <a href="../formularios/consulta.php"><i class="bi bi-search"></i> Consultar producto</a>
        <a href="../formularios/borrar.html" class="activo"><i class="bi bi-trash"></i> Dar de baja producto</a>
        <?php if($_SESSION["rol"] == "Administrador"){ ?><a href="historial.php"><i class="bi bi-clock-history"></i> Historial</a>
        <?php } ?>
        <?php if(puedeGestionarUsuarios()){ ?>
        <a href="../formularios/usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
        <?php } ?>
         <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
    </nav>
</aside>

<div class="contenedor-panel">

    <div class="resultado">

        <?php if($resultado && $fila){ ?>

            <h1>
                <i class="bi bi-check-circle verde"></i>
                Producto dado de baja correctamente
            </h1>

            <p class="texto-info">
                El producto
                <strong><?php echo $fila["nombre"]; ?></strong>
                con código
                <strong><?php echo $fila["codigo"]; ?></strong>
                ha sido dado de baja correctamente.
            </p>

            <img src="../img/<?php echo $fila["imagen"]; ?>" class="producto-img">

            <table>
                <tr><th>Código</th><td><?php echo $fila["codigo"]; ?></td></tr>
                <tr><th>Nombre</th><td><?php echo $fila["nombre"]; ?></td></tr>
                <tr><th>Descripción</th><td><?php echo $fila["descripcion"]; ?></td></tr>
                <tr><th>Precio</th><td><?php echo $fila["precio"]; ?> €</td></tr>
                <tr><th>Cantidad</th><td><?php echo $fila["cantidad"]; ?></td></tr>
                <tr><th>Categoría</th><td><?php echo $fila["categoria"]; ?></td></tr>
                <tr><th>Marca</th><td><?php echo $fila["marca"]; ?></td></tr>
                <tr><th>Estado actual</th><td>Baja</td></tr>
            </table>

        <?php }else{ ?>

            <h1>
                <i class="bi bi-exclamation-triangle naranja"></i>
                No se pudo dar de baja
            </h1>

        <?php } ?>

        <a href="../formularios/inventario.php" class="boton">
            <i class="bi bi-box-seam"></i>
            Volver al inventario
        </a>

        <a href="../formularios/borrar.html" class="boton">
            <i class="bi bi-trash"></i>
            Dar de baja otro producto
        </a>

    </div>

</div>

</body>
</html>

<?php mysqli_close($conexion); ?>
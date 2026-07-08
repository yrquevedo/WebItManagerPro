<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

if(!puedeEditar()){
    header("Location: ../formularios/inventario.php");
    exit();
}

$codigo = $_REQUEST["fcodigo"];
$precio = $_REQUEST["fprecio"];
$cantidad = $_REQUEST["fcantidad"];

$sql = "";
$mensaje = "";

if($precio != "" && $cantidad != ""){

    $sql = "UPDATE productos
            SET precio = '$precio',
                cantidad = '$cantidad'
            WHERE codigo = $codigo";

    $mensaje = "Se ha actualizado el precio a $precio € y el stock del producto a $cantidad unidades.";        


}elseif($precio != ""){

    $sql = "UPDATE productos
            SET precio = '$precio'
            WHERE codigo = $codigo";

    $mensaje = "Se ha actualizado el precio del producto a $precio €.";
    

}elseif($cantidad != ""){

    $sql = "UPDATE productos
            SET cantidad = '$cantidad'
            WHERE codigo = $codigo";

    
    $mensaje = "Se ha actualizado el stock del producto a $cantidad unidades.";

}

if($sql != ""){
    $resultado = mysqli_query($conexion, $sql);
    
}else{
    $resultado = false;
}

/* Buscar producto actualizado */
$sqlProducto = "SELECT *
                FROM productos
                WHERE codigo = $codigo";

$resultadoProducto = mysqli_query($conexion, $sqlProducto);
$fila = mysqli_fetch_assoc($resultadoProducto);

// AQUI ES LA PARTE DONDE SE VE EL HISTORIAL DEL MOVIMIENTO,
$usuario = $_SESSION["usuario"];
$nombreUsuario = $_SESSION["nombre"];
$rol = $_SESSION["rol"];

$sqlHistorial = "INSERT INTO historial_movimientos
(usuario, nombre_usuario, rol, accion, codigo_producto, producto, detalle, fecha)
VALUES
('$usuario', '$nombreUsuario', '$rol', 'Actualización de producto', '$codigo', '".$fila["nombre"]."',
'$mensaje', NOW())";

mysqli_query($conexion, $sqlHistorial);


?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Producto actualizado</title>

<link rel="stylesheet" href="../css/style.css?v=53">
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
        <?php if(puedeRegistrar()){ ?>
        <a href="../formularios/registro.html">
        <i class="bi bi-plus-circle"></i> Registrar producto
        </a>
        <?php } ?>

        <?php if(puedeEditar()){ ?>
        <a href="../formularios/actualizar.html" class="activo">
        <i class="bi bi-pencil-square"></i> Actualizar producto
        </a>
        <?php } ?>

        <a href="../formularios/consulta.php">
        <i class="bi bi-search"></i> Consultar producto
        </a>

        <?php if(puedeEliminar()){ ?>
        <a href="../formularios/borrar.html">
        <i class="bi bi-trash"></i> Dar de baja producto
        </a>
        <?php } ?>

        <?php if($_SESSION["rol"] == "Administrador"){ ?>
        <a href="historial.php">
        <i class="bi bi-clock-history"></i> Historial
        </a>
        <?php } ?>

        <?php if(puedeGestionarUsuarios()){ ?>
        <a href="../formularios/usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
        <?php } ?>
        <!-- <a href="../formularios/registro.html"><i class="bi bi-plus-circle"></i> Registrar producto</a>
        <a href="../formularios/actualizar.html" class="activo"><i class="bi bi-pencil-square"></i> Actualizar producto</a>
        <a href="../formularios/consulta.php"><i class="bi bi-search"></i> Consultar producto</a>
        <a href="../formularios/borrar.html"><i class="bi bi-trash"></i> Dar de baja producto</a> -->
       <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
        </nav>
</aside>

<div class="contenedor-panel">

    <div class="resultado">

        <?php if($resultado && $fila){ ?>

            <h1><i class="bi bi-check-circle verde"></i> Producto actualizado correctamente</h1>

            <p class="texto-info">
                <?php echo $mensaje; ?>
            </p>

            <img src="../img/<?php echo $fila["imagen"]; ?>" class="producto-img">

            <table>
                <tr><th>Código</th><td><?php echo $fila["codigo"]; ?></td></tr>
                <tr><th>Nombre</th><td><?php echo $fila["nombre"]; ?></td></tr>
                <tr><th>Descripción</th><td><?php echo $fila["descripcion"]; ?></td></tr>
                <tr><th>Precio actual</th><td><?php echo $fila["precio"]; ?> €</td></tr>
                <tr><th>Stock actual</th><td><?php echo $fila["cantidad"]; ?></td></tr>
                <tr><th>Categoría</th><td><?php echo $fila["categoria"]; ?></td></tr>
                <tr><th>Marca</th><td><?php echo $fila["marca"]; ?></td></tr>
                <tr><th>Estado</th><td><?php echo $fila["estado"]; ?></td></tr>
            </table>

        <?php }else{ ?>

            <h1><i class="bi bi-exclamation-triangle naranja"></i> No se actualizó ningún dato</h1>

            <p class="texto-info">
                Debes escribir un nuevo precio, una nueva cantidad o ambos.
            </p>

        <?php } ?>

        <a href="../formularios/inventario.php" class="boton">
            <i class="bi bi-box-seam"></i> Volver al inventario
        </a>

        <a href="../formularios/actualizar.html" class="boton">
            <i class="bi bi-pencil-square"></i> Actualizar otro producto
        </a>

    </div>

</div>

</body>
</html>

<?php mysqli_close($conexion); ?>
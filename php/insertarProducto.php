<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

if(!puedeRegistrar()){
    header("Location: ../formularios/inventario.php");
    exit();
}

$nombre = $_REQUEST["fnombre"];
$descripcion = $_REQUEST["fdescripcion"];
$precio = $_REQUEST["fprecio"];
$cantidad = $_REQUEST["fcantidad"];
$categoria = $_REQUEST["fcategoria"];
$marca = $_REQUEST["fmarca"];
$imagen = $_REQUEST["fimagen"];

$codigo = "";

/* Comprobamos si ya existe un producto activo con el mismo nombre */
$sqlComprobar = "SELECT *
                 FROM productos
                 WHERE nombre = '$nombre'
                 AND estado = 'Activo'";

$resultadoComprobar = mysqli_query($conexion, $sqlComprobar);

if(mysqli_num_rows($resultadoComprobar) > 0){

    $duplicado = true;
    $resultado = false;

    $filaDuplicada = mysqli_fetch_assoc($resultadoComprobar);
    $codigoDuplicado = $filaDuplicada["codigo"];

}else{

    $duplicado = false;

    $sql = "INSERT INTO productos
            (nombre, descripcion, precio, cantidad, categoria, marca, imagen, estado)
            VALUES
            ('$nombre', '$descripcion', '$precio', '$cantidad', '$categoria', '$marca', '$imagen', 'Activo')";

    $resultado = mysqli_query($conexion, $sql);

    if($resultado){
        $codigo = mysqli_insert_id($conexion);

        // aqui es donde va toda la parte de hisorial de movimiento.
        $usuario = $_SESSION["usuario"];
        $nombreUsuario = $_SESSION["nombre"];
        $rol = $_SESSION["rol"];

        $sqlHistorial = "INSERT INTO historial_movimientos
        (usuario, nombre_usuario, rol, accion, codigo_producto, producto, detalle, fecha)
        VALUES
        ('$usuario', '$nombreUsuario', '$rol', 'Registro de producto', '$codigo', '$nombre',
        'Se registró el producto $nombre con stock $cantidad y precio $precio €', NOW())";

        mysqli_query($conexion, $sqlHistorial);
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Producto registrado</title>

<link rel="stylesheet" href="../css/style.css?v=31">
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
        <a href="../formularios/registro.html" class="activo"><i class="bi bi-plus-circle"></i> Registrar producto</a>
        <a href="../formularios/actualizar.html"><i class="bi bi-pencil-square"></i> Actualizar producto</a>
        <a href="../formularios/consulta.php"><i class="bi bi-search"></i> Consultar producto</a>
        <a href="../formularios/borrar.html"><i class="bi bi-trash"></i> Dar de baja producto</a>
        <?php if(puedeGestionarUsuarios()){ ?>
        <a href="../formularios/usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
        <?php } ?>
        <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
    </nav>
</aside>

<div class="contenedor-panel">

    <div class="resultado">

        <?php if($duplicado){ ?>

            <h1><i class="bi bi-exclamation-triangle naranja"></i> Producto ya registrado</h1>

            <p class="texto-info">
                Este producto ya existe en el inventario como producto activo.
                <br>
                Código del producto existente:
                <strong><?php echo $codigoDuplicado; ?></strong>
            </p>

            <img src="../img/<?php echo $imagen; ?>" class="producto-img">

            <table>
                <tr><th>Código</th><td><?php echo $codigoDuplicado; ?></td></tr>
                <tr><th>Nombre</th><td><?php echo $nombre; ?></td></tr>
                <tr><th>Categoría</th><td><?php echo $categoria; ?></td></tr>
                <tr><th>Marca</th><td><?php echo $marca; ?></td></tr>
                <tr><th>Estado</th><td>Activo</td></tr>
            </table>

        <?php }else if($resultado){ ?>

            <h1><i class="bi bi-check-circle verde"></i> Producto registrado correctamente</h1>

            <p class="texto-info">
                Código asignado:
                <strong><?php echo $codigo; ?></strong>
            </p>

            <img src="../img/<?php echo $imagen; ?>" class="producto-img">

            <table>
                <tr><th>Código</th><td><?php echo $codigo; ?></td></tr>
                <tr><th>Nombre</th><td><?php echo $nombre; ?></td></tr>
                <tr><th>Precio</th><td><?php echo $precio; ?> €</td></tr>
                <tr><th>Cantidad</th><td><?php echo $cantidad; ?></td></tr>
                <tr><th>Categoría</th><td><?php echo $categoria; ?></td></tr>
                <tr><th>Marca</th><td><?php echo $marca; ?></td></tr>
                <tr><th>Estado</th><td>Activo</td></tr>
            </table>

        <?php }else{ ?>

            <h1><i class="bi bi-x-circle rojo"></i> Error al registrar el producto</h1>

        <?php } ?>

        <a href="../formularios/registro.html" class="boton">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

    </div>

</div>

</body>
</html>

<?php mysqli_close($conexion); ?>
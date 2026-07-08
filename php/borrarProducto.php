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

$sql = "SELECT *
        FROM productos
        WHERE codigo = $codigo";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Confirmar baja</title>

<link rel="stylesheet" href="../css/style.css?v=1">
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
        <a href="../formularios/consulta.php" class="activo"><i class="bi bi-search"></i> Consultar producto</a>
        <a href="../formularios/borrar.html"><i class="bi bi-trash"></i> Dar de baja producto</a>
        <?php if($_SESSION["rol"] == "Administrador"){ ?><a href="historial.php"><i class="bi bi-clock-history"></i> Historial</a>
        <?php } ?>
        <?php if(puedeGestionarUsuarios()){ ?>
        <a href="../formularios/usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
        <?php } ?>
    </nav>
</aside>

<div class="contenedor-panel">

    <div class="resultado">

        <h1><i class="bi bi-trash"></i> Confirmar baja</h1>

        <?php if(mysqli_num_rows($resultado) > 0){ 
            $fila = mysqli_fetch_assoc($resultado);
        ?>

            <p class="texto-info">Revisa el producto antes de darlo de baja:</p>

            <img src="../img/<?php echo $fila["imagen"]; ?>" class="producto-img">

            <table>
                <tr><th>Código</th><td><?php echo $fila["codigo"]; ?></td></tr>
                <tr><th>Nombre</th><td><?php echo $fila["nombre"]; ?></td></tr>
                <tr><th>Descripción</th><td><?php echo $fila["descripcion"]; ?></td></tr>
                <tr><th>Precio</th><td><?php echo $fila["precio"]; ?> €</td></tr>
                <tr><th>Cantidad</th><td><?php echo $fila["cantidad"]; ?></td></tr>
                <tr><th>Categoría</th><td><?php echo $fila["categoria"]; ?></td></tr>
                <tr><th>Marca</th><td><?php echo $fila["marca"]; ?></td></tr>
            </table>

            <form action="eliminarProducto.php" method="post">

                <input type="hidden" name="fcodigo" value="<?php echo $fila["codigo"]; ?>">

                <button type="submit" class="btn-danger">
                    <i class="bi bi-trash"></i> Confirmar baja
                </button>

            </form>

        <?php }else{ ?>

            <h2><i class="bi bi-exclamation-triangle rojo"></i> Producto no encontrado</h2>

        <?php } ?>

        <a href="../formularios/borrar.html" class="boton">Volver</a>
        <a href="../formularios/inventario.php" class="boton">
        <i class="bi bi-box-seam"></i>
        Volver al inventario
    </a>

    </div>

</div>

</body>
</html>

<?php mysqli_close($conexion); ?>
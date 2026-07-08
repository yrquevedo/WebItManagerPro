<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

$sql = "SELECT codigo, nombre FROM productos WHERE estado='Activo' ORDER BY nombre";
$resultadoProductos = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Consultar producto</title>

<link rel="stylesheet" href="../css/style.css?v=22">
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

    <a href="gestion.php"><i class="bi bi-speedometer2"></i> Dashboard</a>

    <a href="inventario.php"><i class="bi bi-box-seam"></i> Inventario</a>

    <?php if(puedeRegistrar()){ ?>
        <a href="registro.html">
            <i class="bi bi-plus-circle"></i> Registrar producto
        </a>
    <?php } ?>

    <a href="consulta.php" class="activo"><i class="bi bi-search"></i> Consultar producto</a>

    <?php if(puedeEditar()){ ?>
        <a href="actualizar.html">
            <i class="bi bi-pencil-square"></i> Actualizar producto
        </a>
    <?php } ?>

    <?php if(puedeEliminar()){ ?>
        <a href="borrar.html">
            <i class="bi bi-trash"></i> Dar de baja producto
        </a>
    <?php } ?>

    <?php if($_SESSION["rol"] == "Administrador"){ ?>
    <a href="historial.php">
        <i class="bi bi-clock-history"></i> Historial
    </a>
    <?php } ?>

    <?php if(puedeGestionarUsuarios()){ ?><a href="usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
        <?php } ?>

    <a href="contactoAdmin.php"><i class="bi bi-envelope-paper"></i>Contactar administrador</a>    

    <a href="../login/logout.php">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
    </a>

        <!-- <a href="../index.html"><i class="bi bi-house"></i> Inicio</a>
        <a href="gestion.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="inventario.php" class="activo"><i class="bi bi-box-seam"></i> Inventario</a>
        <a href="registro.html"><i class="bi bi-plus-circle"></i> Registrar producto</a>
        <a href="actualizar.html"><i class="bi bi-pencil-square"></i> Actualizar producto</a>
        <a href="consulta.php" class="activo"><i class="bi bi-search"></i> Consultar producto</a>
        <a href="borrar.html"><i class="bi bi-trash"></i> Dar de baja producto</a>
        <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a> -->


    </nav>
</aside>

<div class="contenedor-panel">

    <div class="form-card">

        <h1><i class="bi bi-search"></i> Consultar producto</h1>

        <p class="texto-info">
            Puedes buscar el producto por código o seleccionarlo por nombre.
        </p>

        <form action="../php/consultaProducto.php" method="post">

            <label>Buscar por código</label>
            <input type="number" name="fcodigo" placeholder="Ejemplo: 1">

            <label>O buscar por nombre del producto</label>
            <select name="fproducto">
                <option value="">Selecciona un producto</option>

                <?php while($fila = mysqli_fetch_assoc($resultadoProductos)){ ?>
                    <option value="<?php echo $fila["codigo"]; ?>">
                        <?php echo $fila["nombre"]; ?>
                    </option>
                <?php } ?>

            </select>

            <label>O buscar por precio máximo</label>
            <input type="number" name="fprecio" step="0.01" placeholder="Ejemplo: 800">

            <button type="submit">
                <i class="bi bi-eye"></i> Consultar producto
            </button>

        </form>

    </div>

</div>

</body>
</html>

<?php mysqli_close($conexion); ?>
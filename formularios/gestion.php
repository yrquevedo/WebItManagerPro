<?php

include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

$sqlTotal = "SELECT COUNT(*) total FROM productos";
$resultadoTotal = mysqli_query($conexion, $sqlTotal);
$filaTotal = mysqli_fetch_assoc($resultadoTotal);

$sqlActivos = "SELECT COUNT(*) activos FROM productos WHERE estado='Activo'";
$resultadoActivos = mysqli_query($conexion, $sqlActivos);
$filaActivos = mysqli_fetch_assoc($resultadoActivos);

$sqlStock = "SELECT COUNT(*) sinstock FROM productos WHERE cantidad = 0";
$resultadoStock = mysqli_query($conexion, $sqlStock);
$filaStock = mysqli_fetch_assoc($resultadoStock);

$sqlBaja = "SELECT COUNT(*) baja FROM productos WHERE estado='Baja'";
$resultadoBaja = mysqli_query($conexion, $sqlBaja);
$filaBaja = mysqli_fetch_assoc($resultadoBaja);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Panel de gestión | WebIt Manager Pro</title>

<link rel="stylesheet" href="../css/style.css?v=21">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>

<div class="layout">

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
        <a href="../index.html">
            <i class="bi bi-house"></i> Inicio
        </a>

        <a href="gestion.php" class="activo">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="inventario.php">
        <i class="bi bi-box-seam"></i>
        Inventario
        </a>

        <?php if(puedeRegistrar()){ ?>
        <a href="registro.html">
        <i class="bi bi-plus-circle"></i> Registrar producto
        </a>
        <?php } ?>

        <?php if(puedeEditar()){ ?>
        <a href="actualizar.html">
        <i class="bi bi-pencil-square"></i> Actualizar producto
         </a>
        <?php } ?>

        <a href="consulta.php">
        <i class="bi bi-search"></i> Consultar producto
        </a>

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

        <!-- <a href="registro.html">
            <i class="bi bi-plus-circle"></i> Registrar producto
        </a>

        <a href="consulta.php">
            <i class="bi bi-search"></i> Consultar producto
        </a>

        <a href="actualizar.html">
            <i class="bi bi-pencil-square"></i> Actualizar precio
        </a>

        <a href="borrar.html">
            <i class="bi bi-trash"></i> Dar de baja
        </a> -->

        <?php if(puedeGestionarUsuarios()){ ?><a href="usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
        <?php } ?>

        <a href="contactoAdmin.php"><i class="bi bi-envelope-paper"></i>Contactar administrador</a>   

        <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i>Cerrar sesión</a>


    </nav>

</aside>

<main class="main">

    <div class="topbar">
        <h1>Panel de gestión</h1>
        <p>
            Control interno de productos informáticos, stock, marcas,
            categorías y bajas del sistema.
        </p>
    </div>

    <section class="dashboard">

        <div class="stat-card">
            <i class="bi bi-box-seam morado"></i>
            <div>
                <p>Total productos</p>
                <h2><?php echo $filaTotal["total"]; ?></h2>
                <span>Productos registrados</span>
            </div>
        </div>

        <div class="stat-card">
            <i class="bi bi-check-circle verde"></i>
            <div>
                <p>Productos activos</p>
                <h2><?php echo $filaActivos["activos"]; ?></h2>
                <span>Disponibles en sistema</span>
            </div>
        </div>

        <div class="stat-card">
            <i class="bi bi-exclamation-triangle naranja"></i>
            <div>
                <p>Sin stock</p>
                <h2><?php echo $filaStock["sinstock"]; ?></h2>
                <span>Cantidad igual a 0</span>
            </div>
        </div>

        <div class="stat-card">
            <i class="bi bi-trash rojo"></i>
            <div>
                <p>Dados de baja</p>
                <h2><?php echo $filaBaja["baja"]; ?></h2>
                <span>Estado del producto: Baja</span>
            </div>
        </div>

    </section>

    <div class="topbar">
        <h1>Gestión de productos</h1>
        <p>Accesos rápidos para administrar el inventario de la tienda.</p>
    </div>

    <section class="acciones-home">

        <a href="registro.html" class="accion">
            <i class="bi bi-plus-circle"></i>
            <h3>Registrar producto</h3>
            <p>Añadir un nuevo producto informático al inventario.</p>
        </a>

        <a href="consulta.php" class="accion">
            <i class="bi bi-search"></i>
            <h3>Consultar producto</h3>
            <p>Buscar precio, stock, marca, categoría e imagen del producto.</p>
        </a>

        <a href="actualizar.html" class="accion">
            <i class="bi bi-pencil-square"></i>
            <h3>Actualizar precio</h3>
            <p>Modificar el precio de un producto registrado.</p>
        </a>

        <a href="borrar.html" class="accion danger">
            <i class="bi bi-trash"></i>
            <h3>Dar de baja</h3>
            <p>Cambiar el estado del producto a Baja sin eliminarlo.</p>
        </a>

    </section>

    <div class="topbar" style="margin-top:35px;">
        <h1>Categorías</h1>
        <p>Organización principal del catálogo de productos.</p>
    </div>

    <section class="acciones-home">

        <div class="accion">
            <i class="bi bi-laptop"></i>
            <h3>Portátiles</h3>
            <p>Lenovo, MacBook y equipos profesionales.</p>
        </div>

        <div class="accion">
            <i class="bi bi-gpu-card"></i>
            <h3>Componentes</h3>
            <p>Tarjetas gráficas y hardware avanzado.</p>
        </div>

        <div class="accion">
            <i class="bi bi-display"></i>
            <h3>Monitores</h3>
            <p>Pantallas para oficina, diseño y productividad.</p>
        </div>

        <div class="accion">
            <i class="bi bi-keyboard"></i>
            <h3>Periféricos</h3>
            <p>Teclados, ratones y accesorios de trabajo.</p>
        </div>

    </section>

    <div class="topbar" style="margin-top:35px;">
        <h1>Marcas principales</h1>
        <p>Fabricantes disponibles dentro del inventario.</p>
    </div>

    <section class="acciones-home">

        <div class="accion">
            <i class="bi bi-pc-display"></i>
            <h3>Lenovo</h3>
            <p>Portátiles y equipos para empresa.</p>
        </div>

        <div class="accion">
            <i class="bi bi-apple"></i>
            <h3>Apple</h3>
            <p>MacBook y dispositivos de alto rendimiento.</p>
        </div>

        <div class="accion">
            <i class="bi bi-memory"></i>
            <h3>Samsung</h3>
            <p>Almacenamiento SSD y componentes.</p>
        </div>

        <div class="accion">
            <i class="bi bi-printer"></i>
            <h3>HP</h3>
            <p>Impresoras y soluciones para oficina.</p>
        </div>

    </section>

</main>

</div>

</body>
</html>

<?php mysqli_close($conexion); ?>
<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

$sql = "SELECT *
        FROM historial_movimientos
        ORDER BY fecha DESC";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Historial | It Manager Pro</title>

<link rel="stylesheet" href="../css/style.css?v=100">
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
        <a href="../index.html"><i class="bi bi-house"></i> Inicio</a>
        <a href="gestion.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="inventario.php"><i class="bi bi-box-seam"></i> Inventario</a>
        <a href="consulta.php"><i class="bi bi-search"></i> Consultar producto</a>

        <?php if(puedeRegistrar()){ ?>
            <a href="registro.html"><i class="bi bi-plus-circle"></i> Registrar producto</a>
        <?php } ?>

        <?php if(puedeEditar()){ ?>
            <a href="actualizar.html"><i class="bi bi-pencil-square"></i> Actualizar producto</a>
        <?php } ?>

        <?php if(puedeEliminar()){ ?>
            <a href="borrar.html"><i class="bi bi-trash"></i> Dar de baja producto</a>
        <?php } ?>

        <a href="historial.php" class="activo">
            <i class="bi bi-clock-history"></i> Historial
        </a>

        <?php if(puedeGestionarUsuarios()){ ?>
        <a href="usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
        <?php } ?>

        <a href="contactoAdmin.php">
        <i class="bi bi-envelope-paper"></i>
        Contactar administrador
        </a> 

        <a href="../login/logout.php">
            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
        </a>
    </nav>

</aside>

<main class="main inventario-bg">

    <div class="topbar">
        <h1><i class="bi bi-clock-history"></i> Historial de movimientos</h1>
        <p>Registro de acciones realizadas por los usuarios del sistema.</p>
    </div>

  
    <div class="resultado inventario-card">

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acción</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Detalle</th>
                </tr>
            </thead>

            <tbody>

            <?php if(mysqli_num_rows($resultado) > 0){ ?>

                <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

                    <tr>
                        <td><?php echo $fila["fecha"]; ?></td>
                        <td><?php echo $fila["nombre_usuario"]; ?></td>
                        <td><?php echo $fila["rol"]; ?></td>
                        <td><?php echo $fila["accion"]; ?></td>
                        <td><?php echo $fila["codigo_producto"]; ?></td>
                        <td><?php echo $fila["producto"]; ?></td>
                        <td><?php echo $fila["detalle"]; ?></td>
                    </tr>

                <?php } ?>

            <?php }else{ ?>

                <tr>
                    <td colspan="7">No hay movimientos registrados.</td>
                </tr>

            <?php } ?>

            </tbody>
        </table>

    </div>

</main>

</div>

</body>
</html>

<?php mysqli_close($conexion); ?>
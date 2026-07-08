<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

if(!puedeGestionarUsuarios()){
    header("Location: gestion.php");
    exit();
}

$sql = "SELECT *
        FROM usuarios
        ORDER BY id_usuario";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de usuarios</title>

<link rel="stylesheet" href="../css/style.css?v=120">
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

        <a href="historial.php"><i class="bi bi-clock-history"></i> Historial</a>

        <a href="usuarios.php" class="activo"><i class="bi bi-people"></i> Usuarios</a>

        <a href="contactoAdmin.php">
        <i class="bi bi-envelope-paper"></i>Contactar administrador</a> 

        <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
    </nav>

</aside>

<main class="main inventario-bg">

    <div class="topbar">
        <h1><i class="bi bi-people"></i> Gestión de usuarios</h1>
        <p>Alta, consulta y baja de usuarios del sistema.</p>
    </div>

    <div class="resultado">

        <h2><i class="bi bi-person-plus"></i> Crear nuevo usuario</h2>

        <form action="../php/guardarUsuario.php" method="post">

            <label>Nombre completo</label>
            <input type="text" name="fnombre" required>

            <label>Usuario</label>
            <input type="text" name="fusuario" required>

            <label>Contraseña</label>
            <input type="text" name="fpassword" required>

            <label>Rol</label>
            <select name="frol" required>
                <option value="Administrador">Administrador</option>
                <option value="Vendedor">Vendedor</option>
                <option value="Invitado">Invitado</option>
            </select>

            <button type="submit">
                <i class="bi bi-save"></i> Guardar usuario
            </button>

        </form>

    </div>

    <div class="resultado inventario-card">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

            <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

                <tr>
                    <td><?php echo $fila["id_usuario"]; ?></td>
                    <td><?php echo $fila["nombre"]; ?></td>
                    <td><?php echo $fila["usuario"]; ?></td>
                    <td><?php echo $fila["rol"]; ?></td>
                    <td><?php echo $fila["estado"]; ?></td>

                    <td>
                        <form action="../php/cambiarEstadoUsuario.php" method="post">
                            <input type="hidden" name="fid_usuario" value="<?php echo $fila["id_usuario"]; ?>">
                            <input type="hidden" name="festado" value="<?php echo $fila["estado"]; ?>">

                            <?php if($fila["estado"] == "Activo"){ ?>
                                <button class="btn-icono danger" title="Dar de baja">
                                    <i class="bi bi-person-x"></i>
                                </button>
                            <?php }else{ ?>
                                <button class="btn-icono" title="Reactivar">
                                    <i class="bi bi-person-check"></i>
                                </button>
                            <?php } ?>
                        </form>
                    </td>
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
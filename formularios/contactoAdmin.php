<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Contacto administrador</title>

<link rel="stylesheet" href="../css/style.css?v=90">
<!-- <link rel="stylesheet" href="../css/style.css?v=80"> -->
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

        <?php if(puedeRegistrar()){ ?>
            <a href="registro.html"><i class="bi bi-plus-circle"></i> Registrar producto</a>
        <?php } ?>

        <?php if(puedeEditar()){ ?>
            <a href="actualizar.html"><i class="bi bi-pencil-square"></i> Actualizar producto</a>
        <?php } ?>

        <?php if(puedeEliminar()){ ?>
            <a href="borrar.html"><i class="bi bi-trash"></i> Dar de baja producto</a>
        <?php } ?>

        <a href="historial.php" class="activo"><i class="bi bi-clock-history"></i> Historial</a>

        <?php if(puedeGestionarUsuarios()){ ?>
        <a href="usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
        <?php } ?>

        <a href="contactoAdmin.php"><i class="bi bi-envelope-paper"></i>Contactar administrador</a> 


        <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
    </nav>

</aside>

<div class="contenedor-panel">

<div class="form-card">

<h1>
<i class="bi bi-envelope-paper"></i>
Contacto administrador
</h1>

<form action="../php/enviarCorreo.php" method="post">

<label>Nombre usuario</label>

<input type="text"
       name="fnombre"
       value="<?php echo $_SESSION["nombre"]; ?>"
       readonly>

<label>Correo administrador</label>

<input type="email"
       name="fcorreo"
       value="administrador@itmanagerpro.com"
       required>

<label>Tipo de incidencia</label>

<select name="ftipo">

<option>Consulta general</option>

<option>Solicitud de compra</option>

<option>Error de precio</option>

<option>Producto defectuoso</option>

<option>Problema inventario</option>

<option>Stock bajo</option>

</select>

<label>Asunto</label>

<input type="text"
       name="fasunto"
       required>

<label>Mensaje</label>

<textarea name="fmensaje" rows="8" required></textarea>

<!-- <textarea name="fmensaje"
          rows="8"
          required></textarea> -->

<button type="submit">

<i class="bi bi-send"></i>

Enviar correo

</button>

</form>

<a href="inventario.php" class="boton">
    <i class="bi bi-arrow-left"></i>
    Volver
</a>

</div>

</div>
</div>


</body>
</html>
<?php

include("../includes/seguridad.php");

$nombre = $_REQUEST["fnombre"];
$correo = $_REQUEST["fcorreo"];
$tipo = $_REQUEST["ftipo"];
$asunto = $_REQUEST["fasunto"];
$mensaje = $_REQUEST["fmensaje"];

$textoFinal =
"USUARIO: ".$nombre."\n\n".
"TIPO DE INCIDENCIA: ".$tipo."\n\n".
"MENSAJE:\n".$mensaje;

$enviado = mail($correo, $asunto, $textoFinal);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Correo enviado</title>

<!-- <link rel="stylesheet" href="../css/style.css?v=90"> -->
<link rel="stylesheet" href="../css/style.css?v=80">
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
        <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
    </nav>

</aside>

<div class="contenedor-panel">

<div class="resultado">

<?php if($enviado){ ?>

<h1>
<i class="bi bi-check-circle verde"></i>
Correo enviado correctamente
</h1>

<p class="texto-info">

La incidencia ha sido enviada al administrador.

</p>

<?php }else{ ?>

<h1>
<i class="bi bi-exclamation-triangle naranja"></i>
Error al enviar correo
</h1>

<p class="texto-info">

La función mail() no ha podido enviar el correo.

</p>

<?php } ?>

<a href="../formularios/contactoAdmin.php"
   class="boton">

<i class="bi bi-arrow-left"></i>

Volver

</a>

</div>
</div>
</div>

</body>
</html>
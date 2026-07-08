<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

$codigo = $_REQUEST["fcodigo"];

$sql = "SELECT *
        FROM productos
        WHERE codigo = $codigo";

$resultado = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Aviso de stock bajo</title>
<link rel="stylesheet" href="../css/style.css?v=999">
<!-- <link rel="stylesheet" href="../css/style.css?v=70"> -->
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
        <a href="consulta.php"><i class="bi bi-search"></i> Consultar producto</a>
        <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
    </nav>

</aside>

<div class="contenedor-panel">

    <div class="resultado">

        <h1><i class="bi bi-envelope-exclamation"></i> Aviso de stock bajo</h1>

        <?php if($fila){ ?>

            <p class="texto-info">
                Se enviará un aviso al administrador para reponer stock.
            </p>

            <img src="../img/<?php echo $fila["imagen"]; ?>" class="producto-img">

            <table>
                <tr><th>Código</th><td><?php echo $fila["codigo"]; ?></td></tr>
                <tr><th>Producto</th><td><?php echo $fila["nombre"]; ?></td></tr>
                <tr><th>Stock actual</th><td><?php echo $fila["cantidad"]; ?> unidades</td></tr>
                <tr><th>Categoría</th><td><?php echo $fila["categoria"]; ?></td></tr>
                <tr><th>Marca</th><td><?php echo $fila["marca"]; ?></td></tr>
            </table>

            

            <form action="../php/enviarAvisoStock.php" method="post">

                <input type="hidden" name="fcodigo" value="<?php echo $fila["codigo"]; ?>">
                <input type="hidden" name="fproducto" value="<?php echo $fila["nombre"]; ?>">
                <input type="hidden" name="fstock" value="<?php echo $fila["cantidad"]; ?>">
                <input type="hidden" name="fcategoria" value="<?php echo $fila["categoria"]; ?>">
                <input type="hidden" name="fmarca" value="<?php echo $fila["marca"]; ?>">
                <input type="hidden" name="fimagen" value="<?php echo $fila["imagen"]; ?>">

                <label>Correo administrador</label>
                <input type="email" name="fcorreo" value="administrador@itmanagerpro.com" required>

                <label>Asunto</label>
                <input type="text" name="fasunto" value="Aviso de stock bajo - It Manager Pro" required>

                <label>Observaciones del administrador</label>

               <textarea name="fmensaje" rows="5" required>Se recomienda revisar el inventario y realizar la reposición del producto lo antes posible.</textarea>

                <button type="submit">
                    <i class="bi bi-envelope"></i> Enviar aviso
                </button>

            </form>

        <?php }else{ ?>

            <h2>Producto no encontrado</h2>

        <?php } ?>

        <a href="inventario.php" class="boton">
            <i class="bi bi-arrow-left"></i> Volver al inventario
        </a>

    </div>

</div>

</body>
</html>

<?php mysqli_close($conexion); ?>
<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

$sql = "SELECT *
        FROM productos
        ORDER BY codigo";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Inventario PDF</title>

<style>
body{
    font-family:Arial, sans-serif;
    padding:30px;
}

h1{
    text-align:center;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:25px;
}

th{
    background:#111827;
    color:white;
    padding:10px;
}

td{
    border:1px solid #ccc;
    padding:8px;
    font-size:13px;
}

.fecha{
    text-align:right;
    margin-bottom:20px;
}

.boton-imprimir{
    display:block;
    width:220px;
    margin:20px auto;
    padding:12px;
    background:#d9a528;
    color:white;
    text-align:center;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
}

@media print{
    .boton-imprimir{
        display:none;
    }
}

.boton-volver{
    display:block;
    width:220px;
    margin:15px auto 25px auto;
    padding:12px;
    background:#374151;
    color:white;
    text-align:center;
    border-radius:10px;
    text-decoration:none;
    font-weight:bold;
}

.boton-volver:hover{
    background:#111827;
}
</style>
</head>

<body>

<h1>Inventario - It Manager Pro</h1>

<p class="fecha">
    Fecha: <?php echo date("d/m/Y H:i"); ?>
</p>

<a href="#" onclick="window.print()" class="boton-imprimir">
    Imprimir / Guardar PDF
</a>

<a href="../formularios/inventario.php" class="boton-volver">
    ← Volver al inventario
</a>

<table>
    <tr>
        <th>Código</th>
        <th>Producto</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Categoría</th>
        <th>Marca</th>
        <th>Estado</th>
    </tr>

    <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
        <tr>
            <td><?php echo $fila["codigo"]; ?></td>
            <td><?php echo $fila["nombre"]; ?></td>
            <td><?php echo $fila["precio"]; ?> €</td>
            <td><?php echo $fila["cantidad"]; ?></td>
            <td><?php echo $fila["categoria"]; ?></td>
            <td><?php echo $fila["marca"]; ?></td>
            <td><?php echo $fila["estado"]; ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>

<?php mysqli_close($conexion); ?>
<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/** @var mysqli $conexion */
include("../bd/conexion.php");

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=inventario.xls");

$sql = "SELECT *
        FROM productos
        ORDER BY codigo";

$resultado = mysqli_query($conexion, $sql);
?>

<table border="1">
    <tr>
        <th>Código</th>
        <th>Producto</th>
        <th>Descripción</th>
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
            <td><?php echo $fila["descripcion"]; ?></td>
            <td><?php echo $fila["precio"]; ?> €</td>
            <td><?php echo $fila["cantidad"]; ?></td>
            <td><?php echo $fila["categoria"]; ?></td>
            <td><?php echo $fila["marca"]; ?></td>
            <td><?php echo $fila["estado"]; ?></td>
        </tr>
    <?php } ?>
</table>

<?php mysqli_close($conexion); ?>
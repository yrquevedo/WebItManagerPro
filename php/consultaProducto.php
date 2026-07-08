<?php

include("../includes/seguridad.php");
include("../includes/permisos.php");
/** @var mysqli $conexion */
include("../bd/conexion.php");

// Inicializamos las variables
$codigo = "";
$precio = "";
$resultado = false;
$stmt = null;


// Comprueba si se ha enviado un código de producto
if(!empty($_REQUEST["fcodigo"])){

    // Guarda el código introducido
    $codigo = $_REQUEST["fcodigo"];

    // Consulta preparada
    $sql = "SELECT *
            FROM productos
            WHERE codigo = ?";

    // Prepara la consulta
    $stmt = mysqli_prepare($conexion, $sql);

    // Asocia el valor del código al símbolo ?
    // "i" indica que es un número entero
    mysqli_stmt_bind_param($stmt, "i", $codigo);

    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado del SELECT
    $resultado = mysqli_stmt_get_result($stmt);

}


// Comprueba si se ha seleccionado un producto del desplegable
elseif(!empty($_REQUEST["fproducto"])){

    // Guarda el código del producto seleccionado
    $codigo = $_REQUEST["fproducto"];

    // Consulta preparada
    $sql = "SELECT *
            FROM productos
            WHERE codigo = ?";

    // Prepara la consulta
    $stmt = mysqli_prepare($conexion, $sql);

    // Asocia el código con el símbolo ?
    mysqli_stmt_bind_param($stmt, "i", $codigo);

    // Ejecuta la consulta
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado
    $resultado = mysqli_stmt_get_result($stmt);

}


// Comprueba si se ha introducido un precio máximo
elseif(!empty($_REQUEST["fprecio"])){

    // Guarda el precio introducido
    $precio = $_REQUEST["fprecio"];

    // Consulta preparada
    $sql = "SELECT *
            FROM productos
            WHERE precio <= ?
            AND estado = 'Activo'
            ORDER BY precio";

    // Prepara la consulta
    $stmt = mysqli_prepare($conexion, $sql);

    // "d" indica un número decimal (double)
    mysqli_stmt_bind_param($stmt, "d", $precio);

    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado del SELECT
    $resultado = mysqli_stmt_get_result($stmt);

}
?>



<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Consulta producto</title>

<link rel="stylesheet" href="../css/style.css?v=40">
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

        <?php if(puedeRegistrar()){ ?>
        <a href="../formularios/registro.html">
        <i class="bi bi-plus-circle"></i> Registrar producto
        </a>
        <?php } ?>

        <?php if(puedeEditar()){ ?>
        <a href="../formularios/actualizar.html">
        <i class="bi bi-pencil-square"></i> Actualizar producto
         </a>
        <?php } ?>

        <a href="../formularios/consulta.php" class="activo">
        <i class="bi bi-search"></i> Consultar producto
        </a>

        <?php if(puedeEliminar()){ ?>
        <a href="../formularios/borrar.html">
        <i class="bi bi-trash"></i> Dar de baja producto
         </a>
        <?php } ?>

        <?php if(puedeGestionarUsuarios()){ ?>
        <a href="../formularios/usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
        <?php } ?>

        <a href="../login/logout.php">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
        </a>
        <!-- <a href="../index.html"><i class="bi bi-house"></i> Inicio</a>
        <a href="../formularios/gestion.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="../formularios/inventario.php"><i class="bi bi-box-seam"></i> Inventario</a>
        <a href="../formularios/registro.html"><i class="bi bi-plus-circle"></i> Registrar producto</a>
        <a href="../formularios/actualizar.html"><i class="bi bi-pencil-square"></i> Actualizar producto</a>
        <a href="../formularios/consulta.php" class="activo"><i class="bi bi-search"></i> Consultar producto</a>
        <a href="../formularios/borrar.html"><i class="bi bi-trash"></i> Dar de baja producto</a> -->
    </nav>
</aside>

<div class="contenedor-panel">

    <div class="resultado">

        <h1><i class="bi bi-search"></i> Consulta producto</h1>

      <?php if($resultado && mysqli_num_rows($resultado) > 0){ ?>

            <?php if($precio != ""){ ?>

                <p class="texto-info">
                    Productos encontrados con precio menor o igual a
                    <strong><?php echo $precio; ?> €</strong>
                </p>

                <table>
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
                            <tr>
                                <td>
                                    <img src="../img/<?php echo $fila["imagen"]; ?>" class="mini-img">
                                </td>
                                <td><?php echo $fila["codigo"]; ?></td>
                                <td><?php echo $fila["nombre"]; ?></td>
                                <td><?php echo $fila["precio"]; ?> €</td>
                                <td><?php echo $fila["cantidad"]; ?></td>
                                <td><?php echo $fila["categoria"]; ?></td>
                                <td><?php echo $fila["marca"]; ?></td>
                                <td><?php echo $fila["estado"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            <?php }else{ ?>

                <?php $fila = mysqli_fetch_assoc($resultado); ?>

                <img src="../img/<?php echo $fila["imagen"]; ?>" class="producto-img">

                <table>
                    <tr><th>Código</th><td><?php echo $fila["codigo"]; ?></td></tr>
                    <tr><th>Nombre</th><td><?php echo $fila["nombre"]; ?></td></tr>
                    <tr><th>Descripción</th><td><?php echo $fila["descripcion"]; ?></td></tr>
                    <tr><th>Precio</th><td><?php echo $fila["precio"]; ?> €</td></tr>
                    <tr><th>Stock</th><td><?php echo $fila["cantidad"]; ?></td></tr>
                    <tr><th>Categoría</th><td><?php echo $fila["categoria"]; ?></td></tr>
                    <tr><th>Marca</th><td><?php echo $fila["marca"]; ?></td></tr>
                    <tr><th>Estado</th><td><?php echo $fila["estado"]; ?></td></tr>
                </table>

            <?php } ?>

        <?php }else{ ?>

            <h2><i class="bi bi-exclamation-triangle rojo"></i> Producto no encontrado</h2>

        <?php } ?>

        <div class="botones-final">

    <a href="../formularios/inventario.php" class="boton">
        <i class="bi bi-box-seam"></i>
        Volver al inventario
    </a>

    <a href="../formularios/consulta.php" class="boton">
        <i class="bi bi-search"></i>
        Nueva consulta
    </a>

</div>

    </div>

</div>

</body>
</html>

<?php

// Si existe una consulta preparada, la cerramos
if($stmt){
    mysqli_stmt_close($stmt);
}

// Cerramos la conexión con la base de datos
mysqli_close($conexion);

?>




<!-- aqui va apertura de php
/** @var mysqli $conexion */
include("../bd/conexion.php");

$codigo = "";
$precio = "";
$sql = "";

if(!empty($_REQUEST["fcodigo"])){
    $codigo = $_REQUEST["fcodigo"];

    $sql = "SELECT *
            FROM productos
            WHERE codigo = $codigo";

}elseif(!empty($_REQUEST["fproducto"])){
    $codigo = $_REQUEST["fproducto"];

    $sql = "SELECT *
            FROM productos
            WHERE codigo = $codigo";

}elseif(!empty($_REQUEST["fprecio"])){
    $precio = $_REQUEST["fprecio"];

    $sql = "SELECT *
            FROM productos
            WHERE precio <= $precio
            AND estado = 'Activo'
            ORDER BY precio";
}

$resultado = false;

if($sql != ""){
    $resultado = mysqli_query($conexion, $sql);
}
aqui va cierre -->
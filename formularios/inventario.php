<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");



/** @var mysqli $conexion */
include("../bd/conexion.php");

/* Todos los productos */
$sql = "SELECT *
        FROM productos
        ORDER BY codigo";
$resultado = mysqli_query($conexion, $sql);

/* Valor total del inventario activo */
$sqlValor = "SELECT SUM(precio * cantidad) total
             FROM productos
             WHERE estado = 'Activo'";
$resultadoValor = mysqli_query($conexion, $sqlValor);
$filaValor = mysqli_fetch_assoc($resultadoValor);

/* Últimos productos registrados */
$sqlUltimos = "SELECT *
               FROM productos
               ORDER BY codigo DESC
               LIMIT 5";
$resultadoUltimos = mysqli_query($conexion, $sqlUltimos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Inventario | WebIt Manager Pro</title>

<link rel="stylesheet" href="../css/style.css?v=61">
<!-- <link rel="stylesheet" href="../css/style.css?v=50"> -->
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

    <a href="inventario.php" class="activo"><i class="bi bi-box-seam"></i> Inventario</a>

    <?php if(puedeRegistrar()){ ?>
        <a href="registro.html">
            <i class="bi bi-plus-circle"></i> Registrar producto
        </a>
    <?php } ?>

     <a href="consulta.php"><i class="bi bi-search"></i> Consultar producto</a>

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

    <a href="contactoAdmin.php">
    <i class="bi bi-envelope-paper"></i>
    Contactar administrador
    </a>

    <a href="../login/logout.php">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
    </a>

</nav>
        <!-- <a href="../index.html"><i class="bi bi-house"></i> Inicio</a>
        <a href="gestion.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="inventario.php" class="activo"><i class="bi bi-box-seam"></i> Inventario</a>
        <a href="registro.html"><i class="bi bi-plus-circle"></i> Registrar producto</a>
        <a href="actualizar.html"><i class="bi bi-pencil-square"></i> Actualizar producto</a>
        <a href="consulta.php"><i class="bi bi-search"></i> Consultar producto</a>
        <a href="borrar.html"><i class="bi bi-trash"></i> Dar de baja producto</a>
        <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a> -->

</aside>

<main class="main inventario-bg">

    <div class="topbar">
        <h1><i class="bi bi-box-seam"></i> Inventario</h1>
        <p>Listado completo de productos registrados en la tienda informática.</p>
    </div>

    <section class="dashboard">

        <div class="stat-card">
            <i class="bi bi-cash-coin verde"></i>
            <div>
                <p>Valor total inventario</p>
                <h2><?php echo number_format($filaValor["total"], 2, ",", "."); ?> €</h2>
                <span>Productos activos</span>
            </div>
        </div>

    </section>

    <div class="buscador">
        <input type="text" id="buscar" placeholder="🔍 Buscar producto...">

        <select id="filtroCategoria">
            <option value="">Todas las categorías</option>
            <option value="Portátiles">Portátiles</option>
            <option value="Monitores">Monitores</option>
            <option value="Componentes">Componentes</option>
            <option value="Impresoras">Impresoras</option>
            <option value="Almacenamiento">Almacenamiento</option>
            <option value="Periféricos">Periféricos</option>
        </select>
    </div><!-- Fin buscador -->

<div class="acciones-exportar">

    <a href="../php/exportarExcel.php" class="boton">
        <i class="bi bi-file-earmark-excel"></i>
        Exportar Excel
    </a>

    <a href="../php/exportarPDF.php" class="boton">
        <i class="bi bi-file-earmark-pdf"></i>
        Exportar PDF
    </a>

</div>

   <div class="resultado inventario-card">

        <table id="tablaProductos">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>

                <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

                    <tr>
                        <td>
                            <img src="../img/<?php echo $fila["imagen"]; ?>" class="mini-img">
                        </td>

                        <td><?php echo $fila["codigo"]; ?></td>

                        <td class="nombre-producto">
                        <?php echo $fila["nombre"]; ?>
                        </td>

                        <td><?php echo $fila["categoria"]; ?></td>

                        <td><?php echo $fila["marca"]; ?></td>

                        <td><?php echo $fila["precio"]; ?> €</td>

                        <td>
                            <?php if($fila["cantidad"] <= 10){ ?>
                                <span class="stock-bajo">
                                    <?php echo $fila["cantidad"]; ?> unidades
                                </span>
                            <?php }else{ ?>
                                <?php echo $fila["cantidad"]; ?>
                            <?php } ?>
                        </td>

                        <td><?php echo $fila["estado"]; ?></td>

                        <td>
                            <div class="acciones-tabla">

                            <form action="../php/consultaProducto.php" method="post">
    <input type="hidden" name="fcodigo" value="<?php echo $fila["codigo"]; ?>">

    <button type="submit" class="btn-icono" title="Ver producto">
        <i class="bi bi-eye"></i>
    </button>
</form>

<!-- se ha añadid esto para el email -->
<?php if($fila["cantidad"] <= 10 && puedeEditar()){ ?>

    <form action="avisoStock.php" method="post">
        <input type="hidden" name="fcodigo" value="<?php echo $fila["codigo"]; ?>">

        <button type="submit" class="btn-icono" title="Avisar stock bajo">
            <i class="bi bi-envelope-exclamation"></i>
        </button>
    </form>

<?php } ?>

<?php if(puedeEditar()){ ?>

    <form action="../php/actualizarProducto.php" method="post">
        <input type="hidden" name="fcodigo" value="<?php echo $fila["codigo"]; ?>">

        <button type="submit" class="btn-icono" title="Editar producto">
            <i class="bi bi-pencil-square"></i>
        </button>
    </form>

<?php } ?>

<?php if(puedeEliminar()){ ?>

    <?php if($fila["estado"] == "Activo"){ ?>

        <form action="../php/borrarProducto.php" method="post">
            <input type="hidden" name="fcodigo" value="<?php echo $fila["codigo"]; ?>">

            <button type="submit" class="btn-icono danger" title="Dar de baja">
                <i class="bi bi-trash"></i>
            </button>
        </form>

    <?php }else{ ?>

        <form action="../php/reactivarProducto.php" method="post">
            <input type="hidden" name="fcodigo" value="<?php echo $fila["codigo"]; ?>">

            <button type="submit" class="btn-icono" title="Reactivar producto">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </form>

    <?php } ?>

<?php } ?>

                            </div>
                        </td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>

    </div>

    <div class="topbar" style="margin-top:35px;">
        <h1><i class="bi bi-clock-history"></i> Últimos productos registrados</h1>
        <p>Los 5 productos añadidos más recientemente.</p>
    </div>

    <div class="resultado">

        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Stock</th>
                </tr>
            </thead>

            <tbody>
                <?php while($ultimo = mysqli_fetch_assoc($resultadoUltimos)){ ?>
                    <tr>
                        <td><?php echo $ultimo["codigo"]; ?></td>
                        <td><?php echo $ultimo["nombre"]; ?></td>
                        <td><?php echo $ultimo["marca"]; ?></td>
                        <td><?php echo $ultimo["precio"]; ?> €</td>
                        <td><?php echo $ultimo["cantidad"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

</main>

</div>

<script>
let buscar = document.getElementById("buscar");
let filtroCategoria = document.getElementById("filtroCategoria");

function filtrarInventario(){

    let texto = buscar.value.toLowerCase();
    let categoriaSeleccionada = filtroCategoria.value.toLowerCase();

    let filas = document.querySelectorAll("#tablaProductos tbody tr");

    filas.forEach(function(fila){

        let producto = fila.cells[2].textContent.toLowerCase();
        let categoria = fila.cells[3].textContent.toLowerCase();
        let marca = fila.cells[4].textContent.toLowerCase();

        let coincideTexto =
            producto.includes(texto) ||
            categoria.includes(texto) ||
            marca.includes(texto);

        let coincideCategoria =
            categoriaSeleccionada === "" ||
            categoria === categoriaSeleccionada;

        if(coincideTexto && coincideCategoria){
            fila.style.display = "";
        }else{
            fila.style.display = "none";
        }

    });
}

buscar.addEventListener("keyup", filtrarInventario);
filtroCategoria.addEventListener("change", filtrarInventario);
</script>

</body>
</html>

<?php mysqli_close($conexion); ?>
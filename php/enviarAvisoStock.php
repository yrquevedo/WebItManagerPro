<?php
include("../includes/seguridad.php");
include("../includes/permisos.php");

/* Cargamos PHPMailer instalado con Composer */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

/* Recogemos los datos enviados desde AvisoStock.php */
$codigo = $_REQUEST["fcodigo"];
$producto = $_REQUEST["fproducto"];
$stock = $_REQUEST["fstock"];
$categoria = $_REQUEST["fcategoria"];
$marca = $_REQUEST["fmarca"];
$imagen = $_REQUEST["fimagen"];
$correo = $_REQUEST["fcorreo"];
$asunto = $_REQUEST["fasunto"];
$mensaje = $_REQUEST["fmensaje"];

/* Creamos el mensaje final del correo */
$mensajeFinal =
"=========================================\n".
"      IT MANAGER PRO\n".
"      AVISO DE STOCK BAJO\n".
"=========================================\n\n".
"Hola,\n\n".
"El sistema ha detectado que un producto ha alcanzado un nivel bajo de existencias.\n\n".
"-----------------------------------------\n\n".
"Código del producto : ".$codigo."\n".
"Producto            : ".$producto."\n".
"Stock disponible    : ".$stock." unidades\n\n".
"-----------------------------------------\n\n".
"Observaciones del administrador:\n".
$mensaje."\n\n".
"-----------------------------------------\n\n".
"Se recomienda revisar el inventario y realizar la reposición del producto lo antes posible para evitar una rotura de stock.\n\n".
"Este mensaje ha sido generado automáticamente por el sistema.\n\n".
"-----------------------------------------\n".
"IT MANAGER PRO\n".
"Sistema de Gestión de Inventario\n";

/* Enviamos el correo con PHPMailer */
$mail = new PHPMailer(true);

try{

    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;

    
    $configMail = require("../config/mail.php");

    $mail->Username = $configMail["usuario"];
    $mail->Password = $configMail["password"];
   

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->CharSet = "UTF-8";

    $mail->setFrom($configMail["usuario"], "It Manager Pro");
    // $mail->setFrom("itmanagerproweb@gmail.com", "It Manager Pro");
    $mail->addAddress($correo);

    $rutaLogo = "../img/logo-email.jpg";
    $rutaProducto = "../img/".$imagen;

    if(file_exists($rutaLogo)){
    $mail->addEmbeddedImage($rutaLogo, "logoitmanager");
    }

    if(file_exists($rutaProducto)){
    $mail->addEmbeddedImage($rutaProducto, "imagenproducto");
}



    // $mail->addEmbeddedImage("../img/logo-email.jpg", "logoitmanager");
    // $mail->Subject = $asunto;
    // $mail->Body = $mensajeFinal;

    $mail->isHTML(true);

$mail->Subject = $asunto;

$mail->Body = "
<div style='font-family:Arial,sans-serif;background:#f7f8fa;padding:25px;'>

    <div style='max-width:760px;margin:auto;background:white;'>

        <div style='text-align:center;padding:25px 20px 15px;'>
            <img src='cid:logoitmanager' style='width:230px;max-width:100%;'>
        </div>

        <div style='text-align:center;padding:10px 20px 20px;'>
            <h2 style='margin:0;color:#111827;font-size:26px;'>
                📧 Aviso de stock bajo
            </h2>

            <p style='margin:10px 0 18px;color:#111827;font-size:16px;'>
                Hola, el sistema ha detectado un producto tiene stock bajo.
            </p>

            <div style='display:inline-block;background:#f3f4f6;border-radius:18px;padding:18px;border:1px solid #e5e7eb;'>
                <img src='cid:imagenproducto' style='width:170px;height:120px;object-fit:contain;display:block;'>
            </div>
        </div>

        <table style='width:100%;border-collapse:collapse;font-size:14px;margin-top:10px;'>
            <tr>
                <th style='width:35%;background:#111827;color:white;text-align:left;padding:13px;border:1px solid #d1d5db;'>Código</th>
                <td style='background:white;color:#111827;padding:13px;border:1px solid #d1d5db;'>".$codigo."</td>
            </tr>

            <tr>
                <th style='background:#111827;color:white;text-align:left;padding:13px;border:1px solid #d1d5db;'>Producto</th>
                <td style='background:white;color:#111827;padding:13px;border:1px solid #d1d5db;'>".$producto."</td>
            </tr>

            <tr>
                <th style='background:#111827;color:white;text-align:left;padding:13px;border:1px solid #d1d5db;'>Stock actual</th>
                <td style='background:white;color:#ef4444;padding:13px;border:1px solid #d1d5db;font-size:18px;font-weight:bold;'>".$stock." unidades</td>
            </tr>

            <tr>
                <th style='background:#111827;color:white;text-align:left;padding:13px;border:1px solid #d1d5db;'>Categoría</th>
                <td style='background:white;color:#111827;padding:13px;border:1px solid #d1d5db;'>".$categoria."</td>
            </tr>

            <tr>
                <th style='background:#111827;color:white;text-align:left;padding:13px;border:1px solid #d1d5db;'>Marca</th>
                <td style='background:white;color:#111827;padding:13px;border:1px solid #d1d5db;'>".$marca."</td>
            </tr>
        </table>

        <div style='margin:25px 40px;background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;padding:22px;color:#111827;'>
            <p style='font-weight:bold;margin-top:0;'>Observaciones del administrador:</p>
            <p style='margin-bottom:0;'>".$mensaje."</p>
        </div>

        <table style='width:100%;text-align:center;margin:25px 0;font-size:14px;color:#111827;'>
            <tr>
                <td style='padding:12px;'>
                    <strong>Fecha del aviso</strong><br>
                    ".date("d/m/Y")."
                </td>

                <td style='padding:12px;'>
                    <strong>Hora del aviso</strong><br>
                    ".date("H:i:s")."
                </td>

                <td style='padding:12px;'>
                    <strong>Enviado por</strong><br>
                    ".$_SESSION["nombre"]."
                </td>
            </tr>
        </table>

        <div style='background:#ecfdf5;border-top:4px solid #15803d;text-align:center;padding:30px;color:#111827;'>
            <p>Este mensaje ha sido generado automáticamente por el sistema.</p>
            <strong>Sistema automático - It Manager Pro</strong>
        </div>

    </div>

</div>
";

$mail->AltBody = $mensajeFinal;

    $mail->send();
    $enviado = true;
    $errorCorreo = "";

}catch(Exception $e){

    $enviado = false;
    $errorCorreo = $mail->ErrorInfo;

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Aviso enviado</title>

<link rel="stylesheet" href="../css/style.css?v=999">
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
        <a href="../formularios/consulta.php"><i class="bi bi-search"></i> Consultar producto</a>
        <a href="../login/logout.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
    </nav>

</aside>

<div class="contenedor-panel">

    <div class="form-card">

        <?php if($enviado){ ?>

            <h1><i class="bi bi-check-circle verde"></i> Aviso enviado correctamente</h1>

            <p class="texto-info">
                Se ha enviado un aviso de stock bajo para el producto
                <strong><?php echo $producto; ?></strong>
                con código
                <strong><?php echo $codigo; ?></strong>.
            </p>

        <?php }else{ ?>

            <h1><i class="bi bi-exclamation-triangle naranja"></i> No se pudo enviar el aviso</h1>

            <p class="texto-info">
                PHPMailer no pudo enviar el correo.
            </p>

            <p class="texto-info">
                Error: <?php echo $errorCorreo; ?>
            </p>

        <?php } ?>

        <table>
            <tr><th>Código</th><td><?php echo $codigo; ?></td></tr>
            <tr><th>Producto</th><td><?php echo $producto; ?></td></tr>
            <tr><th>Stock actual</th><td><?php echo $stock; ?> unidades</td></tr>
            <tr><th>Correo destino</th><td><?php echo $correo; ?></td></tr>
        </table>

        <a href="../formularios/inventario.php" class="boton">
            <i class="bi bi-box-seam"></i> Volver al inventario
        </a>

    </div>

</div>

</body>
</html>
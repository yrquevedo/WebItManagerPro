<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Acceso administrador</title>

<link rel="stylesheet" href="../css/style.css?v=70">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="login-page">

<div class="contenedor-panel">

    <div class="form-card">

        <h1><i class="bi bi-shield-lock"></i> Acceso administrador</h1>

        <p class="texto-info">
            Inicia sesión para poder gestionar productos.
        </p>

        <form action="validarLogin.php" method="post">

            <label>Usuario</label>
            <input type="text" name="fusuario" required>

            <label>Contraseña</label>
            <input type="password" name="fpassword" required>

            <button type="submit">
                <i class="bi bi-box-arrow-in-right"></i>
                Entrar
            </button>

        </form>

        <a href="../index.html" class="boton">
            <i class="bi bi-arrow-left"></i>
            Volver a la página pública
        </a>

    </div>

</div>

</body>
</html>
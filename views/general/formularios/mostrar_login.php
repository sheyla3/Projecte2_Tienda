<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body class="background_admin_login">
    <div class="login-page">
        <div class="form">
        <h2>Iniciar Sesión Administrador</h2>
            <form aria-label="formulario" class="login-form" action="index.php?controller=Admin&action=procesar_login" method="POST">
                <input aria-label="campo de texto" type="text" id="email" name="email" placeholder="usuario" required/>
                <input aria-label="campo de texto" type="password" placeholder="contraseña" id="password" name="password" required/>
                <input aria-label="Botón" type="submit" class="button" value="Iniciar Sesión">
            </form>
        </div>
    </div>
</body>

</html>
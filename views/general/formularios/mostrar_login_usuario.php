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
        <img src="views/img/inicia_sesion_1.png" alt="img" width="150" height="150">
        <h2>Inicia sesión</h2>
            <form class="login-form" action="index.php?controller=Usuario&action=procesar_login" method="POST"> 
                <input type="text" id="email" name="email" placeholder="Correo" required/>
                <input type="password" placeholder="Contraseña" id="password" name="password" required/>
                <a href="index.php?controller=usuario&action=mostrarLoginUsuario"> Olvidaste la contraseña? </a>
                <input type="submit" class="button" value="Iniciar Sesión">
            </form>
            <form action="">
            <a href="index.php?controller=usuario&action=crearUsuario" class="button">Crear cuenta</a>
        </div>
    </div>
</body>

</html>
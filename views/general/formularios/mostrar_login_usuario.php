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
        <img src="views/img/usuario.gif" aria-label="Imagen" alt="img" width="150" height="150" style="border-radius: 300px;box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.24), 0 5px 5px 0 rgba(0, 0, 0, 0.24);">
        <h2>Inicia sesión</h2>
            <form class="login-form" action="index.php?controller=Usuario&action=procesar_login" method="POST"> 
                <input type="text" aria-label="campo de texto" id="email" name="email" placeholder="Correo" required/>
                <input type="password" aria-label="campo de texto" placeholder="Contraseña" id="password" name="password" required/>
                <a href="index.php?controller=usuario&action=mostrarLoginUsuario" aria-label="Link" class="button-register">¿Olvidaste la contraseña?</a>
                <input type="submit" aria-label="Botón" class="button" value="Iniciar Sesión">
            </form>
            <a href="index.php?controller=usuario&action=crearUsuario" aria-label="Link" class="button-register">¿No estás registrado? Regístrate</a>
        </div>
    </div>
</body>

</html>

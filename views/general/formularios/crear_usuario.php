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
        <h2>Crear cuenta</h2>
        <form class="login-form" action="index.php?controller=Usuario&action=crearUsuario" method="POST" enctype="multipart/form-data">
            <input type="text" id="email" name="email" placeholder="Email" required/>
            <input type="password" placeholder="Contraseña" id="password" name="password" required/>
            <input type="text" id="name" name="name" placeholder="Nombre" required/>
            <input type="text" id="lastname" name="lastname" placeholder="Apellidos" required/>
            <input type="tel" id="phone" name="phone" placeholder="Teléfono" required/>
            <input type="text" id="address" name="address" placeholder="Dirección" required/>
            <input type="file" id="photo" name="photo" accept="image/*"> <!-- Campo para subir foto -->
            <input type="submit" class="button" value="Crear Cuenta">
        </form>
        <a href="index.php?controller=usuario&action=mostrarLoginUsuario">Ya tienes cuenta? Inicia sesión</a>
    </div>
</body>

</html>
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
            <form class="login-form" aria-label='formulario' action="index.php?controller=Usuario&action=crearUsuario" method="POST" enctype="multipart/form-data">
                <input type="text" id="email" aria-label="campo de texto" name="email" placeholder="Email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <?php
                if(isset($_GET['errorEmail'])){
                    echo '<div style="color:red;">' . $_GET['errorEmail'] . '</div>';
                }
                ?>
                <input type="password" aria-label="campo de texto" placeholder="Contraseña" id="password" name="password" required>
                <?php
                if(isset($_GET['errorPass'])){
                    echo '<div style="color:red;">' . $_GET['errorPass'] . '</div>';
                }
                ?>
                <input type="text" id="name" aria-label="campo de texto" name="name" placeholder="Nombre" required>
                <?php
                if(isset($_GET['errorTexto'])){
                    echo '<div style="color:red;">' . $_GET['errorTexto'] . '</div>';
                }
                ?>
                <input type="text" id="lastname" aria-label="campo de texto" name="lastname" placeholder="Apellidos" required>
                <?php
                if(isset($_GET['errorTexto'])){
                    echo '<div style="color:red;">' . $_GET['errorTexto'] . '</div>';
                } 
                ?>
                <input type="text" id="address" aria-label="campo de texto" name="address" placeholder="Dirección" required>
                <?php
                if(isset($_GET['errorTexto'])){
                    echo '<div style="color:red;">' . $_GET['errorTexto'] . '</div>';
                }
                ?>
                <input type="tel" id="phone" aria-label="campo de texto" name="phone" placeholder="Teléfono" required>
                <?php
                if(isset($_GET['errorTel'])){
                    echo '<div style="color:red;">' . $_GET['errorTel'] . '</div>';
                }
                ?>
                <input type="file" id="photo" aria-label="campo de texto" name="photo" accept="image/*"> <!-- Campo para subir foto -->
                <?php
                if(isset($_GET['errorSubir'])){
                    echo '<div style="color:red;">' . $_GET['errorSubir'] . '</div>';
                }
                ?>
                <?php
                if(isset($_GET['errorValidez'])){
                    echo '<div style="color:red;">' . $_GET['errorValidez'] . '</div>';
                }
                ?>
                <input type="submit" aria-label="Botón" class="button" value="Crear Cuenta">
            </form>
            <a href="index.php?controller=usuario&action=mostrarLoginUsuario" class="button-register">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</body>

</html>

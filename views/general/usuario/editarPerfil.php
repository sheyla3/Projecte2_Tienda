<body>
    <h1>Editar Perfil</h1>

    <?php if (isset($result)) {
        echo $result;
    } ?>

    <form action="index.php?controller=usuario&action=actualizarPerfil" method="post">
<div class='div1-user'>
    <div class='subdiv1-user'>
    <h2 class='profile-title-photo'>Editar Datos</h2>
        <div><img src='views/img/user.svg' width='30px' height='30px' class='image-profile-dades'><h3>Nombre: &nbsp</h3><input class='input-decoration' type="text" name="nombre" id="nombre" value="<?php echo $datosUser[0]['nombre']; ?>" required></div>
        <div><img src='views/img/user.svg' width='30px' height='30px' class='image-profile-dades'><h3>Apellidos: &nbsp</h3><input class='input-decoration' type="text" name="apellidos" id="apellidos" value="<?php echo $datosUser[0]['apellidos']; ?>" required></div>
        <div><img src='views/img/house.svg' width='30px' height='30px' class='image-profile-dades'><h3>Dirección: &nbsp</h3><input class='input-decoration' type="text" name="direccion" id="direccion" value="<?php echo $datosUser[0]['direccion']; ?>" required></div>
        <div><img src='views/img/phone.svg' width='30px' height='30px' class='image-profile-dades'><h3>Teléfono: &nbsp</h3><input class='input-decoration' type="tel" name="telefono" id="telefono" value="<?php echo $datosUser[0]['telf']; ?>" required></div>

        <input class='admin-panel-submit-link' type="submit" value="Actualizar Perfil">
        <button role='button' class='admin-panel-submit-link' onclick="goBack()">Volver Atrás</button>

    </div></div>
    </form>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>

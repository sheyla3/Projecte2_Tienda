<br><br><br> <br><br><br>
<?php if (isset($result)) {
    echo $result;
} ?>
<form action="index.php?controller=usuario&action=actualizarPerfil" method="post">

    <div class='div-user-edit'>
        <div class='subdiv1-user'>
            <h2 class='profile-title-photo'>Editar Datos</h2>
            <div class='div-edit-user'><img src='views/img/user.svg' aria-label='Imagen' width='30px' height='30px'
                    class='image-profile-dades'>
                <h3 class='input-edit-user'>Nombre: </h3><input class='input-decoration' type="text" name="nombre"
                    id="nombre" value="<?php echo $datosUser[0]['nombre']; ?>" required>
            </div>
            <div class='div-edit-user'><img src='views/img/user.svg' aria-label='Imagen' width='30px' height='30px'
                    class='image-profile-dades'>
                <h3 class='input-edit-user'>Apellidos: </h3><input class='input-decoration' type="text" name="apellidos"
                    id="apellidos" value="<?php echo $datosUser[0]['apellidos']; ?>" required>
            </div>
            <div class='div-edit-user'><img src='views/img/house.svg' aria-label='Imagen' width='30px' height='30px'
                    class='image-profile-dades'>
                <h3 class='input-edit-user'>Dirección: </h3><input class='input-decoration' type="text" name="direccion"
                    id="direccion" value="<?php echo $datosUser[0]['direccion']; ?>" required>
            </div>
            <div class='div-edit-user'><img src='views/img/phone.svg' aria-label='Imagen' width='30px' height='30px'
                    class='image-profile-dades'>
                <h3 class='input-edit-user'>Teléfono: </h3><input class='input-decoration' type="tel" name="telefono"
                    id="telefono" value="<?php echo $datosUser[0]['telf']; ?>" required>
            </div>

            <div class="edit-user-buttons">
                <button role="button" class='admin-panel-submit-link' type="submit" value="Actualizar Perfil">Actualizar
                    Perfil</button>
                <button role='button' class='admin-panel-submit-link' onclick="goBack()">Volver Atrás</button>
            </div>
        </div>
    </div>
</form>

<script>
    function goBack() {
        window.history.back();
    }
</script>
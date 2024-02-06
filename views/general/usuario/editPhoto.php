    <br /><br /><br />
    <h2 class='my-profile-title'>Mi perfil</h2>
    <div class='blue-line'></div>
    
    <div class='subdiv2-user-photo'>
        <h2 class='profile-title-photo'>Cambiar Foto</h2>

        <?php if (isset($errorSubir)) {
            echo $errorSubir;
        } ?>

        <form action="index.php?controller=usuario&action=editPhoto&email=<?php echo $datosUser[0]['correo']; ?>"
            method="post" enctype="multipart/form-data">
            <label for="nuevaFoto">Selecciona una nueva foto:</label><br><br>
            <input type="file" name="nuevaFoto" id="nuevaFoto" required accept="image/*">
            <br>
            <br>
            <button role="button" class='admin-panel-submit-link' type="submit" value="Actualizar Foto">Actualizar Imagen</button>
            <button role="button" class='admin-panel-submit-link' onclick="goBack()">Volver Atrás</button>

        </form>

        <!-- Botón para volver atrás -->

        <script>
            function goBack() {
                window.history.back();
            }
        </script>
<?php
echo "<br><br><br>";
echo "<h2 class='my-profile-title'>Mi perfil</h2>";
echo "<div class='blue-line'></div>";
echo "<br>";
echo "<div class='div1-user'>

        <div class='subdiv1-user'>
            <div><img src='views/img/email.svg' width='30px' height='30px' class='image-profile-dades'><h3>Correo: &nbsp</h3>" . $datosUser[0]['correo'] . "</div>
            <br>
            <div><img src='views/img/user.svg' width='30px' height='30px' class='image-profile-dades'><h3>Nombre: &nbsp</h3>" . $datosUser[0]['nombre'] . "</div>
            <br>
            <div><img src='views/img/user.svg' width='30px' height='30px' class='image-profile-dades'><h3>Apellidos: &nbsp</h3>" . $datosUser[0]['apellidos'] . "</div>
            <br>
            <div><img src='views/img/house.svg' width='30px' height='30px' class='image-profile-dades'><h3>Dirección: &nbsp</h3>" . $datosUser[0]['direccion'] . "</div>
            <br>
            <div><img src='views/img/phone.svg' width='30px' height='30px' class='image-profile-dades'><h3>Teléfono: &nbsp</h3>" . $datosUser[0]['telf'] . "</div>
            <br>
            <div><a class='admin-panel-submit-link' href='index.php?controller=usuario&action=mostrarEditarPerfil&email=" . $datosUser[0]['correo'] . "'>Editar Datos</a></div>
        </div>

        <div class='subdiv2-user'>
            <h2 class='profile-title-photo'>Foto de perfil</h2>
            <br><br>
            <div><img src='" . $datosUser[0]['foto'] ."' alt='Foto de perfil' width='500px'></div>
            <br>
            <div class='user-profile-row'><a class='admin-panel-submit-link' href='index.php?controller=usuario&action=mostrarFormUserPhoto&email=" . $datosUser[0]['correo'] . "'>Cambiar foto</a>
        </div>
    </div>";
echo "
    </div>";
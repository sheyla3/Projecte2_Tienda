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
        <br></div>
        <div class='subdiv2-user'>
        <h2 class='profile-title-photo'>Foto de perfil</h2>
        <br><br>
        <div><img src='" . $datosUser[0]['foto'] . "' alt='Foto de perfil' width='500px'></div>
        <br>
        </div>
    </div>";

// <form  class='subdiv2-user' method='post' ENCTYPE='multipart/form-data' action='index.php?controller=Perfil&action=cambiarFoto'>
//     <div class='user-profile-row'><img src=' ".$datosUser['foto']."' height='200px' width='170px'></div>
//     <div class='user-profile-row'><input type='text' class='ocult' id='oldimagen' name='oldimagen' value='".$datosUser['foto']."'></div>
//     <div class='user-profile-row'><input required type='file' class='foto-input' id='imagen' name='imagen'></div>
//     <div class='user-profile-row'><button class='profile-save-button' type='submit'><img class='save-icon' src='./img/save.svg' /></button></div>

// </form>
echo "
    </div>";
?>
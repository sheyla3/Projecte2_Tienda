<?php
echo "
    <form class='admin-panel-form' action='index.php?controller=Admin&action=botonCrearCategoria' method='POST'>
        <h2 class='h2-form'>Crear Categoría</h2>    

        <label for='nombre'>Nombre</label>
        <input type='text' id='' name='nombre' required><br><br>

        <label for='genero'>Género:</label>
        <select id='genero' name='genero'>
            <option value='hombre'>Hombre</option>
            <option value='mujer'>Mujer</option>
        </select>

       
	    <input type='checkbox' id='estado' name='estado'>
	    <label for='estado'>Estado</label><br>

        <input class='admin-panel-submit-link' type='submit' value='AÑADIR'>


    </form>";
?>
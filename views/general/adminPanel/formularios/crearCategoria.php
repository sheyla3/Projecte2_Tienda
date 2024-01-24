<div class="editContanier">	
<?php
echo "
    <form class='admin-panel-form' action='index.php?controller=Categoria&action=botonCrearCategoria' method='POST'>
        <h2 class='h2-form'>Crear Categoría</h2>    

        <label for='nombre'>Nombre</label>
        <input type='text' id='' name='nombre' required><br><br>

        <label for='genero'>Género:</label>
        <select id='genero' name='genero'>
            <option value='Hombre'>Hombre</option>
            <option value='Mujer'>Mujer</option>
        </select><br>
        <a href='index.php?controller=Admin&action=botonVistaCategoria' class='admin-panel-submit-link'>Volver atras</a>

        <input class='admin-panel-submit-link' type='submit' value='AÑADIR'>


    </form>";
?>
</div>

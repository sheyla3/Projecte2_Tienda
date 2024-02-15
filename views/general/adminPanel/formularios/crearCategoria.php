<div class="editContanier">
    <?php
    echo "
    <form class='admin-panel-form'  action='index.php?controller=Categoria&action=botonCrearCategoria' method='POST'>
        <h2 class='h2-form'>Crear Categoría</h2>    

        <input type='text' id='' name='nombre' placeholder='Nombre' required><br><br>

        <label for='genero'>Género:</label>
        <select id='genero' name='genero'>
            <option value='Hombre'>Hombre</option>
            <option value='Mujer'>Mujer</option>
        </select><br><br><br>

        <a href='index.php?controller=Admin&action=botonVistaCategoria' class='admin-panel-submit-link'>Volver atras</a>
        <br>
        <br>

        <input aria-label='añadir' class='admin-panel-submit-link' type='submit' value='Añadir'>


    </form>";
    ?>
</div>
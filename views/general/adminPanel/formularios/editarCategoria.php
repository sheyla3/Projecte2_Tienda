<form class='admin-panel-form' action="index.php?controller=Categoria&action=botonEditarCategoria&id_categoria=<?php echo $info[0]['id_categoria']; ?>" method="POST">
    <h2 class="h2-form">Editar categoría</h2>
    <?php
        echo "<label for='nombre'>Nombre</label>
        <input type='text' id='nombre' name='nombre' required value='" . $info[0]['nombre'] . "'><br><br>
        <label for='genero'>Género:</label>
        <select id='genero' name='genero'>";
        $sexo = $info[0]['sexo']; // Obtener el valor del sexo de $info

        $hombreSelected = ($sexo === 'Hombre') ? 'selected' : ''; // Marcar 'Hombre' si coincide
        $mujerSelected = ($sexo === 'Mujer') ? 'selected' : ''; // Marcar 'Mujer' si coincide

        echo "<option value='Hombre' $hombreSelected>Hombre</option>";
        echo "<option value='Mujer' $mujerSelected>Mujer</option>";
        echo "</select>";

        $estadoChecked = ($info[0]['estado'] == 1) ? 'checked' : ''; // Verificar y marcar checkbox

        echo "<input type='checkbox' id='estado' name='estado' $estadoChecked>";
        echo "<label for='estado'>Estado</label><br>";

        echo "<a href='index.php?controller=Admin&action=botonVistaCategoria' class='admin-panel-submit-link'>Volver atras</a>";
        echo "<input class='admin-panel-submit-link' type='submit' value='Editar'>";
    ?>
</form>

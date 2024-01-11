<div class="menu_sexos">
    <a href="index.php?controller=Categoria&action=MostrarCubosCategoriasMujer" <?php if($_SESSION['seccion'] == "mujer") echo 'class="selected"'; ?>>
        <div class="div1_sexos"></div>
        <h3 class="tituloMujer">Mujer</h3>
    </a>
    <a href="index.php?controller=Categoria&action=MostrarCubosCategoriasHombre"<?php if($_SESSION['seccion'] == "hombre") echo ' class="selected"'; ?>>
        <div class="div2_sexos"></div>
        <h3 class="tituloHombre">Hombre</h3>
    </a>
</div>
<?php
ProductoController::mostrarProductoDestacados();
?>

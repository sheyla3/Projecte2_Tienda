<?php


?>
<header>
    <nav>
        <div class="header">
            <div class="logo"><a href='index.php'><img src="views/img/logo.png" alt="SRG" width="200" height="70"></div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><img src="views/img/cerrar_icono.png" alt="cerrar" width="20" height="20"></label>
                <?php
                $clase_seleccionadaM = ($_SESSION['seccion'] === "mujer") ? 'class="tipo selected"' : 'class="tipo"';
                $clase_seleccionadaH = ($_SESSION['seccion'] === "hombre") ? 'class="tipo selected"' : 'class="tipo"';
                // Verificar y mostrar las categorías de mujer si existen
                if (isset($categoriasM)) {
                    echo '<li>';
                    echo '<a href="index.php?controller=Categoria&action=MostrarCubosCategoriasMujer" ' . $clase_seleccionadaM . '>Mujer</a>';
                    echo '<input type="checkbox" id="showMega">';
                    echo '<label for="showMega" class="mobile-item">Mujer</label>';
                    echo '<div class="mega-box">';
                    echo '<div class="contenido">';
                    echo '<div class="fila">';
                    echo '<img src="views/img/zapatos_mujer.png" alt="Zapatos Mujer">';
                    echo '</div>';
                    echo '<div class="fila">';
                    echo '<ul class="categorias">';

                    // Mostrar las categorías de mujer
                    foreach ($categoriasM as $categoriaM) {
                        echo '<li><a href="index.php?controller=Producto&action=mostrarProductosPorCatgeoria&id_categoria=' . $categoriaM['id_categoria'] . '">' . $categoriaM['nombre'] . '</a></li>';
                    }

                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                }

                // Verificar y mostrar las categorías de hombre si existen
                if (isset($categoriasH)) {
                    echo '<li>';
                    echo '<a href="index.php?controller=Categoria&action=MostrarCubosCategoriasHombre" ' . $clase_seleccionadaH . '>Hombre</a>';
                    echo '<input type="checkbox" id="showMega2">';
                    echo '<label for="showMega2" class="mobile-item">Hombre</label>';
                    echo '<div class="mega-box">';
                    echo '<div class="contenido">';
                    echo '<div class="fila">';
                    echo '<img src="views/img/zapatos_hombre.png" alt="Zapatos hombre">';
                    echo '</div>';
                    echo '<div class="fila">';
                    echo '<ul class="categorias">';

                    // Mostrar las categorías de hombre
                    foreach ($categoriasH as $categoriaH) {
                        echo '<li><a href="index.php?controller=Producto&action=mostrarProductosPorCatgeoria&id_categoria=' . $categoriaH['id_categoria'] . '">' . $categoriaH['nombre'] . '</a></li>';
                    }

                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                }
                ?>
                <li>
                    <a href="#" class="tipo"><img src="views/img/lupa.png" alt="Buscar" width="20" height="20"></a>
                    <label class="mobile-item">Buscar</label>
                </li>
                <li>
                    <a href="#" class="tipo"><img src="views/img/carrito.png" alt="Carrito" width="20" height="20"></a>
                    <label class="mobile-item">Carrito</label>
                </li>
                <li>
                    <a href="#" class="tipo"><img src="views/img/usuario.png" alt="Iniciar sesión" width="20" height="20"></a>
                    <label class="mobile-item">Usuario</label>
                    <input type="checkbox" id="showDrop">
                    <ul class="drop-menu">
                        <li><a href="#">Carrito</a></li>
                        <li><a href="#">Mis compras</a></li>
                        <li><a href="#">Favoritos</a></li>
                        <li><a href="#">Perfil</a></li>
                        <li><a href="#">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
            <label for="menu-btn" class="btn menu-btn"><img src="views/img/menu_icono.png" alt="menu" width="20" height="20"></label>
        </div>
    </nav>
</header>

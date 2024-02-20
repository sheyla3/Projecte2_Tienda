<?php


?>
<header>
    <nav>
        <div class="header">
            <div class="logo"><a href='index.php'><img src="views/img/logo.png" alt="SRG" width="200" height="70"></div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><img src="views/img/close-sesion.svg" alt="cerrar"
                        width="20" height="20"></label>
                <?php
                $clase_seleccionadaM = ($_SESSION['seccion'] === "mujer") ? 'class="tipo selected"' : 'class="tipo"';
                $clase_seleccionadaH = ($_SESSION['seccion'] === "hombre") ? 'class="tipo selected"' : 'class="tipo"';
                // Verificar y mostrar las categorías de mujer si existen
                if (isset($categoriasM)) {
                    $totalCategorias = count($categoriasM); // Obtener el total de categorías
                    $columnas = 2; // Número de columnas deseadas
                    $elementosPorColumna = ceil($totalCategorias / $columnas);  // Calcular el número de elementos por columna
                    $elementosImpresos = 0;  // Contador para rastrear el número actual de elementos impresos
                
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

                    // Iterar sobre las categorías de mujer
                    foreach ($categoriasM as $categoriaM) {
                        // Verificar si se debe cerrar y abrir una nueva fila y lista de categorías
                        if ($elementosImpresos > 0 && $elementosImpresos % $elementosPorColumna == 0) {
                            echo '</ul>'; // Cerrar la lista de categorías
                            echo '</div>'; // Cerrar la fila
                            echo '<div class="fila">'; // Abrir una nueva fila
                            echo '<ul class="categorias">'; // Abrir una nueva lista de categorías
                        }

                        // Imprimir el contenido de la categoría
                        echo '<li><a href="index.php?controller=Producto&action=mostrarProductosPorCatgeoria&id_categoria=' . $categoriaM['id_categoria'] . '">' . $categoriaM['nombre'] . '</a></li>';

                        $elementosImpresos++;
                    }

                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                }

                // Verificar y mostrar las categorías de hombre si existen
                if (isset($categoriasH)) {
                    $totalCategorias = count($categoriasH); // Obtener el total de categorías
                    $columnas = 2; // Número de columnas deseadas
                    $elementosPorColumna = ceil($totalCategorias / $columnas);  // Calcular el número de elementos por columna
                    $elementosImpresos = 0;  // Contador para rastrear el número actual de elementos impresos
                
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

                    // Iterar sobre las categorías de mujer
                    foreach ($categoriasH as $categoriaH) {
                        // Verificar si se debe cerrar y abrir una nueva fila y lista de categorías
                        if ($elementosImpresos > 0 && $elementosImpresos % $elementosPorColumna == 0) {
                            echo '</ul>'; // Cerrar la lista de categorías
                            echo '</div>'; // Cerrar la fila
                            echo '<div class="fila">'; // Abrir una nueva fila
                            echo '<ul class="categorias">'; // Abrir una nueva lista de categorías
                        }

                        // Imprimir el contenido de la categoría
                        echo '<li><a href="index.php?controller=Producto&action=mostrarProductosPorCatgeoria&id_categoria=' . $categoriaH['id_categoria'] . '">' . $categoriaH['nombre'] . '</a></li>';

                        $elementosImpresos++;
                    }

                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</li>';
                }
                ?>
                <li>
                    <a href="index.php?controller=Producto&action=mostrarProductosG" class="tipo"><lord-icon
                            src="https://cdn.lordicon.com/kkvxgpti.json" trigger="hover" style="width:25px;height:25px">
                        </lord-icon></a>
                    <label class="mobile-item"><a class="aMobil"
                            href="index.php?controller=Producto&action=mostrarProductosG"
                            class="tipo">Buscar</a></label>

                </li>
                <li>
                    <a href="index.php?controller=carrito&action=entrar" class="tipo"><?php echo $_SESSION['numcarrito']; ?><lord-icon
                            src="https://cdn.lordicon.com/mfmkufkr.json" trigger="hover" style="width:25px;height:25px">
                        </lord-icon></a>
                    <label class="mobile-item"><a href="index.php?controller=carrito&action=entrar"
                            class="aMobil">Carrito</a></label>
                </li>
                <li>
                    <a href="index.php?controller=usuario&action=mostrarPerfil" class="tipo"><lord-icon
                            src="https://cdn.lordicon.com/kddybgok.json" trigger="hover" style="width:25px;height:25px">
                        </lord-icon></a>
                    <input type="checkbox" id="showDrop">
                    <label for="showDrop" class="mobile-item">Usuario</label>
                    <ul class="drop-menu">
                        <li><a href="index.php?controller=usuario&action=mostrarPerfil">Perfil</a></li>
                        <li><a href="index.php?controller=pedido&action=listarPedidosUsuario">Mis Pedidos</a></li>
                        <li><a href="././sortir.php">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
            <label for="menu-btn" class="btn menu-btn"><img src="views/img/menu_icono.png" alt="menu" width="20"
                    height="20"></label>
        </div>
    </nav>

</header>
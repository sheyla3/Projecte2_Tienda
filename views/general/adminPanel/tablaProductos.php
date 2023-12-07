<?php
echo "
<div class='admin-panel-content-container'>
<div class='admin-panel-title-container'>
        <h1 class='admin-panel-title'>Productos</h1>
        <a class='admin-panel-add-link' href='index.php?controller=admin&action=botonCrearProducto'>Añadir producto</a><br>
        <div class='blue-line'></div>
    </div>";

            echo "<table class='admin-panel-page-table'>
    <tr>
        <th>ID Producto</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Destacado?</th>
        <th>ID Categoria</th>
        <th>Estado</th>
        <th>Referencia</th>
    </tr>";

            foreach ($catalogo as $producto) {
                echo "<tr>
        <td class='text'>" . $producto['id_producto'] . "</td>
        <td class='text'>" . $producto['nombre'] . "</td>
        <td class='text'>" . $producto['descripcion'] . "</td>
        <td class='text'>" . $producto['precio'] . "</td>
        <td class='text'>" . $producto['stock'] . "</td>
        <td class='text'>" . $producto['destacado'] . "</td>
        <td class='text'>" . $producto['id_categoria'] . "</td>
        <td class='text'>" . $producto['estado'] . "</td>
        <td class='text'>" . $producto['referencia'] . "</td>
        <td><a href='index.php?controller=admin&action=botonEditarProducto&id_producto=" . $producto['id_producto'] . "'><img src='views/img/edit.svg' class='image_edit_icon'</a></td>
    </tr>";
            }
            echo "</table>
        </div>";
        ?>

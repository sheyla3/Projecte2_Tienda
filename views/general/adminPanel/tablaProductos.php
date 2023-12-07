<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Productos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class='admin-panel-title-container'>
        <h1 class='admin-panel-title'>Productos</h1>
        <a href='index.php?controller=admin&action=botonCrearProducto'>Añadir producto</a><br>
        <div class='blue-line'></div>
    </div>
    <div class="div1">
        <a href="index.php?controller=admin&action=botonVistaCategoria">Categorias</a>
        <a href="index.php?controller=admin&action=botonVistaComanda">Pedidos</a>
    </div>    
    <div class="div2">
            <?php
            echo "<table>
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
        <td>" . $producto['id_producto'] . "</td>
        <td>" . $producto['nombre'] . "</td>
        <td>" . $producto['descripcion'] . "</td>
        <td>" . $producto['precio'] . "</td>
        <td>" . $producto['stock'] . "</td>
        <td>" . $producto['destacado'] . "</td>
        <td>" . $producto['id_categoria'] . "</td>
        <td>" . $producto['estado'] . "</td>
        <td>" . $producto['referencia'] . "</td>
        <td><a href='index.php?controller=admin&action=botonEditarProducto&id_producto=" . $producto['id_producto'] . "'>Editar</a></td>
    </tr>";
            }
            ?>
        </div>
</body>

</html>
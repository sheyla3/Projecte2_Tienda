<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pedidos</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class='admin-panel-title-container'>
        <h1 class='admin-panel-title'>Pedidos</h1>
        <div class='blue-line'></div>
    </div>
    <div class="div1">
        <a href="index.php?controller=admin&action=botonVistaCategoria">Categorias</a>
        <a href="index.php?controller=admin&action=botonVistaProducto">Productos</a>
    </div>

    <div class="div2">
        <?php
        echo "<table>
    <tr>
        <th>ID Pedido</th>
        <th>Correo</th>
        <th>ID Carrito</th>
        <th>Estado</th>
        <th>Fecha del pedido</th>
        <th>Fecha del envío</th>
    </tr>";

        foreach ($catalogo as $pedido) {
            echo "<tr>
        <td>" . $pedido['id_pedido'] . "</td>
        <td>" . $pedido['correo'] . "</td>
        <td>" . $pedido['id_carrito'] . "</td>
        <td>" . $pedido['estado'] . "</td>
        <td>" . $pedido['fechapedido'] . "</td>
        <td>" . $pedido['fechaenvio'] . "</td>
    </tr>";
        }
        ?>
        </div>
</body>

</html>
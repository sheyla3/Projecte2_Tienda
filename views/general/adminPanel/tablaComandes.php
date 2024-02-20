<?php
echo "
<div class='admin-panel-content-container'>
    <div class='admin-panel-title-container'>
        <ul class='tituloMenu'>
            <li><h1 class='admin-panel-title'>Pedidos</h1></li>
            <li class='derecha'>
            </li>
        </ul>
        <div class='blue-line'></div>
    </div>";

echo "<table class='admin-panel-page-table' aria-label='tabla'>
    <tr>
        <th>ID Pedido</th>
        <th>Correo</th>
        <th>Estado</th>
        <th>Fecha del pedido</th>
        <th>Fecha del envío</th>
        <th>Cambiar Estado</th>
    </tr>";

foreach ($catalogo as $pedido) {
    echo "<tr>
        <td class='text'>" . $pedido['id_pedido'] . "</td>
        <td class='text'>" . $pedido['correo'] . "</td>
        <td class='text'>" . $pedido['estado'] . "</td>
        <td class='text'>" . $pedido['fechapedido'] . "</td>
        <td class='text'>" . $pedido['fechaenvio'] . "</td>
        <td class='text'><a href='index.php?controller=pedido&action=verPedido&id_pedido=" . $pedido['id_pedido'] . "'><img src='views/img/edit.svg' class='image_edit_icon'></a></a></td>
    </tr>";
}
echo "</table>
        </div>";

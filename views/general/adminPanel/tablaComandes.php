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
        <th>Ver Detalles</th>
    </tr>";

foreach ($catalogo as $pedido) {
    // Formatear la fecha del pedido
    $fechaPedidoFormateada = date("d-m-Y", strtotime($pedido['fechapedido']));
    
    // Verificar si hay una fecha de envío
    if ($pedido['estado'] === 'Enviado' && $pedido['fechaenvio'] != null) {
        // Si el pedido está en estado "enviado" y hay una fecha de envío, formatear la fecha de envío
        $fechaEnvioFormateada = date("d-m-Y", strtotime($pedido['fechaenvio']));
    } else {
        // Si el pedido no está en estado "enviado" o no hay fecha de envío, mostrar un texto indicando que está pendiente
        $fechaEnvioFormateada = "";
    }

    echo "<tr>
        <td class='text'>" . $pedido['id_pedido'] . "</td>
        <td class='text'>" . $pedido['correo'] . "</td>
        <td class='text'>" . $pedido['estado'] . "</td>
        <td class='text'>" . $fechaPedidoFormateada . "</td>
        <td class='text'>" . $fechaEnvioFormateada . "</td>
        <td class='text'><a href='index.php?controller=pedido&action=verPedido&id_pedido=" . $pedido['id_pedido'] . "'><img src='views/img/edit.svg' class='image_edit_icon'></a></a></td>
        <td class='text'><a href='index.php?controller=pedido&action=verDetallesPedidoAdmin&id_pedido=" . $pedido['id_pedido'] . "'><img src='views/img/detail.svg' width='30px' height='30px'></a></td>
    </tr>";
}
echo "</table>
        </div>";
?>

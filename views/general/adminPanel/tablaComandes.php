<?php
echo "
<div class='admin-panel-content-container'>
    <div class='admin-panel-title-container'>
        <ul class='tituloMenu'>
            <li><h1 class='admin-panel-title'>Pedidos</h1></li>
            <li class='derecha'>
                <form action='' method='post' class='formCom buscador'>
                    <label for='campo' name='Cbuscar'><img src='views/img/AdminLupa.png' alt='Buscar' width='20' height='20'></label>
                    <input type='text' id='Cbuscar' name='Cbuscar'>
                </form>
            </li>
        </ul>
        <div class='blue-line'></div>
    </div>";

echo "<table class='admin-panel-page-table'>
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
        <td class='text'>" . $pedido['id_pedido'] . "</td>
        <td class='text'>" . $pedido['correo'] . "</td>
        <td class='text'>" . $pedido['id_carrito'] . "</td>
        <td class='text'>" . $pedido['estado'] . "</td>
        <td class='text'>" . $pedido['fechapedido'] . "</td>
        <td class='text'>" . $pedido['fechaenvio'] . "</td>
    </tr>";
}
echo "</table>
        </div>";
?>

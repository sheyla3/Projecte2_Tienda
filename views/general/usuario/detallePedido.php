<br><br><br>
<h2>Detalles del Pedido</h2>

<table>
    <thead>
        <tr>
            <th>Correo</th>
            <th>ID Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>ID Pedido</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detallesPedido as $detalleProducto) : ?>
            <tr>
                <td><?php echo $detalleProducto['correo']; ?></td>
                <td><?php echo $detalleProducto['id_producto']; ?></td>
                <td><?php echo $detalleProducto['cantidad']; ?></td>
                <td><?php echo $detalleProducto['precio']; ?></td>
                <td><?php echo $detalleProducto['id_pedido']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

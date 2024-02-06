<br>
<br><br><br>

<h2>Tus Pedidos</h2>

    <!-- Verificar que $pedidos no sea false antes de intentar iterar -->
    <table border="1">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Fecha Pedido</th>
                <th>Fecha Envio</th>
                <th>Factura</th>
                <!-- Agrega más columnas según tu estructura de datos -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido){?>
                <tr>
                    <td><?php echo $pedido['id_pedido']; ?></td>
                    <td><?php echo $pedido['correo']; ?></td>
                    <td><?php echo $pedido['estado']; ?></td>
                    <td><?php echo $pedido['fechapedido']; ?></td>
                    <td><?php echo $pedido['fechaenvio']; ?></td>
                    <td><a href="index.php?controller=pedido&action=downloadInvoices&id_pedido=' . $pedido['id_pedido'] . '">Descargar Factura</a></td>
                </tr>
                <?php } ?>
        </tbody>
    </table>

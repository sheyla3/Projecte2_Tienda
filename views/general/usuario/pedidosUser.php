<br><br><br>
<h2 class='my-profile-title'>Tus Pedidos</h2>
<div class='blue-line'></div>
<br>

    <!-- Verificar que $pedidos no sea false antes de intentar iterar -->
<div class="pedidoCon">
    <table class="table-pedidos">
        <thead >
            <tr>
                <th class="table-pedidos-thead">ID Pedido</th>
                <th class="table-pedidos-thead">Estado</th>
                <th class="table-pedidos-thead">Fecha Pedido</th>
                <th class="table-pedidos-thead">Fecha Envio</th>
                <th class="table-pedidos-thead">Factura</th>
                <th class="table-pedidos-thead">Detalles del pedido</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $pedido){?>
                <tr>
                    <td><?php echo $pedido['id_pedido']; ?></td>
                    <td><?php echo $pedido['estado']; ?></td>
                    <td><?php echo $pedido['fechapedido']; ?></td>
                    <td><?php echo $pedido['fechaenvio']; ?></td>
                    <?php echo "<td><a href='index.php?controller=pedido&action=verDetallesPedidoPDF&id_pedido=". $pedido['id_pedido'] ."'><img src='views/img/factura.svg' width='30px' height='30px'></a></td>"; ?>
                    <?php echo "<td><a href='index.php?controller=pedido&action=verDetallesPedido&id_pedido=". $pedido['id_pedido'] ."'><img src='views/img/detail.svg' width='30px' height='30px'></a></td>"; ?>
                </tr>
                <?php } ?>
        </tbody>
    </table>
</div>

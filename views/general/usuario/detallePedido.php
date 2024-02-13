<br><br><br>
<h2 class='my-profile-title'>Detalles del pedido</h2>

<div class='blue-line'></div>
<div class='user-profile-row'><a role='button' onclick="retroceder()" class='admin-panel-back-link'>Retroceder</a></div>

<br>

<script>
    function retroceder() {
        window.history.back();
    }
</script>

<div class="pedidoCon">

    <table class="table-pedidos" aria-label='Tabla'>
        <thead>
            <tr>
                <th class="table-pedidos-thead">Nombre del Producto</th>
                <th class="table-pedidos-thead">Descripción</th>
                <th class="table-pedidos-thead">ID Producto</th>
                <th class="table-pedidos-thead">Cantidad</th>
                <th class="table-pedidos-thead">Precio</th>
                <th class="table-pedidos-thead">Precio Total</th>
                <th class="table-pedidos-thead">Imagen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detallesPedido as $detalleProducto): ?>
                <tr>
                    <td>
                        <?php echo $detalleProducto['nombre']; ?>
                    </td>
                    <td>
                        <?php echo $detalleProducto['descripcion']; ?>
                    </td>
                    <td>
                        <?php echo $detalleProducto['id_producto']; ?>
                    </td>
                    <td>
                        <?php echo $detalleProducto['cantidad']; ?>
                    </td>
                    <td>
                        <?php echo $detalleProducto['precio']; ?>
                    </td>
                    <td>
                        <?php echo $detalleProducto['precio_total']; ?>
                    </td>
                    <td><img src="<?php echo $detalleProducto['imagen']; ?>" alt="<?php echo $detalleProducto['nombre']; ?>"
                            width='20%' margin='auto'></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
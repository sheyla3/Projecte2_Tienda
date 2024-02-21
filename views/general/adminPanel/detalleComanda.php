<?php
echo "
<div class='admin-panel-content-container'>
    <div class='admin-panel-title-container'>
        <ul class='tituloMenu'>
            <li><h1 class='admin-panel-title'>Detalles del pedido</h1></li>
            <li class='derecha'>
                <form action='' aria-label='formulario' method='post' class='formCom buscador'>
                    <label for='campo' name='Cbuscar'><img src='views/img/AdminLupa.png' alt='Buscar' width='20' height='20'></label>
                    <input type='text' id='Cbuscar' name='Cbuscar'>
                </form>
            </li>
        </ul>
        <div class='blue-line'></div>
    </div>";
?>

<br><br>
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
                <th class="table-pedidos-thead esconder-descripcion">Descripción</th>
                <th class="table-pedidos-thead esconder-descripcion">ID Producto</th>
                <th class="table-pedidos-thead">Cantidad</th>
                <th class="table-pedidos-thead">Precio Unitario</th>
                <th class="table-pedidos-thead">Precio Total</th>
                <th class="table-pedidos-thead esconder-descripcion">Imagen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detallesPedido as $detalleProducto): ?>
                <tr>
                    <td>
                        <?php echo $detalleProducto['nombre']; ?>
                    </td>
                    <td class="esconder-descripcion">
                        <?php echo $detalleProducto['descripcion']; ?>
                    </td>
                    <td class="esconder-descripcion">
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
                    <td class="esconder-descripcion"><img src="<?php echo $detalleProducto['imagen']; ?>" alt="<?php echo $detalleProducto['nombre']; ?>"
                            width='20%' margin='auto'></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
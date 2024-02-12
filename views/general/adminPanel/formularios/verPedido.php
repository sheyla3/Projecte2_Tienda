<br><br>


<form class="admin-panel-form" action="index.php?controller=pedido&action=procesarActualizacionEstado" method="POST">
    <h2 class="h2-form">Cambiar Estado</h2>
    <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
    <label for="estado">Estado del Pedido:</label>
    <select name="estado" id="estado">
        <option value="Pendiente" <?php echo ($pedido['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
        <option value="Enviado" <?php echo ($pedido['estado'] == 'enviado') ? 'selected' : ''; ?>>Enviado</option>
        <option value="Completado" <?php echo ($pedido['estado'] == 'completado') ? 'selected' : ''; ?>>Completado
        </option>
    </select>
    <button aria-label='Actualizar estado' type="submit">Actualizar Estado</button>
</form>
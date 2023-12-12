<?php
echo "
<div class='admin-panel-content-container'>
	<div class='admin-panel-title-container'>
    	<h1 class='admin-panel-title'>Productos</h1>
    	<a class='admin-panel-add-link' href='index.php?controller=admin&action=botonCrearProducto'>Añadir producto</a><br>
    	<div class='blue-line'></div>
	</div>";

// Agrega la barra de búsqueda antes de la tabla
echo "
	<div class='search-bar'>
    	<input type='text' id='query' placeholder='Buscar por nombre...' onkeyup='buscarProducto()'>
    	<button onclick='buscarProducto()'>Buscar</button>
	</div>";

echo "<table class='admin-panel-page-table'>
	<tr>
    	<th>ID Producto</th>
    	<th>Nombre</th>
    	<th>Descripción</th>
    	<th>Precio</th>
    	<th>Stock</th>
    	<th>Destacado?</th>
    	<th>ID Categoria</th>
    	<th>Estado</th>
    	<th>Referencia</th>
    	<th>Editar</th>
	</tr>";

foreach ($catalogo as $producto) {
	echo "<tr>
    	<td class='text'>" . $producto['id_producto'] . "</td>
    	<td class='text'>" . $producto['nombre'] . "</td>
    	<td class='text'>" . $producto['descripcion'] . "</td>
    	<td class='text'>" . $producto['precio'] . "</td>
    	<td class='text'>" . $producto['stock'] . "</td>
    	<td class='text'>" . $producto['destacado'] . "</td>
    	<td class='text'>" . $producto['id_categoria'] . "</td>
    	<td class='text'>" . $producto['estado'] . "</td>
    	<td class='text'>" . $producto['referencia'] . "</td>
    	<td class='text'><a href='index.php?controller=admin&action=botonEditarProducto&id_producto=" . $producto['id_producto'] . "'><img src='views/img/edit.svg' class='image_edit_icon'</a></td>
	</tr>";
}
echo "</table>
</div>";


?>
<script>
function buscarProducto() {
    let filtro = document.getElementById('query').value;

    // Realizar una solicitud AJAX utilizando fetch
    fetch('index.php?controller=ProductoController&action=buscarproductos&filtro=' + filtro)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
		// Limpiar la tabla existente antes de mostrar los resultados
		const tableBody = document.querySelector('.admin-panel-page-table tbody');
		tableBody.innerHTML = '';

		// Iterar sobre los resultados y construir las filas de la tabla
		data.forEach(producto => {
			const row = document.createElement('tr');
			row.innerHTML = `
				<td class='text'>${producto.id_producto}</td>
				<td class='text'>${producto.nombre}</td>
				<td class='text'>${producto.descripcion}</td>
				<!-- ... otros campos del producto ... -->
			`;
			tableBody.appendChild(row);
		});
	})
	.catch(error => {
		// Manejar errores de la solicitud
		console.error('There was a problem with the fetch operation:', error);
});

}
</script>






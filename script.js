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
        	// Manejar la respuesta obtenida
        	console.log(data); // Por ejemplo, muestra los datos en la consola
    	})
    	.catch(error => {
        	// Manejar errores de la solicitud
        	console.error('There was a problem with the fetch operation:', error);
    	});
}

function mostrarCampoImagen() {
	var campoImagen = document.getElementById("campoImagen");
	campoImagen.style.display = "block";
}

$(document).ready(function () {


    // $('.botonAñadir').click(function (event) {
    //     // Evitar el envío del formulario por defecto
    //     event.preventDefault();
        
    //     // Llama a la función para añadir el producto al carrito
    //     añadirProductoAlCarrito();
    // });
    
    

    //funcion obtener datos cesta
    

    // document.addEventListener('DOMContentLoaded', function () {
    //     var botonesAñadir = document.querySelectorAll('.botonAñadir');
    //     console.log("aaaa");
    //     botonesAñadir.forEach(function (boton) {
    //         boton.addEventListener('click', function (event) {
    //             console.log("hola");
    //             event.preventDefault();
    
    //             // Obtener el formulario asociado al botón clicado
    //             var formulario = boton.closest('.formularioCarrito');
    
    //             // Acceder a los valores del formulario actual
    //             var id_producto = formulario.querySelector('[name="d_id_producto"]').value;
    //             var cantidad = formulario.querySelector('[name="d_cantidad"]').value;
    //             var precio = formulario.querySelector('[name="d_precio"]').value;
    
    //             // Puedes realizar operaciones con los datos aquí
    //             console.log("ID Producto: " + id_producto);
    //             console.log("Cantidad: " + cantidad);
    //             console.log("Precio: " + precio);
    
    //             // Ejemplo de cómo enviar los datos a través de XMLHttpRequest o fetch
    //             // (reemplaza esto con tu lógica específica)
    //             // fetch('tu_url_de_backend', {
    //             //     method: 'POST',
    //             //     headers: {
    //             //         'Content-Type': 'application/json',
    //             //     },
    //             //     body: JSON.stringify({
    //             //         id_producto: id_producto,
    //             //         cantidad: cantidad,
    //             //         precio: precio
    //             //     }),
    //             // });
    
    //             // Después de realizar las operaciones, puedes redirigir o mostrar un mensaje
    //             // window.location.href = 'index.php'; // Cambia la URL según tus necesidades
    //         });
    //     });
    // });
    
    

    
    
    function obtenerTablaCompletaP() {
        $.ajax({
            type: 'POST',
            url: 'index.php?controller=Producto&action=CrearTablaCompletaP',
            dataType: 'html',
            success: function (htmlTablaCompleta) {
                // Actualizar el contenido de la tabla con la tabla completa
                $('#tabla-p').html(htmlTablaCompleta);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX para obtener la tabla completa:', textStatus, errorThrown);
            }
        });
    }


    // Función para manejar la búsqueda
    function buscarProductos(busqueda) {
        console.log('Buscando producctos con:', busqueda);
        $.ajax({
            type: 'POST',
            url: 'index.php?controller=Producto&action=buscarP',
            data: { busqueda: busqueda },
            dataType: 'html', // Esperamos HTML como respuesta
            success: function (htmlTabla) {
                try {
                     // Si la búsqueda está en blanco, guarda los resultados completos
					 if (busqueda.length === 0) {
                        // Llamada a la función para obtener la tabla completa
                        obtenerTablaCompletaP();
                    } else {
                        // Actualizar el contenido de la tabla con los resultados
                        $('#tabla-p').html(htmlTabla);
                    }
                } catch (error) {
                    console.error('Error al procesar la respuesta del servidor:', error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
            }
        });
    }


	function obtenerTablaCompleta() {
        $.ajax({
            type: 'POST',
            url: 'index.php?controller=Categoria&action=CrearTablaCompletaCategoria',
            dataType: 'html',
            success: function (htmlTablaCompleta) {
                // Actualizar el contenido de la tabla con la tabla completa
                $('#tabla-categorias').html(htmlTablaCompleta);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX para obtener la tabla completa:', textStatus, errorThrown);
            }
        });
    }


    // Función para manejar la búsqueda
    function buscarCategorias(busqueda) {
        console.log('Buscando categorías con:', busqueda);
        $.ajax({
            type: 'POST',
            url: 'index.php?controller=Categoria&action=buscarCategoria',
            data: { busqueda: busqueda },
            dataType: 'html', // Esperamos HTML como respuesta
            success: function (htmlTabla) {
                try {
                     // Si la búsqueda está en blanco, guarda los resultados completos
					 if (busqueda.length === 0) {
                        // Llamada a la función para obtener la tabla completa
                        obtenerTablaCompleta();
                    } else {
                        // Actualizar el contenido de la tabla con los resultados
                        $('#tabla-categorias').html(htmlTabla);
                    }
                } catch (error) {
                    console.error('Error al procesar la respuesta del servidor:', error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
            }
        });

    }

	    //Evento cuando se escribe en el campo de búsqueda
		$('#Cbuscar').on('input', function () {
			var busqueda = $(this).val().trim();
			if (busqueda.length > 0) {
				buscarCategorias(busqueda);
			} else {
				obtenerTablaCompleta();
			}
		});

        $('#Pbuscar').on('input', function () {
            console.log("hola");
			var busqueda = $(this).val().trim();
			if (busqueda.length > 0) {
				buscarProductos(busqueda);
			} else {
				obtenerTablaCompletaP();
			}
		});
});


function mostrarCampoImagen() {
	var campoImagen = document.getElementById("campoImagen");
	campoImagen.style.display = "block";
}

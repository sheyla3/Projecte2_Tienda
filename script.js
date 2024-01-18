$(document).ready(function () {

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

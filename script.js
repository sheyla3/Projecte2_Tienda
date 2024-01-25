$(document).ready(function () {
    // objectos classes
    class Usuario {
        constructor(email) {
            this.email = email;
        }
    }
    
    // Definición de la clase Carrito
    class Carrito {
        constructor(usuario) {
            this.usuario = usuario;
            this.productos = [];
        }
    
        agregarProducto(id_producto, cantidad, precio) {
            // Agregar el nuevo producto al array de productos
            this.productos.push({
                id_producto: id_producto,
                cantidad: cantidad,
                precio: precio
            });
        }
    
        obtenerProducto() {
            return this.productos;
        }
    }
    

    // carrito

        // Espera a que se cargue el DOM antes de registrar el evento de clic
    var botonAñadir = document.querySelector('.d_botonAñadir');

    if (botonAñadir) {
        // Verifica si el botón existe para evitar errores
        botonAñadir.addEventListener('click', function () {
            // Llama a la función al hacer clic en el botón
            agregarAlCarrito();
        });
    }else{
        console.log(" ");
    }

    
    
    function agregarAlCarrito() {
        // Acceder a los valores del formulario actual
        var id_producto = document.querySelector('[name="d_id_producto"]').value;
        var cantidad = document.querySelector('[name="d_cantidad"]').value;
        var precio = document.querySelector('[name="d_precio"]').value;
        var correo = document.querySelector('[name="d_correo"]').value;

        //declarar usuario
        const usuario1 = new Usuario(correo);

        //crear carrito con objecto usuario
        const carritoDelUsuario = new Carrito(usuario1);

        carritoDelUsuario.agregarProducto(id_producto,cantidad,precio);

        guardarEnLocalStorage(carritoDelUsuario);
        

        var arrayActualizado = leerLocalStorage();
        console.log(arrayActualizado);
        //pasar datos a php
        fetch('index.php?controller=carrito&action=añadirAlCarrito', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id_producto=' + id_producto + '&cantidad=' + cantidad + '&precio=' + precio + '&email=' + correo,
        });
    }

    //cokies

    function leerLocalStorage() {
        var localStorageValue = localStorage.getItem('miLocalStorage');
        return localStorageValue ? JSON.parse(localStorageValue) : [];
    }

    function guardarEnLocalStorage(nuevoCarrito) {
    // Obtener la lista actual de carritos del localStorage
    var arrayDeCarritos = leerLocalStorage();

    // Buscar el carrito actual en la lista
    var carritoExistente = arrayDeCarritos.find(function(carrito) {
        return carrito.usuario.email === nuevoCarrito.usuario.email;
    });

    if (carritoExistente) {
        // Si el carrito ya existe, actualizar los productos existentes con los nuevos
        nuevoCarrito.productos.forEach(function(nuevoProducto) {
            var productoExistente = carritoExistente.productos.find(function(producto) {
                return producto.id_producto === nuevoProducto.id_producto;
            });

            if (productoExistente) {
                // Si el producto ya existe, actualizar sus propiedades
                Object.assign(productoExistente, nuevoProducto);
            } else {
                // Si el producto no existe, añadirlo a la lista de productos
                carritoExistente.productos.push(nuevoProducto);
            }
        });
    } else {
        // Si el carrito no existe, añadirlo a la lista
        arrayDeCarritos.push(nuevoCarrito);
    }

    // Guardar la lista actualizada en el localStorage
    localStorage.setItem('miLocalStorage', JSON.stringify(arrayDeCarritos));
}





    
    
    
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


function mostrarEnviarCorreo() {
    document.getElementById('overlay').style.display = 'flex';
}


function ocultarEnviarCorreo() {
    document.getElementById('overlay').style.display = 'none';
}

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

        agregarProducto(id_producto, cantidad, precio, nombre, img, stock) {
            // Agregar el nuevo producto al array de productos
            this.productos.push({
                id_producto: id_producto,
                cantidad: cantidad,
                precio: precio,
                nombre: nombre,
                img: img,
                stock: stock,

            });
        }

        obtenerProducto() {
            return this.productos;
        }
    }


    // carrito

    var botonAñadir = document.querySelector('.d_botonAñadir');

    if (botonAñadir) {
        // Verifica si el botón existe para evitar errores
        botonAñadir.addEventListener('click', function () {
            // Llama a la función al hacer clic en el botón
            var cantidad = document.querySelector('[name="d_cantidad"]').value;
            var stock = document.querySelector('[name="d_stock"]').value;

            if (cantidad > 0) {
                Swal.fire({
                    title: '¡Producto añadido al carrito!',
                    text: '¡Has añadido el producto al carrito con éxito!',
                    icon: 'success',
                    confirmButtonText: 'Entendido'
                });
                this.classList.add("clicked");
                agregarAlCarrito();
            } else {
                Swal.fire({
                    title: 'Error al añadir el producto',
                    text: '¡No se ha podido añadir el producto!',
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            }

        });
    }

    $(document).ready(function () {
        var botonAñadir = $('.d_botonAñadir');
        var cantidadInput = $('[name="d_cantidad"]');
        var stock = parseInt($('[name="d_stock"]').val());
    
        $(document).on('click', '.sumarCantidad', function () {
            console.log('Sumar cantidad clicado');
            var cantidad = parseInt(cantidadInput.val());
            if (cantidad < stock) {
                cantidadInput.val(cantidad + 1);
            } else if (cantidad === stock) {
                console.log('La cantidad ya ha alcanzado el stock máximo');
            }
        });
    
        $('.restarCantidad').on('click', function () {
            console.log('Restar cantidad clicado');
            var cantidad = parseInt(cantidadInput.val());
            if (cantidad > 0) {
                cantidadInput.val(cantidad - 1);
            } else {
                console.log('No se puede restar menos de 0');
            }
        });
    
        botonAñadir.on('click', function () {
            console.log('Botón añadir clicado');
            var cantidad = parseInt(cantidadInput.val());
            if (cantidad > stock) {
                cantidadInput.val(stock);
            }
            // Resto de tu lógica para añadir al carrito...
        });
    });        
    
    window.onload = function () {
        // Obtener la cadena de búsqueda de la URL
        var queryString = new URL(window.location.href).search;

        // Verificar si estamos en la URL específica
        if (queryString === "?carrito&action=entrar") {
            // Ejecutar la función solo para la URL específica
            console.log("adios");
        }
    };

    var botonCarrito = document.querySelector('#botonCarrito1');
    if (botonCarrito) {
        botonCarrito.addEventListener('click', function () {

            var datos = leerLocalStorage();

            $.ajax({
                url: 'index.php?controller=carrito&action=recibirLocalCarrito',
                type: 'POST',
                contentType: 'application/json; charset=UTF-8',
                data: JSON.stringify({ carrito: datos }),
                success: function (data) {
                    // Maneja la respuesta del servidor
                    if (data.success) {
                        $('#tabla-carrito').html(data.info);

                    } else {
                        console.error('Error en la solicitud:', data.message);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    // Maneja el error
                    console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                    console.error('Estado de la respuesta:', xhr.status);
                    console.error('Respuesta del servidor:', xhr.responseText);
                }
            });
        });
    }

    function agregarAlCarrito() {
        // Acceder a los valores del formulario actual
        var id_producto = document.querySelector('[name="d_id_producto"]').value;
        var cantidad = document.querySelector('[name="d_cantidad"]').value;
        var precio = document.querySelector('[name="d_precio"]').value;
        var correo = document.querySelector('[name="d_correo"]').value;
        var img = document.querySelector('[name="d_img"]').value;
        var nombre = document.querySelector('[name="d_nombre"]').value;
        var stock = document.querySelector('[name="d_stock"]').value;


        if (correo) {
            const usuario1 = new Usuario(correo);
        } else {
            const usuario1 = new Usuario("noValidado");

        }

        //declarar usuario
        const usuario1 = new Usuario(correo);

        //crear carrito con objecto usuario
        const carritoDelUsuario = new Carrito(usuario1);

        carritoDelUsuario.agregarProducto(id_producto, cantidad, precio, nombre, img, stock);

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

    //localStorage

    function leerLocalStorage() {
        var localStorageValue = localStorage.getItem('miLocalStorage');
        return localStorageValue ? JSON.parse(localStorageValue) : [];
    }

    function guardarEnLocalStorage(nuevoCarrito) {
        // Obtener la lista actual de carritos del localStorage
        var arrayDeCarritos = leerLocalStorage();

        // Buscar el carrito actual en la lista
        var carritoExistente = arrayDeCarritos.find(function (carrito) {
            return carrito.usuario.email === nuevoCarrito.usuario.email;
        });

        if (carritoExistente) {
            // Si el carrito ya existe, actualizar los productos existentes con los nuevos
            nuevoCarrito.productos.forEach(function (nuevoProducto) {
                var productoExistente = carritoExistente.productos.find(function (producto) {
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




})
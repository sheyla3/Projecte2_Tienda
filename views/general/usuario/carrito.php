<?php

?>
 <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            datosCarrito();
        });
        function comprarProductos() {
            var productosSeleccionados = document.querySelectorAll('.producto-seleccionado');
            var datosProductos = [];

            productosSeleccionados.forEach(function (producto) {
                var idProducto = producto.value;
                var cantidad = document.querySelector('input[name="productos_seleccionados[' + idProducto + '][cantidad]"]').value;
                var precio = document.querySelector('input[name="productos_seleccionados[' + idProducto + '][precio]"]').value;

                datosProductos.push({
                    id_producto: idProducto,
                    cantidad: cantidad,
                    precio: precio
                });
            });

            // Puedes enviar los datos al servidor usando AJAX o hacer lo que necesites con ellos.
            console.log(datosProductos);
            $.ajax({
                url: 'index.php?controller=Pedido&action=añadirPedido',
                type: 'POST',
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                data: { carrito: JSON.stringify(datosProductos) },
                success: function (data) {
                    // Maneja la respuesta del servidor
                    if (data.success) {
                        console.log("bien");
                        limpiarLocalStorage();
                        datosCarrito();

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
        }


    function enviarFormulario() {
        var checkboxes = document.querySelectorAll('.producto-seleccionado:checked');
        var form = document.getElementById('formProductos');

        checkboxes.forEach(function (checkbox) {
            checkbox.removeAttribute('name'); // Eliminar el nombre para que no se envíe en el formulario
        });

        form.submit();
    } 
    function datosCarrito(){
         
         var datos = leerLocalStorage();

     
         $.ajax({
             url: 'index.php?controller=carrito&action=recibirLocalCarrito',
             type: 'POST',
             contentType: 'application/json; charset=UTF-8',
             data: JSON.stringify({ carrito: datos }),
             success: function (data) {
                 // Maneja la respuesta del servidor
                 if (data.success) {
                     //window.location.href = 'views/general/usuario/carrito.php';
                     // Descomentar esta línea para redirigir a la página de carrito
                     $('#tabla-carrito').html(data.info);
                    agregarEventosBotones();
               
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
     }

     function leerLocalStorage() {
        var localStorageValue = localStorage.getItem('miLocalStorage');
        return localStorageValue ? JSON.parse(localStorageValue) : [];
    }
    function limpiarLocalStorage() {
        localStorage.removeItem('miLocalStorage');
        console.log('LocalStorage limpiada');
    }

    function agregarEventosBotones() {
        // Obtener todos los botones de subir, bajar y eliminar
        var btnSubir = document.querySelectorAll('.btn-subir');
        var btnBajar = document.querySelectorAll('.btn-bajar');
        var btnEliminar = document.querySelectorAll('.btn-eliminar');

        // Asignar eventos a los botones
        btnSubir.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var idProducto = this.getAttribute('data-id');
                var stock = this.getAttribute('data-stock');
                var cant = this.getAttribute('data-cant');
                if(cant === stock){
                    console.log("No mas disponible")
                }else{
                    manejarAccion(idProducto, 'subir');
                }
                
            });
        });

        btnBajar.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var idProducto = this.getAttribute('data-id');
                var stock = this.getAttribute('data-stock');
                manejarAccion(idProducto, 'bajar');
            });
        });

        btnEliminar.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var idProducto = this.getAttribute('data-id');
                manejarAccion(idProducto, 'eliminar');
            });
        });
    }


    function manejarAccion(idProducto, accion) {
        editarProductoEnLocalStorage(idProducto,accion);
        
        //TODO haer que se guarde tambien los canvios en la base de datos
        // // Realizar una solicitud AJAX para manejar la acción
        fetch('index.php?controller=carrito&action=modificarAccion', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id_producto: idProducto, accion: accion }),
        })
        .then(response => response.json())
        .then(data => {
            // Actualizar la cantidad en la interfaz
            var nuevaCantidad = data.nuevaCantidad;
            actualizarCantidadEnInterfaz(idProducto, nuevaCantidad);
        })
        .catch((error) => {
            //console.error('Error:', error);
        });
        datosCarrito();
    }



    function editarProductoEnLocalStorage(idProducto, accion) {
    // Obtener la información actual del localStorage
      
        var datosLocalStorage = leerLocalStorage();
        // Buscar el producto en el array
        for (var i = 0; i < datosLocalStorage.length; i++) {
            var usuario = datosLocalStorage[i].usuario;
            var productos = datosLocalStorage[i].productos;

            // Buscar el producto en el array de productos
            for (var j = 0; j < productos.length; j++) {
                if (productos[j].id_producto === idProducto) {
                    // Realizar la acción según la acción especificada
                    switch (accion) {
                        case 'subir':
                            // Lógica para subir el stock del producto
                            productos[j].cantidad++;
                            break;
                        case 'bajar':
                            // Lógica para bajar el stock del producto
                            if (productos[j].cantidad > 0) {
                                productos[j].cantidad--;
                            }
                            break;
                        case 'eliminar':
                            // Lógica para eliminar el producto
                            productos.splice(j, 1);
                            break;
                        default:
                            break;
                    }

                    // Actualizar el localStorage con los nuevos datos
                    localStorage.setItem('miLocalStorage', JSON.stringify(datosLocalStorage));

                    // Terminar la búsqueda una vez que se realiza la acción
                    return;
                }
            }
        }
    }

    </script>

<div id="tabla-carrito">


</div>
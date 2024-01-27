<?php

?>
 <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            datosCarrito();
        });

        
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
                     console.log("datos base", data.datos);
                     //window.location.href = 'views/general/usuario/carrito.php';
                     // Descomentar esta línea para redirigir a la página de carrito
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
     }

     function leerLocalStorage() {
        var localStorageValue = localStorage.getItem('miLocalStorage');
        return localStorageValue ? JSON.parse(localStorageValue) : [];
    }
    </script>

<div id="tabla-carrito">


</div>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('graficoProductos');
    const ctx = canvas.getContext('2d');
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'graficaPruebas/getData.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const productosMasVendidos = JSON.parse(xhr.responseText);
            const colores = ['#ff5733', '#33ff57', '#5733ff', '#ff33ab', '#33a9ff'];
            const barraAncho = 80;
            const maxAltura = 300;
            const margenSuperior = 20;

            const totalCantidad = productosMasVendidos.reduce((total, producto) => {
                return total + parseInt(producto.totalcantidad);
            }, 0);

            productosMasVendidos.forEach((producto, i) => {
                const color = colores[i % colores.length];
                const altura = (parseInt(producto.totalcantidad) / totalCantidad) * maxAltura;
                const x = i * (barraAncho + 20);
                const y = canvas.height - altura - margenSuperior;

                ctx.fillStyle = color;
                ctx.fillRect(x, y, barraAncho, altura);

                ctx.fillStyle = '#333';
                ctx.fillText(producto.id_producto.toString(), x + barraAncho / 2 - 10, canvas.height - 10);

                ctx.fillStyle = '#333';
                ctx.fillText(producto.totalcantidad.toString(), x + barraAncho / 2 - 10, y - 5);
            });

        } else {
            console.error('Error al obtener los datos del PHP:', xhr.status);
        }
    };

    xhr.send();
});
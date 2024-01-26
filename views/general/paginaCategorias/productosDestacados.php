<head>
    <!-- Agrega estos enlaces para incluir la biblioteca Slick Carousel -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
</head>

<body>
<h2 style="text-align:center; margin-top:100px">Destacados</h2>
<div class="cubosCategorias slider">
    <?php foreach ($productos as $producto): ?>
        <a class="prodDestacado" href="index.php?controller=Producto&action=mostrarProducto&id_producto=<?= $producto['id_producto'] ?>">
            <div class="cuboP" style="background-image: url('<?= $producto['img'] ?>')" alt="<?= $producto['nombre'] ?>">
                <p class="letraP"><?= $producto['nombre'] ?> - <?= $producto['precio'] ?>€</p>
            </div>
        </a>
    <?php endforeach; ?>
</div>
    <!-- Tu contenido HTML anterior -->

    <!-- Agrega estos scripts para activar el slider con Slick Carousel -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.slider').slick({
                autoplay: true,
                autoplaySpeed: 100, // Cambia esta velocidad según tus preferencias
                dots: true,
                infinite: true,
                speed: 2000,
                slidesToShow: 3, // Ajusta la cantidad de productos mostrados a la vez
                slidesToScroll: 1
            });
        });
    </script>
</body>


<!-- <div class="cubosCategorias">
    <h3>Destacados</h3>
    
        echo '<a class="prodDestacado" href="index.php?controller=Producto&action=mostrarProducto&id_producto=' . $producto['id_producto'] . '">';
        echo '<div class="cuboP" style="background-image: url(\'' . $producto['img'] . '\')" alt="' . $producto['nombre'] . '">';
        echo '<p class="letraP">'. $producto['nombre'] . ' - '. $producto['precio'].'€</p>';
        echo '</div>';
        echo '</a>';y
</div> -->

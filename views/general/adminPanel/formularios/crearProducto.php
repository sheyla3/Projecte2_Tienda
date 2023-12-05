<!DOCTYPE html>
<html>
<head>
    <title>Crear Producto</title>
</head>
<body>
    <h2>Crear Producto</h2>
    <form action="index.php?controller=Admin&action=botonCrearProducto" method="POST">
        <label for="id_producto">ID Producto</label>
        <input type="text" id="" name="id_producto" required><br><br>
    
        <label for="nombre">Nombre</label>
        <input type="text" id="" name="nombre" required><br><br>

        <label for="descripcion">Descripción</label>
        <input type="text" id="" name="descripcion" required><br><br>

        <label for="precio">Precio</label>
        <input type="text" id="" name="precio" required><br><br>

        <label for="stock">Stock</label>
        <input type="text" id="" name="stock" required><br><br>

        <label for="destacado">Destacado</label>
        <input type="checkbox" id="" name="destacado" ><br><br>

        <label for="estado">Estado</label>
        <input type="checkbox" id="" name="estado" ><br><br>

        <label for="referencia">Referencia</label>
        <input type="checkbox" id="" name="referencia" ><br><br>

        <label for="imagen">Imagen del producto</label>
	    <input type="file" id="imagen" name="imagen"><br><br>

        <input type="submit" value="Crear">


    </form>
</body>
</html>
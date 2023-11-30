<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Crear Categotia</h2>
    <form action="index.php?controller=Admin&action=botonCrearCategoria" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" id="" name="nombre" required><br><br>

        <label for="genero">Género:</label>
        <select id="genero" name="genero">
            <option value="hombre">Hombre</option>
            <option value="mujer">Mujer</option>
        </select>

       
	    <input type="checkbox" id="estado" name="estado">
	    <label for="estado">Estado</label><br>

        <input type="submit" value="Enviar">


    </form>
</body>
</html>
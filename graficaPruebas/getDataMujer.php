<?php
$host = "localhost";
$usuario = "postgres";
$contrasena = "123";
$base_de_datos = "srg";

$dsn = "pgsql:host=$host;dbname=$base_de_datos;port=5432";
$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conexion = new PDO($dsn, $usuario, $contrasena, $opciones);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}

$query = "SELECT p.id_producto, p.nombre, SUM(cantidad) as totalCantidad FROM carrito c JOIN productos p ON c.id_producto = p.id_producto JOIN categorias cat ON p.id_categoria = cat.id_categoria WHERE c.comprado = true AND cat.sexo = 'Mujer' GROUP BY p.id_producto, p.nombre ORDER BY totalCantidad DESC LIMIT 5";

$statement = $conexion->prepare($query);
$statement->execute();

$productosMasVendidos = $statement->fetchAll(PDO::FETCH_ASSOC);

$conexion = null;

header('Content-Type: application/json');
echo json_encode($productosMasVendidos);
?>

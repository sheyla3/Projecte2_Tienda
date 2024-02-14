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

$query = "SELECT id_producto, SUM(cantidad) as totalCantidad FROM carrito WHERE comprado = true GROUP BY id_producto ORDER BY totalCantidad DESC LIMIT 5";

$statement = $conexion->prepare($query);
$statement->execute();

$productosMasVendidos = $statement->fetchAll(PDO::FETCH_ASSOC);

$conexion = null;

header('Content-Type: application/json');
echo json_encode($productosMasVendidos);
?>

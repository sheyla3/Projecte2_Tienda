<?php
require_once("database.php");
class Carrito extends Database {
    protected $db;
    private $id_carrito;
	private $correo;
	private $id_producto;
	private $cantidad;
    private $precio;

    public function __construct($db,$id_carrito,$correo,$id_producto,$cantidad,$precio) {
		$this->db = $db;
		$this->id_carrito = $id_carrito;
		$this->correo = $correo;
		$this->id_producto = $id_producto;
		$this->cantidad = $cantidad;
        $this->precio = $precio;
	}


public function anadirProductoAlCarrito() {
    try {
        $consulta = $this->db->prepare("INSERT INTO carrito (correo, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
        $consulta->bindParam(1, $this->correo);
        $consulta->bindParam(2, $this->id_producto);
        $consulta->bindParam(3, $this->cantidad);
        $consulta->bindParam(4, $this->precio);

        $consulta->execute();
        $last_id = $this->db->lastInsertId();
        echo "Nuevo producto agregado al carrito correctamente";
        echo "ID del último producto en el carrito: " . $last_id;
        // Puedes redirigir o hacer otras acciones después de agregar el producto al carrito
        return true;
    } catch (PDOException $e) {
        // Captura la excepción y muestra el mensaje de error
        echo "Error al agregar el producto al carrito: " . $e->getMessage();
        return null;
    }
}


public function obtenerProductosEnCarrito() {
    try {
        $consulta = $this->db->prepare("SELECT * FROM carrito WHERE correo = ?");
        $consulta->bindParam(1, $this->correo);
        $consulta->execute();
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    } catch (PDOException $e) {
        // Captura la excepción y muestra el mensaje de error
        echo "Error al obtener productos en el carrito: " . $e->getMessage();
        return null;
    }
}
}





?>
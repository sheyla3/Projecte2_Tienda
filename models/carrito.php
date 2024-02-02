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

// hacer esto en la base de datos para evitar duplicados 
//     ALTER TABLE carrito
// ADD CONSTRAINT uk_correo_id_producto UNIQUE (correo, id_producto);

public function anadirProductoAlCarrito() {
    try {
        // Verificar si ya existe un registro para el mismo producto y usuario no comprado
        $verificarConsulta = $this->db->prepare("
            SELECT id_producto
            FROM carrito
            WHERE correo = ? AND id_producto = ? AND comprado = false
        ");
        
        $verificarConsulta->bindParam(1, $this->correo);
        $verificarConsulta->bindParam(2, $this->id_producto);
        $verificarConsulta->execute();

        $registroExistente = $verificarConsulta->fetch(PDO::FETCH_ASSOC);

        if ($registroExistente) {
            // Ya existe un registro no comprado, entonces actualizar cantidad y precio
            $consulta = $this->db->prepare("
                UPDATE carrito
                SET cantidad = cantidad + ?, precio = ?
                WHERE correo = ? AND id_producto = ? AND comprado = false
            ");

            $consulta->bindParam(1, $this->cantidad);
            $consulta->bindParam(2, $this->precio);
            $consulta->bindParam(3, $this->correo);
            $consulta->bindParam(4, $this->id_producto);

            $consulta->execute();

            echo "Producto actualizado en el carrito correctamente";
        } else {
            // No existe un registro no comprado, entonces insertar
            $nuevaConsulta = $this->db->prepare("
                INSERT INTO carrito (correo, id_producto, cantidad, precio)
                VALUES (?, ?, ?, ?)
            ");

            $nuevaConsulta->bindParam(1, $this->correo);
            $nuevaConsulta->bindParam(2, $this->id_producto);
            $nuevaConsulta->bindParam(3, $this->cantidad);
            $nuevaConsulta->bindParam(4, $this->precio);

            $nuevaConsulta->execute();

            $last_id = $this->db->lastInsertId();
            echo "Nuevo producto agregado al carrito correctamente";
            echo "ID del último producto en el carrito: " . $last_id;
        }

        return true;
    } catch (PDOException $e) {
        // Captura la excepción y muestra el mensaje de error
        echo "Error al agregar el producto al carrito: " . $e->getMessage();
        return null;
    }
}


    
    


// public function obtenerProductosEnCarrito() {
//     try {
//         $consulta = $this->db->prepare("SELECT id_producto, cantidad FROM carrito WHERE correo = ?");
//         $consulta->bindParam(1, $this->correo);
//         $consulta->execute();
//         $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

//         return $resultados;
//     } catch (PDOException $e) {
//         // Captura la excepción y muestra el mensaje de error
//         echo "Error al obtener productos en el carrito: " . $e->getMessage();
//         return null;
//     }
// }


public function obtenerProductosEnCarrito() {
    try {
        // Consulta que combina información de carrito, productos y fotos
        $consulta = $this->db->prepare("
            SELECT c.id_producto, c.cantidad, p.nombre, p.precio, p.stock, f.img
            FROM carrito c
            JOIN productos p ON c.id_producto = p.id_producto
            JOIN fotos f ON p.id_producto = f.id_producto
            WHERE c.correo = ? AND c.comprado = false
        ");
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



public function actualizarProductoEnCarrito($accion) {
    try {
        switch ($accion) {
            case 'subir':
                // Lógica para subir la cantidad del producto
                $consulta = $this->db->prepare("UPDATE carrito SET cantidad = cantidad + 1 WHERE correo = ? AND id_producto = ?");
                break;
            case 'bajar':
                // Lógica para bajar la cantidad del producto (verificando que no sea menor a 0)
                $consulta = $this->db->prepare("UPDATE carrito SET cantidad = GREATEST(cantidad - 1, 0) WHERE correo = ? AND id_producto = ?");
                break;
            case 'eliminar':
                // Lógica para eliminar el producto del carrito
                $consulta = $this->db->prepare("DELETE FROM carrito WHERE correo = ? AND id_producto = ?");
                break;
            default:
                // Acción no reconocida, no realizar ninguna operación
                return false;
        }

        $consulta->bindParam(1, $this->correo);
        $consulta->bindParam(2, $this->id_producto);
        $consulta->execute();

        // Verificar si se afectó algún registro (si se eliminó, rowCount será mayor a 0)
        if ($consulta->rowCount() > 0) {
            echo "Producto actualizado en el carrito correctamente";
            return true;
        } else {
            echo "Ningún producto afectado (es posible que el producto no esté en el carrito)";
            return false;
        }
    } catch (PDOException $e) {
        // Captura la excepción y muestra el mensaje de error
        echo "Error al actualizar el producto en el carrito: " . $e->getMessage();
        return false;
    }
}


}





?>
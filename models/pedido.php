<?php
require_once("database.php");

class Pedido extends Database
{
    protected $db;
    private $id_pedido;
    private $correo;
    private $estado;
    private $fechapedido;
    private $fechaenvio;

    public function __construct($db, $id, $correo, $estado, $fechapedido, $fechaenvio)
    {
        $this->db = $db;
        $this->id_pedido = $id;
        $this->correo = $correo;
        $this->estado = $estado;
        $this->fechapedido = $fechapedido;
        $this->fechaenvio = $fechaenvio;
    }

    public function buscarPedido($filtro)
    {
        $filtro = "%$filtro%";
        $consulta = $this->db->prepare("SELECT * FROM pedidos WHERE correo LIKE ? OR estado LIKE ?");
        $consulta->bindParam(1, $filtro);
        $consulta->bindParam(2, $filtro);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function obtenerPedidos()
    {
        $consulta = $this->db->prepare("SELECT * FROM pedidos");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function obtenerCorreo()
    {
        $consulta = $this->db->prepare("SELECT correo FROM pedidos");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function obtenerInfo($id)
    {
        $consulta = $this->db->prepare("SELECT * FROM pedidos WHERE id_pedido = ?");
        $consulta->bindParam(1, $id);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function pedidosGeneral()
    {
        $consulta = $this->db->prepare("SELECT * FROM pedidos");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    // public function obtenerBusquedaGeneral($filtro, $contenido) {
    // 	$contenido = "%$contenido%";
    // 	$consulta = $this->db->prepare("SELECT Pedido.id_Pedido, Pedido.nombre, Pedido.estado, Pedido.sexo FROM producto WHERE $filtro LIKE ?");
    // 	$consulta->bindParam(1, $contenido);
    // 	$consulta->execute();
    // 	$resultado = $consulta->fetchAll();
    // 	return $resultado;
    // }
    public function crearNuevoPedido()
    {
        try {
            // Paso 1: Crear nuevo pedido
            $fechaPedido = date("Y-m-d H:i:s"); // Obtener la fecha actual
            $estadoPedido = "Pendiente"; // Puedes ajustar esto según tu lógica
            $consultaPedido = $this->db->prepare("INSERT INTO pedidos (correo, estado, fechapedido, fechaenvio) VALUES (?, ?, ?, null)");
            $consultaPedido->bindParam(1, $this->correo);
            $consultaPedido->bindParam(2, $estadoPedido);
            $consultaPedido->bindParam(3, $fechaPedido);
            $consultaPedido->execute();

            $consulta = $this->db->prepare("SELECT id_pedido FROM pedidos ORDER BY id_pedido DESC LIMIT 1");
            $consulta->execute();
            $idPedido = $consulta->fetchColumn();

            // Paso 2: Actualizar carrito
            $consultaCarrito = $this->db->prepare("UPDATE carrito SET id_pedido = ?, comprado = true WHERE correo = ? AND id_pedido IS NULL AND comprado = false");
            $consultaCarrito->bindParam(1, $idPedido);
            $consultaCarrito->bindParam(2, $this->correo);
            $consultaCarrito->execute();

            // Obtener productos en el carrito para restar stock
            $consultaProductosCarrito = $this->db->prepare("SELECT id_producto, cantidad FROM carrito WHERE id_pedido = ?");
            $consultaProductosCarrito->bindParam(1, $idPedido);
            $consultaProductosCarrito->execute();
            $productosCarrito = $consultaProductosCarrito->fetchAll(PDO::FETCH_ASSOC);

            // Actualizar el stock de productos
            foreach ($productosCarrito as $producto) {
                $idProducto = $producto['id_producto'];
                $cantidadEnCarrito = $producto['cantidad'];

                // Restar la cantidad en el carrito del stock de productos
                $consultaRestarStock = $this->db->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
                $consultaRestarStock->bindParam(1, $cantidadEnCarrito);
                $consultaRestarStock->bindParam(2, $idProducto);
                $consultaRestarStock->execute();
            }

            return true; // Éxito
        } catch (PDOException $e) {
            // Capturar la excepción y mostrar el mensaje de error
            echo "Error al crear el pedido: " . $e->getMessage();
            return false; // Fracaso
        }
    }

    public function obtenerPedidosUsuario($email)
    {
        $database = new Database();
        $this->db = $database->getDB();
        if ($this->db !== null) {
            try {
                $consulta = $this->db->prepare("SELECT * FROM pedidos WHERE correo = :correo");
                $consulta->bindParam(':correo', $email, PDO::PARAM_STR);
                $consulta->execute();

                $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

                return $resultados;
            } catch (PDOException $e) {
                // Manejar el error de la consulta
                echo "Error en la consulta: " . $e->getMessage();
                return false;
            }
        } else {
            // Manejo de error si la conexión no está disponible
            echo "Error: La conexión a la base de datos no está disponible.";
            return false;
        }
    }

    public function getPedidoById($idPedido)
    {
        try {
            $database = new Database();
            $this->db = $database->getDB();

            if ($this->db !== null) {
                $query = "SELECT * FROM pedidos WHERE id_pedido = :id_pedido";
                $stmt = $this->db->prepare($query);

                // Ligando el parámetro
                $stmt->bindParam(':id_pedido', $idPedido, PDO::PARAM_INT);

                // Ejecutar la consulta
                $stmt->execute();

                // Obtener el resultado
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                return $resultado;

            } else {
                // Manejo de error si la conexión no está disponible
                echo "Error: La conexión a la base de datos no está disponible.";
                return false;
            }
        } catch (PDOException $e) {
            // Manejar el error de la consulta
            echo "Error en la consulta: " . $e->getMessage();
            return false;

        } finally {
            // Asegurar que la conexión se cierre independientemente de lo que suceda
            if ($this->db !== null) {
                $this->db = null;
            }
        }
    }

    public function actualizarEstado($pedidoId, $nuevoEstado) {
        // Lógica para actualizar el estado del pedido en la base de datos
        try {
            $database = new Database();
            $this->db = $database->getDB();

            $fechaEnvio = ($nuevoEstado == 'Enviado') ? date('Y-m-d H:i:s') : null;


            $consulta = "UPDATE pedidos SET estado = :estado, fechaenvio = :fechaenvio WHERE id_pedido = :id_pedido";
            $stmt = $this->db->prepare($consulta);
            
            $stmt->bindParam(':id_pedido', $pedidoId, PDO::PARAM_INT);
            $stmt->bindParam(':estado', $nuevoEstado, PDO::PARAM_STR);
            $stmt->bindParam(':fechaenvio', $fechaEnvio, PDO::PARAM_STR);

            $stmt->execute();

            // Redireccionar a la vista de la tabla de pedidos u otra página
            // header('Location: index.php?controller=pedido&action=mostrarProductos');

        } catch (PDOException $e) {
            echo "Error al actualizar el estado del pedido: " . $e->getMessage();
        } finally {
            $pdo = null;
        }
    }

}

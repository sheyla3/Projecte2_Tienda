<?php
require_once("database.php");

class Pedido extends Database 
{
	protected $db;
	private $id_pedido;
	private $correo;
	private $id_carrito;
	private $estado;
    private $fechapedido;
    private $fechaenvio;

	public function __construct($db,$id,$correo,$estado,$id_carrito,$fechapedido,$fechaenvio) {
		$this->db = $db;
		$this->id_pedido = $id;
		$this->correo = $correo;
        $this->id_carrito = $id_carrito;
		$this->estado = $estado;
		$this->fechapedido = $fechapedido;
		$this->fechaenvio = $fechaenvio;
	}

	public function buscarPedido($filtro) {
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

	public function obtenerCorreo() {
    	$consulta = $this->db->prepare("SELECT correo FROM pedidos");
    	$consulta->execute();
    	$resultado = $consulta->fetchAll();
    	return $resultado;
	}

	public function obtenerInfo($id) {
    	$consulta = $this->db->prepare("SELECT * FROM pedidos WHERE id_pedido = ?");
    	$consulta->bindParam(1, $id);
    	$consulta->execute();
    	$resultado = $consulta->fetchAll();
    	return $resultado;
	}

	public function pedidosGeneral() {
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

	function obtenerPedidosUsuario($correo) {
		global $conexion;
	
		// Consulta SQL para obtener los pedidos de un usuario específico
		$consulta = "SELECT id_carrito, id_producto, cantidad, preciototal, estado FROM pedidos WHERE correo = :correo";
	
		// Preparar la consulta
		$stmt = pg_prepare($conexion, "consulta_pedidos", $consulta);
	
		// Asignar valores a los parámetros
		pg_execute($conexion, "consulta_pedidos", array(":correo" => $correo));
	
		// Verificar si la ejecución fue exitosa
		if ($stmt) {
			$pedidos = array();
	
			// Obtener los resultados como un array asociativo
			while ($fila = pg_fetch_assoc($stmt)) {
				$pedidos[] = $fila;
			}
	
			return $pedidos;
		} else {
			// Manejar errores de la consulta (aquí puedes mejorar el manejo de errores según tus necesidades)
			die("Error en la consulta: " . pg_last_error($conexion));
		}
	}
}



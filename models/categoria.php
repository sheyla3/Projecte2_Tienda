<?php
require_once("database.php");

class Categoria extends Database {
	protected $db;
	private $id_categoria;
	private $nombre;
	private $estado;
	private $sexo;

	public function __construct($db,$id,$nombre,$estado,$genero) {
		$this->db = $db;
		$this->id_categoria = $id;
		$this->nombre = $nombre;
		$this->estado = $estado;
		$this->sexo = $genero;
	}

	public function buscarCategoria($filtro) {
    	$filtro = "%$filtro%";
    	$consulta = $this->db->prepare("SELECT id_categoria, nombre, estado, sexo FROM categorias WHERE nombre LIKE ? OR estado LIKE ?");
    	$consulta->bindParam(1, $filtro);
    	$consulta->bindParam(2, $filtro);
    	$consulta->execute();
    	$resultado = $consulta->fetchAll();
    	return $resultado;
	}

	public function obtenerCategorias() {
    	$consulta = $this->db->prepare("SELECT id_categoria, nombre, estado, sexo FROM categorias");
    	$consulta->execute();
    	$resultado = $consulta->fetchAll();
    	return $resultado;
	}

	public function obtenerNombre() {
		$id = $this->id_categoria;
		$consulta = $this->db->prepare("SELECT nombre FROM categorias WHERE id_categoria = ?");
		$consulta->bindParam(1, $id);
		$consulta->execute();
		$resultado = $consulta->fetchColumn(); // Obtiene un solo valor
		return $resultado;
	}
	

	public function anadir() {
		$nombre = $this->nombre;
		$estado = $this->estado;
		$sexo = $this->sexo;
		try {
			$consulta = $this->db->prepare("INSERT INTO categorias (nombre, estado, sexo) VALUES (?, ?, ?)");
			$consulta->bindParam(1, $nombre);
			$consulta->bindParam(2, $estado);
			$consulta->bindParam(3, $sexo);
	
			$consulta->execute();
			$last_id = $this->db->lastInsertId();
			echo "Nueva categoría agregada correctamente";
			echo "ID de la última categoría: " . $last_id;
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='2;URL=index.php?controller=Admin&action=botonVistaCategoria'>";
			return true;
		} catch (PDOException $e) {
			// Captura la excepción y muestra el mensaje de error
			echo "Error al agregar la categoría: " . $e->getMessage();
			return null;
		}
	}
	
	public function editar() {
		try {
			$consulta = $this->db->prepare("UPDATE categorias SET nombre = ?, estado = ?, sexo = ? WHERE id_categoria = ?");
			$consulta->bindParam(1, $this->nombre);
			$consulta->bindParam(2, $this->estado);
			$consulta->bindParam(3, $this->sexo);
			$consulta->bindParam(4, $this->id_categoria);
	
			$count = $consulta->execute();
			echo "Categoría editada correctamente";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='2;URL=index.php?controller=Admin&action=botonVistaCategoria'>";
			return $count; // Devolver el número de registros actualizados
		} catch (PDOException $e) {
			// Manejar la excepción si ocurre un error durante la consulta SQL
			
			return false;
		}
	}
	

	public function obtenerIdNombreCategorias() {
		$consulta = $this->db->prepare("SELECT id_categoria, nombre FROM categorias WHERE estado = true");
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function obtenerIdNombreCategoriasHombre() {
		$consulta = $this->db->prepare("SELECT id_categoria, nombre FROM categorias WHERE estado = true and sexo = 'Hombre'" );
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function obtenerIdNombreCategoriasMujer() {
		$consulta = $this->db->prepare("SELECT id_categoria, nombre FROM categorias WHERE estado = true and sexo = 'Mujer'");
		$consulta->execute();
		$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function activar($id) {
    	$consulta = $this->db->prepare("UPDATE categorias SET estado = 1 WHERE id_categoria = ?");
    	$consulta->bindParam(1, $id);

    	$count = $consulta->execute();
    	echo $count . " registros actualizados correctamente";
	}

	public function desactivar($id) {
    	$consulta = $this->db->prepare("UPDATE categorias SET estado = 0 WHERE id_categoria = ?");
    	$consulta->bindParam(1, $id);

    	$count = $consulta->execute();
    	echo $count . " registros actualizados correctamente";
	}

	public function obtenerInfo() {
		$id = $this->id_categoria;

    	$consulta = $this->db->prepare("SELECT id_categoria, nombre, estado, sexo FROM categorias WHERE id_categoria = ?");
    	$consulta->bindParam(1, $id);
    	$consulta->execute();
    	$resultado = $consulta->fetchAll();
    	return $resultado;
	}

	public function CategoriasGeneral() {
    	$consulta = $this->db->prepare("SELECT * FROM categorias");
    	$consulta->execute();
    	$resultado = $consulta->fetchAll();
    	return $resultado;
	}

	public function obtenerBusquedaGeneral($filtro, $contenido) {
    	$contenido = "%$contenido%";
    	$consulta = $this->db->prepare("SELECT categoria.id_categoria, categoria.nombre, categoria.estado, categoria.sexo FROM producto WHERE $filtro LIKE ?");
    	$consulta->bindParam(1, $contenido);
    	$consulta->execute();
    	$resultado = $consulta->fetchAll();
    	return $resultado;
	}
}



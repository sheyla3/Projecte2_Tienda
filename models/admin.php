<?php
require_once("database.php");

class Admin {
	private $user;
	private $email;
	private $password;
	protected $db; // Debes tener la instancia de la base de datos aquí o pasarlo por el constructor

	// Constructor, donde se inicializan propiedades u objetos necesarios
	public function __construct($db, $user, $email, $password) {
    	$this->db = $db;
		$this->user = $user;
		$this->email = $email;
		$this->password = $password;
	}


	// Método para realizar el login
	public function login() {

		$email = $this->user;
		$password = $this->password;

    	$consulta = $this->db->prepare("SELECT * FROM admin WHERE usuario = :email AND contrasena = :password");
    	$consulta->bindParam(':email', $email);
    	$consulta->bindParam(':password', $password);
    	$consulta->execute();

    	// Verifica si hay filas devueltas por la consulta
    	if ($consulta->rowCount() > 0) {
        	return true;
    	} else {
        	return false;
    	}
	}

	public function datosEmpresa()
    {
        $query = "SELECT * FROM empresa";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Obtener los detalles del carrito como un array asociativo
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

	public function firma()
    {
        $query = "SELECT firma FROM admin";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Obtener los detalles del carrito como un array asociativo
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }


	public function productosMasComprados()
	{
		$query = "SELECT id_producto, SUM(cantidad) as totalCantidad FROM carrito WHERE comprado = true GROUP BY id_producto ORDER BY totalCantidad DESC LIMIT 5";

		$stmt = $this->db->prepare($query);
		$stmt->execute();

		$productosMasVendidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $productosMasVendidos;
	}

	public function actualizarFirma($filePath)
    {
		$query = "UPDATE admin SET firma = :rutaFirma WHERE email = :emailAdmin";
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':rutaFirma', $filePath);
		$stmt->bindParam(':emailAdmin', $this->email);
		$stmt->execute();
		
    }


}

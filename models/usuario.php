<?php
require_once("database.php");

class Usuario {
	private $email;
	private $password;
	private $name;
	private $lastname;
	private $phone;
	private $address;
	private $photo;
	protected $db; // Debes tener la instancia de la base de datos aquí o pasarlo por el constructor

	// Constructor, donde se inicializan propiedades u objetos necesarios
	public function __construct($db, $email, $password, $name, $lastname, $phone, $address, $photo) {
    	$this->db = $db;
		$this->email = $email;
		$this->password = $password;
		$this->name = $name;
		$this->lastname = $lastname;
		$this->phone = $phone;
		$this->address = $address;
		$this->photo = $photo;
	}


	// Método para realizar el login
	public function login() {

	$email = $this->email;
	$password = $this->password;

    	$consulta = $this->db->prepare("SELECT * FROM usuarios WHERE correo = :email AND contrasena = :password");
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

	public function agregarUsuario() {
        $consulta = $this->db->prepare("INSERT INTO usuarios (correo, contrasena, nombre, apellidos, telf, direccion, foto) VALUES (:email, :password, :name, :lastname, :phone, :address, :photo)");
        
        $consulta->bindParam(':email', $this->email);
        $consulta->bindParam(':password', $this->password);
        $consulta->bindParam(':name', $this->name);
        $consulta->bindParam(':lastname', $this->lastname);
        $consulta->bindParam(':phone', $this->phone);
        $consulta->bindParam(':address', $this->address);
        $consulta->bindParam(':photo', $this->photo);
        
        try {
            $consulta->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
	public function getProfile($email){
		try {
			$consulta = $this->db->prepare("SELECT * FROM usuarios WHERE correo = :email");
			$consulta->bindParam(':email', $email); // Asignar valor al marcador
			$consulta->execute(); // Ejecutar la consulta con el valor asignado
	
			$datosUser = $consulta->fetchAll(PDO::FETCH_ASSOC);
			return $datosUser;
		} catch (PDOException $e) {
			// Manejo de excepciones, por ejemplo:
			echo "Error al obtener el perfil del usuario: " . $e->getMessage();
			return null;
		}
	}
	
}

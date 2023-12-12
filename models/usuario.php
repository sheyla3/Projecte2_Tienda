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
		$this->address = $address
		$this->photo = $photo
	}


	// Método para realizar el login
	public function login() {

	$email = $this->user;
	$password = $this->password;

    	$consulta = $this->db->prepare("SELECT * FROM usuarios WHERE usuario = :email AND contrasena = :password");
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
}

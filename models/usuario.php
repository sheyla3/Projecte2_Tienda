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
	
		$consulta = $this->db->prepare("SELECT contrasena FROM usuarios WHERE correo = :email");
		$consulta->bindParam(':email', $email);
		$consulta->execute();
	
		$hashedPassword = $consulta->fetchColumn();
	
		if ($hashedPassword) {
			if (password_verify($password, $hashedPassword)) {
				return true;
			}
		}
	
		return false;
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
}

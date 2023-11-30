<?php
require_once("database.php");

class Admin {
	protected $db; // Debes tener la instancia de la base de datos aquí o pasarlo por el constructor

	// Constructor, donde se inicializan propiedades u objetos necesarios
	public function __construct($db) {
    	$this->db = $db;
	}

	// Método para realizar el login
	public function login($email, $password) {
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
}

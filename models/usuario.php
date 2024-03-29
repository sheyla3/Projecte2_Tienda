<?php
require_once("database.php");

/**
 * Clase para gestionar los usuarios del sistema.
 */
class Usuario {
	/** @var string El correo electrónico del usuario. */
	private $email;
	/** @var string La contraseña del usuario. */
	private $password;
	/** @var string El nombre del usuario. */
	private $name;
	/** @var string Los apellidos del usuario. */
	private $lastname;
	/** @var string El teléfono del usuario. */
	private $phone;
	/** @var string La dirección del usuario. */
	private $address;
	/** @var string La foto del usuario. */
	private $photo;
	/** @var PDO La instancia de la base de datos. */
	protected $db;

	/**
	 * Constructor de la clase Usuario.
	 *
	 * @param PDO $db La instancia de la base de datos.
	 * @param string $email El correo electrónico del usuario.
	 * @param string $password La contraseña del usuario.
	 * @param string $name El nombre del usuario.
	 * @param string $lastname Los apellidos del usuario.
	 * @param string $phone El teléfono del usuario.
	 * @param string $address La dirección del usuario.
	 * @param string $photo La foto del usuario.
	 */
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

	/**
	 * Método para realizar el login.
	 *
	 * @return bool True si el login es exitoso, False en caso contrario.
	 */
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

	/**
	 * Método para agregar un nuevo usuario.
	 *
	 * @return bool True si se agregó correctamente, False en caso contrario.
	 */
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

	/**
	 * Método para obtener el perfil de un usuario.
	 *
	 * @param string $email El correo electrónico del usuario.
	 * @return array|null Los datos del usuario si se encontraron, Null si no se encontró ningún usuario o ocurrió un error.
	 */
	public function getProfile($email){
		$database = new Database();
        $this->db = $database->getDB();
		try {
			$consulta = $this->db->prepare("SELECT correo, nombre, apellidos, telf, direccion, foto FROM usuarios WHERE correo = :email");
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

	/**
	 * Método para editar la foto de perfil de un usuario.
	 *
	 * @return PDOStatement|null La consulta preparada si se pudo preparar correctamente, Null en caso contrario.
	 */
	public function editFoto(){
		try {
			$consulta = $this->db->prepare("UPDATE usuarios SET foto = :photo WHERE correo = :email");
            return $consulta;
        } catch (PDOException $e) {
            echo "Error al preparar la consulta: " . $e->getMessage();
            return null;
        }
	}
	
	/**
	 * Método para actualizar el perfil de un usuario.
	 *
	 * @param string $nombre El nuevo nombre del usuario.
	 * @param string $apellidos Los nuevos apellidos del usuario.
	 * @param string $direccion La nueva dirección del usuario.
	 * @param string $telefono El nuevo teléfono del usuario.
	 * @return bool True si se actualizó correctamente, False en caso contrario.
	 */
	public function updateProfile($nombre, $apellidos, $direccion, $telefono) {
		try {
			$consulta = $this->db->prepare("UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, direccion = :direccion, telf = :telefono WHERE correo = :email");
			
			$consulta->bindParam(':nombre', $nombre);
			$consulta->bindParam(':apellidos', $apellidos);
			$consulta->bindParam(':direccion', $direccion);
			$consulta->bindParam(':telefono', $telefono);
			$consulta->bindParam(':email', $this->email);
	
			$consulta->execute();
			
			return true;
		} catch (PDOException $e) {
			echo "Error al actualizar el perfil: " . $e->getMessage();
			return false;
		}
	}
}

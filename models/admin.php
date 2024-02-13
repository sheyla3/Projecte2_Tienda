<?php
require_once("database.php");

/**
 * Clase que representa un administrador del sistema.
 */
class Admin {
    /** @var Database La instancia de la base de datos. */
    protected $db;
    /** @var string El nombre de usuario del administrador. */
    private $user;
    /** @var string El correo electrónico del administrador. */
    private $email;
    /** @var string La contraseña del administrador. */
    private $password;

    /**
     * Constructor de la clase Admin.
     *
     * @param Database $db La instancia de la base de datos.
     * @param string $user El nombre de usuario del administrador.
     * @param string $email El correo electrónico del administrador.
     * @param string $password La contraseña del administrador.
     */
    public function __construct($db, $user, $email, $password) {
        $this->db = $db;
        $this->user = $user;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Método para realizar el login del administrador.
     *
     * @return bool Devuelve true si el login es exitoso, false en caso contrario.
     */
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

    /**
     * Método para obtener los datos de la empresa.
     *
     * @return array Los datos de la empresa como un array asociativo.
     */
    public function datosEmpresa() {
        $query = "SELECT * FROM empresa";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Obtener los detalles de la empresa como un array asociativo
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }

    /**
     * Método para obtener la firma del administrador.
     *
     * @return array La firma del administrador como un array asociativo.
     */
    public function firma() {
        $query = "SELECT firma FROM admin";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Obtener la firma del administrador como un array asociativo
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $datos;
    }
}

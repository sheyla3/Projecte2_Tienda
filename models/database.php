<?php

/**
 * Clase para la gestión de la conexión a la base de datos.
 */
class Database{
    /** @var PDO La instancia de la base de datos. */
    protected $db;

    /**
     * Constructor de la clase Database.
     */
    public function __construct(){
        $servername = "localhost";
        $dbname= "srg";
        $username = "postgres";
        $password = "admin1234";

        try{
            // Crear una nueva conexión instanciando el objeto PDO
            $this->db = new PDO("pgsql:host=$servername;dbname=$dbname",$username, $password);
            // Establecer el modo PDO error a exception para poder recuperar las excepciones
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $error) {
            // Capturar y mostrar el mensaje de error si la conexión falla
            echo "Connection failed: ". $error->getMessage();
        }
    }
    
    /**
     * Método para obtener la instancia de la base de datos.
     *
     * @return PDO La instancia de la base de datos.
     */
    public function getDB() {
        return $this->db;
    }

}

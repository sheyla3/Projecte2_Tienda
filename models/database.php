<?php

class Database{
    protected $db;
    
    
    public function __construct(){
        $servername = "localhost";
        $dbname= "srg";
        $username = "postgres";
        $password = "admin1234";

        try{
        //Creem una nova connexió instancinat l'objecte PDO
		$this->db = new PDO("pgsql:host=$servername;dbname=$dbname",$username, $password);
		// Establim el mode PDO error a exception per poder recuperar les excepccions
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
        catch(PDOException $error)
        {
            echo "Connection failed: ". $error->getMessage();
            
        }
        
        
    }
    public function getDB() {
        return $this->db;
    }

}


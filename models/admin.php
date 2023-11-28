<?php
require_once("database.php");
class Admin extends Database
{
    private $email;
    private $usuario;
    private $password;

    public function login($email, $password)
    {
        $consulta = $this->db->prepare("SELECT * FROM admin WHERE email LIKE '$email' and password LIKE '$password'");
        $consulta->execute();
        if ($consulta->fetch(PDO::FETCH_OBJ)) {
            return true;
        } else {
            return false;
        }
    }
}

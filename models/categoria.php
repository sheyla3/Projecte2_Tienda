<?php
require_once("database.php");
class Categoria extends Database
{
    private $id_categoria;
    private $nombre;
    private $estado;
    private $sexo;

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    public function buscarCategoria($filtro)
    {
        $consulta = $this->db->prepare("SELECT id_categoria, nombre, estado, sexo, FROM categorias WHERE nombre LIKE '%$filtro%' OR estado LIKE '%$filtro%'");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function obtenerCategorias()
    {
        $consulta = $this->db->prepare("SELECT id_categoria, nombre, estado, sexo, FROM categorias");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function obtenerNombre()
    {
        $consulta = $this->db->prepare("SELECT nombre FROM categorias");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function anadir(
        $id_categoria,
        $nombre,
        $estado,
        $sexo,
    ) 
    {
        $consulta = $this->db->prepare("INSERT INTO categorias (id_categoria, nombre, estado, sexo) VALUES ($id_categoria,$nombre,$estado,$sexo)") ;
        $consulta->execute();
        $last_id = $this->db->lastInsertId();
        echo "Nuevo categoria agregado correctamente";
        echo "ID de la ultima categoria: " . $last_id;
    }

    public function editar(
        $id_categoria,
        $nombre,
        $estado,
        $sexo,
    ) 
    {
        $consulta = $this->db->prepare("UPDATE categotias SET id_categoria= $id_categoria, nombre = $nombre, estado = '$estado', sexo= '$sexo'");
        $count =$consulta->execute();
        echo $count." registros actualizados correctamente";
    }

    public function activar($id){
        $consulta = $this->db->prepare("UPDATE categorias SET estado = 1 WHERE id_categoria LIKE '$id'");
        $count =$consulta->execute();
        echo $count." registros actualizados correctamente";
    } 

    public function desactivar($id){
        $consulta = $this->db->prepare("UPDATE categorias SET estado = 0 WHERE id_categoria LIKE '$id'");
        $count =$consulta->execute();
        echo $count." registros actualizados correctamente";
    } 

    public function obtenerInfo($id){
        $consulta = $this->db->prepare("SELECT id_categoria, nombre, estado, sexo FROM categorias INNER JOIN WHERE id_categoria = $id");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    
    public function CategoriasGeneral()
    {
        $consulta = $this->db->prepare("SELECT * FROM categorias");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function obtenerBusquedaGeneral($filtro,$contenido)
    {
        $consulta = $this->db->prepare("SELECT categoria.id_categoria, categoria.nombre, categoria.estado, categoria.sexo FROM producto WHERE $filtro LIKE '%$contenido%'");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    
}
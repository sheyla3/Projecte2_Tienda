<?php
require_once("database.php");
class Producto extends Database
{
    // private $id_producto;
    // private $nombre;
    // private $descripcion;
    // private $precio;
    // private $stock;
    // private $destacado;
    // private $stock;
    // private $estado;
    // private $imagen;

    private $cantidad;
    
    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function buscarproductos($filtro)
    {
        $consulta = $this->db->prepare("SELECT id_producto, categorias.nombre AS categoria, referencia, nombre, descripcion, precio, stock, destacado, fk_id_categoria, estado, imagen FROM producto INNER JOIN categorias ON producto.fk_id_categoria = categorias.id_categoria WHERE producto.nombre LIKE '%$filtro%' OR referencia LIKE '%$filtro%'");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function obtenerCatalogo()
    {
        // $consulta = $this->db->prepare("SELECT id_producto, categorias.nombre AS categoria, referencia, nombre, descripcion, precio, stock, destacado, fk_id_categoria, estado, imagen FROM producto INNER JOIN categorias ON producto.fk_id_categoria = categorias.id_categoria");
        // $consulta->execute();
        // $resultado = $consulta->fetchAll();
        // return $resultado;
        return "holaa admin";
    }

    public function anadir(
        $id_producto,
        $referencia,
        $nombre,
        $descripcion,
        $precio,
        $stock,
        $destacado,
        $imagen,
        $estado,
    ) 
    {
        $consulta = $this->db->prepare("INSERT INTO producto (fk_id_categoria, referencia, nombre, descripcion, stock, precio, imagen, estado) VALUES ($id_producto, $referencia, '$nombre', '$descripcion', $stock, $precio, '$imagen', 1)") ;
        $consulta->execute();
        $last_id = $this->db->lastInsertId();
        echo "Nuevo producto agregado correctamente";
        echo "ID del ultimo producto: " . $last_id;
    }

    public function editar(
        $id_producto,
        $referencia,
        $nombre,
        $descripcion,
        $precio,
        $stock,
        $destacado,
        $imagen,
        $estado,
    ) 
    {
        $consulta = $this->db->prepare("UPDATE producto SET fk_id_categoria= $id_producto, referencia = $referencia, nombre = '$nombre', descripcion= '$descripcion', descripcion = '$descripcion', stock = $stock, precio = $precio, imagen = '$imagen', estado=1 WHERE id_producto = $id_producto") ;
        $count =$consulta->execute();
        echo $count." registros actualizados correctamente";
    }

    public function activar($id){
        $consulta = $this->db->prepare("UPDATE producto SET estado = 1 WHERE id_producto LIKE '$id'");
        $count =$consulta->execute();
        echo $count." registros actualizados correctamente";
    } 

    public function desactivar($id){
        $consulta = $this->db->prepare("UPDATE productos SET estado = 0 WHERE id_producto LIKE '$id'");
        $count =$consulta->execute();
        echo $count." registros actualizados correctamente";
    } 

    public function obtenerInfo($id){
        $consulta = $this->db->prepare("SELECT id_producto, categorias.nombre AS categoria, referencia, producto.nombre AS nombre, descripcion, stock, precio, imagen, fk_id_categoria FROM productos INNER JOIN categorias ON producto.fk_id_categoria = categorias.id_categoria WHERE id_producto = $id");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    
    public function productoDestacado()
    {
        $consulta = $this->db->prepare("SELECT * FROM productos WHERE destacado = 1");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function productosCategoria($id)
    {
        $consulta = $this->db->prepare("SELECT * FROM productos WHERE fk_id_categoria = $id");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    public function productosGeneral()
    {
        $consulta = $this->db->prepare("SELECT * FROM productos");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function obtenerBusquedaGeneral($filtro,$contenido)
    {
        $consulta = $this->db->prepare("SELECT producto.id_producto, producto.fk_id_categoria, producto.referencia, producto.nombre, producto.descripcion, producto.stock, producto.precio, producto.imagen, producto.destacado, producto.estado FROM producto INNER JOIN categorias ON producto.fk_id_categoria = categorias.id_categoria WHERE $filtro LIKE '%$contenido%'");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }


    
}

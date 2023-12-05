<?php
require_once("database.php");
class Producto extends Database
{
    protected $db;
    private $id_producto;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $destacado;
    private $categoria;
    private $estado;
    private $imagen;
    private $referencia;

    public function __construct($db,$id_producto,$nombre,$descripcion,$precio,$stock,$destacado,$categoria,$estado,$imagen,$referencia) {
		$this->db = $db;
		$this->id_producto = $id_producto;
		$this->nombre = $nombre;
        $this->descripcion = $descripcion;
		$this->precio = $precio;
		$this->stock = $stock;
		$this->destacado = $destacado;
        $this->categoria = $categoria;
        $this->estado = $estado;
		$this->imagen = $imagen;
        $this->referencia = $referencia;
	}
    
    public function getCantidad()
    {
        return $this->stock;
    }

    public function setCantidad($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    public function buscarproductos($filtro)
    {
        $consulta = $this->db->prepare("SELECT id_producto, categorias.nombre AS categoria, referencia, nombre, descripcion, precio, stock, destacado, fk_id_categoria, estado, imagen FROM producto INNER JOIN categorias ON producto.fk_id_categoria = categorias.id_categoria WHERE producto.nombre LIKE '%$filtro%' OR referencia LIKE '%$filtro%'");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function obtenerProductos()
    {
        $consulta = $this->db->prepare("SELECT * FROM productos");
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }

    public function anadir() {
        try {
            $this->db->beginTransaction();
    
            // Insertar en la tabla productos y obtener el ID insertado
            $consultaProducto = $this->db->prepare("INSERT INTO productos (id_producto, nombre, descripcion, precio, stock, destacado, id_categoria, estado, referencia) VALUES (:id_producto, :nombre, :descripcion, :precio, :stock, :destacado, :id_categoria, :estado, :referencia) RETURNING id_producto");
            $consultaProducto->bindValue(':id_producto', $this->id_producto);
            $consultaProducto->bindValue(':nombre', $this->nombre);
            $consultaProducto->bindValue(':descripcion', $this->descripcion);
            $consultaProducto->bindValue(':precio', $this->precio);
            $consultaProducto->bindValue(':stock', $this->stock);
            $consultaProducto->bindValue(':destacado', $this->destacado);
            $consultaProducto->bindValue(':id_categoria', $this->categoria);
            $consultaProducto->bindValue(':estado', $this->estado);
            $consultaProducto->bindValue(':referencia', $this->referencia);
    
            if ($consultaProducto->execute()) {
                $lastProductoId = $consultaProducto->fetchColumn(); // Obtener el ID del producto insertado
                
                // Insertar en la tabla fotos usando el ID obtenido
                $consultaFotos = $this->db->prepare("INSERT INTO fotos (id_producto, img) VALUES (:id_producto, :img)");
                $consultaFotos->bindValue(':id_producto', $lastProductoId);
                $consultaFotos->bindValue(':img', $this->imagen);
                $consultaFotos->execute();
    
                $this->db->commit();
                
                echo "Nuevo producto y foto agregados correctamente";
                echo "ID del último producto: " . $lastProductoId;
            } else {
                $this->db->rollBack();
                echo "Error al agregar el producto";
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            echo "Error al agregar el producto y la foto: " . $e->getMessage();
        }
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

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
	$consulta = $this->db->prepare("SELECT id_producto, nombre, descripcion, precio, stock, destacado, id_categoria AS fk_id_categoria, estado, referencia FROM productos WHERE nombre LIKE '%$filtro%' OR referencia LIKE '%$filtro%'");
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
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=index.php?controller=Admin&action=botonVistaProducto'>";


            } else {
                $this->db->rollBack();
                echo "Error al agregar el producto";
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            echo "Error al agregar el producto y la foto: " . $e->getMessage();
        }
    }
    
        public function obtenerNumeroProductos()
    {
        $consulta = $this->db->prepare("SELECT * FROM productos");
        $consulta->execute();
        $cantidad = $consulta->rowCount();
        return $cantidad;
    }

    public function buscador($nom) {
        $consulta = $this->db->prepare("SELECT id_producto, nombre, descripcion, precio, stock, destacado, id_categoria, estado, referencia  FROM productos WHERE nombre ILIKE '%' || :nombre || '%'");
        $consulta->bindParam(':nombre', $nom, PDO::PARAM_STR);
    
        error_log('Consulta SQL ejecutada: ' . $consulta->queryString);
    
        $consulta->execute();
        $resultado = $consulta->fetchAll();
    
        // Añade un mensaje de depuración para ver los resultados
        error_log('Resultados de la consulta: ' . print_r($resultado, true));
    
        return $resultado;
    }
    

    public function editar() {
        try {
            $this->db->beginTransaction();
    
            $consulta = $this->db->prepare("UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, destacado = :destacado, id_categoria = :id_categoria, estado = :estado, referencia = :referencia WHERE id_producto = :id_producto");
            
            $consulta->bindValue(':nombre', $this->nombre);
            $consulta->bindValue(':descripcion', $this->descripcion);
            $consulta->bindValue(':precio', $this->precio);
            $consulta->bindValue(':stock', $this->stock);
            $consulta->bindValue(':destacado', $this->destacado);
            $consulta->bindValue(':id_categoria', $this->categoria);
            $consulta->bindValue(':estado', $this->estado);
            $consulta->bindValue(':referencia', $this->referencia);
            $consulta->bindValue(':id_producto', $this->id_producto);
    
            $consulta->execute();
            
            $this->db->commit();
    
            echo "Producto editado correctamente";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='2;URL=index.php?controller=Admin&action=botonVistaProducto'>";


        } catch (PDOException $e) {
            $this->db->rollBack();
            echo "Error al editar el producto: " . $e->getMessage();
        }
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

    public function obtenerInfo() {
        $consulta = $this->db->prepare("SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.stock, p.destacado, p.id_categoria, p.estado, p.referencia, f.img 
                                        FROM productos p 
                                        LEFT JOIN fotos f ON p.id_producto = f.id_producto 
                                        WHERE p.id_producto = :id");
        $consulta->bindValue(':id', $this->id_producto);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    

    public function obtenerFotos(){
        $consulta = $this->db->prepare("SELECT img FROM fotos WHERE id_producto = :id");
        $consulta->bindValue(':id', $this->id_producto);
        $consulta->execute();
        $resultado = $consulta->fetchAll();
        return $resultado;
    }
    
    
    
    public function productoDestacado()
{
    $consulta = $this->db->prepare("SELECT p.*, f.img 
                                    FROM productos p 
                                    LEFT JOIN fotos f ON p.id_producto = f.id_producto 
                                    WHERE p.destacado = true");
    $consulta->execute();
    $resultado = $consulta->fetchAll();
    return $resultado;
}


    public function productosCategoria()
{
    $consulta = $this->db->prepare("SELECT p.id_producto, p.nombre, p.precio, f.img, p.stock 
                                    FROM productos p 
                                    LEFT JOIN fotos f ON p.id_producto = f.id_producto 
                                    WHERE p.id_categoria = :categoria");
    $consulta->bindParam(':categoria', $this->categoria, PDO::PARAM_INT);
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

    public function obtenerBusquedaGeneral($filtro, $contenido)
{
	$consulta = $this->db->prepare("SELECT producto.id_producto, producto.fk_id_categoria, producto.referencia, producto.nombre, producto.descripcion, producto.stock, producto.precio, producto.imagen, producto.destacado, producto.estado FROM producto INNER JOIN categorias ON producto.fk_id_categoria = categorias.id_categoria WHERE $filtro LIKE :contenido");
	$consulta->bindValue(':contenido', '%' . $contenido . '%');
	$consulta->execute();
	$resultado = $consulta->fetchAll();
	return $resultado;
}



    
}

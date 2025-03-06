<?php
class PrincipalModel extends Query {
 
    public function __construct() {
        parent::__construct();
    }

    public function getProducto($id_producto) {
        $sql = "SELECT p.*, c.nombreCategoria, i.ruta 
        FROM articulos p 
        INNER JOIN categorias c ON p.id_categoria = c.id_categoria 
        LEFT JOIN imagenes i ON p.id_imagen = i.id_imagen 
        WHERE p.id_producto = :id_producto";
        $params = [':id_producto' => $id_producto];
        return $this->select($sql, $params);
    }

    // Paginación
    public function getProductos($desde, $porPagina) {
        $sql = "SELECT p.*, r.ruta FROM articulos p LEFT JOIN imagenes r ON p.id_imagen = r.id_imagen LIMIT :desde, :porPagina";
        $params = [
            ':desde' => (int)$desde,
            ':porPagina' => (int)$porPagina,
        ];
        return $this->selectAll($sql, $params);
    }
    

    // Obtener total productos
    public function getTotalProductos() {
        $sql = "SELECT COUNT(*) AS total FROM articulos";
        return $this->select($sql);
    }

    public function getProductosCat($id_categoria, $desde, $porPagina) {
        $sql = "SELECT a.*, i.ruta FROM articulos a 
                JOIN imagenes i ON a.id_imagen = i.id_imagen 
                WHERE a.id_categoria = :id_categoria 
                LIMIT $desde, $porPagina"; // Evita usar parámetros aquí
        $params = [
            ':id_categoria' => (int)$id_categoria,
        ];
    
        return $this->selectAll($sql, $params);
    }
    
    
    

    // Obtener total productos relacionados con la categoría
    public function getTotalProductosCat($id_categoria) {
        $sql = "SELECT COUNT(*) as total FROM articulos WHERE id_categoria = :id_categoria";
        $params = [
            ':id_categoria' => (int)$id_categoria,
        ];
        return $this->select($sql, $params);
    }
    
    

    // Productos relacionados aleatorios
    public function getAleatorios($id_categoria, $id_producto) {
        $sql = "SELECT a.*, i.ruta 
                FROM articulos a 
                LEFT JOIN imagenes i ON a.id_imagen = i.id_imagen 
                WHERE a.id_categoria = :id_categoria AND a.id_producto != :id_producto 
                ORDER BY RAND() 
                LIMIT 15";
        $params = [
            ':id_categoria' => (int)$id_categoria,
            ':id_producto' => (int)$id_producto,
        ];
        return $this->selectAll($sql, $params);
    }
    
    //busqueda
    public function getBusqueda($valor) {
        // Asegurarse de que el valor no esté vacío
        if (empty($valor)) {
            return []; // Retorna un array vacío si no hay valor
        }
    
        // Corregir la consulta para agregar la ruta de la imagen
        $sql = "SELECT p.*, c.nombreCategoria, i.ruta 
                FROM articulos p 
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria 
                LEFT JOIN imagenes i ON p.id_imagen = i.id_imagen 
                WHERE p.nombre LIKE '%" . $valor . "%' OR p.descripcion LIKE '%" . $valor . "%' 
                LIMIT 5";
    
        return $this->selectAll($sql);
    }
    
    
    
}

 
?>
<?php
class HomeModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias";
        return $this->selectAll($sql);
    }
    public function getNuevosProductos()
{
    $sql = "SELECT p.*, c.nombreCategoria, r.ruta 
            FROM articulos p 
            INNER JOIN categorias c ON p.id_categoria = c.id_categoria 
            LEFT JOIN imagenes r ON p.id_imagen = r.id_imagen 
            ORDER BY RAND() 
            LIMIT 9"; // Muestra 9 productos aleatorios
    return $this->selectAll($sql);
}

}

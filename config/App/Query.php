<?php
class Query extends Conexion{
    private $pdo, $con, $sql, $datos;
    public function __construct() {
        $this->pdo = new Conexion();
        $this->con = $this->pdo->conect();
    }
    public function select(string $sql, array $params = [])
{
    $this->sql = $sql;
    $resul = $this->con->prepare($this->sql);

    // Enlazar los parámetros si existen
    foreach ($params as $key => $value) {
        $resul->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }

    $resul->execute();
    return $resul->fetch(PDO::FETCH_ASSOC);
}

    public function selectAll(string $sql, array $params = []) {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);

        // Enlazar los parámetros si existen
        foreach ($params as $key => $value) {
            $resul->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $resul->execute();
        return $resul->fetchAll(PDO::FETCH_ASSOC); // Retorna todas las filas
    }

    public function save(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = 1;
        }else{
            $res = 0;
        }
        return $res;
    }
    public function insertar(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = $this->con->lastInsertId();
        } else {
            $res = 0;
        }
        return $res;
    }
}
?>
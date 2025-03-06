<?php
class ClientesModel extends Query{
 
    public function __construct()
    {
        parent::__construct();
    }
    public function registroDirecto($nombre, $apellido, $email, $clave, $token)
    {
        $sql = "INSERT INTO clientes (nombre, apellido, email, clave, token) VALUES (?,?,?,?,?)";
        $datos = array($nombre, $apellido, $email, $clave, $token);
        $data = $this->insertar($sql, $datos);
        if ($data > 0) {
            $res = $data;
        } else {
           $res = 0;
        }
        return $res;
    }
    public function getToken($token)
    {
        $sql = "SELECT * FROM clientes WHERE token = '$token'" ;
        return $this->select($sql);
    }

     public function actualizarVerify($id_cliente) {
        $sql = "UPDATE clientes SET token =?, verify=? whERE id_cliente=?";
        $datos = array(null, 1, $id_cliente);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = $data;
        } else {
           $res = 0;
        }
        return $res;
    }
    public function getVerificar($email)
    {
        $sql = "SELECT * FROM clientes WHERE email = '$email'" ;
        return $this->select($sql);
    }

    public function resgistrarPedido($id_transaccion, $precio, $estado, $fechaCompra, $email, $nombre, $apellido, $direccion, $ciudad, $email_user)
    {
        $sql = "INSERT INTO ventas (id_transaccion, precio, estado, fechaCompra, email, nombre, apellido, direccion, ciudad, email_user) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $datos = array($id_transaccion, $precio, $estado, $fechaCompra, $email, $nombre, $apellido, $direccion, $ciudad, $email_user);
        $data = $this->insertar($sql, $datos);
        if ($data > 0) {
            $res = $data;
        } else {
           $res = 0;
        }
        return $res;
    }

    public function getProducto($id_producto) {
        $sql = "SELECT * FROM articulos WHERE id_producto = $id_producto";
        return $this->select($sql);
    }
    public function registrarDetalle($producto, $precio, $cantidad, $id_pedido) {
        $sql = "INSERT INTO detalle_pedidos (producto, precio, cantidad, id_pedido) VALUES (?,?,?,?)";
        $datos = array($producto, $precio, $cantidad, $id_pedido);
        $data = $this->insertar($sql, $datos);
        if ($data > 0) {
            $res = $data;
        } else {
           $res = 0;
        }
        return $res;
    }
    public function getPedidos($proceso) {
        $sql = "SELECT * FROM ventas WHERE proceso = $proceso";
        return $this->selectAll($sql);
    }

    public function verPedido($idPedido)  {
        $sql = "SELECT d.* FROM ventas v INNER JOIN detalle_pedidos d ON v.id = d.id_pedido WHERE v.id = $idPedido";
        return $this->selectAll($sql);
    }
}
 
?>
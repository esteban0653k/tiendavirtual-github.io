<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class Clientes extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        if (empty($_SESSION['email'])) {
            header('Location: ' . BASE_URL);
        }
        $data['perfil'] = 'si';
        $data['title'] = 'Tu Perfil';
        $data['verificar'] = $this->model->getVerificar($_SESSION['email']);
        $this->views->getView('principal', "perfil", $data);
    }

    public function registroDirecto()
    {
        if (isset($_POST['nombre']) && isset($_POST['clave'])) {
            if (empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['clave'])) {
                $mensaje = array('msg' => 'DEBES LLENAR TODOS LOS CAMPOS', 'icono' => 'warning');
            } else {
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $email = $_POST['email'];
                $clave = $_POST['clave'];
                $verificar = $this->model->getVerificar($email);
                if (empty($verificar)) {
                    $token = md5($email);
                    $hash = password_hash($clave, PASSWORD_DEFAULT);
                    $data = $this->model->registroDirecto($nombre, $apellido, $email, $hash, $token);
                    if ($data > 0) {
                        $_SESSION['email'] = $email;
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['apellido'] = $apellido;
                        $mensaje = array('msg' => 'registrado con exito', 'icono' => 'success', 'token' => $token);
                    } else {
                        $mensaje = array('msg' => 'Error al registrar', 'icono' => 'error');
                    }
                } else {
                    $mensaje = array('msg' => 'ESTE CORREO YA ESTA REGISTRADO', 'icono' => 'warning');
                }
            }

            echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
            die;
        }
    }

    public function enviarCorreo()
    {
        if (isset($_POST['email']) && isset($_POST['token'])) {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = HOST_SMTP;                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = USER_SMTP;                     //SMTP username
                $mail->Password   = PASS_SMTP;                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = PUERTO_SMTP;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('esteban0653k@gmail.com', TITLE);
                $mail->addAddress($_POST['email']);


                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Mensaje desde la: ' . TITLE;
                $mail->Body    = 'Para verificar tu correo en nuestra tienda <a href="' . BASE_URL . 'clientes/verificarCorreo/' . $_POST['token'] . '">click aqui</a>';
                $mail->AltBody = 'GRACIAS POR LA PREFERENCIA CON NUESTRA TIENDA';

                $mail->send();
                $mensaje = array('msg' => 'CORREO ENVIADO, REVISA TU CORREO', 'icono' => 'success');
            } catch (Exception $e) {
                $mensaje = array('msg' => 'ERROR AL ENVIAR CORREO: ' . $mail->ErrorInfo, 'icono' => 'error');
            }
        } else {
            $mensaje = array('msg' => 'ERROR FATAL', 'icono' => 'error');
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die;
    }
    public function verificarCorreo($token)
    {
        $verificar = $this->model->getToken($token);
        if (!empty($verificar)) {
            $data = $this->model->actualizarVerify($verificar['id_cliente']);
            print_r($data);
            header('Location: ' . BASE_URL . 'clientes');
        }
    }

    //login directo
    public function loginDirecto()
    {
        if (isset($_POST['correoLogin']) && isset($_POST['claveLogin'])) {
            if (empty($_POST['correoLogin']) || empty($_POST['claveLogin'])) {
                $mensaje = array('msg' => 'DEBES LLENAR TODOS LOS CAMPOS', 'icono' => 'warning');
            } else {
                $email = $_POST['correoLogin'];
                $clave = $_POST['claveLogin'];
                $verificar = $this->model->getVerificar($email);
                if (!empty($verificar)) {
                    if (password_verify($clave, $verificar['clave'])) {
                        $_SESSION['email'] = $verificar['email'];
                        $_SESSION['nombre'] = $verificar['nombre'];
                        $_SESSION['apellido'] = $verificar['apellido'];
                        $mensaje = array('msg' => 'OK', 'icono' => 'success');
                    } else {
                        $mensaje = array('msg' => 'CONTRASEÑA INCORRECTA', 'icono' => 'error');
                    }
                } else {
                    $mensaje = array('msg' => 'El CORREO NO EXISTE', 'icono' => 'warning');
                }
            }

            echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
            die;
        }
    }

    //registrar Pedidos
    function resgistrarPedido()
    {
        $datos = file_get_contents('php://input');
        $json = json_decode($datos, true);
        $datos = $json['datos'];
        $productos = $json['productos'];
        if (is_array($datos) && is_array($productos)) {
            $id_transaccion = $datos['id'];
            $precio = $datos['purchase_units'][0]['amount']['value'];
            $estado = $datos['status'];
            $fechaCompra = date('Y-m-d H:i:s');
            $email = $datos['payer']['email_address'];
            $nombre = $datos['payer']['name']['given_name'];
            $apellido = $datos['payer']['name']['surname'];
            $direccion = $datos['purchase_units'][0]['shipping']['address']['address_line_1'];
            $ciudad = $datos['purchase_units'][0]['shipping']['address']['admin_area_2'];
            $emaill_user = $_SESSION['email'];
            $data = $this->model->resgistrarPedido($id_transaccion, $precio, $estado, $fechaCompra, $email, $nombre, $apellido, $direccion, $ciudad, $emaill_user);
            if ($data > 0) {
                foreach ($productos as $producto) {
                    $temp = $this->model->getProducto($producto['idProducto']);
                    $this->model->registrarDetalle($temp['nombre'], $temp['precio'], $producto['cantidad'], $data);
                    $mensaje = array('msg' => 'PAGO EXITOSO', 'icono' => 'success');
                }
            }else {
                $mensaje = array('msg' => 'NO SE PUDO REGISTRAR PEDIDO', 'icono' => 'error');
            }
         }else{
            $mensaje = array('msg' => 'ERROR FATAL', 'icono' => 'error');
         }
         echo json_encode($mensaje);
         die();
    }

    //listar productos pendientes
function listarPendientes() {
    // Obtener los pedidos con proceso 1
    $data = $this->model->getPedidos(1);
    
    // Filtrar los pedidos que tengan id_venta igual a 0
    $filteredData = array_filter($data, function($pedido) {
        return $pedido['id_venta'] == 0; // Solo mostrar filas con id_venta igual a 0
    });

    // Modificar los datos para agregar la acción (botón)
    foreach ($filteredData as $key => $pedido) {
        $filteredData[$key]['accion'] = '<div class="text-center"><button class="btn btn-success" type="button" onclick="verPedido('.$pedido['id'].')"><i class="fas fa-eye"></i></button></div>';
    }

    // Devolver los datos en formato JSON
    echo json_encode(array_values($filteredData)); // array_values para reindexar el array
    die;
}


    //ver pedidos
    public function verPedido($idPedido) {
        $data['productos'] = $this->model->verPedido($idPedido);
        $data['moneda'] = MONEDA;
        echo json_encode($data);
        die;
    }

    //salir
    public function salir()  {
        session_destroy();
        header('Location: ' . BASE_URL);
    }
}

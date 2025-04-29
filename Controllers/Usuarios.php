<?php
class Usuarios extends Controller
{
  public function __construct()
  {
    session_start();
    parent::__construct();
  }

  public function index()
  {
    $data['cajas'] = $this->model->getCajas();
    $this->views->getView($this, "index", $data);
  }

  public function editar(int $id)
  {
    $data = $this->model->getUserById($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function listar()
  {
    $data = $this->model->getUsuarios();
    for ($i = 0; $i < count($data); $i++) {
      if ($data[$i]["usuario_estado"] == 1) {
        $data[$i]["estado"] = '<span class="badge text-bg-primary">Activo</span>';
        $data[$i]["acciones"] =
          '<button class="btn btn-primary" type="button" onclick="btnEditUser(' . $data[$i]["id_usuario"] . ');"><i class="fas fa-edit"></i></button>
        <button class="btn btn-danger" type="button" onclick="btnDeleteUser(' . $data[$i]["id_usuario"] . ');"><i class="fas fa-trash"></i></button>';
      } else {
        $data[$i]["estado"] = '<span class="badge text-bg-danger">Inactivo</span>';
        $data[$i]["acciones"] = '<button class="btn btn-success" type="button" onclick="btnRestoreUser(' . $data[$i]["id_usuario"] . ');"><i class="fas fa-trash-can-arrow-up"></i></button>';
      }
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  // Valida los datos del formulario de login
  public function validar()
  {
    if (empty($_POST["nick"]) || empty($_POST["clave"])) {
      $msg = "Todos los campos son obligatorios";
      print_r($msg);
      die();
    } else {
      $nick = $_POST["nick"];
      $clave = $_POST["clave"];
      $data = $this->model->getUsuario($nick, $clave);
      $msg = "";
      if ($data) {
        $_SESSION['id_usuario'] = $data['id_usuario'];
        $_SESSION['nick'] = $data['nick'];
        $_SESSION['nombre'] = $data['nombre'];
        $msg = "ok";
      } else {
        $msg = "Usuario o contraseña incorrecta";
      }
    }
    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
  }

  public function registrar()
  {
    if ($_SERVER['REQUEST_METHOD'] != "POST") {
      echo json_encode(['error' => 'Método no permitido']);
      die();
    }
    $input = file_get_contents("php://input");
    $decode = json_decode($input, true);
    $nombre = isset($decode['nombre']) ? $decode['nombre'] : "";
    $nick = isset($decode['nick']) ? $decode['nick'] : "";
    $clave = isset($decode['clave']) ? $decode['clave'] : "";
    $confirm_clave = isset($decode['confirm_clave']) ? $decode['confirm_clave'] : "";
    $id_caja = isset($decode['id_caja']) ? $decode['id_caja'] : "";

    if ($nombre == "" || $nick == "" || $clave == "" || $confirm_clave == "" || $id_caja == "") {
      $msg = "Todos los campos son obligatorios";
      echo json_encode($msg, JSON_UNESCAPED_UNICODE);
      die();
    } else {
      if ($clave != $confirm_clave) {
        $msg = "Las contraseñas no coinciden";
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
      } else {
        $data = $this->model->verificarUsuario($nick, $nombre);
        if ($data) {
          $msg = "El usuario ya existe";
          echo json_encode($msg, JSON_UNESCAPED_UNICODE);
          die();
        } else {
          $data = $this->model->registrarUsuario($nombre, $nick, $clave, $id_caja);
          if ($data == "ok") {
            $msg = "ok";
          } else {
            $msg = "Error al registrar el usuario";
          }
        }
      }
    }
    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
  }
}

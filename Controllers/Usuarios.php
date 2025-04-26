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
    $this->views->getView($this, "index");
  }

  public function listar()
  {
    $data = $this->model->getUsuarios();
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

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
}

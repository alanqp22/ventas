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
    header('Content-Type: application/json; charset=utf-8');
    $data = $this->model->getUserById($id);
    if (!$data) {
      http_response_code(409);
      echo json_encode(['message' => 'El usuario no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    return;
  }

  public function restaurar(int $id)
  {
    header('Content-Type: application/json; charset=utf-8');
    if ($_SERVER['REQUEST_METHOD'] != "PUT") {
      http_response_code(405); // Method Not Allowed
      echo json_encode(['message' => 'Método no permitido'], JSON_UNESCAPED_UNICODE);
      return;
    }

    if (!$this->model->getUserById($id)) {
      http_response_code(409);
      echo json_encode(['message' => 'El usuario no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $result = $this->model->restaurarUsuario($id);

    if ($result === "ok") {
      http_response_code(200); // OK
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al restaurar el usuario'], JSON_UNESCAPED_UNICODE);
    }
  }

  public function eliminar(int $id)
  {
    header('Content-Type: application/json; charset=utf-8');
    if ($_SERVER['REQUEST_METHOD'] != "DELETE") {
      http_response_code(405); // Method Not Allowed
      echo json_encode(['message' => 'Método no permitido'], JSON_UNESCAPED_UNICODE);
      return;
    }

    if (!$this->model->getUserById($id)) {
      http_response_code(409);
      echo json_encode(['message' => 'El usuario no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $result = $this->model->eliminarUsuario($id);

    if ($result === "ok") {
      http_response_code(200); // OK
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al eliminar el usuario'], JSON_UNESCAPED_UNICODE);
    }
  }

  public function listar()
  {
    $data = $this->model->getUsuarios();
    for ($i = 0; $i < count($data); $i++) {
      $id = (int)$data[$i]["id_usuario"];
      if ($data[$i]["usuario_estado"] == 1) {
        $data[$i]["estado"] = '<span class="badge text-bg-primary">Activo</span>';
        $data[$i]["acciones"] = <<<HTML
          <button class="btn btn-primary" data-action="edit" data-id="$id">
            <i class="fas fa-edit"></i>
          </button>
          <button class="btn btn-danger" data-action="delete" data-id="$id">
            <i class="fas fa-trash"></i>
          </button>
        HTML;
      } else {
        $data[$i]["estado"] = '<span class="badge text-bg-danger">Inactivo</span>';
        $data[$i]["acciones"] = '';
        $data[$i]["acciones"] = <<<HTML
          <button class="btn btn-success" data-action="restore" data-id="$id">
            <i class="fas fa-trash-can-arrow-up"></i>
          </button>
        HTML;
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

  public function actualizar(int $id_usuario)
  {
    header('Content-Type: application/json; charset=utf-8');
    if ($_SERVER['REQUEST_METHOD'] != "PUT") {
      http_response_code(405); // Method Not Allowed
      echo json_encode(['message' => 'Método no permitido'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $input = json_decode(file_get_contents("php://input"), true);

    $required = ['nombre', 'nick', 'id_caja'];

    foreach ($required as $field) {
      if (empty($input[$field])) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
        return;
      }
    }

    $nombre = trim(htmlspecialchars($input['nombre']));
    $nick = trim(htmlspecialchars($input['nick']));
    $id_caja = $input['id_caja'];

    if (!$this->model->getUserById($id_usuario)) {
      http_response_code(409);
      echo json_encode(['message' => 'El usuario no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $result = $this->model->actualizarUsuario($id_usuario, $nombre, $nick, $id_caja);

    if ($result === "ok") {
      http_response_code(201); // Created      
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al registrar el usuario'], JSON_UNESCAPED_UNICODE);
    }
  }

  public function registrar()
  {
    header('Content-Type: application/json; charset=utf-8');
    if ($_SERVER['REQUEST_METHOD'] != "POST") {
      http_response_code(405); // Method Not Allowed
      echo json_encode(['message' => 'Método no permitido'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $input = json_decode(file_get_contents("php://input"), true);

    $required = ['nombre', 'nick', 'clave', 'confirm_clave', 'id_caja'];

    foreach ($required as $field) {
      if (empty($input[$field])) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
        return;
      }
    }

    $nombre = trim(htmlspecialchars($input['nombre']));
    $nick = trim(htmlspecialchars($input['nick']));
    $clave = $input['clave'];
    $confirm_clave = $input['confirm_clave'];
    $id_caja = $input['id_caja'];

    if ($clave != $confirm_clave) {
      http_response_code(400); // Bad Request
      echo json_encode(['message' => 'Las contraseñas no coinciden'], JSON_UNESCAPED_UNICODE);
      return;
    }

    if ($this->model->verificarUsuario($nick)) {
      http_response_code(409);
      echo json_encode(['message' => 'El usuario ya existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $hash = password_hash($clave, PASSWORD_BCRYPT);
    $result = $this->model->registrarUsuario($nombre, $nick, $hash, $id_caja);

    if ($result === "ok") {
      http_response_code(201); // Created      
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al registrar el usuario'], JSON_UNESCAPED_UNICODE);
    }
  }
}

<?php
class Cajas extends Controller
{
  public function __construct()
  {
    session_start();
    parent::__construct();
  }

  public function index()
  {
    $resources = "Cajas/app";
    $this->views->getView($this, "index", array('resources' => $resources));
  }

  public function listar()
  {
    $data = $this->model->getCajas();
    for ($i = 0; $i < count($data); $i++) {
      $id = (int)$data[$i]["id_caja"];
      $data[$i]["estado"] = $this->getEstadoBadge($data[$i]["caja_estado"]);
      $data[$i]["acciones"] = $this->getActionButtons($data[$i]["caja_estado"], $id);
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
  }

  public function editar(int $id)
  {
    header('Content-Type: application/json; charset=utf-8');
    $data = $this->model->getCajaById($id);
    if (!$data) {
      http_response_code(409);
      echo json_encode(['message' => 'La caja no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    return;
  }

  public function restaurar(int $id)
  {
    header('Content-Type: application/json; charset=utf-8');
    if (!$this->validateMethod("PUT")) return;
    if (!$this->model->getCajaById($id)) {
      http_response_code(409);
      echo json_encode(['message' => 'La caja no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $result = $this->model->restaurarCaja($id);

    if ($result === "ok") {
      http_response_code(200); // OK
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al restaurar La caja'], JSON_UNESCAPED_UNICODE);
    }
  }

  public function eliminar(int $id)
  {
    header('Content-Type: application/json; charset=utf-8');
    if (!$this->validateMethod("DELETE")) return;

    if (!$this->model->getCajaById($id)) {
      http_response_code(409);
      echo json_encode(['message' => 'La caja no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $result = $this->model->eliminarCaja($id);

    if ($result === "ok") {
      http_response_code(200); // OK
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al eliminar la caja'], JSON_UNESCAPED_UNICODE);
    }
  }


  public function actualizar(int $id_caja)
  {
    if (!$this->validateMethod("PUT")) return;
    header('Content-Type: application/json; charset=utf-8');

    $input = json_decode(file_get_contents("php://input"), true);

    if (empty($input['nombre'])) {
      http_response_code(400); // Bad Request
      echo json_encode(['message' => "El campo nombre es obligatorio"], JSON_UNESCAPED_UNICODE);
      return;
    }

    $nombre = trim(htmlspecialchars($input['nombre']));

    if (!$this->model->getCajaById($id_caja)) {
      http_response_code(409);
      echo json_encode(['message' => 'La caja no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $result = $this->model->actualizarCaja($id_caja, $nombre);

    if ($result === "ok") {
      http_response_code(201); // Created      
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al actualizar la caja'], JSON_UNESCAPED_UNICODE);
    }
  }

  public function registrar()
  {
    if (!$this->validateMethod("POST")) return;
    header('Content-Type: application/json; charset=utf-8');

    $input = json_decode(file_get_contents("php://input"), true);

    if (empty($input['nombre'])) {
      http_response_code(400); // Bad Request
      echo json_encode(['message' => "El campo nombre es obligatorio"], JSON_UNESCAPED_UNICODE);
      return;
    }

    $nombre = trim(htmlspecialchars($input['nombre']));

    if ($this->model->verificarCaja($nombre)) {
      http_response_code(409);
      echo json_encode(['message' => 'La caja ya existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $result = $this->model->registrarCaja($nombre);

    if ($result === "ok") {
      http_response_code(201); // Created      
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al registrar la caja'], JSON_UNESCAPED_UNICODE);
    }
  }

  private function validateMethod(string $expectedMethod)
  {
    if ($_SERVER['REQUEST_METHOD'] != $expectedMethod) {
      http_response_code(405); // Method Not Allowed
      echo json_encode(['message' => 'Método no permitido'], JSON_UNESCAPED_UNICODE);
      return false;
    }
    return true;
  }
}

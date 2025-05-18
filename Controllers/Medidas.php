<?php
class Medidas extends Controller
{
  public function __construct()
  {
    session_start();
    parent::__construct();
  }

  public function index()
  {
    $resources = "Medidas/app";
    $this->views->getView($this, "index", array('resources' => $resources));
  }

  public function listar()
  {
    $data = $this->model->getMedidas();
    for ($i = 0; $i < count($data); $i++) {
      $id = (int)$data[$i]["id_medida"];
      $data[$i]["estado"] = $this->getEstadoBadge($data[$i]["medida_estado"]);
      $data[$i]["acciones"] = $this->getActionButtons($data[$i]["medida_estado"], $id);
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
  }

  public function editar(int $id)
  {
    header('Content-Type: application/json; charset=utf-8');
    $data = $this->model->getMedidaById($id);
    if (!$data) {
      http_response_code(409);
      echo json_encode(['message' => 'La medida no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    return;
  }

  public function restaurar(int $id)
  {
    header('Content-Type: application/json; charset=utf-8');
    if (!$this->validateMethod("PUT")) return;
    if (!$this->model->getMedidaById($id)) {
      http_response_code(409);
      echo json_encode(['message' => 'La medida no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $result = $this->model->restaurarMedida($id);

    if ($result === "ok") {
      http_response_code(200); // OK
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al restaurar la medida'], JSON_UNESCAPED_UNICODE);
    }
  }

  public function eliminar(int $id)
  {
    header('Content-Type: application/json; charset=utf-8');
    if (!$this->validateMethod("DELETE")) return;

    if (!$this->model->getMedidaById($id)) {
      http_response_code(409);
      echo json_encode(['message' => 'La medida no existe'], JSON_UNESCAPED_UNICODE);
      return;
    }

    $result = $this->model->eliminarMedida($id);

    if ($result === "ok") {
      http_response_code(200); // OK
      echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
    } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al eliminar la medida'], JSON_UNESCAPED_UNICODE);
    }
  }


  public function actualizar(int $id_medida)
  {
    try {
      if (!$this->validateMethod("PUT")) return;
      header('Content-Type: application/json; charset=utf-8');

      $input = json_decode(file_get_contents("php://input"), true);
      $required = ['descripcion_medida'];

      foreach ($required as $field) {
        if (empty($input[$field])) {
          http_response_code(400); // Bad Request
          echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
          return;
        }
      }

      $descripcion_medida = $input['descripcion_medida'];
      $descripcion_corta = $input['descripcion_corta'];

      if (!$this->model->getMedidaById($id_medida)) {
        http_response_code(409);
        echo json_encode(['message' => 'La medida no existe'], JSON_UNESCAPED_UNICODE);
        return;
      }

      $result = $this->model->actualizarMedida($id_medida, $descripcion_medida, $descripcion_corta);

      if ($result === "ok") {
        http_response_code(201); // Created      
        echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
      } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Error al actualizar la medida'], JSON_UNESCAPED_UNICODE);
      }
    } catch (\Throwable $th) {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => $th], JSON_UNESCAPED_UNICODE);
    }
  }

  public function registrar()
  {
    if (!$this->validateMethod("POST")) return;
    header('Content-Type: application/json; charset=utf-8');

    $input = json_decode(file_get_contents("php://input"), true);
    $required = ['descripcion_medida'];

    foreach ($required as $field) {
      if (empty($input[$field])) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => "El campo $field es obligatorio"], JSON_UNESCAPED_UNICODE);
        return;
      }
    }

    $descripcion_medida = $input['descripcion_medida'];
    $descripcion_corta = $input['descripcion_corta'];
    try {
      if ($this->model->verificarMedida($descripcion_medida)) {
        http_response_code(409);
        echo json_encode(['message' => 'La medida ya existe'], JSON_UNESCAPED_UNICODE);
        return;
      }
      $result = $this->model->registrarMedida($descripcion_medida, $descripcion_corta);

      if ($result === "ok") {
        http_response_code(201); // Created      
        echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
      } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Error al registrar la medida'], JSON_UNESCAPED_UNICODE);
      }
    } catch (\Throwable $th) {
      http_response_code(500); // Internal Server Error
      echo json_encode(['message' => 'Error al registrar la medida'], JSON_UNESCAPED_UNICODE);
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

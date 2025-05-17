<?php
class Pedidos extends Controller
{
  public function __construct()
  {
    session_start();
    parent::__construct();
  }

  public function index()
  {
    $data['resources'] = "Pedidos/app";
    $this->views->getView($this, "index", $data);
  }

  public function nuevo_pedido()
  {
    $data['resources'] = "Pedidos/app";
    $this->views->getView($this, "nuevo_pedido", $data);
  }

  public function buscarCliente()
  {
    if (!$this->validateMethod("POST")) return;
    header('Content-Type: application/json; charset=utf-8');

    $input = json_decode(file_get_contents("php://input"), true);
    $documentoid = $input['documentoid'];
    $data = $this->model->buscarCliente($documentoid);
    if (!$data) {
      http_response_code(409);
      echo json_encode(['message' => 'No se encontró cliente'], JSON_UNESCAPED_UNICODE);
      return;
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    return;
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

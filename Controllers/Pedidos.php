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
    $documentoid = $_POST['documentoid'];
    $data = $this->model->buscarCliente($documentoid);
    if ($data) {
      echo json_encode($data);
    } else {
      echo json_encode("El cliente no existe");
    }
  }
}

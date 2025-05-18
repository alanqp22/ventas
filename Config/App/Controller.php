<?php
class Controller
{
  public $model;
  public $views;
  public function __construct()
  {
    $this->views = new Views();
    $this->cargarModel();
  }
  public function cargarModel()
  {
    $model = get_class($this) . "Model";
    $ruta = "Models/" . $model . ".php";
    if (file_exists($ruta)) {
      require_once $ruta;
      $this->model = new $model();
    }
  }

  protected function getActionButtons($estado, $id)
  {
    if ($estado == 1) {
      return <<<HTML
          <button class="btn btn-primary btn-sm" data-action="edit" data-id="$id">
            <i class="fas fa-edit"></i>
          </button>
          <button class="btn btn-danger btn-sm" data-action="delete" data-id="$id">
            <i class="fas fa-trash"></i>
          </button>
        HTML;
    } else {
      return <<<HTML
          <button class="btn btn-success btn-sm" data-action="restore" data-id="$id">
            <i class="fas fa-trash-can-arrow-up"></i>
          </button>
        HTML;
    }
  }

  protected function getEstadoBadge($estado)
  {
    return $estado == 1 ?
      '<span class="badge text-bg-primary">Activo</span>'
      :
      '<span class="badge text-bg-danger">Inactivo</span>';
  }
}

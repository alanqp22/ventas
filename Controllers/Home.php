<?php
class Home extends Controller
{
  public function index($parametros = "")
  {
    $this->views->getView($this, "index");
  }

  public function error()
  {
    require_once 'Views/Home/error.php';
  }
}

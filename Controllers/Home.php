<?php
class Home extends Controller
{
  public function index($parametros = "")
  {
    echo "hola mundo cruel";
    //require_once 'Views/Home/index.php';
  }

  public function error()
  {
    require_once 'Views/Home/error.php';
  }
}

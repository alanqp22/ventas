<?php
require_once 'Config/Config.php';
$ruta = !empty($_GET['url']) ? $_GET['url'] : 'Home/index';
$array = explode('/', $ruta);
$controller = $array[0];
$metodo = isset($array[1]) ? $array[1] : 'index';
$parametros = "";
if (!empty($array[2])) {
  if ($array[2] != "") {
    for ($i = 2; $i < count($array); $i++) {
      $parametros .= $array[$i] . ",";
    }
    $parametros = rtrim($parametros, ",");
  }
}

require_once 'Config/App/autoload.php';
$dirController = "Controllers/" . $controller . ".php";
if (file_exists($dirController)) {
  require_once $dirController;
  $controller = new $controller();
  if (method_exists($controller, $metodo)) {
    $controller->$metodo($parametros);
  } else {
    echo "No existe el método";
  }
} else {
  // echo "No existe el controlador";
  header("HTTP/1.1 404 Not Found");
  echo "Recurso no encontrado";
  exit;
}

<?php
class Views
{
    public function getView($controlador, $vista, $params = [])
    {
        $controlador = get_class($controlador);
        if ($controlador == "Home") {
            $vista = "Views/" . $vista . ".php";
        } else {
            $vista = "Views/" . $controlador . "/" . $vista . ".php";
        }
        require $vista;
    }
}

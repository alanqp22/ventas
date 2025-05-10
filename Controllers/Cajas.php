<?php
class cajas extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        //$data['cajas'] = $this->model->getCajas();
        $this->views->getView($this, "index");
    }
};

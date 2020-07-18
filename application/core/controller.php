<?php
class Controller {

    public $model;
    public $view;

    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
    }

    public function getLocation(string $controller, string $action = ''): string
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        return 'Location:' . $host . $controller . '/' . $action;
    }

    function action_index()
    {
    }
}
<?php

namespace Beejee\application\core;

use Beejee\application\core\View;
use Beejee\application\lib\Twig;

abstract class Controller {

    public $route;
    public $view;
    public $twig;
    use Twig;

    public function __construct($route) {
        $this->route = $route;
        $this->twig = Twig::init();
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    public function loadModel($name)
    {
        $path = 'application\models\\'.ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }
}
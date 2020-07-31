<?php

namespace Beejee\application\core;

use Beejee\application\core\View;

abstract class Controller {

    public $route;
    public $view;
    public $twig;
    public $loader;

    public function __construct($route) {
        $this->route = $route;
        $this->loader = new \Twig\Loader\FilesystemLoader('application/views');
        $this->twig = new \Twig\Environment($this->loader, ['debug' => true]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);
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
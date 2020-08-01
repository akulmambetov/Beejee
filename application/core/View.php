<?php

namespace Beejee\application\core;

class View {

    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route) {
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($title, $layout = 'default', $vars = []) {
        extract($vars);
        $path = 'application/views/'.$this->path.'.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'application/views/layouts/'.$layout.'.php';
        }
    }

    public function redirect($url)
    {
        header('location: /'.$url);
        exit;
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'application/views/errors/'.$code.'.htm.twig';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    public function message($status, $message, $fields = [])
    {
        exit(json_encode(['status' => $status, 'message' => $message, 'fields' => $fields]));
    }

    public function redirectJs($url)
    {
        exit(json_encode(['url' => $url]));
    }

}

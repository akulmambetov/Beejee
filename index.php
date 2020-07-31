<?php
require 'application/lib/Dev.php';
require_once __DIR__ . '/vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__. '/application/views');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__. '/application/views/cache',
]);

use Beejee\application\core\Router;

session_start();

$router = new Router;

$router->run();

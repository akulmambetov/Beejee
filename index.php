<?php
require_once __DIR__ . '/vendor/autoload.php';
require 'application/lib/Dev.php';

use Beejee\application\core\Router;

session_start();

$router = new Router;

$router->run();

<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;


class MainController extends Controller
{
    public function indexAction()
    {
        View::message(200, 'asdasdas');
    }
}
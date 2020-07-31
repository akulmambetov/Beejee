<?php

namespace Beejee\application\controllers;

use Beejee\application\core\Controller;
use Beejee\application\models\Main;

class MainController extends Controller
{
    public function indexAction()
    {
        $model = new Main();
        $content = [
            'tasks' => $model->getTasks(),
        ];

        $template = $this->twig->load('main/index.htm.twig');
        echo $template->render($content);

    }
}
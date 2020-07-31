<?php

namespace Beejee\application\controllers;

use Beejee\application\core\Controller;
use Beejee\application\models\Tasks;

class TaskController extends Controller
{
    public function indexAction()
    {
        $model = new Tasks();
        $content = [
            'tasks' => $model->getTasks()
        ];

        echo $this->twig->render('main/index.htm.twig', $content);

    }

    public function addAction()
    {
        $model = new Tasks();

        $content = [];

        if ($_POST) {
            $model->setAttributes($_POST);
            if ($model->addTask()){
                $this->view->redirectJs('');
            }else {
                $this->view->message('error', implode('<br />', $model->error), $model->error);
            }
        }
        echo $this->twig->render('main/add.htm.twig', $content);
    }
}
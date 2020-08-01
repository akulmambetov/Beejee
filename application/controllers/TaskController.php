<?php

namespace Beejee\application\controllers;

use Beejee\application\lib\Pagination;
use Beejee\application\core\Controller;
use Beejee\application\core\View;
use Beejee\application\models\Tasks;

class TaskController extends Controller
{
    public function indexAction()
    {

        $page = $_GET['page'] ?? 1;
        $sort = $_GET['sort'] ?? 'id';
        $order = $_GET['order'] ?? 'desc';

        $model = new Tasks();
        $pagination = new Pagination($page, $model->getTasksCount(), $model::TASKS_PER_PAGE);

        $tasks = $model->getTasks($page, $model::TASKS_PER_PAGE, $sort, $order);

        $order = $order == 'asc' ? 'desc' : 'asc';

        $content = [
            'pagination' => $pagination->get(),
            'tasks' => $tasks,
            'page' => $page,
            'sort' => $sort,
            'order' => $order,
        ];

        echo $this->twig->render('main/index.htm.twig', $content);

    }

    public function addAction()
    {
        $model = new Tasks();

        if ($_POST) {
            $model->setAttributes($_POST);
            if ($model->addTask()) {
                $this->view->redirectJs('');
                $this->view->message(200, 'Задача успешно добавлена');
            } else {
                $this->view->message('error', 'Ошибка', $model->error);
            }
        }
        echo $this->twig->render('main/add.htm.twig');
    }

    public function editAction($id)
    {
        if (isset($_SESSION['admin'])) {
            $model = new Tasks();
            $content = [
                'task' => $model->findOne($id)
            ];

            if ($_POST) {
                $model->setAttributes($_POST);
                if ($model->updateTask($id)) {
                    $this->view->redirectJs('');
                } else {
                    $this->view->message('error', 'Ошибка', $model->error);
                }
            }
            echo $this->twig->render('main/detail.htm.twig', $content);
        }else {
            $this->view->redirectJs('login');
        }
    }
}
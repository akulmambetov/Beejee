<?php

namespace Beejee\application\controllers;

use Beejee\application\models\Auth;
use Beejee\application\core\Controller;

class AuthController extends Controller
{
    public function loginAction()
    {
        if (!empty($_POST) && isset($_POST['login']) && isset($_POST['password'])) {
            $model = new Auth();
            if (!$model->loginValidate($_POST)) {
                $this->view->message('error', $model->error, ['login' => $model->error]);
            }
            $_SESSION['admin'] = true;
            $this->view->redirectJs('');
        }
        echo $this->twig->render('main/login.htm.twig');
    }

    public function logoutAction()
    {
        unset($_SESSION['admin']);
        $this->view->redirect('login');
    }

}
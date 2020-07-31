<?php

namespace Beejee\application\models;

use Beejee\application\core\Model;

class Auth extends Model
{
    public $error;
    public function loginValidate($post)
    {
        $params = [
            'login' => $post['login'],
            'password' => $post['password']
        ];
        $isExist = $this->db->column('SELECT * FROM users WHERE login = :login AND password = :password', $params);
        if (!$isExist) {
            $this->error = 'Логин или пароль указан неверно';
            return false;
        }
        return true;
    }
}
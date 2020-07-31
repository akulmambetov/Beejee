<?php

namespace Beejee\application\models;

use Beejee\application\core\Model;

class Tasks extends Model
{
    public $task = [];
    public $error = [];

    public function validate()
    {
        if (mb_strlen($this->task['username']) < 3 || mb_strlen($$this->task['username']) > 25) {
            $this->error['login'] = 'Поле «Username» должно содержать от 3 до 25 символов';
        }

        if (mb_strlen($this->task['text']) < 3 || mb_strlen($$this->task['text']) > 50) {
            $this->error['login'] = 'Поле «Username» должно содержать от 3 до 50 символов';
        }

        if (!empty($this->error)) {
            return false;
        }
        return true;
    }

    public function setAttributes($data)
    {
        $this->task = [
            'username' => $data['username'],
            'email' => $data['email'],
            'text' => $data['text'],
            'status' => 0,
        ];
    }

    public function addTask()
    {
        if ($this->validate()) {
            $params = [
                'username' => $this->task['username'],
                'email' => $this->task['email'],
                'text' => $this->task['text'],
                'status' => $this->task['status']
            ];

            $this->db->query("INSERT INTO tasks (status, username, email, text) VALUE (:status, :username, :email, :text)", $params);
            return true;
        }
        return false;
    }

    public function getTasks()
    {
        return $this->db->row('SELECT * FROM tasks ORDER BY id DESC');
    }
}
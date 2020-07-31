<?php

namespace Beejee\application\models;

use application\core\View;
use Beejee\application\core\Model;

class Tasks extends Model
{
    public $task = [];
    public $error = [];

    public function validate()
    {
        if (mb_strlen($this->task['username']) < 3 || mb_strlen($this->task['username']) > 25) {
            $this->error['username'] = 'Поле «Username» должно содержать от 3 до 25 символов';
        }

        if ($this->task['email'] == '') {
            $this->error['email'] = 'Поле «Email» не должно быть пустым';
        } elseif (!filter_var($this->task['email'], FILTER_VALIDATE_EMAIL)) {
            $this->error['email'] = 'Email введен неправильно';
        }


        if (mb_strlen($this->task['text']) < 3 || mb_strlen($this->task['text']) > 50) {
            $this->error['text'] = 'Поле «text» должно содержать от 3 до 50 символов';
        }

        if (!empty($this->error)) {
            return false;
        }
        return true;
    }

    public function setAttributes($data)
    {
        if (isset($data['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }
        $this->task = [
            'username' => $data['username'],
            'email' => $data['email'],
            'text' => $data['text'],
            'status' => $status,
        ];
    }

    public function addTask()
    {
        if ($this->validate()) {
            $params = [
                'username' => $this->task['username'],
                'email' => $this->task['email'],
                'text' => $this->task['text'],
                'status' => 0
            ];

            $this->db->query("INSERT INTO tasks (status, username, email, text) VALUE (:status, :username, :email, :text)", $params);
            return true;
        }
        return false;
    }

    public function updateTask($id)
    {
        if ($this->validate()) {
            $params = [
                'username' => $this->task['username'],
                'email' => $this->task['email'],
                'text' => $this->task['text'],
                'status' => $this->task['status'],
                'id' => $id
            ];

            $this->db->query('UPDATE tasks SET username = :username, email = :email, text = :text, status = :status WHERE id = :id', $params);
            return true;
        }
        return false;

    }

    public function getTasks()
    {
        return $this->db->row('SELECT * FROM tasks ORDER BY id DESC');
    }

    public function findOne($id)
    {
        $data = $this->db->row('SELECT * FROM tasks WHERE id = :id', ['id' => $id]);
        if (!empty($data)) {
            $this->setAttributes($data[0]);
            return $data[0];
        }
        View::errorCode(404);
    }
}
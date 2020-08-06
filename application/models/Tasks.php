<?php

namespace Beejee\application\models;

use Beejee\application\core\View;
use Beejee\application\models\Auth;
use Beejee\application\core\Model;

class Tasks extends Model
{
    public $task = [];
    public $error = [];
    const TASKS_PER_PAGE = 3;

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


        if (mb_strlen($this->task['text']) < 3 || mb_strlen($this->task['text']) > 150) {
            $this->error['text'] = 'Поле «text» должно содержать от 3 до 150 символов';
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
        $text = strip_tags($data['text']);
        $text = htmlentities($data['text'], ENT_QUOTES, "UTF-8");
        $text = htmlspecialchars($data['text'], ENT_QUOTES);
        $this->task = [
            'username' => $data['username'],
            'email' => $data['email'],
            'text' => $text,
            'status' => $status,
            'edited' => 0
        ];
    }

    public function addTask()
    {
        if ($this->validate()) {
            $params = [
                'username' => $this->task['username'],
                'email' => $this->task['email'],
                'text' => $this->task['text'],
                'status' => 0,
                'edited' => 0,
            ];

            $this->db->query("INSERT INTO tasks (status, username, email, text, edited) VALUE (:status, :username, :email, :text, :edited)", $params);
            return true;
        }
        return false;
    }

    public function updateTask($id)
    {
        if ($this->validate()) {

            $task = $this->findOne($id);

            $diff = array_diff_assoc($task, $this->task);

            unset($diff['id']);
            unset($diff['edited']);

            if (!empty($diff)){
                $edited = 1;
            }else {
                $edited = 0;
            }

            $params = [
                'username' => $this->task['username'],
                'email' => $this->task['email'],
                'text' => $this->task['text'],
                'status' => $this->task['status'],
                'id' => $id,
                'edited' => $edited,
            ];

            $this->db->query('UPDATE tasks SET username = :username, email = :email, text = :text, status = :status, edited = :edited WHERE id = :id', $params);
            return true;
        }
        return false;
    }

    public function getTasks($page = 1, $max = 3, $sort, $order = 'asc')
    {
        $page = !is_numeric($page) || $page < 0 ? 1 : $page;
        $params = [
            'max' => $max,
            'start' => ((($page ?? 1) - 1) * $max),
        ];

        return $this->db->row('SELECT * FROM tasks ORDER BY ' . $sort . ' ' . $order . ' LIMIT :start, :max', $params);
    }

    public function getTasksCount()
    {
        return $this->db->column('SELECT COUNT(id) FROM tasks');
    }

    public function findOne($id)
    {
        $data = $this->db->row('SELECT * FROM tasks WHERE id = :id', ['id' => $id]);
        if (!empty($data)) {
            return $data[0];
        }
        View::errorCode(404);
    }
}
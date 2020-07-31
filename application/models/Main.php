<?php

namespace Beejee\application\models;
use Beejee\application\core\Model;

class Main extends Model
{
    public function getTasks()
    {
        return $this->db->row('SELECT * FROM tasks ORDER BY id');
    }
}
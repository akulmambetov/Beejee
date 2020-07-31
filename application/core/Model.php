<?php

namespace Beejee\application\core;

use Beejee\application\lib\Db;

abstract class Model {

    public $db;

    public function __construct() {
        $this->db = new Db;
    }

}
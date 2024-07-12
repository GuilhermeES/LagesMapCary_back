<?php

namespace MapcityBack\Controller;
use MapcityBack\Database\Database;

class LoginController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function login() {

        echo $this->pdo;
    }
}

<?php

namespace src\Database;

use PDO;
use src\Route\Route;
use src\Session\Cookie;

class DB
{
    private PDO $pdo;

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    private $state;

    public function __construct(string $configName = 'database.php')
    {
        $data = require ROOT_PATH . "configs/$configName";
        try {
            $this->pdo = new PDO("mysql:host=$data[host];dbname=$data[dbname]", $data["username"], $data["password"]);
        } catch (\PDOException $e) {
            Route::redirect('/500');
        }

    }

    public static function prepare(string $query): DB
    {
        $db = new self();
        $pdo = $db->pdo;
        $db->state = $pdo->prepare($query);
        return $db;
    }


    public function exec(array $arguments) :bool
    {
        try {
            $this->state->execute($arguments);
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }


}
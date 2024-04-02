<?php

namespace App\Services;

use PDO;
use src\Database\DB;
use src\Route\Route;

class UserService
{
    public static function checkCredentials($login, $password)
    {
        try {
            $db = (new DB())->getPdo();
            $stmt = $db->prepare('SELECT id FROM users WHERE login= :login AND password= :password');
            $stmt->execute([
                'login' => $login,
                'password' => $password
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($result['id'])) {
                return $result['id'];
            }
            return false;

        } catch (\PDOException $e) {
            return false;
        }
    }
    public static function checkUnique($login)
    {
        try {
            $db = (new DB())->getPdo();
            $stmt = $db->prepare('SELECT id FROM users WHERE login= ?');
            $stmt->execute([$login]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (\PDOException $exception){
            Route::redirect('/500');
        }

    }
    public static function insertUser($login, $password): bool
    {
        return DB::prepare("INSERT INTO users (login, password) VALUES (? , ?)")
            ->exec([$login, $password]);
    }

}
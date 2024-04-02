<?php

namespace App\Services;

class AuthService
{
    public static function auth($id, $login, $password): void
    {
//        $stat1 = session_status();
//        session_start();
//        $stat2 = session_status();

        $_SESSION['id'] =  $id;
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
//        $stat3 = session_status();
//        var_dump($stat1 , $stat2, $stat3);
//        die();
    }
    public static function getUserId(): ?int
    {
        if (isset($_SESSION['id'])) {
            return $_SESSION['id'];
        }
        return null;
    }

    public static function getUserCredentials(): ?array
    {
        if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
            return [
                'login' => $_SESSION['login'],
                'password' => $_SESSION['password']
            ];
        }
        return null;
    }

    public static function logout(): void
    {
        session_unset();
    }
}
<?php

namespace App\Middlewares;

use App\Middlewares\Middleware;
use App\Services\AuthService;
use App\Services\UserService;
use src\Request\Request;

class Auth implements Middleware
{
    public static function process(): bool
    {
        $data = AuthService::getUserCredentials();
        if ($data)
        {
            if (UserService::checkCredentials($data['login'], $data['password'])){
                return true;
            }
        }
        return false;

    }
}
<?php

namespace src\Request;

use src\Route\Route;
use src\View\View;

class Request
{
    public static function data()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            return $_GET;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
            return $_POST;
        } else {
            View::view('system.404');
            die();
        }
    }
    public static function formData()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = $_POST;
            foreach ($data as $key => $value){
                $data[$key] = strip_tags($value);
            }
            return $data;
        } else {
            View::view('system.404');
            die();
        }
    }

}
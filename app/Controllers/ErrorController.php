<?php

namespace App\Controllers;

use App\Controllers\Controller;
use src\View\View;

class ErrorController extends Controller
{
    private string $errorCode;

    public function __construct()
    {
        $this->errorCode = substr($_SERVER['REQUEST_URI'], 1);
    }

    public function custom(): void
    {
        if ($this->errorCode === '/') {
            View::view("system.404");
            return;
        }
        View::view("system.$this->errorCode");
    }

    public function standard(): void
    {
        $error = $this->errorCode;
        View::view("system.error", compact("error"));
    }

}
<?php

namespace App\Middlewares;

interface Middleware
{
    public static function process() : bool ;
}
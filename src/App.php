<?php

namespace src;

use src\Route\Route;
use src\Route\RouteDispatcher;
use src\View\View;

class App
{
    public static function run(): void
    {
        $requestMethod = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));
        $method = 'getRoutes' . $requestMethod;
        $urls = Route::$method();
        foreach ($urls as $routeConfiguration){
            $routeDispatcher = new RouteDispatcher($routeConfiguration);
            $routeDispatcher->process();
            if( !next($urls) ) {
                View::view('system.404');
            }
        }
    }


}
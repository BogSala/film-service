<?php

namespace App\View\Components;

use App\View\Components\Component;

class StyleComponent extends Component
{
    public static function getStyle(string $stylePath, $fileType = ".css")
    {
        $stylePath = str_replace('.', '/', $stylePath). $fileType;
        return include ROOT_PATH . "/app/View/styles/$stylePath" ;
    }
}
<?php

namespace App\View\Components;

use App\View\Components\Component;

class ImportComponent extends Component
{
    public static function style(string $stylePath, $fileType = ".css")
    {
        $stylePath = str_replace('.', '/', $stylePath). $fileType;
        return include ROOT_PATH . "/app/View/styles/$stylePath" ;
    }
    public static function script(string $script, $fileType = ".js")
    {
        $script = str_replace('.', '/', $script). $fileType;
        return include ROOT_PATH . "/app/View/scripts/$script" ;
    }
}
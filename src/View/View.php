<?php

namespace src\View;

class View
{
    private static string $path;
    private static ?array $data;


    public static function view(string $str, array $data = []): void
    {
        self::$data = $data;
        $path = str_replace( 'public', 'app/View/views/', $_SERVER['DOCUMENT_ROOT']);
        self::$path = $path. str_replace('.', '/', $str). '.php';
        echo self::getContent();
    }

    private static function getContent(): string
    {
        extract(self::$data);
        ob_start();
        include self::$path;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public static function getStyles(array $styles)
    {

    }



}
<?php

namespace App\View\Components;

use App\View\Components\Component;
use src\Session\Cookie;

class ErrorComponent extends Component
{
    public static function getErrorsFromSession(): string
    {
        $errors = '';
        if (isset($_SESSION['errors'])){
            $errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }


        return self::getErrors($errors);
    }
    public static function getErrorsFromVariable($variable): string
    {
        return self::getErrors($variable);
    }

    public static function getError($errorBody): string
    {
        return "
        <small>$errorBody</small>
        <br>
        ";
    }



    /**
     * @param mixed $errors
     * @return string
     */
    public static function getErrors(mixed $errors): string
    {
        if (!$errors) {
            return '';
        }
        $errorsHTML = '';
        foreach (arrayFlat($errors) as $error) {
            $errorsHTML .= self::getError($error);
        }
        return $errorsHTML;
    }

}
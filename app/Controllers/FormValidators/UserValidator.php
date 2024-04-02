<?php

namespace App\Controllers\FormValidators;

use src\Route\Route;
use src\Validation\Validator;

class UserValidator
{

    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function registerFormValidate(array $data): array|bool
    {
        $this->loginField($data['login'] ?? null);
        $this->passwordField($data['password'] ?? null);
        $this->repeatedPasswordField($data["password_repeat"] ?? null , $data["password"] ?? null);

        return !($this->errors);
    }

    private function loginField($login): void
    {
        $validator = new Validator();
        if (!$validator->set(['login', $login])
            ->isAlphaNumeric()
            ->required()
            ->betweenSymbols(3, 10)
            ->validate()
        ){
            $this->errors[] = $validator->getErrors();
        }
    }

    private function passwordField($password): void
    {
        $validator = new Validator();
        if (!$validator->set(['password', $password])
            ->isAlphaNumeric()
            ->required()
            ->betweenSymbols(3, 10)
            ->validate()
        ){
            $this->errors[] = $validator->getErrors();
        }
    }

    private function repeatedPasswordField($repeatedPassword, $originalPassword): void
    {
        $validator = new Validator();
        if (!$validator->set(['repeated password', $repeatedPassword])
            ->required()
            ->equals($originalPassword, 'to password')
            ->validate()
        ){
            $this->errors[] = $validator->getErrors();
        }
    }

}
<?php

namespace App\Controllers\FormValidators;

use src\Validation\Validator;

class FilmValidator
{
    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function createFormValidate(array $data): array|bool
    {
        $this->titleField($data['title']);
        $this->dateField($data['release_year']);
        $this->formatField($data['format']);
        $this->starsField($data['stars']);

        return !($this->errors);
    }

    private function titleField($title): void
    {
        $validator = new Validator();
        if (!$validator->set(['title', $title])
            ->required()
            ->betweenSymbols(3, 100)
            ->validate()
        ){
            $this->errors[] = $validator->getErrors();
        }

    }

    private function dateField($date)
    {
        $validator = new Validator();
        if (!$validator->set(['release date', $date])
            ->isInt()
            ->required()
            ->betweenValues(1800, date("Y"))
            ->validate()
        ){
            $this->errors[] = $validator->getErrors();
        }
    }

    private function formatField($format): void
    {
        $validator = new Validator();
        if (!$validator->set(['format', $format])
            ->required()
            ->betweenSymbols(1,100)
            ->validate()
        ){
            $this->errors[] = $validator->getErrors();
        }
    }
    private function starsField($stars): void
    {
        $validator = new Validator();
        if (!$validator->set(['$stars', $stars])
            ->required()
            ->betweenSymbols(1,1000)
            ->validate()
        ){
            $this->errors[] = $validator->getErrors();
        }
    }
}
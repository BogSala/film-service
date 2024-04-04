<?php

namespace App\Controllers\FormValidators;

use App\Services\FilmService;
use src\Validation\Validator;

class FilmValidator
{
    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }
    public function clearErrors(): array
    {
        return $this->errors = [];
    }

    public function createFormValidate(array $data): array|bool
    {
        $titles = FilmService::getAllTitlesByUserId($data['user_id'] ?? null);
        $this->titleField($data['title'] ?? null, $titles);
        $this->dateField($data['release_year'] ?? null);
        $this->formatField($data['format'] ?? null);
        $this->starsField($data['stars'] ?? null);

        return !($this->errors);
    }

    private function titleField($title, $titles): void
    {
        $validator = new Validator();
        if (!$validator->set(['title', $title])
            ->required()
            ->betweenSymbols(3, 100)
            ->unique($titles)
            ->validate()
        ){
            $this->errors[] = $validator->getErrors();
        }

    }

    private function dateField($date): void
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
            ->inArray(['VHS', 'DVD', 'Blu-Ray'])
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
            ->notPregMatch("/[^\p{L}' ,-]/u")
            ->validate()
        ){
            $this->errors[] = $validator->getErrors();
        }
    }
}
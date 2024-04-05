<?php

namespace App\Controllers\FormValidators;

use App\Services\FilmService;
use finfo;
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

    public function importFormValidate($file): bool
    {
        if (empty($file)) {
            $this->errors[] =  'Add your file';
        } elseif ($this->getFileError($file)){
            $this->errors[] = $this->getFileError($file);
        } elseif ($file["size"] > 1048576) {
            $this->errors[] = 'File is too big';
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($file['tmp_name']);
            if ($mime_type !== 'text/plain'){
                $this->errors[] =  'Filetype isn`t text/plain';
            }
        }
        return !($this->errors);
    }

    private function getFileError(array $file) : ?string
    {
        if ($file["error"] !== UPLOAD_ERR_OK) {

            return match ($file["error"]) {
                UPLOAD_ERR_PARTIAL => ('File only partially uploaded'),
                UPLOAD_ERR_NO_FILE => ('No file was uploaded'),
                UPLOAD_ERR_EXTENSION => ('File upload stopped by a PHP extension'),
                UPLOAD_ERR_FORM_SIZE => ('File exceeds MAX_FILE_SIZE in the HTML form'),
                UPLOAD_ERR_INI_SIZE => ('File exceeds upload_max_filesize in php.ini'),
                UPLOAD_ERR_NO_TMP_DIR => ('Temporary folder not found'),
                UPLOAD_ERR_CANT_WRITE => ('Failed to write file'),
                default => ('Unknown upload error'),
            };
        }
        return null;
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
<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Controllers\FormValidators\FilmValidator;
use App\Middlewares\Auth;
use App\Services\AuthService;
use App\Services\FilmService;
use App\View\Components\ErrorComponent;
use App\View\Components\FilmComponent;
use src\Request\Request;
use src\Route\Route;
use src\View\View;

class FilmController extends Controller
{
    private FilmValidator $formValidator;
    private ?int $userId;

    public function __construct()
    {
        if (!Auth::process()) {
            Route::redirect('/users/login');
        }
        $this->userId = AuthService::getUserId();
        $this->formValidator = new FilmValidator();
    }

    public function index(): void
    {
        $films = FilmService::getUserFilms($this->userId);
        View::view('films.index', compact('films'));

    }
    public function search(): void
    {
        View::view('films.search');
    }

    public function makeSearch(): void
    {
        $data = Request::data();

        $films = FilmService::searchBy($data['search_type'] ?? 'title', $data['search']);

        $_SESSION['search_results'] = $films;
        Route::redirect('/films/search');
    }

    public function create(): void
    {
        $formErrors = ErrorComponent::getErrorsFromSession();
        View::view('films.create' , compact('formErrors'));
    }

    public function store(): void
    {
        $data = Request::formData();
        $data['user_id'] = $this->userId;
        $validated = $this->formValidator->createFormValidate($data);
        $errors = $this->formValidator->getErrors();

        if ($validated){
            $inserted = FilmService::insertFilm($data);
            if ($inserted){
                Route::redirect('/films');
            } else {
                Route::redirect('/500');
            }
        } else {
            $_SESSION['errors'] = $errors;
            Route::redirect('/films/create');
        }

    }

    public function massStore(): void
    {
        $file = $_FILES['import'] ?? [];

        if (!$this->formValidator->importFormValidate($file)) {
            $_SESSION['errors'] = $this->formValidator->getErrors();;
            Route::redirect('/films/import');
            die();
        }

        $fileData = FilmService::safeOpen($file['name'] , $file['tmp_name']);

        $films = @FilmService::getFilmsFromString($fileData);
        if($films){
            $filmsCount = count($films);
            $films = FilmService::deleteInvalidFilms($films, $this->userId);
            $inserted = 0;
        } else {
            $_SESSION['errors'] = ['We have a problem with opening or parsing your file, check its name and value for special characters like whitespaces'];
            Route::redirect('/films/import');
            die();
        }

        if ($filmsCount > 0){
            $inserted = FilmService::importFilms($films , $this->userId);
        }
        if($inserted === $filmsCount && $inserted !== 0){
            Route::redirect('/films');
            die();
        } else {
            $_SESSION['errors'] = ["Not all films imported this time. Imported count: $inserted"];
        }
        Route::redirect('/films/import');
    }

    public function import(): void
    {
        $formErrors = ErrorComponent::getErrorsFromSession();
        View::view('films.import' , compact('formErrors'));
    }

    public function show($id): void
    {
        $film = FilmService::getFilmById($id);
        if (!is_array($film)){
            Route::redirect('/404');
            die();
        }
        View::view('films.show', compact('film'));
    }

    public function destroy(): void
    {
        $data = Request::data();
        if(FilmService::destroyFilm( $data['film_id'],$this->userId)) {
            Route::redirect('/films');
            exit();
        };
        Route::redirect('/404');
    }
}
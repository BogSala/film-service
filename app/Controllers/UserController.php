<?php

namespace App\Controllers;
use App\Controllers\FormValidators\UserValidator;
use App\Services\AuthService;
use App\Services\UserService;
use App\View\Components\ErrorComponent;
use src\Request\Request;
use src\Route\Route;
use src\View\View;


class UserController extends Controller
{

    private UserValidator $formValidator;

    public function __construct()
    {
        $this->formValidator = new UserValidator();
    }

    public function dump(): void
    {
        View::view('system.dump');
    }

    public function logout(): void
    {
        AuthService::logout();
        Route::redirect('/users/login');
    }

    public function register(): void
    {
        $formErrors = ErrorComponent::getErrorsFromSession();
        View::view('users.register' , compact('formErrors'));
    }

    public function login(): void
    {
        $formErrors = ErrorComponent::getErrorsFromSession();
        View::view('users.login' , compact('formErrors'));
    }

    public function auth(): void
    {
        $data = Request::data();
        if (empty($data)){
            Route::redirect('/users/login');
            die();
        }
        $id = UserService::checkCredentials($data['login'], $data['password']);
        if ($id) {

            AuthService::auth($id, $data['login'], $data['password']);
            Route::redirect('/films');

        } else {
            $_SESSION['errors'] = ["Login or password is wrong"];
            Route::redirect('/users/login');
        }

    }

    public function store(): void
    {
        $data = Request::data();
        $validated = $this->formValidator->registerFormValidate($data);
        $errors = $this->formValidator->getErrors();

        if (UserService::checkUnique($data['login'])){
            $errors[] = 'Login must be unique';
            $validated = false;
        }
        if ($validated && UserService::insertUser($data['login'], $data['password'])){
            Route::redirect('/users/login');
        } else {
            $_SESSION['errors'] = $errors;
            Route::redirect('/users/register');
        }
    }
}
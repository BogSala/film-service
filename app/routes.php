<?php

use App\Controllers\FilmController;
use App\Controllers\UserController;
use App\Middlewares\Auth;
use src\Route\Route;

require '../src/errors.php';

Route::get('/users/login', [UserController::class, 'login']);
Route::get('/users/register', [UserController::class, 'register']);
Route::post('/users/logout', [UserController::class, 'logout']);
Route::post('/users/store', [UserController::class, 'store']);
Route::post('/users/auth', [UserController::class, 'auth']);

Route::get('/films', [FilmController::class, 'index']);
Route::get('/films/index', [FilmController::class, 'index']);
Route::get('/films/search', [FilmController::class, 'search']);
Route::get('/films/create', [FilmController::class, 'create']);
Route::get('/films/import', [FilmController::class, 'import']);
Route::post('/films/mass-store', [FilmController::class, 'massStore']);
Route::post('/films/make-search', [FilmController::class, 'makeSearch']);
Route::post('/films/store', [FilmController::class, 'store']);
Route::post('/films/destroy', [FilmController::class, 'destroy']);
Route::get('/films/{id}', [FilmController::class, 'show']);


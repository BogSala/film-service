<?php
use App\Controllers\ErrorController;
use src\Route\Route;

Route::get('/403', [ErrorController::class, 'custom']);
Route::get('/404', [ErrorController::class, 'custom']);
Route::get('/500', [ErrorController::class, 'custom']);
Route::get('/541', [ErrorController::class, 'standard']);
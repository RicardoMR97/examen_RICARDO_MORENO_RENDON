<?php
use App\Http\Controllers\UserController;
// Ruta para la pantalla de inicio de sesión

Route::get('/', [UserController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);


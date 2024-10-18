<?php
use App\Http\Controllers\UserController;
// Ruta para la pantalla de inicio de sesión
Route::get('/', function () {
    return view('login');
});
Route::get('/users', [UserController::class, 'index']);


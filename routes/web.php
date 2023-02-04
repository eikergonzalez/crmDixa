<?php

use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;

Route::get('/auth/login', [AuthController::class, 'index']);
Route::post('/auth/login', [AuthController::class, 'login'])->middleware('logs');
Route::get('/auth/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::view('/', 'dashboard');

    Route::get('/agenda', [AgendaController::class, 'index']);
    Route::post('/agenda', [AgendaController::class, 'saveEvento']);
    Route::delete('/agenda/{id}', [AgendaController::class, 'deleteEvento']);

    Route::view('/noticias', 'pages.noticias');
    Route::view('/valoracion', 'pages.valoracion');
    Route::view('/encargo', 'pages.encargo');
    Route::view('/pedidos', 'pages.pedidos');
    Route::view('/firma-pendiente', 'pages.firma-pendiente');
    Route::view('/de-baja', 'pages.de-baja');
    Route::view('/operaciones-cerradas', 'pages.operaciones-cerradas');

    Route::view('/informe/main', 'pages.informe');

    Route::get('/ajustes/usuarios', [UsuarioController::class, 'index']);
    Route::post('/ajustes/usuarios', [UsuarioController::class, 'saveUsuario']);
    Route::delete('/ajustes/usuarios/{id}', [UsuarioController::class, 'deleteUsuario']);
    
    Route::view('/ajustes/roles', 'pages.ajustes.roles');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\TurnosController;

Route::domain('{account}.'.env('DOMAIN'))->group(function () {
    Route::get('/', function ($domain) {
        return view('welcome');
        //return redirect('https://iwie.app');
    });

    Route::post('/login', [AuthController::class, 'login'])->middleware('logs');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::middleware(['auth:api'])->group(function () {
        Route::get('/clientes', [ClientesController::class, 'getClientes']);
        Route::get('/cliente/{id}', [ClientesController::class, 'getClientebyId']);
        
		Route::post('/turnos', [TurnosController::class, 'createTurno'])->middleware('logs');
    });
});


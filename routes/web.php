<?php

use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\EncargoController;
use App\Http\Controllers\DeBajaController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\VisitasController;

Route::get('/auth/login', [AuthController::class, 'index']);
Route::post('/auth/login', [AuthController::class, 'login'])->middleware('logs');
Route::get('/auth/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::view('/', 'dashboard');

    Route::get('/agenda', [AgendaController::class, 'index']);
    Route::post('/agenda', [AgendaController::class, 'saveEvento']);
    Route::delete('/agenda/{id}', [AgendaController::class, 'deleteEvento']);

    Route::get('/ajustes/usuarios', [UsuarioController::class, 'index']);
    Route::post('/ajustes/usuarios', [UsuarioController::class, 'saveUsuario']);
    Route::delete('/ajustes/usuarios/{id}', [UsuarioController::class, 'deleteUsuario']);
    
    Route::get('/ajustes/roles', [RolController::class, 'index']);

    Route::get('/noticias', [NoticiasController::class, 'index']);
    Route::post('/noticias', [NoticiasController::class, 'saveNoticias']);

    Route::get('/valoracion', [ValoracionController::class, 'index']);
    Route::post('/valoracion', [ValoracionController::class, 'saveValoracion']);
    Route::get('/valoracion/getfiles/{id}', [ValoracionController::class, 'getArchivos']);
    Route::post('/valoracion/savefile', [ValoracionController::class, 'saveArchivo']);
    Route::delete('/valoracion/deletefile/{id}', [ValoracionController::class, 'deleteArchivo']);

    Route::get('/encargo', [EncargoController::class, 'index']);
    Route::get('/encargo/detalle/{inmuebleId}', [EncargoController::class, 'getDetalle']);
    Route::get('/encargo/galeria/{inmuebleId}', [EncargoController::class, 'getGaleria']);
    Route::post('/encargo/savefile', [EncargoController::class, 'saveArchivo']);
    Route::post('/encargo/saveimagen', [EncargoController::class, 'saveImagen']);

    Route::get('/visitas/{idInmueble}', [VisitasController::class, 'getVisitasByInmueble']);
    Route::post('/visitas', [VisitasController::class, 'saveVisitasInmueble']);

    Route::get('/de-baja', [DeBajaController::class, 'index']);

    Route::get('/pedidos', [PedidosController::class, 'index']);
    Route::get('/pedidos/detalle/{pedidosid}', [PedidosController::class, 'getDetallePedidos']);
    Route::post('/pedidos', [PedidosController::class, 'savePedidos']);
    Route::get('/pedidos/dardebaja/{id}', [PedidosController::class, 'darDeBaja']);
    


});





    //Route::view('/encargo-detalle', 'pages.encargo-detalle');
    //Route::view('/noticias', 'pages.noticias');
    //Route::view('/pedidos-detalle', 'pages.pedidos-detalle');
    //Route::view('/encargo', 'pages.encargo');
    //Route::view('/pedidos', 'pages.pedidos');
    //Route::view('/de-baja', 'pages.de-baja');
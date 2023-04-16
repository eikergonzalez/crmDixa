<?php

use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\EncargoController;
use App\Http\Controllers\DeBajaController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\VisitasController;
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\OperacionesCerradasController;
use App\Http\Controllers\FirmaPendienteController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\DashboardController;

Route::get('/auth/login', [AuthController::class, 'index']);
Route::post('/auth/login', [AuthController::class, 'login'])->middleware('logs');
Route::get('/auth/logout', [AuthController::class, 'logout']);

Route::get('/contrato/{id}/{uuid}', [ContratoController::class, 'viewNotaEncargo']);
Route::post('/contrato/{id}/{uuid}', [ContratoController::class, 'saveFirmaNotaEncargo']);

Route::get('/propuesta/{id}/{uuid}', [ContratoController::class, 'viewPropuesta']);
Route::post('/propuesta/{id}/{uuid}', [ContratoController::class, 'saveFirmaPropuesta']);


Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

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
    Route::get('/valoracion/getcontrato/{id}', [ValoracionController::class, 'getContrato']);

    Route::get('/encargo', [EncargoController::class, 'index']);
    Route::get('/encargo/detalle/{inmuebleId}', [EncargoController::class, 'getDetalle']);
    Route::get('/encargo/galeria/{inmuebleId}', [EncargoController::class, 'getGaleria']);
    Route::post('/encargo/savefile', [EncargoController::class, 'saveArchivo']);
    Route::post('/encargo/saveimagen', [EncargoController::class, 'saveImagen']);
    Route::post('/encargo/rebaja', [EncargoController::class, 'saveRebaja']);

    Route::get('/visitas/{idInmueble}', [VisitasController::class, 'getVisitasByInmueble']);
    Route::post('/visitas', [VisitasController::class, 'saveVisitasInmueble']);

    Route::get('/pedidos', [PedidosController::class, 'index']);
    Route::get('/pedidos/detalle/{pedidosid}', [PedidosController::class, 'getDetallePedidos']);
    Route::post('/pedidos', [PedidosController::class, 'savePedidos']);
    Route::post('/pedidos/dardebaja/{id}', [PedidosController::class, 'darDeBaja']);
    Route::get('/pedidos/sugerencia/{pedidosid}', [PedidosController::class, 'getDetalleEncargo']);

    Route::post('/ofertas', [OfertasController::class, 'saveOfertas']);

    Route::get('/de-baja', [DeBajaController::class, 'index']);
    Route::get('/de-baja/detalle/{inmuebleId}', [DeBajaController::class, 'getDetalle']);
    Route::post('/debaja/cambiarestatus/{inmuebleId}', [DeBajaController::class, 'CambiarEstatus']);

    Route::get('/operaciones-cerradas', [OperacionesCerradasController::class, 'index']);
    Route::get('/operaciones-cerradas/detalle/{inmuebleId}', [OperacionesCerradasController::class, 'getDetalle']);

    Route::get('/firma-pendiente', [FirmaPendienteController::class, 'index']);
    Route::get('/firma-pendiente/detalle/{inmuebleId}', [FirmaPendienteController::class, 'getDetalle']);
    Route::post('/firma-pendiente/savefile', [FirmaPendienteController::class, 'saveArchivo']);

    //Route::get('/informes', [InformeController::class, 'index']);
    Route::get('/informe-global', [InformeController::class, 'Global']);
    Route::get('/informe-global/exportexcel', [InformeController::class, 'exportGlobal']); 


    Route::get('/informe-comercial', [InformeController::class, 'Comercial']); 

    Route::get('/informe-pedidos', [InformeController::class, 'Pedidos']); 
    Route::get('/informe-pedidos/exportexcel', [InformeController::class, 'exportPedidos']); 

    // ROUTE INFORME INMUEBLE
    Route::get('/informe-inmueble', [InformeController::class, 'Inmueble']);  
    Route::get('/informe-inmueble/exportexcel', [InformeController::class, 'exportInmueble']);

    Route::post('/contrato/save-propuesta', [ContratoController::class, 'savePropuesta']);
    Route::get('/contrato/getcontrato', [ContratoController::class, 'getContrato']);
    Route::get('/contrato/{id}', [ContratoController::class, 'showContrato']);
});
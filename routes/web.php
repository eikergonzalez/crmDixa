<?php

use Illuminate\Support\Facades\Route;

Route::view('/auth/login', 'auth.login');

Route::view('/', 'dashboard');
Route::view('/agenda', 'pages.agenda');
Route::view('/noticias', 'pages.noticias');
Route::view('/valoracion', 'pages.valoracion');
Route::view('/encargo', 'pages.encargo');
Route::view('/pedidos', 'pages.pedidos');
Route::view('/firma-pendiente', 'pages.firma-pendiente');
Route::view('/de-baja', 'pages.de-baja');
Route::view('/operaciones-cerradas', 'pages.operaciones-cerradas');

Route::view('/informe/main', 'pages.informe');

Route::view('/ajustes/usuarios', 'pages.ajustes.usuarios');
Route::view('/ajustes/roles', 'pages.ajustes.roles');


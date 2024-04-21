<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\tareasController;

Route::get('/tareas', [tareasController::class, 'index']);

Route::get('/tareas/{id}',[tareasController::class, 'show']);

Route::post('/tareas', [tareasController::class, 'store']);

Route::put('/tareas/{id}', [tareasController::class, 'update']);

Route::patch('/tareas/{id}', [tareasController::class, 'updateParcial']);

Route::delete('/tareas/{id}', [tareasController::class, 'destroy'] );

<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\ReceitaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/receitas', [ReceitaController::class, 'store']);
// Route::get('/receitas', [ReceitaController::class, 'index']);
// Route::get('/receitas/{id}', [ReceitaController::class, 'show']);
// Route::put('/receitas/{id}', [ReceitaController::class, 'update']);
// Route::delete('/receitas/{receita}', [ReceitaController::class, 'destroy']);
Route::resource('receitas', ReceitaController::class)->except(['create', 'edit']);
Route::resource('despesas', DespesaController::class)->except(['create', 'edit']);
Route::resource('categorias', CategoriaController::class)->except(['create', 'edit']);

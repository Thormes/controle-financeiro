<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ResumoController;
use App\Http\Controllers\ReceitaController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserControler;

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

Route::resource('receitas', ReceitaController::class)->except(['create', 'edit'])->middleware('auth:api');
Route::resource('despesas', DespesaController::class)->except(['create', 'edit'])->middleware('auth:api');
Route::get('receitas/{ano}/{mes}', [ReceitaController::class, 'porMes'])->middleware('auth:api');
Route::get('despesas/{ano}/{mes}', [DespesaController::class, 'porMes'])->middleware('auth:api');
Route::get('resumo/{ano}/{mes}', ResumoController::class)->middleware('auth:api');
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class ,'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
Route::post('auth/register', UserControler::class);

<?php

use App\Http\Controllers\Api\Admin\CategoriaController;
use App\Http\Controllers\Api\Admin\ProductoController;
use App\Http\Controllers\Api\Admin\ModuloController;
use App\Http\Controllers\Api\Admin\UsuarioController;
use App\Http\Controllers\AuthController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    //Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::get('/categorias', [CategoriaController::class, 'index']);
Route::post('/categorias', [CategoriaController::class, 'store']);
Route::put('/categorias/{id}', [CategoriaController::class, 'update']);

Route::get('/productos', [ProductoController::class, 'index']);
Route::post('/productos', [ProductoController::class, 'store']);
Route::put('/productos/{id}', [ProductoController::class, 'update']);
Route::get('/productosCategorias', [ProductoController::class, 'obtenerCategorias']);

Route::get('/modulos', [ModuloController::class, 'index']);
Route::post('/modulos', [ModuloController::class, 'store']);
Route::put('/modulos/{id}', [ModuloController::class, 'update']);


Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
Route::get('/modulosUsuarios', [UsuarioController::class, 'obtenerCategorias']);
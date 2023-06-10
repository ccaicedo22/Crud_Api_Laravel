<?php

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

Route::get('/productos', 'App\Http\Controllers\ProductController@index'); //para mostrar todos los registros
Route::post('/productos', 'App\Http\Controllers\ProductController@store'); //para crear un producto
Route::get('/productos/{id}', 'App\Http\Controllers\ProductController@show'); //para mostrar un producto en especifico
Route::put('/productos/{id}', 'App\Http\Controllers\ProductController@update'); //actualizar un producto en especifico
Route::delete('/productos/{id}', 'App\Http\Controllers\ProductController@destroy'); //Elimina un producto en especifico

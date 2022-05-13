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


Route::get('v1/print/{id}', [App\Http\Controllers\Api\V1\PrintController::class, 'print']);
Route::get('v1/print_order/{id}', [App\Http\Controllers\Api\V1\PrintController::class, 'print_order']);

Route::post('login',[App\Http\Controllers\Api\LoginController::class,'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

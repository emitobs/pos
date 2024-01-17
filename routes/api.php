<?php

use App\Http\Controllers\Api\V1\DelivererController;
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
Route::GET('v1/getClients', [App\Http\Controllers\Api\V1\PrintController::class, 'getClients'])->name('getClients');
Route::GET('v1/getProducts', [App\Http\Controllers\Api\V1\PrintController::class, 'getProducts'])->name('getProducts');


Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::middleware(['auth:api', 'forceJson'])->group(function () {
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('v1/assignDelivererToOrder', [DelivererController::class, 'assignOrder']);
});

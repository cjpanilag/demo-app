<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::group(['prefix' => 'order'], function () {
    Route::get('', [OrderController::class, 'index']);
    Route::post('', [OrderController::class, 'store']);
    Route::put('{order}', [OrderController::class, 'update']);
    Route::delete('{order}', [OrderController::class, 'delete']);
    Route::get('export', [OrderController::class, 'export']);
    Route::get('analytics', [OrderController::class, 'analytics']);
});

Route::group(['prefix' => 'product'], function () {
    Route::get('', [ProductController::class, 'index']);
});

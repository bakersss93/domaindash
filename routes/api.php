<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api_key')->group(function () {
    Route::get('domains', [\App\Http\Controllers\Api\DomainApiController::class, 'index']);
    Route::get('domains/{id}', [\App\Http\Controllers\Api\DomainApiController::class, 'show']);
    Route::get('hosting-services', [\App\Http\Controllers\Api\HostingServiceApiController::class, 'index']);
    Route::get('hosting-services/{id}', [\App\Http\Controllers\Api\HostingServiceApiController::class, 'show']);
    Route::get('ssl-services', [\App\Http\Controllers\Api\SSLServiceApiController::class, 'index']);
    Route::get('ssl-services/{id}', [\App\Http\Controllers\Api\SSLServiceApiController::class, 'show']);
});

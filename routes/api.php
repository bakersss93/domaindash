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

Route::middleware('api.key')->group(function () {
    Route::get('customers', [\App\Http\Controllers\Api\CustomerController::class, 'index']);
    Route::get('domains', [\App\Http\Controllers\Api\DomainController::class, 'index']);
    Route::get('hosting-services', [\App\Http\Controllers\Api\HostingServiceController::class, 'index']);
    Route::get('ssl-services', [\App\Http\Controllers\Api\SSLServiceController::class, 'index']);
});

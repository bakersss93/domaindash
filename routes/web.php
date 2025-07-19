<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
#Admin Only 
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('domains', DomainController::class);
    Route::resource('hosting-services', HostingServiceController::class);
    Route::resource('ssl-services', SSLServiceController::class);
    Route::resource('email-templates', EmailTemplateController::class)->except(['show']);
    Route::resource('notifications', NotificationController::class)->only(['index']);
    Route::resource('backup-settings', BackupSettingController::class)->only(['edit', 'update']);
    Route::resource('smtp-settings', SMTPSettingController::class)->only(['edit', 'update']);
    Route::resource('api-keys', ApiKeyController::class);
    Route::get('synergy-api', [SynergyAPIController::class, 'edit'])->name('synergy-api.edit');
    Route::post('synergy-api', [SynergyAPIController::class, 'update'])->name('synergy-api.update');
});
#Customer

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/search', [CustomerController::class, 'searchDomains'])->name('customer.domains.search');
});

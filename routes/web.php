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
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('domains', DomainController::class)->except(['show']);
    Route::resource('hosting-services', HostingServiceController::class)->except(['show']);
    Route::get('hosting-services/{id}/cpanel', [HostingServiceController::class, 'cpanel'])->name('hosting-services.cpanel');
    Route::resource('ssl-services', SSLServiceController::class)->except(['show']);
    Route::resource('email-templates', EmailTemplateController::class)->except(['show']);
    Route::resource('notifications', NotificationController::class)->only(['index']);
    Route::resource('backup-settings', BackupSettingController::class)->only(['edit', 'update']);
    Route::resource('smtp-settings', SMTPSettingController::class)->only(['edit', 'update']);
    Route::resource('settings', SettingController::class)->only(['edit', 'update']);
    Route::resource('api-keys', ApiKeyController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('synergy-api', [SynergyAPIController::class, 'edit'])->name('synergy-api.edit');
    Route::post('synergy-api', [SynergyAPIController::class, 'update'])->name('synergy-api.update');
    Route::get('permissions', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('permissions', [PermissionController::class, 'update'])->name('permissions.update');
});
#Toggle dark mode for any authenticated user
Route::middleware('auth')->post('dark-mode', [DarkModeController::class, 'toggle'])->name('dark-mode.toggle');
#Customer
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('domains', [DomainController::class, 'index'])->name('customer.domains.index');
    Route::get('hosting-services', [HostingServiceController::class, 'index'])->name('customer.hosting.index');
    Route::get('hosting-services/{id}/cpanel', [HostingServiceController::class, 'cpanel'])->name('customer.hosting.cpanel');
    Route::get('ssl-services', [SSLServiceController::class, 'index'])->name('customer.ssl.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('/dashboard/search', [CustomerController::class, 'searchDomains'])->name('customer.domains.search');
    Route::get('/support-ticket', [SupportTicketController::class, 'create'])->name('support-ticket.create');
    Route::post('/support-ticket', [SupportTicketController::class, 'store'])->name('support-ticket.store');
});

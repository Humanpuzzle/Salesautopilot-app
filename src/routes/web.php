<?php

use App\Http\Controllers\Api\SapiListController;
use App\Http\Controllers\Api\SapiSubscriberController;
use App\Http\Controllers\Api\SapiSettingsController;
use Illuminate\Support\Facades\Route;

route::middleware('sapi.config')->group(function () {
    Route::get('/', [SapiListController::class, 'lists'])->name('lists.index');
    Route::get('/lists/{id}', [SapiSubscriberController::class, 'show'])->name('lists.show');
});

Route::get('/settings/login', [SapiSettingsController::class, 'index']);
Route::post('/settings/login', [SapiSettingsController::class, 'store']);

Route::post('/settings/logout', function () {
    session()->forget('sapi_username');
    session()->forget('sapi_password');

    return redirect('/settings/login');
})->name('sapi.logout');

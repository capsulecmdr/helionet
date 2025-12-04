<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminMagicLoginController;
use Laravel\Horizon\Horizon;

Route::get('/', function () {
    return view('welcome');
    // return "hi there";
});

Route::get('/auth/login/admin/{token}', [AdminMagicLoginController::class, 'login'])
    ->name('admin.magic-login')
    ->middleware('web');


Route::prefix('control-deck')
    ->name('control-deck.')
    ->middleware(['web', 'admin']) // adjust middleware stack as needed
    ->group(function () {
        Route::get('/', function () {
            return view('control-deck.dashboard');
        })->name('dashboard');

        Route::get('/users', function () {
            return view('control-deck.users');
        })->name('users');

        Route::get('/plugins', function () {
            return view('control-deck.plugins');
        })->name('plugins');

        Route::get('/settings', function () {
            return view('control-deck.settings');
        })->name('settings');
    });
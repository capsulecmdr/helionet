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
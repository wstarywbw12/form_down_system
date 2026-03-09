<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/login-sikawan', [AuthController::class, 'login'])->name('login.process');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('jenis', JenisController::class);
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::resource('/forms', FormController::class);

});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);
Route::get('/form/download/{id}', [DashboardController::class, 'download'])
    ->name('form.download');


require __DIR__.'/auth.php';

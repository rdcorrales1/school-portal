<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Student\HomeController as StudentHomeController;
use App\Http\Controllers\Student\MarkController as StudentMarkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

// Student pages. Only logged-in users with the "student" role can open these.
// No student ID is in the URL: the controller uses the logged-in user instead.
Route::middleware(['auth', 'role:student'])
    ->prefix('student')->name('student.')
    ->group(function () {
        Route::get('/home', [StudentHomeController::class, 'index'])->name('home');
        Route::get('/my/marks', [StudentMarkController::class, 'index'])->name('marks');
    });

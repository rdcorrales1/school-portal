<?php

use App\Http\Controllers\Teacher\HomeController as TeacherHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')->name('teacher.')
    ->group(function () {
        Route::get('/', [TeacherHomeController::class, 'index'])->name('home');
    });

<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Teacher\HomeController as TeacherHomeController;
use App\Http\Controllers\Teacher\MarkController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')->name('teacher.')
    ->group(function () {
        Route::get('/', [TeacherHomeController::class, 'index'])->name('home');

        Route::get('students', [StudentController::class, 'index'])->name('students.index');
        Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('students', [StudentController::class, 'store'])->name('students.store');

        Route::get('subjects', [SubjectController::class, 'index'])->name('subjects.index');
        Route::get('subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
        Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');

        Route::get('marks', [MarkController::class, 'index'])->name('marks.index');
        Route::post('marks', [MarkController::class, 'store'])->name('marks.store');
    });

<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Student\AccountController as StudentAccountController;
use App\Http\Controllers\Student\HomeController as StudentHomeController;
use App\Http\Controllers\Student\MarkController as StudentMarkController;
use App\Http\Controllers\Teacher\HomeController as TeacherHomeController;
use App\Http\Controllers\Teacher\MarkController as TeacherMarkController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use App\Http\Controllers\Teacher\SubjectController as TeacherSubjectController;
use App\Http\Middleware\RedirectIfLoggedIn;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// A logged-in user is sent to their home page. They must log out to see the login page.
Route::middleware(RedirectIfLoggedIn::class)->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('home');

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');
    });

// Student pages. Only logged-in users with the "student" role can open these.
// No student ID is in the URL: the controller uses the logged-in user instead.
Route::middleware(['auth', 'role:student'])
    ->prefix('student')->name('student.')
    ->group(function () {
        Route::get('/', [StudentHomeController::class, 'index'])->name('home');
        Route::get('/my/marks', [StudentMarkController::class, 'index'])->name('marks');
        Route::get('/my/account', [StudentAccountController::class, 'show'])->name('account');
        Route::post('/my/account/photo', [StudentAccountController::class, 'updatePhoto'])->name('account.photo');
    });

// Teacher pages. Only logged-in users with the "teacher" role can open these.
Route::middleware(['auth', 'role:teacher'])
    ->prefix('teacher')->name('teacher.')
    ->group(function () {
        Route::get('/', [TeacherHomeController::class, 'index'])->name('home');

        Route::get('students', [TeacherStudentController::class, 'index'])->name('students.index');
        Route::get('students/create', [TeacherStudentController::class, 'create'])->name('students.create');
        Route::post('students', [TeacherStudentController::class, 'store'])->name('students.store');

        Route::get('subjects', [TeacherSubjectController::class, 'index'])->name('subjects.index');
        Route::get('subjects/create', [TeacherSubjectController::class, 'create'])->name('subjects.create');
        Route::post('subjects', [TeacherSubjectController::class, 'store'])->name('subjects.store');

        Route::get('marks', [TeacherMarkController::class, 'index'])->name('marks.index');
        Route::post('marks', [TeacherMarkController::class, 'store'])->name('marks.store');
    });

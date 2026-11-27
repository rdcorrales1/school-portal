<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

// Helper: make a logged-in-ready user with the given role.
// "role" is not mass-assignable, so we set it on the model directly.
function userWithRole(string $role): User
{
    $user = User::factory()->create();
    $user->role = $role;
    $user->save();

    return $user;
}

test('a guest is redirected to login from a student page', function () {
    $this->get('/student/home')->assertRedirect('/login');
    $this->get('/student/my/marks')->assertRedirect('/login');
});

test('a student gets 403 on a teacher-only URL', function () {
    // The teacher pages do not exist yet, so this test adds a small
    // teacher-only route to prove the role check works.
    Route::middleware(['auth', 'role:teacher'])
        ->get('/test-teacher-only', fn () => 'teacher area');

    $this->actingAs(userWithRole('student'))
        ->get('/test-teacher-only')
        ->assertForbidden();

    $this->actingAs(userWithRole('teacher'))
        ->get('/test-teacher-only')
        ->assertOk();
});

test('a teacher gets 403 on the student pages', function () {
    $teacher = userWithRole('teacher');

    $this->actingAs($teacher)->get('/student/home')->assertForbidden();
    $this->actingAs($teacher)->get('/student/my/marks')->assertForbidden();
});

test('a principal gets 403 on the student pages', function () {
    $this->actingAs(userWithRole('principal'))
        ->get('/student/home')
        ->assertForbidden();
});

test('a student can open their home page', function () {
    $student = userWithRole('student');

    $this->actingAs($student)
        ->get('/student/home')
        ->assertOk()
        ->assertSee($student->name);
});

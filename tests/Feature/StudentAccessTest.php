<?php

use App\Models\Student;
use App\Models\Subject;
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
    $this->get('/student')->assertRedirect('/login');
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

    $this->actingAs($teacher)->get('/student')->assertForbidden();
    $this->actingAs($teacher)->get('/student/my/marks')->assertForbidden();
});

test('a principal gets 403 on the student pages', function () {
    $this->actingAs(userWithRole('principal'))
        ->get('/student')
        ->assertForbidden();
});

test('a student can open their home page', function () {
    $student = userWithRole('student');

    $this->actingAs($student)
        ->get('/student')
        ->assertOk()
        ->assertSee($student->name);
});

test('the student home shows the student number and only their own subjects', function () {
    $student = Student::factory()->create();
    $mySubject = Subject::factory()->create();
    $otherSubject = Subject::factory()->create();
    $student->subjects()->attach($mySubject);

    $this->actingAs($student->user)
        ->get('/student')
        ->assertOk()
        ->assertSee($student->student_no)
        ->assertSee($mySubject->code)
        ->assertDontSee($otherSubject->code);
});

test('a student lands on /student after login', function () {
    $user = Student::factory()->create()->user;

    $this->post('/login', ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect('/student');
});

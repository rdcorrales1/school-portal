<?php

use App\Models\Student;
use App\Models\Subject;
use App\Models\User;

it('lets a principal see the principal home page', function () {
    $principal = User::factory()->principal()->create();

    $this->actingAs($principal)
        ->get(route('principal.home'))
        ->assertOk()
        ->assertSee('Principal Home');
});

it('lets a principal see the list of all students', function () {
    $principal = User::factory()->principal()->create();
    $student = Student::factory()->create();
    $student->user->update(['name' => 'Visible Student']);

    $this->actingAs($principal)
        ->get(route('principal.students.index'))
        ->assertOk()
        ->assertSee('Visible Student')
        ->assertSee($student->student_no);
});

it('lets a principal see the list of all teachers', function () {
    $principal = User::factory()->principal()->create();
    User::factory()->teacher()->create(['name' => 'Visible Teacher']);

    $this->actingAs($principal)
        ->get(route('principal.teachers.index'))
        ->assertOk()
        ->assertSee('Visible Teacher');
});

it('lets a principal see the list of all subjects', function () {
    $principal = User::factory()->principal()->create();
    Subject::factory()->create(['code' => 'PRN-900', 'name' => 'Visible Subject']);

    $this->actingAs($principal)
        ->get(route('principal.subjects.index'))
        ->assertOk()
        ->assertSee('Visible Subject');
});

it('shows a subject with its teacher and enrolled students to a principal', function () {
    $principal = User::factory()->principal()->create();
    $teacher = User::factory()->teacher()->create(['name' => 'Subject Teacher']);
    $subject = Subject::factory()->create(['teacher_id' => $teacher->id, 'name' => 'Detail Subject']);
    $student = Student::factory()->create();
    $student->user->update(['name' => 'Enrolled Student']);
    $subject->students()->attach($student->id);

    $this->actingAs($principal)
        ->get(route('principal.subjects.show', $subject))
        ->assertOk()
        ->assertSee('Detail Subject')
        ->assertSee('Subject Teacher')
        ->assertSee('Enrolled Student');
});

it('returns 403 when a student opens a principal URL', function () {
    $student = User::factory()->student()->create();

    $this->actingAs($student)
        ->get(route('principal.students.index'))
        ->assertForbidden();
});

it('returns 403 when a teacher opens a principal URL', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('principal.teachers.index'))
        ->assertForbidden();
});

it('redirects a guest from the principal students page to login', function () {
    $this->get(route('principal.students.index'))
        ->assertRedirect(route('login'));
});

it('sends a principal to the principal home page after login', function () {
    User::factory()->principal()->create([
        'email' => 'principal-login@example.com',
        'password' => 'password',
    ]);

    $this->post(route('login'), [
        'email' => 'principal-login@example.com',
        'password' => 'password',
    ])->assertRedirect(route('principal.home'));
});

<?php

use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;

// Helper: a student login plus the matching students row.
function makePrincipalTestStudent(string $name, string $studentNo): Student
{
    $user = User::factory()->student()->create(['name' => $name]);

    return Student::create([
        'user_id' => $user->id,
        'student_no' => $studentNo,
    ]);
}

it('lets a principal see the students list', function () {
    $principal = User::factory()->principal()->create();
    makePrincipalTestStudent('Ana Reyes', '2026-00101');

    $this->actingAs($principal)
        ->get(route('principal.students.index'))
        ->assertOk()
        ->assertSee('Ana Reyes')
        ->assertSee('2026-00101');
});

it('lets a principal see the teachers and subjects lists', function () {
    $principal = User::factory()->principal()->create();
    $teacher = User::factory()->teacher()->create(['name' => 'Maria Lopez']);
    Subject::create(['code' => 'MATH-101', 'name' => 'Mathematics', 'teacher_id' => $teacher->id]);

    $this->actingAs($principal)
        ->get(route('principal.teachers.index'))
        ->assertOk()
        ->assertSee('Maria Lopez');

    $this->actingAs($principal)
        ->get(route('principal.subjects.index'))
        ->assertOk()
        ->assertSee('MATH-101')
        ->assertSee('Maria Lopez');
});

it('shows a student with their subjects and marks', function () {
    $principal = User::factory()->principal()->create();
    $student = makePrincipalTestStudent('Ben Santos', '2026-00102');
    $subject = Subject::create(['code' => 'SCI-101', 'name' => 'Science', 'teacher_id' => null]);
    $student->subjects()->attach($subject->id);
    Mark::create(['student_id' => $student->id, 'subject_id' => $subject->id, 'quarter' => 1, 'mark' => 81]);

    $this->actingAs($principal)
        ->get(route('principal.students.show', $student))
        ->assertOk()
        ->assertSee('Ben Santos')
        ->assertSee('SCI-101')
        ->assertSee('81');
});

it('shows a teacher with the subjects they teach', function () {
    $principal = User::factory()->principal()->create();
    $teacher = User::factory()->teacher()->create(['name' => 'Jose Rizal']);
    Subject::create(['code' => 'HIS-101', 'name' => 'History', 'teacher_id' => $teacher->id]);

    $this->actingAs($principal)
        ->get(route('principal.teachers.show', $teacher))
        ->assertOk()
        ->assertSee('Jose Rizal')
        ->assertSee('HIS-101');
});

it('shows a subject with its enrolled students', function () {
    $principal = User::factory()->principal()->create();
    $student = makePrincipalTestStudent('Carla Cruz', '2026-00103');
    $subject = Subject::create(['code' => 'ENG-101', 'name' => 'English', 'teacher_id' => null]);
    $subject->students()->attach($student->id);

    $this->actingAs($principal)
        ->get(route('principal.subjects.show', $subject))
        ->assertOk()
        ->assertSee('English')
        ->assertSee('Carla Cruz');
});

it('returns 404 when a principal opens a teacher page for a non-teacher', function () {
    $principal = User::factory()->principal()->create();
    $student = User::factory()->student()->create();

    $this->actingAs($principal)
        ->get(route('principal.teachers.show', $student))
        ->assertNotFound();
});

it('returns 403 when a teacher opens a principal URL', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('principal.students.index'))
        ->assertForbidden();
});

it('redirects a guest from a principal URL to login', function () {
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

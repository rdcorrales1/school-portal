<?php

use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Helper: a student user plus their students row.
function makeStudent(string $studentNo): Student
{
    $user = User::factory()->create();
    $user->role = 'student';
    $user->save();

    return Student::create([
        'user_id' => $user->id,
        'student_no' => $studentNo,
    ]);
}

test('a student sees only their own marks', function () {
    $algebra = Subject::create(['code' => 'MA-101', 'name' => 'Algebra One']);
    $zoology = Subject::create(['code' => 'BI-201', 'name' => 'Zoology Two']);

    $me = makeStudent('2026-00001');
    $other = makeStudent('2026-00002');

    Mark::create(['student_id' => $me->id, 'subject_id' => $algebra->id, 'quarter' => 1, 'mark' => 87]);
    Mark::create(['student_id' => $other->id, 'subject_id' => $zoology->id, 'quarter' => 1, 'mark' => 53]);

    $this->actingAs($me->user)
        ->get('/student/my/marks')
        ->assertOk()
        ->assertSee('Algebra One')
        ->assertSee('87')
        ->assertDontSee('Zoology Two');
});

test('a student with no marks sees the empty message', function () {
    $me = makeStudent('2026-00003');

    $this->actingAs($me->user)
        ->get('/student/my/marks')
        ->assertOk()
        ->assertSee('No marks yet.');
});

test('a student user without a student record sees the empty message', function () {
    $user = User::factory()->create();
    $user->role = 'student';
    $user->save();

    $this->actingAs($user)
        ->get('/student/my/marks')
        ->assertOk()
        ->assertSee('No marks yet.');
});

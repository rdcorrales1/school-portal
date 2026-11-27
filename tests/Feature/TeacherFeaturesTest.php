<?php

use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('shows a teacher only the students in subjects they teach', function () {
    $teacher = User::factory()->teacher()->create();
    $otherTeacher = User::factory()->teacher()->create();

    $mine = Student::factory()->create();
    $theirs = Student::factory()->create();

    $mySubject = Subject::factory()->create(['teacher_id' => $teacher->id]);
    $theirSubject = Subject::factory()->create(['teacher_id' => $otherTeacher->id]);
    $mySubject->students()->attach($mine->id);
    $theirSubject->students()->attach($theirs->id);

    $this->actingAs($teacher)
        ->get(route('teacher.students.index'))
        ->assertOk()
        ->assertSee($mine->student_no)
        ->assertDontSee($theirs->student_no);
});

it('creates a student login and enrolls the student in the chosen subject', function () {
    $teacher = User::factory()->teacher()->create();
    $subject = Subject::factory()->create(['teacher_id' => $teacher->id]);

    $this->actingAs($teacher)
        ->post(route('teacher.students.store'), [
            'name' => 'New Student',
            'email' => 'new.student@example.com',
            'subject_id' => $subject->id,
        ])
        ->assertRedirect(route('teacher.students.index'));

    $user = User::where('email', 'new.student@example.com')->firstOrFail();
    expect($user->role)->toBe('student');
    expect($user->student)->not->toBeNull();
    expect($user->student->subjects->pluck('id')->all())->toBe([$subject->id]);
});

it('does not let a teacher add a student to another teacher\'s subject', function () {
    $teacher = User::factory()->teacher()->create();
    $otherTeacher = User::factory()->teacher()->create();
    $theirSubject = Subject::factory()->create(['teacher_id' => $otherTeacher->id]);

    $this->actingAs($teacher)
        ->post(route('teacher.students.store'), [
            'name' => 'Sneaky Student',
            'email' => 'sneaky@example.com',
            'subject_id' => $theirSubject->id,
        ])
        ->assertSessionHasErrors('subject_id');

    expect(User::where('email', 'sneaky@example.com')->exists())->toBeFalse();
});

it('sets a new subject\'s teacher to the logged-in teacher', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->post(route('teacher.subjects.store'), [
            'code' => 'CS-101',
            'name' => 'Intro to Computing',
        ])
        ->assertRedirect(route('teacher.subjects.index'));

    $subject = Subject::where('code', 'CS-101')->firstOrFail();
    expect($subject->teacher_id)->toBe($teacher->id);
});

it('saves marks for students enrolled in the teacher\'s subject', function () {
    $teacher = User::factory()->teacher()->create();
    $subject = Subject::factory()->create(['teacher_id' => $teacher->id]);
    $student = Student::factory()->create();
    $subject->students()->attach($student->id);

    $this->actingAs($teacher)
        ->post(route('teacher.marks.store'), [
            'subject_id' => $subject->id,
            'quarter' => 1,
            'marks' => [$student->id => 88],
        ])
        ->assertSessionHas('status');

    expect(Mark::where([
        'student_id' => $student->id,
        'subject_id' => $subject->id,
        'quarter' => 1,
        'mark' => 88,
    ])->exists())->toBeTrue();
});

it('ignores marks for students who are not enrolled in that subject', function () {
    $teacher = User::factory()->teacher()->create();
    $subject = Subject::factory()->create(['teacher_id' => $teacher->id]);
    $notEnrolled = Student::factory()->create();

    $this->actingAs($teacher)
        ->post(route('teacher.marks.store'), [
            'subject_id' => $subject->id,
            'quarter' => 1,
            'marks' => [$notEnrolled->id => 50],
        ]);

    expect(Mark::where('student_id', $notEnrolled->id)->exists())->toBeFalse();
});

it('rejects a mark above 100', function () {
    $teacher = User::factory()->teacher()->create();
    $subject = Subject::factory()->create(['teacher_id' => $teacher->id]);
    $student = Student::factory()->create();
    $subject->students()->attach($student->id);

    $this->actingAs($teacher)
        ->post(route('teacher.marks.store'), [
            'subject_id' => $subject->id,
            'quarter' => 1,
            'marks' => [$student->id => 101],
        ])
        ->assertSessionHasErrors("marks.{$student->id}");

    expect(Mark::count())->toBe(0);
});

it('returns 403 when a teacher opens marks for another teacher\'s subject', function () {
    $teacher = User::factory()->teacher()->create();
    $otherTeacher = User::factory()->teacher()->create();
    $theirSubject = Subject::factory()->create(['teacher_id' => $otherTeacher->id]);

    $this->actingAs($teacher)
        ->get(route('teacher.marks.index', ['subject_id' => $theirSubject->id]))
        ->assertForbidden();
});

it('returns 403 when a student opens the teacher students page', function () {
    $student = User::factory()->student()->create();

    $this->actingAs($student)
        ->get(route('teacher.students.index'))
        ->assertForbidden();
});

it('shows the add student and add subject forms to a teacher', function () {
    $teacher = User::factory()->teacher()->create();
    Subject::factory()->create(['teacher_id' => $teacher->id]);

    $this->actingAs($teacher)
        ->get(route('teacher.students.create'))
        ->assertOk()
        ->assertSee('Save Student');

    $this->actingAs($teacher)
        ->get(route('teacher.subjects.create'))
        ->assertOk()
        ->assertSee('Save Subject');
});

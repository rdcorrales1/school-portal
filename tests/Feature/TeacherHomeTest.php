<?php

use App\Models\User;

it('lets a teacher see the teacher home page', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('teacher.home'))
        ->assertOk()
        ->assertSee('Teacher Home');
});

it('sends a teacher to the teacher home page after login', function () {
    User::factory()->teacher()->create([
        'email' => 'teacher-login@example.com',
        'password' => 'password',
    ]);

    $this->post(route('login'), [
        'email' => 'teacher-login@example.com',
        'password' => 'password',
    ])->assertRedirect(route('teacher.home'));
});

it('returns 403 when a student opens a teacher URL', function () {
    $student = User::factory()->student()->create();

    $this->actingAs($student)
        ->get(route('teacher.home'))
        ->assertForbidden();
});

it('returns 403 when a principal opens a teacher URL', function () {
    $principal = User::factory()->principal()->create();

    $this->actingAs($principal)
        ->get(route('teacher.home'))
        ->assertForbidden();
});

<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a logged in teacher who goes back to the login page is sent to the teacher home', function () {
    $user = User::factory()->create(['role' => 'teacher']);

    $this->actingAs($user)->get('/login')->assertRedirect(route('teacher.home'));
});

test('a logged in admin who goes back to the login page is sent to the admin home', function () {
    $user = User::factory()->create(['role' => 'admin']);

    $this->actingAs($user)->get('/login')->assertRedirect(route('admin.home'));
});

test('a logged in student who goes back to the login page is sent to the student home', function () {
    $user = User::factory()->create(['role' => 'student']);

    $this->actingAs($user)->get('/login')->assertRedirect(route('student.home'));
});

test('web pages tell the browser not to cache them', function () {
    $response = $this->get('/login');

    expect($response->headers->get('Cache-Control'))->toContain('no-store');
});

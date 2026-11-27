<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a logged in user can log out and is sent to the login page', function () {
    $user = User::factory()->create(['role' => 'teacher']);

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect(route('login'));
    $this->assertGuest();
});

test('a guest cannot use the logout route', function () {
    $response = $this->post('/logout');

    $response->assertRedirect(route('login'));
});

test('logged in pages show the logout button', function () {
    $user = User::factory()->create(['role' => 'teacher']);

    $response = $this->actingAs($user)->get(route('teacher.home'));

    $response->assertStatus(200);
    $response->assertSee('Log out');
    $response->assertSee('action="' . route('logout') . '"', false);
});

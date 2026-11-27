<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the login page shows the sign in form', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Portal Sign In');
});

test('a user can log in with the correct email and password', function () {
    $user = User::factory()->create([
        'email' => 'teacher@example.com',
        'password' => 'password',
    ]);

    $response = $this->post('/login', [
        'email' => 'teacher@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
});

test('a wrong password shows an error and does not log in', function () {
    User::factory()->create([
        'email' => 'teacher@example.com',
        'password' => 'password',
    ]);

    $response = $this->from('/login')->post('/login', [
        'email' => 'teacher@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertRedirect('/login');
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('an empty form shows required errors and does not log in', function () {
    $response = $this->from('/login')->post('/login', []);

    $response->assertRedirect('/login');
    $response->assertSessionHasErrors(['email', 'password']);
    $this->assertGuest();
});

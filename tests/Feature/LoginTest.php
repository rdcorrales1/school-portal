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

    $response->assertRedirect('/student');
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

test('a logged in student is sent to their home page instead of the login page', function () {
    $student = User::factory()->create(['role' => 'student']);

    $this->actingAs($student)
        ->get('/login')
        ->assertRedirect(route('student.home'));
});

test('a logged in teacher cannot post to the login page again', function () {
    $teacher = User::factory()->create(['role' => 'teacher']);

    $this->actingAs($teacher)
        ->post('/login', ['email' => 'other@example.com', 'password' => 'password'])
        ->assertRedirect(route('teacher.home'));

    $this->assertAuthenticatedAs($teacher);
});

test('after logging out the login page is shown again', function () {
    $student = User::factory()->create(['role' => 'student']);

    $this->actingAs($student)->post('/logout');

    $this->get('/login')->assertStatus(200);
});

test('ticking remember me sets a long-lived login cookie', function () {
    User::factory()->create([
        'email' => 'remember@example.com',
        'password' => 'password',
        'role' => 'student',
    ]);

    $response = $this->post('/login', [
        'email' => 'remember@example.com',
        'password' => 'password',
        'remember' => '1',
    ]);

    $response->assertRedirect(route('student.home'));
    expect(rememberCookieCount($response))->toBe(1);
});

test('login without remember me does not set the long-lived cookie', function () {
    User::factory()->create([
        'email' => 'noremember@example.com',
        'password' => 'password',
        'role' => 'student',
    ]);

    $response = $this->post('/login', [
        'email' => 'noremember@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('student.home'));
    expect(rememberCookieCount($response))->toBe(0);
});

/**
 * How many "remember me" cookies the response sends back.
 */
function rememberCookieCount($response): int
{
    return collect($response->headers->getCookies())
        ->filter(fn ($cookie) => str_starts_with($cookie->getName(), 'remember_web_'))
        ->count();
}

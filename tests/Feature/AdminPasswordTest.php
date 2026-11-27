<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('lets an admin reset a student\'s password and the student can sign in with it', function () {
    $admin = User::factory()->admin()->create();
    $student = User::factory()->student()->create([
        'email' => 'reset-me@example.com',
        'password' => 'old-password',
    ]);

    $this->actingAs($admin)
        ->put(route('admin.users.password', $student), [
            'password' => 'new-secret-123',
            'password_confirmation' => 'new-secret-123',
        ])
        ->assertRedirect(route('admin.users.index'));

    expect(Hash::check('new-secret-123', $student->fresh()->password))->toBeTrue();

    auth()->logout();

    $this->post(route('login'), [
        'email' => 'reset-me@example.com',
        'password' => 'new-secret-123',
    ])->assertRedirect('/');

    $this->assertAuthenticatedAs($student);
});

it('rejects a new password shorter than 8 characters', function () {
    $admin = User::factory()->admin()->create();
    $student = User::factory()->student()->create();

    $this->actingAs($admin)
        ->put(route('admin.users.password', $student), [
            'password' => 'short',
            'password_confirmation' => 'short',
        ])
        ->assertSessionHasErrors('password');
});

it('returns 403 when a teacher opens the admin users page', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('admin.users.index'))
        ->assertForbidden();
});

it('returns 403 when a student tries to reset a password', function () {
    $student = User::factory()->student()->create();
    $otherStudent = User::factory()->student()->create();

    $this->actingAs($student)
        ->put(route('admin.users.password', $otherStudent), [
            'password' => 'hacked-123',
            'password_confirmation' => 'hacked-123',
        ])
        ->assertForbidden();
});

it('sends an admin to the admin home page after login', function () {
    User::factory()->admin()->create([
        'email' => 'admin-login@example.com',
        'password' => 'password',
    ]);

    $this->post(route('login'), [
        'email' => 'admin-login@example.com',
        'password' => 'password',
    ])->assertRedirect(route('admin.home'));
});

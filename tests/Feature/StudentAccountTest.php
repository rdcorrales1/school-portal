<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

// Helper: a user with the given role ("role" is not mass-assignable).
function accountTestUser(string $role): User
{
    $user = User::factory()->create();
    $user->role = $role;
    $user->save();

    return $user;
}

test('a student can upload a profile picture', function () {
    Storage::fake('public');
    $student = accountTestUser('student');

    $this->actingAs($student)
        ->post('/student/my/account/photo', ['photo' => UploadedFile::fake()->image('me.jpg', 200, 200)])
        ->assertRedirect('/student/my/account');

    $student->refresh();
    expect($student->profile_photo_path)->not->toBeNull();
    Storage::disk('public')->assertExists($student->profile_photo_path);
});

test('uploading a new picture removes the old file', function () {
    Storage::fake('public');
    $student = accountTestUser('student');

    $this->actingAs($student)->post('/student/my/account/photo', ['photo' => UploadedFile::fake()->image('a.jpg')]);
    $oldPath = $student->refresh()->profile_photo_path;

    $this->actingAs($student)->post('/student/my/account/photo', ['photo' => UploadedFile::fake()->image('b.png')]);

    Storage::disk('public')->assertMissing($oldPath);
});

test('a non-image upload is rejected', function () {
    Storage::fake('public');

    $this->actingAs(accountTestUser('student'))
        ->post('/student/my/account/photo', ['photo' => UploadedFile::fake()->create('notes.pdf', 10, 'application/pdf')])
        ->assertSessionHasErrors('photo');
});

test('only students can open My Account', function () {
    $this->get('/student/my/account')->assertRedirect('/login');
    $this->actingAs(accountTestUser('teacher'))->get('/student/my/account')->assertForbidden();
    $this->actingAs(accountTestUser('student'))->get('/student/my/account')->assertOk();
});

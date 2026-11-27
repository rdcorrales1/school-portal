<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The student record for a user with the student role.
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * The subjects a teacher created and teaches.
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    /**
     * The home page for this user's role. Used after login and when a
     * logged-in user tries to open the login page again.
     */
    public function homeUrl(): string
    {
        return match ($this->role) {
            'teacher' => route('teacher.home'),
            'admin' => route('admin.home'),
            'student' => route('student.home'),
            'principal' => route('principal.home'),
            default => '/',
        };
    }
     /** Public URL of the profile picture, or null when none was uploaded.*/
    public function profilePhotoUrl(): ?string
    {
        return $this->profile_photo_path
            ? Storage::disk('public')->url($this->profile_photo_path)
            : null;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

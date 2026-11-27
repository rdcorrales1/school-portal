<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = ['user_id', 'student_no'];

    // The login account of this student.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Subjects the student is enrolled in (through the enrollments table).
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'enrollments');
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }
}

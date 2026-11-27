<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'student_no'])]
class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'enrollments')->withTimestamps();
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    /**
     * Only students enrolled in at least one subject that this teacher teaches.
     */
    public function scopeTaughtBy(Builder $query, User $teacher): Builder
    {
        return $query->whereHas('subjects', function (Builder $subjectQuery) use ($teacher) {
            $subjectQuery->where('teacher_id', $teacher->id);
        });
    }

    /**
     * Make the next student number, for example 2026-00042.
     */
    public static function nextStudentNumber(): string
    {
        $next = (static::max('id') ?? 0) + 1;

        return now()->year.'-'.str_pad((string) $next, 5, '0', STR_PAD_LEFT);
    }
}

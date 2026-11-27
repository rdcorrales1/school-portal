<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;

class SubjectPolicy
{
    /**
     * A teacher can manage (add students, enter marks for) only the subjects they teach.
     */
    public function manage(User $user, Subject $subject): bool
    {
        return $user->role === 'teacher' && $subject->teacher_id === $user->id;
    }
}

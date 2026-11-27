<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends Controller
{
    /**
     * List every teacher. Read only.
     */
    public function index(): View
    {
        $teachers = User::where('role', 'teacher')
            ->orderBy('name')
            ->get();

        return view('principal.teachers.index', ['teachers' => $teachers]);
    }

    /**
     * Show one teacher and the subjects they teach. Read only.
     */
    public function show(User $teacher): View
    {
        // A user id that belongs to a non-teacher is not found.
        abort_unless($teacher->role === 'teacher', Response::HTTP_NOT_FOUND);

        $subjects = $teacher->subjects()
            ->withCount('students')
            ->orderBy('code')
            ->get();

        return view('principal.teachers.show', [
            'teacher' => $teacher,
            'subjects' => $subjects,
        ]);
    }
}

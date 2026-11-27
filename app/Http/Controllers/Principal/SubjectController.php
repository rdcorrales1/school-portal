<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Contracts\View\View;

class SubjectController extends Controller
{
    /**
     * List every subject in the school (read-only).
     */
    public function index(): View
    {
        $subjects = Subject::with('teacher')
            ->withCount('students')
            ->orderBy('code')
            ->get();

        return view('principal.subjects.index', ['subjects' => $subjects]);
    }

    /**
     * Show one subject with its teacher and enrolled students (read-only).
     */
    public function show(Subject $subject): View
    {
        $subject->load('teacher');

        $students = $subject->students()
            ->with('user')
            ->orderBy('student_no')
            ->get();

        return view('principal.subjects.show', [
            'subject' => $subject,
            'students' => $students,
        ]);
    }
}

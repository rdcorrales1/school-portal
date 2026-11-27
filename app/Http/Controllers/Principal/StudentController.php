<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Contracts\View\View;

class StudentController extends Controller
{
    /**
     * List every student. Read only.
     */
    public function index(): View
    {
        $students = Student::with('user')
            ->orderBy('student_no')
            ->get();

        return view('principal.students.index', ['students' => $students]);
    }

    /**
     * Show one student with their subjects and marks. Read only.
     */
    public function show(Student $student): View
    {
        $student->load('user');

        $subjects = $student->subjects()
            ->with('teacher')
            ->orderBy('code')
            ->get();

        $marks = $student->marks()
            ->with('subject')
            ->orderBy('subject_id')
            ->orderBy('quarter')
            ->get();

        return view('principal.students.show', [
            'student' => $student,
            'subjects' => $subjects,
            'marks' => $marks,
        ]);
    }
}

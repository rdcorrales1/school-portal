<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Contracts\View\View;

class StudentController extends Controller
{
    /**
     * List every student in the school (read-only).
     */
    public function index(): View
    {
        $students = Student::with('user')
            ->orderBy('student_no')
            ->get();

        return view('principal.students.index', ['students' => $students]);
    }
}

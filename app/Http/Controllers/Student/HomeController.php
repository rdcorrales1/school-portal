<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Student home page. The route group already checks "auth" and "role:student".
    public function index(Request $request)
    {
        $user = $request->user();

        // The student record of the logged-in user (null if none exists yet).
        $student = $user->student;

        // Subjects this student is enrolled in, with the teacher's name.
        $subjects = $student
            ? $student->subjects()->with('teacher')->orderBy('code')->get()
            : collect();

        return view('student.home', [
            'user' => $user,
            'student' => $student,
            'subjects' => $subjects,
        ]);
    }
}

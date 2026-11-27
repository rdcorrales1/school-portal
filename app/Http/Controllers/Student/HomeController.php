<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Student dashboard. The route group already checks "auth" and "role:student".
    // Everything is loaded from the logged-in user, never from the URL.
    public function index(Request $request)
    {
        $user = $request->user();

        // The student record of the logged-in user (null if none exists yet).
        $student = $user->student;

        $subjects = collect();
        $recentMarks = collect();
        $marksCount = 0;
        $averageMark = null;

        if ($student) {
            $subjects = $student->subjects()->with('teacher')->orderBy('code')->get();

            $marksCount = $student->marks()->count();
            $averageMark = $marksCount > 0 ? round($student->marks()->avg('mark'), 1) : null;

            // The five most recently saved marks.
            $recentMarks = $student->marks()->with('subject')->latest('id')->take(5)->get();
        }

        return view('student.home', [
            'user' => $user,
            'student' => $student,
            'subjects' => $subjects,
            'marksCount' => $marksCount,
            'averageMark' => $averageMark,
            'recentMarks' => $recentMarks,
        ]);
    }
}

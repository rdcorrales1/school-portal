<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    // "My Marks": shows only the marks of the logged-in student.
    // No ID comes from the URL, so a student cannot open someone else's marks.
    public function index(Request $request)
    {
        $student = $request->user()->student;

        // If this user has no student record yet, show an empty list.
        $marks = $student
            ? $student->marks()->with('subject')->orderBy('subject_id')->orderBy('quarter')->get()
            : collect();

        return view('student.marks', [
            'marks' => $marks,
        ]);
    }
}

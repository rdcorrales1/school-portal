<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * List only the students enrolled in this teacher's subjects.
     */
    public function index(Request $request): View
    {
        $students = Student::taughtBy($request->user())
            ->with('user')
            ->get();

        return view('teacher.students.index', ['students' => $students]);
    }

    /**
     * Show the add student form.
     */
    public function create(Request $request): View
    {
        $subjects = $request->user()->subjects()->orderBy('code')->get();

        return view('teacher.students.create', ['subjects' => $subjects]);
    }

    /**
     * Create the login account and the student record together, then enroll the student.
     */
    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $subject = Subject::findOrFail($request->validated('subject_id'));
        Gate::authorize('manage', $subject);

        // A random temporary password. The teacher gives it to the student once.
        $temporaryPassword = Str::random(10);

        DB::transaction(function () use ($request, $subject, $temporaryPassword) {
            $user = new User([
                'name' => $request->validated('name'),
                'email' => $request->validated('email'),
            ]);
            $user->password = $temporaryPassword;
            $user->role = 'student';
            $user->save();

            $student = Student::create([
                'user_id' => $user->id,
                'student_no' => Student::nextStudentNumber(),
            ]);

            $student->subjects()->attach($subject->id);
        });

        return redirect()
            ->route('teacher.students.index')
            ->with('status', "Student added. Temporary password (show it once): {$temporaryPassword}");
    }
}

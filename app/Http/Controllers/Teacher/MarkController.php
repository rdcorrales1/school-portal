<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveMarksRequest;
use App\Models\Mark;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MarkController extends Controller
{
    /**
     * Pick a subject and quarter, then show the enrolled students and their marks.
     */
    public function index(Request $request): View
    {
        $subjects = $request->user()->subjects()->orderBy('code')->get();
        $quarter = (int) $request->query('quarter', 1);
        $subject = null;
        $students = collect();
        $existingMarks = collect();

        if ($request->filled('subject_id')) {
            $subject = Subject::findOrFail($request->query('subject_id'));
            Gate::authorize('manage', $subject);

            $students = $subject->students()->with('user')->get();
            $existingMarks = Mark::where('subject_id', $subject->id)
                ->where('quarter', $quarter)
                ->get()
                ->keyBy('student_id');
        }

        return view('teacher.marks.index', [
            'subjects' => $subjects,
            'subject' => $subject,
            'quarter' => $quarter,
            'students' => $students,
            'existingMarks' => $existingMarks,
        ]);
    }

    /**
     * Save marks only for students who are enrolled in this subject.
     * Any student ID that is not enrolled is ignored.
     */
    public function store(SaveMarksRequest $request): RedirectResponse
    {
        $subject = Subject::findOrFail($request->validated('subject_id'));
        Gate::authorize('manage', $subject);

        $quarter = (int) $request->validated('quarter');
        $enrolledStudentIds = $subject->students()->pluck('students.id');

        foreach ($enrolledStudentIds as $studentId) {
            $value = $request->validated('marks.'.$studentId);

            // Leave the mark alone when the box was left empty.
            if ($value === null || $value === '') {
                continue;
            }

            Mark::updateOrCreate(
                ['student_id' => $studentId, 'subject_id' => $subject->id, 'quarter' => $quarter],
                ['mark' => (int) $value],
            );
        }

        return redirect()
            ->route('teacher.marks.index', ['subject_id' => $subject->id, 'quarter' => $quarter])
            ->with('status', 'Marks saved.');
    }
}

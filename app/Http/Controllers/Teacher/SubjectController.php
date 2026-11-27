<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Models\Subject;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * List the subjects this teacher created.
     */
    public function index(Request $request): View
    {
        $subjects = $request->user()
            ->subjects()
            ->withCount('students')
            ->orderBy('code')
            ->get();

        return view('teacher.subjects.index', ['subjects' => $subjects]);
    }

    public function create(): View
    {
        return view('teacher.subjects.create');
    }

    /**
     * The logged-in teacher becomes the subject's teacher.
     */
    public function store(StoreSubjectRequest $request): RedirectResponse
    {
        Subject::create([
            'code' => $request->validated('code'),
            'name' => $request->validated('name'),
            'teacher_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('teacher.subjects.index')
            ->with('status', 'Subject added.');
    }
}

<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

class TeacherController extends Controller
{
    /**
     * List every teacher in the school (read-only).
     */
    public function index(): View
    {
        $teachers = User::where('role', 'teacher')
            ->withCount('subjects')
            ->orderBy('name')
            ->get();

        return view('principal.teachers.index', ['teachers' => $teachers]);
    }
}

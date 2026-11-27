<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Student home page. The route group already checks "auth" and "role:student".
    public function index(Request $request)
    {
        return view('student.home', [
            'user' => $request->user(),
        ]);
    }
}

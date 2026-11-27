<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Show the teacher's home page.
     */
    public function index(): View
    {
        return view('teacher.home');
    }
}

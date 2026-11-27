<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Show the admin home page.
     */
    public function index(): View
    {
        return view('admin.home');
    }
}

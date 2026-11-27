<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Show the principal home page.
     */
    public function index(): View
    {
        return view('principal.home');
    }
}

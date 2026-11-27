<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Check the email and password, then log the user in.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        if (! Auth::attempt($request->validated())) {
            return back()
                ->withErrors(['email' => 'These credentials do not match our records.'])
                ->onlyInput('email');
        }

        // Create a fresh session ID after login to prevent session fixation.
        $request->session()->regenerate();

        // Teachers land on their home page. Student and principal home pages are not built yet.
        if ($request->user()->role === 'teacher') {
            return redirect()->intended(route('teacher.home'));
        }

        return redirect()->intended('/');
    }
}

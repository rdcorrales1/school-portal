<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

        // Each role lands on its home page. Student and principal home pages are not built yet.
        $home = match ($request->user()->role) {
            'teacher' => route('teacher.home'),
            'admin' => route('admin.home'),
            default => '/',
        };

        return redirect()->intended($home);
    }

    /**
     * Log the user out, end the session and send them back to the login page.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        // Throw away the session data and issue a new CSRF token.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

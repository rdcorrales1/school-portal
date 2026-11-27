<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminResetPasswordRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * List every user in the portal.
     */
    public function index(): View
    {
        $users = User::orderBy('role')->orderBy('name')->get();

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the password reset form for one user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Set a new password for any user. The password cast hashes it when saved.
     */
    public function updatePassword(AdminResetPasswordRequest $request, User $user): RedirectResponse
    {
        $user->password = $request->validated('password');
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('status', "Password updated for {$user->name}.");
    }
}

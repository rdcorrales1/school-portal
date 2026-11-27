<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfilePhotoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    // "My Account" page. Uses the logged-in user, never an ID from the URL.
    public function show(Request $request)
    {
        return view('student.account', ['user' => $request->user()]);
    }

    // Save a new profile picture for the logged-in student.
    public function updatePhoto(UpdateProfilePhotoRequest $request)
    {
        $user = $request->user();

        $newPath = $request->file('photo')->store('profile-photos', 'public');

        // Remove the old picture so unused files do not pile up.
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->profile_photo_path = $newPath;
        $user->save();

        return redirect()->route('student.account')->with('status', 'Profile picture updated.');
    }
}

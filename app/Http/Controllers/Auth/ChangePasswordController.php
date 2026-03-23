<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserPassChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the form for changing the password.
     *
     * @return \Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Change the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UserPassChangeRequest $request)
    {
        $user = Auth::user();

        // Check if the current password is correct. This handles both hashed and potentially unhashed passwords for migration.
        if (!Hash::check($request->current_password, $user->password) && $user->password !== $request->current_password) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        // Check if the current password is the same as new_password
        if ($request->current_password === $request->new_password) {
            return back()->withErrors(['new_password' => 'The new password is the same as the current one.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->new_password),
        ])->save();

        return redirect()->route('password.change')->with('status', 'Password changed successfully!');
    }
}

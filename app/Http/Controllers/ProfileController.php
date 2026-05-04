<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function almightyAssign()
    {
        if( auth()->check() ) {
            Artisan::call('almighty:assign', ['username' => auth()->user()->username]);
        }

        return Redirect::to('/');
    }

    public function almightyRemove()
    {
        if( auth()->check() ) {
            Artisan::call('almighty:remove', ['username' => auth()->user()->username]);
        }

        return Redirect::to('/');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('users.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->update($request->get('user'));
        $request->user()->profile->update($request->get('profile'));

        // $request->user()->update([
        //     'notification_preferences' => [
        //         'in_app' => $request->boolean('in_app'),
        //         'email' => $request->boolean('email'),
        //         'sms' => $request->boolean('sms'),
        //         'teams' => $request->boolean('teams'),
        //     ]
        // ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function langSwitch($lang): RedirectResponse
    {

        if (! in_array($lang, ['en', 'de', 'pl'])) {
            abort(400);
        }

        session()->put('locale', $lang);
        app()->setLocale($lang);

        return Redirect::back()->withErrors(['msg' => 'Lang changed!']);
        // return Redirect::to('/');
    }
}

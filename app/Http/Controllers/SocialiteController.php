<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                $existingUser->update(['google_id' => $user->id]);
                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name'      => $user->name,
                    'email'     => $user->email,
                    'google_id' => $user->id,
                    'password'  => null,
                ]);
                Auth::login($newUser);
            }
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login failed');
        }
    }
}

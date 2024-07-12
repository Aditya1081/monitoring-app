<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authctrl extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', function ($attribute, $value, $fail) {
                $isValidUsername = preg_match('/^[A-Za-z][A-Za-z0-9_]{4,29}$/', $value);
                $isValidNIK = preg_match('/^[0-9]{10,16}$/', $value);

                if (!$isValidUsername && !$isValidNIK) {
                    $fail('The '.$attribute.' must be a valid username or NIK.');
                }
            }
            ],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

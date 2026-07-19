<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Identifiants incorrects.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (! $user->actif) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => "Votre compte a été désactivé. Contactez l'administration.",
            ]);
        }

        return match ($user->role) {
            'admin' => redirect()->intended(route('admin.dashboard')),
            'hotelier' => redirect()->intended(route('hotelier.dashboard')),
            default => redirect()->intended(route('home')),
        };
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

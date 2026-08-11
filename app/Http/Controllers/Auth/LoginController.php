<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => "Identifiants incorrects."])->onlyInput('email');
        }

        $user = Auth::user();

        // if (! $user->email_verified_at) {
        //     Auth::logout();
        //     return redirect()->route('register.verifier', ['email' => $user->email])
        //         ->withErrors(['email' => "Vérifiez d'abord votre e-mail avec le code reçu."]);
        // }

        if ($user->statut_validation === 'en_attente') {
            Auth::logout();
            return back()->withErrors(['email' => "Votre compte est en attente de validation par un administrateur."]);
        }

        if ($user->statut_validation === 'rejete') {
            Auth::logout();
            return back()->withErrors(['email' => "Votre inscription n'a pas été validée. Vous pouvez soumettre une nouvelle demande."]);
        }

        if (! $user->actif) {
            Auth::logout();
            return back()->withErrors(['email' => "Ce compte a été désactivé. Contactez l'administrateur."]);
        }

        $request->session()->regenerate();

        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'hotelier' => redirect()->route('hotelier.dashboard'),
            'bailleur' => redirect()->route('bailleur.dashboard'),
            default => redirect()->intended(route('accueil')),
        };
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('accueil');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MotDePasseReinitialiseMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function forgotPassword()
    {
        return view('auth.password-email');
    }

    public function findAccount(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email']]);
        $user = User::where('email', $data['email'])->first();

        if (! $user) {
            return back()->withErrors(['email' => "Aucun compte ne correspond à cette adresse e-mail."])->withInput();
        }

        return view('auth.password-confirm', ['user' => $user]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'nom' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'in:homme,femme,autre'],
            'role' => ['required', 'in:client,hotelier,bailleur'],
            'telephone' => ['required', 'string', 'max:30'],
        ]);

        $user = User::where('email', $data['email'])->first();
        $informationsCorrectes = $user
            && mb_strtolower(trim($user->nom)) === mb_strtolower(trim($data['nom']))
            && $user->genre === $data['genre']
            && $user->role === $data['role']
            && trim((string) $user->telephone) === trim($data['telephone']);

        if (! $informationsCorrectes) {
            return back()->withErrors(['email' => 'Les informations fournies ne correspondent pas à ce compte.'])->withInput();
        }

        $temporaryPassword = Str::password(12, true, true, false, false);
        $user->update(['password' => Hash::make($temporaryPassword)]);

        Mail::to($user->email)->send(new MotDePasseReinitialiseMail($user, $temporaryPassword));

        return redirect()->route('login')->with('success', 'Un nouveau mot de passe vous a été envoyé par e-mail.');
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

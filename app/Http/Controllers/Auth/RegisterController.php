<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'role' => 'required|in:client,hotelier',
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string|max:20',
            'genre' => 'required|in:homme,femme',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'genre' => $data['genre'],
            'role' => $data['role'],
            // un hôtelier est actif dès l'inscription : ce sont ses HÔTELS qui sont
            // ensuite soumis à validation par l'admin, pas le compte lui-même
            'actif' => true,
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return match ($user->role) {
            'hotelier' => redirect()->route('hotelier.dashboard'),
            default => redirect()->route('home'),
        };
    }
}

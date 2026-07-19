<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('client.profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'required|string|max:20',
            'genre' => 'required|in:homme,femme',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'nouveau_mot_de_passe' => ['required', 'confirmed', Password::min(8)],
        ]);

        Auth::user()->update(['password' => Hash::make($request->input('nouveau_mot_de_passe'))]);

        return back()->with('success', 'Mot de passe modifié.');
    }
}

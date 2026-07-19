<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->input('role', 'client');
        $recherche = $request->input('recherche');

        $users = User::where('role', $role)
            ->when($recherche, fn ($q) => $q->where('nom', 'like', "%{$recherche}%")
                ->orWhere('email', 'like', "%{$recherche}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users', compact('users', 'role', 'recherche'));
    }

    public function basculerActivation(User $user)
    {
        $user->update(['actif' => ! $user->actif]);

        return back()->with('success', $user->actif ? 'Compte activé.' : 'Compte désactivé.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }
}

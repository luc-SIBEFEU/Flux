<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CompteRejeteMail;
use App\Mail\CompteValideMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['client', 'hotelier', 'bailleur'])
            ->when(request('role'), fn ($q, $v) => $q->where('role', $v))
            ->when(request('statut_validation'), fn ($q, $v) => $q->where('statut_validation', $v))
            ->when(request('recherche'), fn ($q, $v) => $q->where('nom', 'like', "%{$v}%")->orWhere('email', 'like', "%{$v}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /** Comptes hôtelier/bailleur en attente de validation (après vérification de l'e-mail). */
    public function enAttente()
    {
        $users = User::whereIn('role', ['hotelier', 'bailleur'])
            ->where('statut_validation', 'en_attente')
            ->latest()
            ->paginate(10); //
            //->whereNotNull('email_verified_at')

        return view('admin.users.en-attente', compact('users'));
    }

    public function valider(User $user)
    {
        abort_unless(in_array($user->role, ['hotelier', 'bailleur']), 404);

        $user->update(['statut_validation' => 'valide', 'actif' => true, 'motif_rejet_compte' => null]);
        Mail::to($user->email)->send(new CompteValideMail($user));

        return back()->with('success', "Compte de {$user->nom} validé.");
    }

    public function rejeter(Request $request, User $user)
    {
        abort_unless(in_array($user->role, ['hotelier', 'bailleur']), 404);

        $data = $request->validate(['motif_rejet_compte' => ['required', 'string', 'max:500']]);
        $user->update(['statut_validation' => 'rejete', 'actif' => false, ...$data]);
        Mail::to($user->email)->send(new CompteRejeteMail($user));

        return back()->with('success', "Inscription de {$user->nom} rejetée.");
    }

    public function toggleActif(User $user)
    {
        $user->update(['actif' => ! $user->actif]);
        return back()->with('success', $user->actif ? 'Compte réactivé.' : 'Compte désactivé.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Compte supprimé.');
    }
}

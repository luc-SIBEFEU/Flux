<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CompteRejeteMail;
use App\Mail\CompteValideMail;
use App\Models\Forfait;
use App\Models\User;
use App\Services\NotificationDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct(private NotificationDashboardService $notifications)
    {
    }

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

        // Un hôtelier/bailleur nouvellement validé démarre en forfait free (upgrade possible ensuite).
        $user->update([
            'statut_validation' => 'valide', 'actif' => true, 'motif_rejet_compte' => null,
            'forfait_id' => $user->forfait_id ?? Forfait::free()->id,
        ]);
        Mail::to($user->email)->send(new CompteValideMail($user));
        $this->notifications->compteValide($user);

        return back()->with('success', "Compte de {$user->nom} validé.");
    }

    public function rejeter(Request $request, User $user)
    {
        abort_unless(in_array($user->role, ['hotelier', 'bailleur']), 404);

        $data = $request->validate(['motif_rejet_compte' => ['required', 'string', 'max:500']]);
        $user->update(['statut_validation' => 'rejete', 'actif' => false, ...$data]);
        Mail::to($user->email)->send(new CompteRejeteMail($user));
        $this->notifications->compteRejete($user);

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

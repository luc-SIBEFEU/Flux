<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CodeVerificationMail;
use App\Mail\NouvelleInscriptionMail;
use App\Models\User;
use App\Services\NotificationDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function __construct(private NotificationDashboardService $notifications)
    {
    }

    public function create()
    {
        return view('auth.register', ['type' => request('type', 'client')]);
    }

    /**
     * Étape 1 : enregistre les informations et envoie un code de vérification
     * par e-mail. Le compte n'est ni actif, ni connecté à ce stade.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'genre' => ['nullable', 'in:homme,femme,autre'],
            'role' => ['required', 'in:client,hotelier,bailleur'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password']),
            // Seuls les clients sont actifs par défaut ; hôteliers/bailleurs attendent la validation admin.
            'actif' => $data['role'] === 'client',
            'statut_validation' => $data['role'] === 'client' ? 'non_requis' : 'en_attente',
            'code_verification' => (string) random_int(100000, 999999),
            'code_expire_a' => now()->addMinutes(15),
        ]);

        Mail::to($user->email)->send(new CodeVerificationMail($user));

        return redirect()->route('register.verifier', ['email' => $user->email]);
    }

    public function formulaireVerification(Request $request)
    {
        $email = $request->query('email');
        abort_unless($email, 404);

        return view('auth.verifier-code', ['email' => $email]);
    }

    /**
     * Étape 2 : vérifie le code reçu par e-mail et finalise le compte.
     * - Client : compte actif, connexion immédiate.
     * - Hôtelier / Bailleur : compte en attente de validation admin, l'admin est notifié.
     */
    public function verifier(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || $user->code_verification !== $data['code']) {
            return back()->withErrors(['code' => 'Code incorrect.'])->withInput();
        }

        if ($user->code_expire_a && now()->greaterThan($user->code_expire_a)) {
            return back()->withErrors(['code' => 'Ce code a expiré. Demandez-en un nouveau.'])->withInput();
        }

        $user->update([
            'email_verified_at' => now(),
            'code_verification' => null,
            'code_expire_a' => null,
        ]);

        if ($user->role === 'client') {
            Auth::login($user);
            return redirect()->route('accueil')->with('success', 'Bienvenue sur Flux !');
        }

        // Hôtelier / bailleur : notifie l'admin, affiche un écran d'attente (pas de connexion).
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Mail::to($admin->email)->send(new NouvelleInscriptionMail($user));
            $this->notifications->nouvelleInscription($admin, $user);
        }

        return redirect()->route('login')->with('success',
            "Votre e-mail est vérifié. Votre inscription {$user->role} est en attente de validation par un administrateur ; vous recevrez un e-mail dès que votre compte sera activé.");
    }

    public function renvoyerCode(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email']]);
        $user = User::where('email', $data['email'])->whereNull('email_verified_at')->first();

        abort_unless($user, 404);

        $user->update([
            'code_verification' => (string) random_int(100000, 999999),
            'code_expire_a' => now()->addMinutes(15),
        ]);

        Mail::to($user->email)->send(new CodeVerificationMail($user));

        return back()->with('success', 'Un nouveau code vous a été envoyé.');
    }
}

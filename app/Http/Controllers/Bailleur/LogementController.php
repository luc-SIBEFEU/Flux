<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Mail\NouveauLogementMail;
use App\Models\Equipement;
use App\Models\Logement;
use App\Models\Minicite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LogementController extends Controller
{
    public function index()
    {
        $logements = auth()->user()->logements()
            ->when(request('type'), fn ($q, $v) => $q->where('type', $v))
            ->when(request('validation'), fn ($q, $v) => $q->where('validation', $v))
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->with('minicite')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('bailleur.logements.index', compact('logements'));
    }

    public function create()
    {
        $minicites = auth()->user()->minicites;
        $equipements = Equipement::whereIn('contexte', ['logement', 'les_deux'])->get();
        return view('bailleur.logements.form', ['logement' => new Logement(), 'minicites' => $minicites, 'equipements' => $equipements]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $nombre = (int) $request->input('nombre_exemplaires', 1);
        $equipements = $request->input('equipements', []);

        // Une villa est toujours meublée, quoi qu'il ait été soumis dans le formulaire.
        if ($data['type'] === 'villa') {
            $data['categorie'] = 'meuble';
        }

        $data['bailleur_id'] = auth()->id();
        $data['statut'] = 'disponible';
        $data['validation'] = 'en_attente'; // doit être validé par l'admin avant d'être visible

        // Si le bailleur possede plusieurs logements identiques dans une mini-cité,
        // on genere automatiquement "nombre" exemplaires avec des id differents.
        $logements = Logement::genererGroupe($data, max(1, $nombre));
        $logements->each(fn (Logement $l) => $l->equipements()->sync($equipements));

        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Mail::to($admin->email)->send(new NouveauLogementMail($logements->first()));
        }

        return redirect()->route('bailleur.logements.index')
            ->with('success', ($nombre > 1 ? "{$nombre} logements créés" : 'Logement créé') . ', en attente de validation par un administrateur.');
    }

    public function edit(Logement $logement)
    {
        $this->authorizeProprietaire($logement);
        $minicites = auth()->user()->minicites;
        $equipements = Equipement::whereIn('contexte', ['logement', 'les_deux'])->get();
        return view('bailleur.logements.form', compact('logement', 'minicites', 'equipements'));
    }

    public function update(Request $request, Logement $logement)
    {
        $this->authorizeProprietaire($logement);
        $data = $this->validated($request);
        unset($data['nombre_exemplaires']);

        if ($data['type'] === 'villa') {
            $data['categorie'] = 'meuble';
        }

        // Toute modification substantielle repasse le logement en attente de validation.
        $data['validation'] = 'en_attente';

        $logement->update($data);
        $logement->equipements()->sync($request->input('equipements', []));

        return back()->with('success', 'Logement mis à jour, en attente de re-validation par un administrateur.');
    }

    public function destroy(Logement $logement)
    {
        $this->authorizeProprietaire($logement);
        $logement->delete();
        return back()->with('success', 'Logement supprimé.');
    }

    private function authorizeProprietaire(Logement $logement): void
    {
        abort_unless($logement->bailleur_id === auth()->id(), 403);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'minicite_id' => ['nullable', 'exists:minicites,id'],
            'type' => ['required', 'in:chambre,studio,appartement,villa'],
            'categorie' => ['required', 'in:standard,meuble'],
            'ville' => ['required', 'string', 'max:255'],
            'quartier' => ['required', 'string', 'max:255'],
            'google_map_lien' => ['nullable', 'url'],
            'prix_mois' => ['required', 'numeric', 'min:0'],
            'caution' => ['nullable', 'numeric', 'min:0'],
            'duree_min_mois' => ['required', 'integer', 'min:1'],
            'moratoire_jours' => ['nullable', 'integer', 'min:0', 'max:90'],
            'info' => ['nullable', 'string'],
            'nombre_exemplaires' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);
    }
}

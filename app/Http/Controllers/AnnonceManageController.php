<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Support\HtmlAssainisseur;
use Illuminate\Http\Request;

/**
 * Commun aux hôteliers et aux bailleurs (mêmes règles), monté sous
 * /mes-annonces avec le middleware role:hotelier,bailleur — même logique
 * que ForfaitController pour éviter de dupliquer deux contrôleurs identiques.
 *
 * Fonctionnalité réservée au forfait pro : un hôtelier/bailleur en forfait
 * free peut consulter cette page mais est redirigé vers /forfait pour créer
 * une annonce.
 */
class AnnonceManageController extends Controller
{
    public function index()
    {
        $annonces = auth()->user()->annonces()->latest()->get();

        return view('annonces.manage.index', compact('annonces'));
    }

    public function create()
    {
        $this->authorizeForfaitPro();

        return view('annonces.manage.form', ['annonce' => new Annonce()]);
    }

    public function store(Request $request)
    {
        $this->authorizeForfaitPro();

        $data = $this->validated($request);
        $data['contenu'] = HtmlAssainisseur::nettoyer($data['contenu']);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('annonces', 'public');
        }

        Annonce::create($data);

        return redirect()->route('annonces.manage.index')->with('success', 'Annonce publiée.');
    }

    public function edit(Annonce $annonce)
    {
        $this->authorizeProprietaire($annonce);

        return view('annonces.manage.form', compact('annonce'));
    }

    public function update(Request $request, Annonce $annonce)
    {
        $this->authorizeProprietaire($annonce);

        $data = $this->validated($request);
        $data['contenu'] = HtmlAssainisseur::nettoyer($data['contenu']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('annonces', 'public');
        }

        $annonce->update($data);

        return redirect()->route('annonces.manage.index')->with('success', 'Annonce mise à jour.');
    }

    public function destroy(Annonce $annonce)
    {
        $this->authorizeProprietaire($annonce);
        $annonce->delete();

        return redirect()->route('annonces.manage.index')->with('success', 'Annonce supprimée.');
    }

    private function authorizeProprietaire(Annonce $annonce): void
    {
        abort_unless($annonce->user_id === auth()->id(), 403);
    }

    private function authorizeForfaitPro(): void
    {
        if (! auth()->user()->peutUtiliserFonctionsPro()) {
            abort(403, 'La publication d\'annonces est réservée aux comptes en forfait pro.');
        }
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'ville' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'in:promotion,information,evenement,disponibilite,autre'],
            'expire_le' => ['nullable', 'date', 'after_or_equal:today'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}

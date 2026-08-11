<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Minicite;
use Illuminate\Http\Request;

class MiniciteController extends Controller
{
    public function index()
    {
        $minicites = auth()->user()->minicites()
            ->when(request('ville'), fn ($q, $v) => $q->where('ville', 'like', "%{$v}%"))
            ->withCount('logements')
            ->latest()
            ->get();

        return view('bailleur.minicites.index', compact('minicites'));
    }

    public function create()
    {
        return view('bailleur.minicites.form', ['minicite' => new Minicite()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        auth()->user()->minicites()->create($data);
        return redirect()->route('bailleur.minicites.index')->with('success', 'Mini-cité créée.');
    }

    public function edit(Minicite $minicite)
    {
        $this->authorizeProprietaire($minicite);
        return view('bailleur.minicites.form', compact('minicite'));
    }

    public function update(Request $request, Minicite $minicite)
    {
        $this->authorizeProprietaire($minicite);
        $minicite->update($this->validated($request));
        return back()->with('success', 'Mini-cité mise à jour.');
    }

    public function destroy(Minicite $minicite)
    {
        $this->authorizeProprietaire($minicite);
        $minicite->delete();
        return back()->with('success', 'Mini-cité supprimée.');
    }

    private function authorizeProprietaire(Minicite $minicite): void
    {
        abort_unless($minicite->bailleur_id === auth()->id(), 403);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'quartier' => ['required', 'string', 'max:255'],
            'google_map_lien' => ['nullable', 'url'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'info' => ['nullable', 'string'],
        ]);
    }
}

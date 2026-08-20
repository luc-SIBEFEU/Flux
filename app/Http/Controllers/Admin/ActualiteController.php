<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;

class ActualiteController extends Controller
{
    public function index()
    {
        $actualites = Actualite::ordonnees()
            ->when(request('periode') === 'en_cours', fn ($q) => $q->enCours())
            ->when(request('periode') === 'a_venir', fn ($q) => $q->where('date_debut', '>', now()))
            ->when(request('periode') === 'passees', fn ($q) => $q->where('date_fin', '<', now()))
            ->paginate(10)
            ->withQueryString();

        return view('admin.actualites.index',['actualite' => new Actualite()] + compact('actualites'));
    }

    public function create()
    {
        return view('admin.actualites.form', ['actualite' => new Actualite()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = $request->file('image')->store('actualites', 'public');
        $data['cree_par'] = auth()->id();

        Actualite::create($data);

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité publiée.');
    }

    public function edit(Actualite $actualite)
    {
        return view('admin.actualites.form', compact('actualite'));
    }

    public function update(Request $request, Actualite $actualite)
    {
        $data = $this->validated($request, false);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('actualites', 'public');
        }

        $actualite->update($data);

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité mise à jour.');
    }

    public function destroy(Actualite $actualite)
    {
        $actualite->delete();
        return back()->with('success', 'Actualité supprimée.');
    }

    private function validated(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
            'ordre' => ['nullable', 'integer', 'min:0'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:4096'],
        ]);
    }
}

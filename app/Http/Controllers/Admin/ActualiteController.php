<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActualiteController extends Controller
{
    public function index()
    {
        $actualites = Actualite::with('auteur')->latest()->paginate(10);

        return view('admin.actualites.index', compact('actualites'));
    }

    public function create()
    {
        return view('admin.actualites.create');
    }

    public function store(Request $request)
    {
        $data = $this->validerDonnees($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('actualites', 'public');
        }

        $data['user_id'] = Auth::id();

        Actualite::create($data);

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité créée.');
    }

    public function edit(Actualite $actualite)
    {
        return view('admin.actualites.edit', compact('actualite'));
    }

    public function update(Request $request, Actualite $actualite)
    {
        $data = $this->validerDonnees($request);

        if ($request->hasFile('image')) {
            if ($actualite->image) {
                Storage::disk('public')->delete($actualite->image);
            }
            $data['image'] = $request->file('image')->store('actualites', 'public');
        }

        $actualite->update($data);

        return redirect()->route('admin.actualites.index')->with('success', 'Actualité mise à jour.');
    }

    public function destroy(Actualite $actualite)
    {
        if ($actualite->image) {
            Storage::disk('public')->delete($actualite->image);
        }

        $actualite->delete();

        return back()->with('success', 'Actualité supprimée.');
    }

    protected function validerDonnees(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:150',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'image' => 'nullable|image|max:4096',
        ]);
    }
}

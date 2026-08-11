<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;
use App\Models\Logement;
use App\Models\Minicite;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function store(Request $request, string $type, int $id)
    {
        $model = $this->resoudreModele($type, $id);

        $request->validate(['photos.*' => ['required', 'image', 'max:4096']]);

        foreach ($request->file('photos', []) as $fichier) {
            $model->photos()->create(['chemin' => $fichier->store('galeries', 'public')]);
        }

        return back()->with('success', 'Photos ajoutées.');
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();
        return back()->with('success', 'Photo supprimée.');
    }

    private function resoudreModele(string $type, int $id)
    {
        $model = match ($type) {
            'logement' => Logement::findOrFail($id),
            'minicite' => Minicite::findOrFail($id),
            default => abort(404),
        };

        abort_unless($model->bailleur_id === auth()->id(), 403);

        return $model;
    }
}

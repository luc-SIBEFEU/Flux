<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /** Gere la galerie d'un hotel OU d'une categorie de chambre (polymorphique). */
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
            'hotel' => Hotel::findOrFail($id),
            'chambre' => \App\Models\CategorieChambre::findOrFail($id),
            default => abort(404),
        };

        $hotel = $type === 'hotel' ? $model : $model->hotel;
        abort_unless($hotel->hotelier_id === auth()->id(), 403);

        return $model;
    }
}

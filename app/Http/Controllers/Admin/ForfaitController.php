<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forfait;
use Illuminate\Http\Request;

class ForfaitController extends Controller
{
    /** L'admin voit free (informatif) + les formules pro (prix/durée modifiables). */
    public function index()
    {
        $forfaits = Forfait::orderByRaw("type = 'free' desc")->orderBy('prix')->get();

        return view('admin.forfaits.index', compact('forfaits'));
    }

    public function update(Request $request, Forfait $forfait)
    {
        abort_if($forfait->estFree(), 422, 'Le forfait free est gratuit par définition.');

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prix' => ['required', 'numeric', 'min:0'],
            'duree_jours' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:500'],
            'actif' => ['sometimes', 'boolean'],
        ]);
        $data['actif'] = $request->boolean('actif');

        $forfait->update($data);

        return back()->with('success', "Formule « {$forfait->nom} » mise à jour.");
    }
}

<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\CategorieChambre;
use App\Models\Hotel;
use Illuminate\Http\Request;

class CategorieChambreController extends Controller
{
    public function index(Hotel $hotel)
    {
        $this->authorizeProprietaire($hotel);
        $chambres = $hotel->categorieChambres()
            ->when(request('recherche'), fn ($q, $v) => $q->where('nom', 'like', "%{$v}%"))
            ->withCount('reservations')
            ->get();
        return view('hotelier.chambres.index', compact('hotel', 'chambres'));
    }

    public function create(Hotel $hotel)
    {
        $this->authorizeProprietaire($hotel);
        return view('hotelier.chambres.form', ['hotel' => $hotel, 'chambre' => new CategorieChambre()]);
    }

    public function store(Request $request, Hotel $hotel)
    {
        $this->authorizeProprietaire($hotel);
        $data = $this->validated($request);

        $chambre = $hotel->categorieChambres()->create($data);

        return redirect()->route('hotelier.hotels.chambres.index', $hotel)->with('success', 'Catégorie de chambre ajoutée.');
    }

    public function edit(Hotel $hotel, CategorieChambre $chambre)
    {
        $this->authorizeProprietaire($hotel);
        return view('hotelier.chambres.form', compact('hotel', 'chambre'));
    }

    public function update(Request $request, Hotel $hotel, CategorieChambre $chambre)
    {
        $this->authorizeProprietaire($hotel);
        $data = $this->validated($request);

        $chambre->update($data);

        return back()->with('success', 'Catégorie de chambre mise à jour.');
    }

    public function destroy(Hotel $hotel, CategorieChambre $chambre)
    {
        $this->authorizeProprietaire($hotel);
        $chambre->delete();
        return back()->with('success', 'Catégorie de chambre supprimée.');
    }

    private function authorizeProprietaire(Hotel $hotel): void
    {
        abort_unless($hotel->hotelier_id === auth()->id(), 403);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'capacite_adultes' => ['required', 'integer', 'min:1'],
            'capacite_enfants' => ['nullable', 'integer', 'min:0'],
            'prix_nuit' => ['required', 'numeric', 'min:0'],
            'nombre_disponible' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
        ]);
    }
}

<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Hotel;
use App\Models\RoomCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomCategoryController extends Controller
{
    public function index(Hotel $hotel)
    {
        $this->autoriser($hotel);

        $chambres = $hotel->roomCategories()->with('amenities')->latest()->get();

        return view('hotelier.rooms.index', compact('hotel', 'chambres'));
    }

    public function create(Hotel $hotel)
    {
        $this->autoriser($hotel);

        $toutesAmenities = Amenity::orderBy('nom')->get();

        return view('hotelier.rooms.create', compact('hotel', 'toutesAmenities'));
    }

    public function store(Request $request, Hotel $hotel)
    {
        $this->autoriser($hotel);

        $data = $this->validerDonnees($request);

        $chambre = $hotel->roomCategories()->create($data);
        $chambre->amenities()->sync($request->input('amenities', []));

        return redirect()->route('hotelier.rooms.index', $hotel)->with('success', 'Catégorie de chambre ajoutée.');
    }

    public function edit(Hotel $hotel, RoomCategory $chambre)
    {
        $this->autoriser($hotel);
        abort_unless($chambre->hotel_id === $hotel->id, 404);

        $toutesAmenities = Amenity::orderBy('nom')->get();
        $chambre->load('amenities');

        return view('hotelier.rooms.edit', compact('hotel', 'chambre', 'toutesAmenities'));
    }

    public function update(Request $request, Hotel $hotel, RoomCategory $chambre)
    {
        $this->autoriser($hotel);
        abort_unless($chambre->hotel_id === $hotel->id, 404);

        $data = $this->validerDonnees($request);
        $chambre->update($data);
        $chambre->amenities()->sync($request->input('amenities', []));

        return redirect()->route('hotelier.rooms.index', $hotel)->with('success', 'Catégorie de chambre mise à jour.');
    }

    public function destroy(Hotel $hotel, RoomCategory $chambre)
    {
        $this->autoriser($hotel);
        abort_unless($chambre->hotel_id === $hotel->id, 404);

        $chambre->delete();

        return redirect()->route('hotelier.rooms.index', $hotel)->with('success', 'Catégorie de chambre supprimée.');
    }

    protected function validerDonnees(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:100',
            'capacite_adultes' => 'required|integer|min:1|max:20',
            'capacite_enfants' => 'required|integer|min:0|max:20',
            'prix_nuit' => 'required|numeric|min:0',
            'quantite_disponible' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);
    }

    protected function autoriser(Hotel $hotel): void
    {
        abort_unless($hotel->hotelier_id === Auth::id(), 403);
    }
}

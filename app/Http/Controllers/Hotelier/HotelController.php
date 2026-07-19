<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Auth::user()->hotels()->latest()->get();

        return view('hotelier.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotelier.hotels.create');
    }

    public function store(Request $request)
    {
        $data = $this->validerDonnees($request);

        if ($request->hasFile('image_couverture')) {
            $data['image_couverture'] = $request->file('image_couverture')->store('hotels', 'public');
        }
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('hotels/logos', 'public');
        }

        $data['hotelier_id'] = Auth::id();
        $data['statut'] = 'en_attente'; // toute création est soumise à validation admin

        Hotel::create($data);

        return redirect()->route('hotelier.hotels.index')
            ->with('success', "Hôtel enregistré. Il sera visible après validation par l'administrateur.");
    }

    public function edit(Hotel $hotel)
    {
        $this->autoriser($hotel);

        return view('hotelier.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $this->autoriser($hotel);

        $data = $this->validerDonnees($request);

        if ($request->hasFile('image_couverture')) {
            if ($hotel->image_couverture) {
                Storage::disk('public')->delete($hotel->image_couverture);
            }
            $data['image_couverture'] = $request->file('image_couverture')->store('hotels', 'public');
        }
        if ($request->hasFile('logo')) {
            if ($hotel->logo) {
                Storage::disk('public')->delete($hotel->logo);
            }
            $data['logo'] = $request->file('logo')->store('hotels/logos', 'public');
        }

        // toute modification renvoie l'hôtel en attente de validation admin
        $data['statut'] = 'en_attente';

        $hotel->update($data);

        return redirect()->route('hotelier.hotels.index')
            ->with('success', "Hôtel mis à jour. Il sera de nouveau visible après validation par l'administrateur.");
    }

    public function destroy(Hotel $hotel)
    {
        $this->autoriser($hotel);

        if ($hotel->image_couverture) {
            Storage::disk('public')->delete($hotel->image_couverture);
        }
        if ($hotel->logo) {
            Storage::disk('public')->delete($hotel->logo);
        }

        $hotel->delete();

        return redirect()->route('hotelier.hotels.index')->with('success', 'Hôtel supprimé.');
    }

    protected function validerDonnees(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:150',
            'nombre_etoiles' => 'required|integer|min:1|max:5',
            'ville' => 'required|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'adresse' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_couverture' => 'nullable|image|max:4096',
            'logo' => 'nullable|image|max:2048',
        ]);
    }

    protected function autoriser(Hotel $hotel): void
    {
        abort_unless($hotel->hotelier_id === Auth::id(), 403);
    }
}

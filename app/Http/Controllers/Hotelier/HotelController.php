<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = auth()->user()->hotels()
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->latest()
            ->get();

        return view('hotelier.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('hotelier.hotels.form', ['hotel' => new Hotel()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image_couverture'] = $request->file('image_couverture')->store('hotels', 'public');
        $data['hotelier_id'] = auth()->id();
        $data['statut'] = 'en_attente'; // doit être validé par l'admin

        $hotel = Hotel::create($data);

        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            \Illuminate\Support\Facades\Mail::to($admin->email)->send(new \App\Mail\NouvelHotelMail($hotel));
        }

        return redirect()->route('hotelier.hotels.edit', $hotel)
            ->with('success', 'Hôtel créé, en attente de validation par un administrateur.');
    }

    public function edit(Hotel $hotel)
    {
        $this->authorizeProprietaire($hotel);
        return view('hotelier.hotels.form', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $this->authorizeProprietaire($hotel);
        $data = $this->validated($request, false);

        if ($request->hasFile('image_couverture')) {
            $data['image_couverture'] = $request->file('image_couverture')->store('hotels', 'public');
        }

        $hotel->update($data);

        return back()->with('success', 'Hôtel mis à jour.');
    }

    public function destroy(Hotel $hotel)
    {
        $this->authorizeProprietaire($hotel);
        $hotel->delete();
        return redirect()->route('hotelier.hotels.index')->with('success', 'Hôtel supprimé.');
    }

    private function authorizeProprietaire(Hotel $hotel): void
    {
        abort_unless($hotel->hotelier_id === auth()->id(), 403);
    }

    private function validated(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'nombre_etoiles' => ['required', 'integer', 'min:1', 'max:5'],
            'ville' => ['required', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
            'image_couverture' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:4096'],
        ]);
    }
}

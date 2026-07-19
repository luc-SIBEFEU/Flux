<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotelGalleryController extends Controller
{
    public function index(Hotel $hotel)
    {
        abort_unless($hotel->hotelier_id === Auth::id(), 403);

        return view('hotelier.hotel-gallery', [
            'hotel' => $hotel,
            'images' => $hotel->galeries,
        ]);
    }

    public function store(Request $request, Hotel $hotel)
    {
        abort_unless($hotel->hotelier_id === Auth::id(), 403);

        $request->validate(['images.*' => 'image|max:4096']);

        foreach ($request->file('images', []) as $image) {
            HotelGallery::create([
                'hotel_id' => $hotel->id,
                'image' => $image->store('hotels/galerie', 'public'),
            ]);
        }

        return back()->with('success', 'Images ajoutées à la galerie.');
    }

    public function destroy(Hotel $hotel, HotelGallery $image)
    {
        abort_unless($hotel->hotelier_id === Auth::id(), 403);
        abort_unless($image->hotel_id === $hotel->id, 404);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image supprimée.');
    }
}

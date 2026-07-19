<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\RoomCategory;
use App\Models\RoomGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomGalleryController extends Controller
{
    public function index(RoomCategory $chambre)
    {
        abort_unless($chambre->hotel->hotelier_id === Auth::id(), 403);

        return view('hotelier.room-gallery', [
            'chambre' => $chambre,
            'images' => $chambre->galeries,
        ]);
    }

    public function store(Request $request, RoomCategory $chambre)
    {
        abort_unless($chambre->hotel->hotelier_id === Auth::id(), 403);

        $request->validate(['images.*' => 'image|max:4096']);

        foreach ($request->file('images', []) as $image) {
            RoomGallery::create([
                'room_category_id' => $chambre->id,
                'image' => $image->store('chambres/galerie', 'public'),
            ]);
        }

        return back()->with('success', 'Images ajoutées à la galerie.');
    }

    public function destroy(RoomCategory $chambre, RoomGallery $image)
    {
        abort_unless($chambre->hotel->hotelier_id === Auth::id(), 403);
        abort_unless($image->room_category_id === $chambre->id, 404);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image supprimée.');
    }
}

<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;
use App\Models\MessageContact;

class MessageContactController extends Controller
{
    public function index()
    {
        $messages = MessageContact::where('destinataire_id', auth()->id())
            ->with('client', 'contactable')
            ->latest()
            ->paginate(15);

        // Consultés = marqués lus, comme une boîte de réception classique.
        MessageContact::where('destinataire_id', auth()->id())->where('lu', false)->update(['lu' => true]);

        return view('hotelier.messages.index', compact('messages'));
    }
}

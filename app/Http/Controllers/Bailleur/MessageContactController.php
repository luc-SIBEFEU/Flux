<?php

namespace App\Http\Controllers\Bailleur;

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

        MessageContact::where('destinataire_id', auth()->id())->where('lu', false)->update(['lu' => true]);

        return view('bailleur.messages.index', compact('messages'));
    }
}

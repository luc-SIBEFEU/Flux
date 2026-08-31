<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    /**
     * Liste des messages de contact (avec filtres).
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Filtre par statut
        if ($request->has('statut')) {
            match ($request->statut) {
                'non-lu' => $query->nonLus(),
                'sans-reponse' => $query->sansReponse(),
                'repondu' => $query->whereNotNull('reponse'),
                default => null,
            };
        }

        // Filtre par type de demande
        if ($request->filled('type_demande')) {
            $query->where('type_demande', $request->type_demande);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('sujet', 'like', "%{$search}%");
            });
        }

        $contacts = $query->latest()->paginate(20);

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Afficher un contact avec formulaire de réponse.
     */
    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Marquer un contact comme lu.
     */
    public function markAsRead(Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update(['lu' => true]);

        return back();
    }

    /**
     * Supprimer un contact.
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact supprimé avec succès.');
    }
}

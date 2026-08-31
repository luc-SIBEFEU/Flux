<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Mail\ReplyContactFormMail;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Stocker un nouveau message de contact depuis le formulaire public.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type_demande' => 'required|in:support,reservations,paiement,partenariat,autre',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
            'piece_jointe' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:5120',
            'consentement' => 'required|accepted',
        ]);

        // Traiter la pièce jointe si présente
        if ($request->hasFile('piece_jointe')) {
            $file = $request->file('piece_jointe');
            $path = $file->store('contacts', 'public');
            $validated['piece_jointe'] = $path;
        }

        // Créer le contact
        $contact = Contact::create($validated);

        // Récupérer les admins pour envoyer les notifications
        $admins = User::where('role', 'admin')->get();

        // Envoyer mail et notification à tous les admins
        foreach ($admins as $admin) {
            // Notification dashboard
            $admin->notify(new ContactMessageNotification($contact));

            // Mail
            Mail::to($admin->email)->send(new ContactFormMail($contact));
        }

        return back()->with('success', 'Votre message a été envoyé avec succès. Notre équipe vous contactera dans les plus brefs délais.');
    }

    /**
     * Répondre à un message de contact (admin).
     */
    public function reply(Request $request, Contact $contact)
    {
        $this->authorize('reply', $contact);

        $validated = $request->validate([
            'reponse' => 'required|string|min:10|max:5000',
        ]);

        // Mettre à jour le contact avec la réponse
        $contact->update([
            'reponse' => $validated['reponse'],
            'reponse_date' => now(),
            'repondu_par' => auth()->id(),
        ]);

        // Envoyer le mail de réponse à l'auteur
        Mail::to($contact->email)->send(new ReplyContactFormMail($contact));

        return back()->with('success', 'Réponse envoyée avec succès.');
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

        return back()->with('success', 'Contact supprimé.');
    }
}

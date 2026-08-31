# Nouveau message de contact — Flux

Bonjour,

Un nouveau message a été reçu via le formulaire de contact.

**Informations du contact :**

| Champ | Valeur |
| --- | --- |
| **Nom** | {{ $contact->nom }} |
| **Email** | {{ $contact->email }} |
| **Type de demande** | {{ $contact->type_demande }} |
| **Sujet** | {{ $contact->sujet }} |
| **Date** | {{ $contact->created_at->format('d/m/Y à H:i') }} |

**Message :**

{{ $contact->message }}

@component('mail::button', ['url' => route('admin.contacts.show', $contact)])
Voir le détail du message
@endcomponent

---

*Cet email a été généré automatiquement. Veuillez ne pas y répondre directement.*

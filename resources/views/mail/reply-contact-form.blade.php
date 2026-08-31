# {{ __('mail.reponse_contact_titre') }}

{{ __('mail.bonjour', ['nom' => $contact->nom]) }},

{{ __('mail.voici_reponse') }}

---

{{ $contact->reponse }}

---

**{{ __('mail.infos_message_initial') }} :**

| {{ __('mail.champ') }} | {{ __('mail.valeur') }} |
| --- | --- |
| **{{ __('contact.sujet') }}** | {{ $contact->sujet }} |
| **{{ __('contact.type_demande') }}** | {{ $contact->type_demande }} |
| **{{ __('mail.recu_le') }}** | {{ $contact->created_at->format('d/m/Y à H:i') }} |
| **{{ __('mail.repondu_le') }}** | {{ $contact->reponse_date->format('d/m/Y à H:i') }} |

{{ __('mail.autres_questions') }}

---

*{{ __('mail.merci_confiance_flux') }}*

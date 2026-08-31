# {{ __('mail.nouveau_message_contact_titre') }} — Flux

{{ __('mail.bonjour_simple') }},

{{ __('mail.nouveau_message_recu') }}

**{{ __('mail.infos_contact') }} :**

| {{ __('mail.champ') }} | {{ __('mail.valeur') }} |
| --- | --- |
| **{{ __('common.nom') }}** | {{ $contact->nom }} |
| **{{ __('auth.email') }}** | {{ $contact->email }} |
| **{{ __('contact.type_demande') }}** | {{ $contact->type_demande }} |
| **{{ __('contact.sujet') }}** | {{ $contact->sujet }} |
| **{{ __('common.date') }}** | {{ $contact->created_at->format('d/m/Y à H:i') }} |

**{{ __('contact.message') }} :**

{{ $contact->message }}

@component('mail::button', ['url' => route('admin.contacts.show', $contact)])
{{ __('mail.voir_detail_message') }}
@endcomponent

---

*{{ __('mail.email_auto_genere') }}*

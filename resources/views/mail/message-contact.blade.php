@component('mail::message')
# {{ __('mail.nouveau_message_client_titre') }}

{{ __('mail.souhaite_contact', ['client' => $messageContact->client->nom, 'objet' => $messageContact->contactable->nom]) }}

@component('mail::panel')
**{{ __('common.telephone') }} :** {{ $messageContact->telephone_client }}<br>
**{{ __('contact.message') }} :**<br>
{{ $messageContact->message }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# Nouveau message d'un client

**{{ $messageContact->client->nom }}** souhaite être contacté au sujet de « {{ $messageContact->contactable->nom }} ».

@component('mail::panel')
**Téléphone :** {{ $messageContact->telephone_client }}<br>
**Message :**<br>
{{ $messageContact->message }}
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent

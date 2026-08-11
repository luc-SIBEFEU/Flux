@component('mail::message')
# Votre inscription n'a pas été retenue

Bonjour {{ $user->nom }},

Après examen, votre inscription en tant que **{{ $user->role }}** sur Flux n'a pas pu être validée.

@if($user->motif_rejet_compte)
@component('mail::panel')
{{ $user->motif_rejet_compte }}
@endcomponent
@endif

Vous pouvez soumettre une nouvelle inscription en corrigeant les informations concernées.

@component('mail::button', ['url' => route('register', ['type' => $user->role])])
Nouvelle inscription
@endcomponent

Merci,<br>
L'équipe {{ config('app.name') }}
@endcomponent

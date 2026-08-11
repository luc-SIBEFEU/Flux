@component('mail::message')
# Nouvelle inscription à valider

Un nouveau compte **{{ $user->role }}** vient d'être créé et attend votre validation.

@component('mail::panel')
**Nom :** {{ $user->nom }}<br>
**E-mail :** {{ $user->email }}<br>
**Téléphone :** {{ $user->telephone ?? '—' }}<br>
**Rôle :** {{ ucfirst($user->role) }}
@endcomponent

@component('mail::button', ['url' => route('admin.users.index', ['role' => $user->role])])
Examiner les inscriptions
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent

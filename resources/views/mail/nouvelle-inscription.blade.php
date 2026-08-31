@component('mail::message')
# {{ __('mail.nouvelle_inscription_titre') }}

{{ __('mail.nouveau_compte_corps', ['role' => $user->role]) }}

@component('mail::panel')
**{{ __('common.nom') }} :** {{ $user->nom }}<br>
**{{ __('auth.email') }} :** {{ $user->email }}<br>
**{{ __('common.telephone') }} :** {{ $user->telephone ?? '—' }}<br>
**{{ __('mail.role') }} :** {{ ucfirst($user->role) }}
@endcomponent

@component('mail::button', ['url' => route('admin.users.index', ['role' => $user->role])])
{{ __('mail.examiner_inscriptions') }}
@endcomponent

{{ __('mail.merci') }},<br>
{{ config('app.name') }}
@endcomponent

@extends('layouts.dashboard')
@php $espaceRole = 'hotelier'; @endphp
@section('titre_page', __('sidebar.messages'))
@section('titre', __('sidebar.messages') . ' — ' . __('sidebar.espace_hotelier'))

@section('contenu')

<p class="text-sm text-flux-noir/60 mb-6">
    {!! __('messages_page.intro_hotelier', ['lien' => '<a href="' . route('forfait.index') . '" class="text-flux-bleu underline">' . __('messages_page.forfait_pro') . '</a>']) !!}
</p>

<div class="space-y-4">
    @forelse ($messages as $message)
        <div class="bg-white border border-black/10 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="font-medium">{{ $message->client->nom }}</span>
                    <span class="text-flux-noir/40 text-sm"> — {{ $message->contactable->nom }}</span>
                </div>
                <span class="text-xs text-flux-noir/40">{{ $message->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-sm text-flux-noir/60 mb-2">{{ $message->message }}</p>
            <a href="tel:{{ $message->telephone_client }}" class="inline-flex items-center gap-1.5 text-sm text-flux-bleu font-medium">
                <x-icon name="phone" class="w-4 h-4" /> {{ $message->telephone_client }}
            </a>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="mail" class="w-10 h-10 mx-auto mb-3" />
            {{ __('messages_page.aucun_message') }}
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $messages->links() }}</div>
@endsection

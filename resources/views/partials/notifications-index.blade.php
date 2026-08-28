@extends('layouts.dashboard', ['espaceRole' => auth()->user()->role, 'espaceLabel' => ''])

@section('titre', 'Notifications — Flux')
@section('titre_page', 'Notifications')

@section('contenu')
    <div class="bg-white rounded-2xl border border-black/5 divide-y divide-black/5">
        @forelse ($notifications as $notification)
            <form method="POST" action="{{ route('notifications.lue', $notification->id) }}">
                @csrf
                <button type="submit" class="w-full text-left px-5 py-4 hover:bg-flux-brume flex gap-3 {{ $notification->read_at ? 'opacity-60' : '' }}">
                    <x-icon name="{{ $notification->data['icone'] ?? 'bell' }}" class="w-5 h-5 shrink-0 mt-0.5 text-flux-bleu" />
                    <span>
                        <span class="block text-sm font-medium text-flux-noir">{{ $notification->data['titre'] ?? '' }}</span>
                        <span class="block text-sm text-flux-noir/60 mt-0.5">{{ $notification->data['message'] ?? '' }}</span>
                        <span class="block text-xs text-flux-noir/40 mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                    </span>
                </button>
            </form>
        @empty
            <p class="px-5 py-10 text-sm text-flux-noir/40 text-center">Aucune notification pour le moment.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $notifications->links() }}</div>
@endsection

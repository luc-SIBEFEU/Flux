@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', __('sidebar.comptes_a_valider'))
@section('titre', __('sidebar.comptes_a_valider') . ' — ' . __('sidebar.espace_admin'))

@section('contenu')

<p class="text-sm text-flux-noir/50 mb-6">{{ trans_choice('admin_valid.comptes_en_attente_compte', $users->total(), ['n' => $users->total()]) }}</p>

<div class="space-y-4">
    @forelse($users as $user)
        <div class="bg-white border border-black/10 rounded-2xl p-5" x-data="{ rejet: false }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-flux-or/20 text-flux-or capitalize">{{ $user->role }}</span>
                    <h3 class="font-medium mt-2">{{ $user->nom }}</h3>
                    <p class="text-sm text-flux-noir/50">{{ $user->email }} · {{ $user->telephone ?? '—' }}</p>
                </div>
                <div class="flex gap-3 shrink-0">
                    <form action="{{ route('admin.users.valider', $user) }}" method="POST">
                        @csrf
                        <button class="inline-flex items-center gap-1.5 bg-flux-bleu text-white text-sm font-medium px-4 py-2 rounded-lg">
                            <x-icon name="check-circle" class="w-4 h-4" /> {{ __('demande.valider') }}
                        </button>
                    </form>
                    <button @click="rejet = !rejet" class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-sm font-medium px-4 py-2 rounded-lg">
                        <x-icon name="x-circle" class="w-4 h-4" /> {{ __('demande.rejeter') }}
                    </button>
                </div>
            </div>
            <form x-show="rejet" x-cloak action="{{ route('admin.users.rejeter', $user) }}" method="POST" class="mt-3 flex gap-2">
                @csrf
                <input type="text" name="motif_rejet_compte" required placeholder="{{ __('admin_valid.motif_rejet') }}" class="flex-1 border border-black/10 rounded-lg px-3 py-2 text-sm">
                <button class="bg-red-500 text-white text-sm font-medium px-4 py-2 rounded-lg">{{ __('admin_valid.confirmer') }}</button>
            </form>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="check-circle" class="w-10 h-10 mx-auto mb-3" />
            {{ __('admin_valid.aucun_compte_attente') }}
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $users->links() }}</div>
@endsection

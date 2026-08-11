@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', 'Comptes en attente')
@section('titre', 'Comptes en attente — Admin')

@section('contenu')

<p class="text-sm text-flux-noir/50 mb-6">{{ $users->total() }} compte(s) hôtelier/bailleur en attente de validation</p>

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
                            <x-icon name="check-circle" class="w-4 h-4" /> Valider
                        </button>
                    </form>
                    <button @click="rejet = !rejet" class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-sm font-medium px-4 py-2 rounded-lg">
                        <x-icon name="x-circle" class="w-4 h-4" /> Rejeter
                    </button>
                </div>
            </div>
            <form x-show="rejet" x-cloak action="{{ route('admin.users.rejeter', $user) }}" method="POST" class="mt-3 flex gap-2">
                @csrf
                <input type="text" name="motif_rejet_compte" required placeholder="Motif du rejet" class="flex-1 border border-black/10 rounded-lg px-3 py-2 text-sm">
                <button class="bg-red-500 text-white text-sm font-medium px-4 py-2 rounded-lg">Confirmer</button>
            </form>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="check-circle" class="w-10 h-10 mx-auto mb-3" />
            Aucun compte en attente. Tout est à jour !
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $users->links() }}</div>
@endsection

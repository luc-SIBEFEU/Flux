@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', 'Logements à valider')
@section('titre', 'Validation des logements — Admin')

@section('contenu')

<p class="text-sm text-flux-noir/50 mb-6">{{ $logements->total() }} logement(s) en attente de validation</p>

<div class="space-y-4">
    @forelse($logements as $logement)
        <div class="bg-white border border-black/10 rounded-2xl p-5 flex flex-col sm:flex-row gap-4" x-data="{ rejet: false }">
            @if($logement->photos->first())
                <img src="{{ asset('storage/'.$logement->photos->first()->chemin) }}" class="w-full sm:w-40 h-28 rounded-xl object-cover shrink-0">
            @else
                <div class="w-full sm:w-40 h-28 rounded-xl bg-flux-violet-pale flex items-center justify-center shrink-0">
                    <x-icon name="building" class="w-8 h-8 text-flux-violet/40" />
                </div>
            @endif
            <div class="flex-1">
                <span class="text-xs font-semibold bg-flux-violet-pale text-flux-violet px-2.5 py-1 rounded-full capitalize">{{ $logement->type }} · {{ $logement->categorie === 'meuble' ? 'Meublé' : 'Standard' }}</span>
                <h3 class="font-medium mt-2">{{ $logement->quartier }}, {{ $logement->ville }}</h3>
                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="user" class="w-3.5 h-3.5" /> {{ $logement->bailleur->nom }} — {{ $logement->bailleur->email }}</p>
                <p class="font-display text-lg text-flux-violet mt-1">{{ number_format($logement->prix_mois,0,',',' ') }} F<span class="text-xs font-sans text-flux-noir/40">/mois</span></p>

                <div class="flex flex-wrap gap-3 mt-4">
                    <form action="{{ route('admin.logements.approuver', $logement) }}" method="POST">
                        @csrf
                        <button class="inline-flex items-center gap-1.5 bg-flux-violet text-white text-sm font-medium px-4 py-2 rounded-lg">
                            <x-icon name="check-circle" class="w-4 h-4" /> Approuver
                        </button>
                    </form>
                    <button @click="rejet = !rejet" class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-sm font-medium px-4 py-2 rounded-lg">
                        <x-icon name="x-circle" class="w-4 h-4" /> Rejeter
                    </button>
                </div>

                <form x-show="rejet" x-cloak action="{{ route('admin.logements.rejeter', $logement) }}" method="POST" class="mt-3 flex gap-2">
                    @csrf
                    <input type="text" name="motif_rejet" required placeholder="Motif du rejet" class="flex-1 border border-black/10 rounded-lg px-3 py-2 text-sm">
                    <button class="bg-red-500 text-white text-sm font-medium px-4 py-2 rounded-lg">Confirmer</button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="check-circle" class="w-10 h-10 mx-auto mb-3" />
            Aucun logement en attente. Tout est à jour !
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $logements->links() }}</div>
@endsection

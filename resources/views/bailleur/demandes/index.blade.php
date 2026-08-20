@extends('layouts.dashboard')
@php $espaceRole = 'bailleur'; @endphp
@section('titre_page', 'Demandes de baye')
@section('titre', 'Demandes — Bailleur')

@section('contenu')

<div class="flex gap-2 mb-6 overflow-x-auto carte-scroll">
    @foreach(['' => 'Toutes', 'nouveau'=>'Nouvelles', 'validee'=>'Validées', 'rejetee'=>'Rejetées'] as $val=>$label)
        <a href="{{ route('bailleur.demandes.index', array_filter(['statut'=>$val])) }}"
           class="shrink-0 px-4 py-2 rounded-full text-sm font-medium border
                  {{ request('statut', '') === $val ? 'bg-flux-violet text-white border-flux-violet' : 'bg-white text-flux-noir/60 border-black/10' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="space-y-4">
    @forelse($demandes as $demande)
        <div class="bg-white border border-black/10 rounded-2xl p-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="font-medium">{{ $demande->client->nom }}</h3>
                    <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="phone" class="w-3.5 h-3.5" /> {{ $demande->telephone_client }}</p>
                    <p class="text-sm text-flux-noir/50 mt-1 capitalize">{{ $demande->logement->type }} — {{ $demande->logement->quartier }}, {{ $demande->logement->ville }}</p>
                    @if($demande->message)
                        <p class="text-sm text-flux-noir/60 mt-2 italic">"{{ $demande->message }}"</p>
                    @endif
                </div>

                @if($demande->statut === 'nouveau')
                    <div class="flex gap-3 shrink-0">
                        <form action="{{ route('bailleur.demandes.valider', $demande) }}" method="POST">
                            @csrf
                            <button class="inline-flex items-center gap-1.5 bg-flux-violet text-white text-sm font-medium px-4 py-2 rounded-lg">
                                <x-icon name="check-circle" class="w-4 h-4" /> Valider
                            </button>
                        </form>
                        <form action="{{ route('bailleur.demandes.rejeter', $demande) }}" method="POST">
                            @csrf
                            <button class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-sm font-medium px-4 py-2 rounded-lg">
                                <x-icon name="x-circle" class="w-4 h-4" /> Rejeter
                            </button>
                        </form>
                    </div>
                @else
                    @php $badges = ['validee'=>'bg-flux-violet-pale text-flux-violet','rejetee'=>'bg-red-50 text-red-500']; @endphp
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium shrink-0 {{ $badges[$demande->statut] }}">{{ ucfirst($demande->statut) }}</span>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="bell" class="w-10 h-10 mx-auto mb-3" />
            Aucune demande pour le moment.
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $demandes->links() }}</div>
@endsection

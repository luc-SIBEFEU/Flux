@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', __('sidebar.logements_a_valider'))
@section('titre', __('admin_valid.validation_logements') . ' — ' . __('sidebar.espace_admin'))

@section('contenu')

<p class="text-sm text-flux-noir/50 mb-6">{{ trans_choice('admin_valid.logements_en_attente_compte', $logements->total(), ['n' => $logements->total()]) }}</p>

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
                <span class="text-xs font-semibold bg-flux-violet-pale text-flux-violet px-2.5 py-1 rounded-full">{{ __('logement.type_' . $logement->type) }} · {{ $logement->categorie === 'meuble' ? __('logement.meuble') : __('logement.standard') }}</span>
                <h3 class="font-medium mt-2">{{ $logement->quartier }}, {{ $logement->ville }}</h3>
                <p class="text-sm text-flux-noir/50 flex items-center gap-1 mt-1"><x-icon name="user" class="w-3.5 h-3.5" /> {{ $logement->bailleur->nom }} — {{ $logement->bailleur->email }}</p>
                <p class="font-display text-lg text-flux-violet mt-1">{{ number_format($logement->prix_mois,0,',',' ') }} F<span class="text-xs font-sans text-flux-noir/40">{{ __('logement.par_mois') }}</span></p>

                <div class="flex flex-wrap gap-3 mt-4">
                    <form action="{{ route('admin.logements.approuver', $logement) }}" method="POST">
                        @csrf
                        <button class="inline-flex items-center gap-1.5 bg-flux-violet text-white text-sm font-medium px-4 py-2 rounded-lg">
                            <x-icon name="check-circle" class="w-4 h-4" /> {{ __('admin_valid.approuver') }}
                        </button>
                    </form>
                    <button @click="rejet = !rejet" class="inline-flex items-center gap-1.5 bg-red-50 text-red-600 text-sm font-medium px-4 py-2 rounded-lg">
                        <x-icon name="x-circle" class="w-4 h-4" /> {{ __('demande.rejeter') }}
                    </button>
                </div>

                <form x-show="rejet" x-cloak action="{{ route('admin.logements.rejeter', $logement) }}" method="POST" class="mt-3 flex gap-2">
                    @csrf
                    <input type="text" name="motif_rejet" required placeholder="{{ __('admin_valid.motif_rejet') }}" class="flex-1 border border-black/10 rounded-lg px-3 py-2 text-sm">
                    <button class="bg-red-500 text-white text-sm font-medium px-4 py-2 rounded-lg">{{ __('admin_valid.confirmer') }}</button>
                </form>
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="check-circle" class="w-10 h-10 mx-auto mb-3" />
            {{ __('admin_valid.aucun_logement_attente') }}
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $logements->links() }}</div>
@endsection

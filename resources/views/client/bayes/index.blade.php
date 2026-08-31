@extends('layouts.dashboard')
@php $espaceRole = 'client'; @endphp
@section('titre_page', __('sidebar.mes_locations'))
@section('titre', __('baye.titre_mes_locations'))

@section('contenu')

<div class="flex gap-2 mb-6 overflow-x-auto carte-scroll">
    @foreach(['' => __('common.tout'), 'nouveau'=>__('baye.statut_nouveau'), 'en_cours'=>__('baye.statut_en_cours'), 'termine'=>__('baye.statut_termine')] as $val=>$label)
        <a href="{{ route('client.bayes.index', array_filter(['statut'=>$val])) }}"
           class="shrink-0 px-4 py-2 rounded-full text-sm font-medium border
                  {{ request('statut', '') === $val ? 'bg-flux-violet text-white border-flux-violet' : 'bg-white text-flux-noir/60 border-black/10' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="space-y-4">
    @forelse($bayes as $baye)
        <a href="{{ route('client.bayes.show', $baye) }}" class="block bg-white border border-black/10 rounded-2xl p-5 hover:border-flux-violet transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="font-medium capitalize">{{ $baye->logement->type }} — {{ $baye->logement->quartier }}, {{ $baye->logement->ville }}</h3>
                    <p class="text-sm text-flux-noir/50 mt-1">{{ $baye->date_debut->format('d/m/Y') }} · {{ trans_choice('baye.mois_compte', $baye->duree_mois, ['n' => $baye->duree_mois]) }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @php $badges = ['nouveau'=>'bg-flux-or/20 text-flux-or','en_cours'=>'bg-flux-violet-pale text-flux-violet','termine'=>'bg-black/5 text-flux-noir/50']; @endphp
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$baye->statut] }}">{{ __('baye.badge_statut_' . $baye->statut) }}</span>
                    @php $paiementBadges = ['a_jour'=>'bg-flux-bleu-pale text-flux-bleu','en_retard'=>'bg-red-50 text-red-500','solde'=>'bg-black/5 text-flux-noir/50']; @endphp
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $paiementBadges[$baye->etat_paiement] }}">{{ __('baye.etat_paiement_' . $baye->etat_paiement) }}</span>
                </div>
            </div>
        </a>
    @empty
        <div class="text-center py-16 text-flux-noir/40">
            <x-icon name="key" class="w-10 h-10 mx-auto mb-3" />
            {{ __('baye.aucune_location') }}
        </div>
    @endforelse
</div>

<div class="mt-8">{{ $bayes->links() }}</div>
@endsection

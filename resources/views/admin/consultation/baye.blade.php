@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', __('consultation.detail_bail'))
@section('titre', __('consultation.bail_singulier') . ' — ' . __('consultation.consultation_admin'))

@section('contenu')

<a href="{{ route('admin.consultation.bayes') }}" class="text-sm text-flux-noir/50 hover:text-flux-violet">← {{ __('consultation.retour_aux_baux') }}</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h2 class="font-display text-2xl">{{ __('logement.type_' . $baye->logement->type) }} — {{ $baye->logement->quartier }}</h2>
            <p class="text-sm text-flux-noir/50 mt-1">{{ $baye->date_debut->format('d/m/Y') }} → {{ $baye->date_fin_prevue->format('d/m/Y') }} ({{ trans_choice('baye.mois_compte', $baye->duree_mois, ['n' => $baye->duree_mois]) }})</p>
            @if($baye->date_fin_moratoire)
                <p class="text-xs text-flux-noir/40 mt-1">{{ __('consultation.fin_moratoire') }} : {{ $baye->date_fin_moratoire->format('d/m/Y') }}</p>
            @endif
        </div>

        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-4">{{ __('consultation.echeancier_loyers') }}</h3>
            <div class="divide-y divide-black/5">
                @foreach($baye->loyers as $loyer)
                    <div class="flex items-center justify-between py-3 text-sm">
                        <span>{{ \Carbon\Carbon::parse($loyer->mois_concerne)->translatedFormat('F Y') }} @if($loyer->paiement_initial)<span class="text-xs text-flux-violet">({{ __('consultation.paiement_initial_court') }})</span>@endif</span>
                        <span class="font-medium">{{ number_format($loyer->montant,0,',',' ') }} F — {{ $loyer->statut === 'paye' ? __('baye.paye') : __('consultation.non_paye') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-3">{{ __('logement.locataire_singulier') }}</h3>
            <p class="text-sm">{{ $baye->client->nom }} — {{ $baye->client->email }}</p>
        </div>
        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-3">{{ __('sidebar.espace_bailleur') }}</h3>
            <p class="text-sm">{{ $baye->bailleur->nom }} — {{ $baye->bailleur->email }}</p>
        </div>
    </aside>
</div>
@endsection

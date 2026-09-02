@extends('layouts.dashboard')
@php $espaceRole = 'bailleur'; @endphp
@section('titre_page', 'Locations en cours')
@section('titre', 'Locations — Bailleur')

@section('contenu')

<div class="flex gap-2 mb-6 overflow-x-auto carte-scroll">
    @foreach(['' => 'Toutes', 'nouveau'=>'Nouveaux', 'en_cours'=>'En cours', 'termine'=>'Terminés'] as $val=>$label)
        <a href="{{ route('bailleur.bayes.index', array_filter(['statut'=>$val])) }}"
           class="shrink-0 px-4 py-2 rounded-full text-sm font-medium border
                  {{ request('statut', '') === $val ? 'bg-flux-violet text-white border-flux-violet' : 'bg-white text-flux-noir/60 border-black/10' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="bg-white border border-black/10 rounded-2xl overflow-x-auto">
    <table class="w-full text-sm min-w-[720px]">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Locataire</th>
                <th class="text-left px-5 py-3">Logement</th>
                <th class="text-left px-5 py-3">Période</th>
                <th class="text-left px-5 py-3">{{ __('common.statut') }}</th>
                <th class="text-left px-5 py-3">Paiement</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach($bayes as $baye)
                <tr>
                    <td class="px-5 py-3 font-medium">{{ $baye->client->nom }}</td>
                    <td class="px-5 py-3 capitalize">{{ $baye->logement->type }} — {{ $baye->logement->quartier }}</td>
                    <td class="px-5 py-3 whitespace-nowrap">{{ $baye->date_debut->format('d/m/y') }} · {{ trans_choice('baye.mois_compte', $baye->duree_mois, ['n' => $baye->duree_mois]) }}</td>
                    <td class="px-5 py-3">
                        @php $badges = ['nouveau'=>'bg-flux-or/20 text-flux-or','en_cours'=>'bg-flux-violet-pale text-flux-violet','termine'=>'bg-black/5 text-flux-noir/50']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$baye->statut] }}">{{ __('baye.badge_statut_' . $baye->statut) }}</span>
                    </td>
                    <td class="px-5 py-3">
                        @php $paiementBadges = ['a_jour'=>'bg-flux-bleu-pale text-flux-bleu','en_retard'=>'bg-red-50 text-red-500','solde'=>'bg-black/5 text-flux-noir/50']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $paiementBadges[$baye->etat_paiement] }}">{{ __('baye.etat_paiement_' . $baye->etat_paiement) }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $bayes->links() }}</div>
@endsection

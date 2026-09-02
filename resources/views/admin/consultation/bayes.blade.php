@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', __('sidebar.tous_les_baux'))
@section('titre', __('sidebar.tous_les_baux') . ' — ' . __('consultation.consultation_admin'))

@section('contenu')

<p class="text-xs text-flux-noir/40 mb-4 flex items-center gap-1.5"><x-icon name="cog" class="w-3.5 h-3.5" /> {{ __('consultation.lecture_seule') }}</p>

<form method="GET" class="flex gap-3 mb-6">
    <select name="statut" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">{{ __('common.tous_les_statuts') }}</option>
        <option value="nouveau" {{ request('statut')=='nouveau'?'selected':'' }}>{{ __('baye.statut_nouveau') }}</option>
        <option value="en_cours" {{ request('statut')=='en_cours'?'selected':'' }}>{{ __('baye.statut_en_cours') }}</option>
        <option value="termine" {{ request('statut')=='termine'?'selected':'' }}>{{ __('baye.statut_termine') }}</option>
    </select>
    <button class="bg-flux-violet text-white text-sm font-medium px-5 py-2.5 rounded-lg">{{ __('common.filtrer') }}</button>
</form>

<div class="bg-white border border-black/10 rounded-2xl overflow-x-auto">
    <table class="w-full text-sm min-w-[720px]">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">{{ __('logement.locataire_singulier') }}</th>
                <th class="text-left px-5 py-3">{{ __('dashboard_stats.bailleurs') }}</th>
                <th class="text-left px-5 py-3">{{ __('logement.logement_singulier') }}</th>
                <th class="text-left px-5 py-3">{{ __('common.statut') }}</th>
                <th class="text-right px-5 py-3">{{ __('consultation.detail') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach($bayes as $baye)
                <tr>
                    <td class="px-5 py-3 font-medium">{{ $baye->client->nom }}</td>
                    <td class="px-5 py-3 text-flux-noir/60">{{ $baye->bailleur->nom }}</td>
                    <td class="px-5 py-3">{{ __('logement.type_' . $baye->logement->type) }}, {{ $baye->logement->quartier }}</td>
                    <td class="px-5 py-3">
                        @php $badges = ['nouveau'=>'bg-flux-or/20 text-flux-or','en_cours'=>'bg-flux-violet-pale text-flux-violet','termine'=>'bg-black/5 text-flux-noir/50']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$baye->statut] }}">{{ __('baye.badge_statut_' . $baye->statut) }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.consultation.bayes.show', $baye) }}" class="text-flux-violet text-xs font-medium">{{ __('consultation.voir') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $bayes->links() }}</div>
@endsection

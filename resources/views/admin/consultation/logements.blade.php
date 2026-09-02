@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', __('sidebar.tous_les_logements'))
@section('titre', __('sidebar.tous_les_logements') . ' — ' . __('consultation.consultation_admin'))

@section('contenu')

<p class="text-xs text-flux-noir/40 mb-4 flex items-center gap-1.5"><x-icon name="cog" class="w-3.5 h-3.5" /> {{ __('consultation.lecture_seule_bailleur') }}</p>

<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <select name="type" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">{{ __('logement.tous_les_types') }}</option>
        @foreach(['chambre'=>__('logement.type_chambre'),'studio'=>__('logement.type_studio'),'appartement'=>__('logement.type_appartement'),'villa'=>__('logement.type_villa')] as $val=>$label)
            <option value="{{ $val }}" {{ request('type')==$val?'selected':'' }}>{{ $label }}</option>
        @endforeach
    </select>
    <select name="validation" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">{{ __('common.tous_les_statuts') }}</option>
        <option value="en_attente" {{ request('validation')=='en_attente'?'selected':'' }}>{{ __('common.statut_en_attente') }}</option>
        <option value="valide" {{ request('validation')=='valide'?'selected':'' }}>{{ __('common.statut_valides') }}</option>
        <option value="rejete" {{ request('validation')=='rejete'?'selected':'' }}>{{ __('common.statut_rejetes') }}</option>
    </select>
    <button class="bg-flux-violet text-white text-sm font-medium px-5 py-2.5 rounded-lg">{{ __('common.filtrer') }}</button>
</form>

<div class="bg-white border border-black/10 rounded-2xl overflow-x-auto">
    <table class="w-full text-sm min-w-[720px]">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">{{ __('logement.logement_singulier') }}</th>
                <th class="text-left px-5 py-3">{{ __('dashboard_stats.bailleurs') }}</th>
                <th class="text-left px-5 py-3">{{ __('common.prix') }}</th>
                <th class="text-left px-5 py-3">{{ __('consultation.disponibilite') }}</th>
                <th class="text-left px-5 py-3">{{ __('consultation.validation') }}</th>
                <th class="text-right px-5 py-3">{{ __('consultation.detail') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach($logements as $logement)
                <tr>
                    <td class="px-5 py-3 font-medium">{{ __('logement.type_' . $logement->type) }} — {{ $logement->quartier }}</td>
                    <td class="px-5 py-3 text-flux-noir/60">{{ $logement->bailleur->nom }}</td>
                    <td class="px-5 py-3">{{ number_format($logement->prix_mois,0,',',' ') }} F</td>
                    <td class="px-5 py-3">{{ $logement->statut === 'disponible' ? __('logement.disponible') : __('logement.loue') }}</td>
                    <td class="px-5 py-3">
                        @php $badges = ['en_attente'=>'bg-flux-or/20 text-flux-or','valide'=>'bg-flux-violet-pale text-flux-violet','rejete'=>'bg-red-50 text-red-500']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$logement->validation] }}">{{ __('hotel.statut_' . $logement->validation) }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.consultation.logements.show', $logement) }}" class="text-flux-violet text-xs font-medium">{{ __('consultation.voir') }}</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $logements->links() }}</div>
@endsection

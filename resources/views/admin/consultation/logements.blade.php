@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', 'Tous les logements')
@section('titre', 'Logements — Consultation admin')

@section('contenu')

<p class="text-xs text-flux-noir/40 mb-4 flex items-center gap-1.5"><x-icon name="cog" class="w-3.5 h-3.5" /> Lecture seule — l'admin consulte, seul le bailleur modifie.</p>

<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <select name="type" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Tous les types</option>
        @foreach(['chambre'=>'Chambre','studio'=>'Studio','appartement'=>'Appartement','villa'=>'Villa'] as $val=>$label)
            <option value="{{ $val }}" {{ request('type')==$val?'selected':'' }}>{{ $label }}</option>
        @endforeach
    </select>
    <select name="validation" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">Tous les statuts</option>
        <option value="en_attente" {{ request('validation')=='en_attente'?'selected':'' }}>En attente</option>
        <option value="valide" {{ request('validation')=='valide'?'selected':'' }}>Validés</option>
        <option value="rejete" {{ request('validation')=='rejete'?'selected':'' }}>Rejetés</option>
    </select>
    <button class="bg-flux-violet text-white text-sm font-medium px-5 py-2.5 rounded-lg">Filtrer</button>
</form>

<div class="bg-white border border-black/10 rounded-2xl overflow-x-auto">
    <table class="w-full text-sm min-w-[720px]">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">Logement</th>
                <th class="text-left px-5 py-3">Bailleur</th>
                <th class="text-left px-5 py-3">Prix</th>
                <th class="text-left px-5 py-3">Disponibilité</th>
                <th class="text-left px-5 py-3">Validation</th>
                <th class="text-right px-5 py-3">Détail</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @foreach($logements as $logement)
                <tr>
                    <td class="px-5 py-3 font-medium capitalize">{{ $logement->type }} — {{ $logement->quartier }}</td>
                    <td class="px-5 py-3 text-flux-noir/60">{{ $logement->bailleur->nom }}</td>
                    <td class="px-5 py-3">{{ number_format($logement->prix_mois,0,',',' ') }} F</td>
                    <td class="px-5 py-3">{{ $logement->statut === 'disponible' ? 'Disponible' : 'Loué' }}</td>
                    <td class="px-5 py-3">
                        @php $badges = ['en_attente'=>'bg-flux-or/20 text-flux-or','valide'=>'bg-flux-violet-pale text-flux-violet','rejete'=>'bg-red-50 text-red-500']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$logement->validation] }}">{{ ucfirst(str_replace('_',' ',$logement->validation)) }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.consultation.logements.show', $logement) }}" class="text-flux-violet text-xs font-medium">Voir →</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-8">{{ $logements->links() }}</div>
@endsection

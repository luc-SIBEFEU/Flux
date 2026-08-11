@extends('layouts.dashboard')
@php($espaceRole = 'bailleur')
@section('titre_page', 'Tableau de bord')
@section('titre', 'Bailleur — Flux')

@section('contenu')

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['icone'=>'building','label'=>'Logements','valeur'=>$stats['logements'],'couleur'=>'violet'],
        ['icone'=>'key','label'=>'Loués','valeur'=>$stats['logements_loues'],'couleur'=>'violet'],
        ['icone'=>'check-circle','label'=>'Baux en cours','valeur'=>$stats['bayes_en_cours'],'couleur'=>'or'],
        ['icone'=>'bell','label'=>'Nouvelles demandes','valeur'=>$stats['demandes_nouvelles'],'couleur'=>'or'],
    ] as $c)
        <div class="bg-white rounded-2xl border border-black/5 p-5">
            <span class="inline-flex w-9 h-9 rounded-lg bg-flux-{{ $c['couleur'] }}-pale items-center justify-center mb-3">
                <x-icon name="{{ $c['icone'] }}" class="w-5 h-5 text-flux-{{ $c['couleur'] }}" />
            </span>
            <p class="text-2xl font-display">{{ $c['valeur'] }}</p>
            <p class="text-xs text-flux-noir/50 mt-1">{{ $c['label'] }}</p>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-black/5 p-6">
        <h3 class="font-medium mb-1">Revenus locatifs des 6 derniers mois</h3>
        <p class="text-xs text-flux-noir/40 mb-4">Loyers payés</p>
        <canvas id="revenusChart" height="110"></canvas>
    </div>

    <div class="bg-white rounded-2xl border border-black/5 p-6">
        <h3 class="font-medium mb-1">Parc de logements</h3>
        <p class="text-xs text-flux-noir/40 mb-4">Répartition par type</p>
        <canvas id="typeChart" height="220"></canvas>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <a href="{{ route('bailleur.logements.create') }}" class="inline-flex items-center gap-2 bg-flux-violet text-white text-sm font-medium px-4 py-2.5 rounded-lg">
        <x-icon name="plus" class="w-4 h-4" /> Ajouter un logement
    </a>
    <a href="{{ route('bailleur.demandes.index') }}" class="inline-flex items-center gap-2 bg-white border border-black/10 text-sm font-medium px-4 py-2.5 rounded-lg">
        <x-icon name="bell" class="w-4 h-4 text-flux-or" /> {{ $stats['demandes_nouvelles'] }} demande(s) à traiter
    </a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('revenusChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($revenusParMois->toArray())) !!},
            datasets: [{
                label: 'Revenus (FCFA)',
                data: {!! json_encode(array_values($revenusParMois->toArray())) !!},
                borderColor: '#5B3596',
                backgroundColor: 'rgba(91,53,150,0.08)',
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#C6A24D',
                pointRadius: 4,
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('typeChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($logementsParType->toArray())) !!},
            datasets: [{
                data: {!! json_encode(array_values($logementsParType->toArray())) !!},
                backgroundColor: ['#5B3596', '#C6A24D', '#7A4FC2', '#94A3B8'],
                borderWidth: 0,
            }]
        },
        options: { plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } } }
    });
});
</script>
@endsection

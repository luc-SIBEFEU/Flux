@extends('layouts.dashboard')
@php($espaceRole = 'hotelier')
@section('titre_page', 'Tableau de bord')
@section('titre', 'Hôtelier — Flux')

@section('contenu')

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['icone'=>'building','label'=>'Mes hôtels','valeur'=>$stats['hotels'],'couleur'=>'bleu'],
        ['icone'=>'calendar','label'=>'En attente','valeur'=>$stats['reservations_en_attente'],'couleur'=>'or'],
        ['icone'=>'check-circle','label'=>'Confirmées','valeur'=>$stats['reservations_confirmees'],'couleur'=>'bleu'],
        ['icone'=>'coins','label'=>'Revenus totaux','valeur'=>number_format($stats['revenus_total'],0,',',' ').' F','couleur'=>'or'],
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
        <h3 class="font-medium mb-1">Réservations des 6 derniers mois</h3>
        <p class="text-xs text-flux-noir/40 mb-4">Toutes catégories de chambres confondues</p>
        <canvas id="reservationsChart" height="110"></canvas>
    </div>

    <div class="bg-white rounded-2xl border border-black/5 p-6">
        <h3 class="font-medium mb-1">Occupation par chambre</h3>
        <p class="text-xs text-flux-noir/40 mb-4">Réservations par catégorie</p>
        <canvas id="chambresChart" height="220"></canvas>
    </div>
</div>

<div class="mt-8">
    <a href="{{ route('hotelier.hotels.create') }}" class="inline-flex items-center gap-2 bg-flux-bleu text-white text-sm font-medium px-4 py-2.5 rounded-lg">
        <x-icon name="plus" class="w-4 h-4" /> Ajouter un hôtel
    </a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('reservationsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($reservationsParMois->toArray())) !!},
            datasets: [{
                label: 'Réservations',
                data: {!! json_encode(array_values($reservationsParMois->toArray())) !!},
                borderColor: '#1B3A6B',
                backgroundColor: 'rgba(27,58,107,0.08)',
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#C6A24D',
                pointRadius: 4,
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('chambresChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($reservationsParChambre->toArray())) !!},
            datasets: [{
                data: {!! json_encode(array_values($reservationsParChambre->toArray())) !!},
                backgroundColor: ['#1B3A6B', '#C6A24D', '#2E5AA8', '#94A3B8', '#5B3596'],
                borderWidth: 0,
            }]
        },
        options: { plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } } }
    });
});
</script>
@endsection

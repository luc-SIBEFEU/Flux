@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', 'Rapports financiers')
@section('titre', 'Rapports — Admin')

@section('contenu')

<div class="bg-white border border-black/5 rounded-2xl p-6 mb-6">
    <p class="text-xs text-flux-noir/40 uppercase tracking-wide">Revenu total (toutes plateformes)</p>
    <p class="font-display text-4xl text-flux-bleu mt-1">{{ number_format($totalGeneral, 0, ',', ' ') }} FCFA</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-black/5 p-6">
        <h3 class="font-medium mb-1">Revenus par hôtel</h3>
        <p class="text-xs text-flux-noir/40 mb-4">Top des hôtels par chiffre d'affaires</p>
        <div class="divide-y divide-black/5">
            @foreach($parHotel as $hotel)
                <div class="flex items-center justify-between py-3 text-sm">
                    <span>{{ $hotel->nom }}</span>
                    <span class="font-medium text-flux-bleu">{{ number_format($hotel->revenus ?? 0, 0, ',', ' ') }} FCFA</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-black/5 p-6">
        <h3 class="font-medium mb-1">Répartition par ville</h3>
        <p class="text-xs text-flux-noir/40 mb-4">Part des revenus</p>
        <canvas id="villeChart" height="220"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new Chart(document.getElementById('villeChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_keys($parVille->toArray())) !!},
            datasets: [{
                data: {!! json_encode(array_values($parVille->toArray())) !!},
                backgroundColor: ['#1B3A6B', '#C6A24D', '#2E5AA8', '#5B3596', '#94A3B8', '#7A4FC2'],
                borderWidth: 0,
            }]
        },
        options: { plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } } }
    });
});
</script>
@endsection

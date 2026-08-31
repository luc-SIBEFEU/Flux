@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre_page', __('sidebar.tableau_de_bord'))
@section('titre', __('sidebar.espace_admin') . ' — Flux')

@section('contenu')

<!-- Cartes stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['icone'=>'users','label'=>__('dashboard_stats.clients'),'valeur'=>$stats['clients'],'couleur'=>'bleu'],
        ['icone'=>'building','label'=>__('dashboard_stats.hoteliers'),'valeur'=>$stats['hoteliers'],'couleur'=>'bleu'],
        ['icone'=>'key','label'=>__('dashboard_stats.bailleurs'),'valeur'=>$stats['bailleurs'],'couleur'=>'violet'],
        ['icone'=>'bell','label'=>__('dashboard_stats.hotels_en_attente'),'valeur'=>$stats['hotels_en_attente'],'couleur'=>'or'],
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
    <!-- Courbe : revenus -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-black/5 p-6">
        <h3 class="font-medium mb-1">{{ __('dashboard_stats.revenus_6_mois') }}</h3>
        <p class="text-xs text-flux-noir/40 mb-4">{{ __('dashboard_stats.paiements_reussis_toutes_plateformes') }}</p>
        <canvas id="revenusChart" height="110"></canvas>
    </div>

    <!-- Camembert : reservations par statut -->
    <div class="bg-white rounded-2xl border border-black/5 p-6">
        <h3 class="font-medium mb-1">{{ __('dashboard_stats.reservations_par_statut') }}</h3>
        <p class="text-xs text-flux-noir/40 mb-4">{{ __('dashboard_stats.repartition_globale') }}</p>
        <canvas id="statutChart" height="220"></canvas>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <a href="{{ route('admin.hotels.index') }}" class="inline-flex items-center gap-2 bg-flux-bleu text-white text-sm font-medium px-4 py-2.5 rounded-lg">
        <x-icon name="check-circle" class="w-4 h-4" /> {{ trans_choice('dashboard_stats.hotels_a_valider', $stats['hotels_en_attente'], ['n' => $stats['hotels_en_attente']]) }}
    </a>
    <a href="{{ route('admin.avis.index') }}" class="inline-flex items-center gap-2 bg-white border border-black/10 text-sm font-medium px-4 py-2.5 rounded-lg">
        <x-icon name="star" class="w-4 h-4 text-flux-or" /> {{ __('dashboard_stats.moderer_avis') }}
    </a>
</div>

@push('scripts')
@endpush

<script>
document.addEventListener('DOMContentLoaded', function () {
    const revenusLabels = {!! json_encode(array_keys($revenusParMois->toArray())) !!};
    const revenusData = {!! json_encode(array_values($revenusParMois->toArray())) !!};

    new Chart(document.getElementById('revenusChart'), {
        type: 'line',
        data: {
            labels: revenusLabels,
            datasets: [{
                label: @json(__('dashboard_stats.revenus_fcfa')),
                data: revenusData,
                borderColor: '#1B3A6B',
                backgroundColor: 'rgba(27,58,107,0.08)',
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#C6A24D',
                pointRadius: 4,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const statutLabels = {!! json_encode(array_keys($reservationsParStatut->toArray())) !!};
    const statutData = {!! json_encode(array_values($reservationsParStatut->toArray())) !!};

    new Chart(document.getElementById('statutChart'), {
        type: 'pie',
        data: {
            labels: statutLabels,
            datasets: [{
                data: statutData,
                backgroundColor: ['#C6A24D', '#1B3A6B', '#5B3596', '#94A3B8'],
                borderWidth: 0,
            }]
        },
        options: { plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } } }
    });
});

</script>
<script src="{{ asset('js/admin.js') }}"></script>
@endsection

@props(['actif'])

{{-- Onglets de recherche partagés entre hotels/logements/annonces — inspiré des barres
     de recherche à onglets (type HoroHouse) : on garde le contexte de recherche visible
     même en changeant de type de contenu. --}}
<div class="flex gap-1 mb-1">
    @foreach([
        'hotels' => ['route' => 'hotels.index', 'label' => __('navigation.hotels'), 'icone' => 'building'],
        'logements' => ['route' => 'logements.index', 'label' => __('navigation.logements'), 'icone' => 'key'],
        'annonces' => ['route' => 'annonces.index', 'label' => __('navigation.annonces'), 'icone' => 'megaphone'],
    ] as $cle => $onglet)
        <a href="{{ route($onglet['route']) }}"
           class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-t-xl transition-colors
                  {{ $actif === $cle ? 'bg-white text-flux-noir' : 'bg-white/10 text-white/70 hover:bg-white/20' }}">
            <x-icon name="{{ $onglet['icone'] }}" class="w-4 h-4" />
            {{ $onglet['label'] }}
        </a>
    @endforeach
</div>

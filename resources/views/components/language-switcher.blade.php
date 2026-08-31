@php
    $currentLocale = app()->getLocale();
    $locales = [
        'en' => __('languages.en'),
        'fr' => __('languages.fr')
    ];
@endphp

<div class="relative group">
    <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-flux-noir hover:bg-flux-noir/5 transition-colors">
        <x-icon name="globe" class="w-4 h-4" />
        <span>{{ $locales[$currentLocale] ?? __('common.language') }}</span>
    </button>
    
    <div class="absolute right-0 mt-0 w-40 bg-white border border-flux-noir/10 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
        @foreach($locales as $locale => $label)
            @if($locale !== $currentLocale)
                <a href="{{ route('locale.set', $locale) }}" class="block px-4 py-3 hover:bg-flux-noir/5 first:rounded-t-lg last:rounded-b-lg transition-colors">
                    <span class="text-sm font-medium text-flux-noir">{{ $label }}</span>
                </a>
            @else
                <div class="px-4 py-3 bg-flux-bleu/10 first:rounded-t-lg">
                    <span class="text-sm font-medium text-flux-bleu">✓ {{ $label }}</span>
                </div>
            @endif
        @endforeach
    </div>
</div>

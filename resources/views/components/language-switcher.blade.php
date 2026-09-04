@php
    $currentLocale = app()->getLocale();
    $locales = [
        'en' => __('common.languages.en'),
        'fr' => __('common.languages.fr')
    ];
@endphp

<div class="relative group">
    <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-flux-noir hover:bg-flux-noir/5 transition-colors">
        <div>
            @if($locales[$currentLocale] == 'Français' || $locales[$currentLocale] == 'French')
                <img src="{{ asset('fr.svg') }}" alt="French Flag" class="w-7 h-7 border border-flux-noir/20 rounded-4xl">
            @elseif($locales[$currentLocale] == 'English' || $locales[$currentLocale] == 'Anglais')
                <img src="{{ asset('gb.png') }}" alt="English Flag" class="w-7 h-7 border border-flux-noir/20 rounded-4xl">
            @endif
        </div>
        <span>{{ $locales[$currentLocale] ?? __('common.language') }}</span>
    </button>
    
    <div class="absolute w-60 right-0 p-6 mt-0 bg-white border border-flux-noir/10 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
        <div class="flex gap-2">
            <i class="bi bi-globe w-4 h-4 text-flux-noir"></i>
            <span class="text-sm font-medium text-flux-noir">{{ __('common.language') }}</span>
        </div>
        <hr class="my-3 border-flux-noir/20">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
        @foreach($locales as $locale => $label)
            @if($locale !== $currentLocale)
                <div class="rounded-lg overflow-hidden border border-flux-noir/20">
                <a href="{{ route('locale.set', $locale) }}" class="block px-4 py-3 hover:bg-flux-noir/5 first:rounded-t-lg last:rounded-b-lg transition-colors">
                <div class="grid gril-cols-2"> 
                    <div>
                    @if($label == 'Français' || $label == 'French')
                        <img src="{{ asset('fr.svg') }}" alt="French Flag" class="w-25 h-10 object-cover border border-flux-noir/20 rounded-xl">
                    @elseif($label == 'English' || $label == 'Anglais')
                        <img src="{{ asset('en.svg') }}" alt="English Flag" class="w-25 h-10 object-cover border border-flux-noir/20 rounded-xl">
                    @endif
                    </div>
                    <div><span class="text-sm font-medium text-flux-noir">{{ $label }}</span></div>
                </div> 
                </a>
                </div>
            @else
                <div class="px-4 py-3 bg-flux-bleu/20 first:rounded-t-lg rounded-lg overflow-hidden border border-flux-noir/20">
                    @if($label == 'Français' || $label == 'French')
                        <img src="{{ asset('fr.svg') }}" alt="French Flag" class="w-25 h-10 object-cover border border-flux-noir/20 rounded-xl">
                    @elseif($label == 'English' || $label == 'Anglais')
                        <img src="{{ asset('en.svg') }}" alt="English Flag" class="w-25 h-10 object-cover border border-flux-noir/20 rounded-xl">
                    @endif
                    <span class="text-sm font-medium text-flux-bleu">{{ $label }}</span>
                </div>
            @endif
        @endforeach
        </div>
    </div>
</div>

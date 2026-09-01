@extends('layouts.dashboard')
@php $espaceRole = 'hotelier'; @endphp
@section('titre_page', $hotel->exists ? __('hotel.modifier_hotel') : __('hotel.nouvel_hotel'))
@section('titre', __('hotel.hotel_singulier') . ' — ' . __('sidebar.espace_hotelier'))

@section('contenu')

<form action="{{ $hotel->exists ? route('hotelier.hotels.update', $hotel) : route('hotelier.hotels.store') }}"
      method="POST" enctype="multipart/form-data" class="bg-white border border-black/10 rounded-2xl p-6 max-w-2xl space-y-5">
    @csrf
    @if($hotel->exists) @method('PUT') @endif

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('hotel.nom_hotel') }}</label>
        <input type="text" name="nom" required value="{{ old('nom', $hotel->nom) }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('hotel.nombre_etoiles') }}</label>
            <select name="nombre_etoiles" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none">
                @foreach([1,2,3,4,5] as $n)
                    <option value="{{ $n }}" {{ old('nombre_etoiles', $hotel->nombre_etoiles)==$n?'selected':'' }}>{{ trans_choice('hotel.etoile_compte', $n, ['n' => $n]) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('common.ville') }}</label>
            <input type="text" name="ville" required value="{{ old('ville', $hotel->ville) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('hotel.adresse_quartier') }}</label>
        <input type="text" name="adresse" value="{{ old('adresse', $hotel->adresse) }}"
               class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('hotel.lien_google_maps') }}</label>
            <input type="text" name="map" value="{{ old('latitude', $hotel->map) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('hotel.latitude_gm') }}</label>
            <input type="text" name="latitude" value="{{ old('latitude', $hotel->latitude) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
        <div>
            <label class="text-xs font-medium text-flux-noir/50">{{ __('hotel.longitude_gm') }}</label>
            <input type="text" name="longitude" value="{{ old('longitude', $hotel->longitude) }}"
                   class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('common.description') }}</label>
        <textarea name="description" rows="4" class="mt-1 w-full border border-black/10 rounded-lg px-3 py-2.5 text-sm outline-none focus:border-flux-bleu">{{ old('description', $hotel->description) }}</textarea>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('hotel.equipements') }}</label>
        <div class="flex flex-wrap gap-2 mt-2">
            @foreach($equipements as $eq)
                <label>
                    <input type="checkbox" name="equipements[]" value="{{ $eq->id }}" class="peer sr-only"
                           {{ in_array($eq->id, old('equipements', $hotel->equipements->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                    <span class="text-xs px-3 py-1.5 rounded-full border border-black/10 peer-checked:bg-flux-bleu peer-checked:text-white peer-checked:border-flux-bleu cursor-pointer">{{ $eq->nom }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <label class="text-xs font-medium text-flux-noir/50">{{ __('hotel.image_couverture') }}</label>
        @if($hotel->image_couverture)
            <img src="{{ asset('storage/'.$hotel->image_couverture) }}" class="w-32 h-20 object-cover rounded-lg mt-2 mb-2">
        @endif
        <input type="file" name="image_couverture" accept="image/*" class="mt-1 w-full text-sm">
    </div>

    @if(!$hotel->exists)
        <p class="text-xs text-flux-noir/40 flex items-center gap-1.5"><x-icon name="bell" class="w-3.5 h-3.5" /> {{ __('hotel.visible_apres_validation') }}</p>
    @endif

    <button type="submit" class="inline-flex items-center gap-2 bg-flux-bleu text-white font-semibold px-6 py-3 rounded-lg">
        {{ $hotel->exists ? __('form.enregistrer') : __('hotel.creer_hotel') }}
    </button>
</form>

@if($hotel->exists)
    <div class="max-w-2xl mt-6 space-y-6">

        @include('partials.galerie', [
            'model' => $hotel,
            'routeStore' => route('hotelier.photos.store', ['hotel', $hotel->id]),
            'routeDestroy' => 'hotelier.photos.destroy',
            'accent' => 'bleu',
        ])

        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-4">{{ __('hotel.reseaux_sociaux') }}</h3>
            <div class="space-y-2 mb-4">
                @foreach($hotel->reseauxSociaux as $rs)
                    <div class="flex items-center justify-between text-sm bg-flux-brume rounded-lg px-3 py-2">
                        <span><strong class="capitalize">{{ $rs->plateforme }}</strong> — {{ $rs->lien }}</span>
                    </div>
                @endforeach
            </div>
            <form action="{{ route('hotelier.reseaux-sociaux.store', $hotel) }}" method="POST" class="flex gap-2">
                @csrf
                <select name="plateforme" class="border border-black/10 rounded-lg px-3 py-2 text-sm">
                    <option value="facebook">Facebook</option>
                    <option value="instagram">Instagram</option>
                    <option value="tiktok">TikTok</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="x">X</option>
                    <option value="site_web">{{ __('hotel.site_web') }}</option>
                </select>
                <input type="url" name="lien" required placeholder="https://..." class="flex-1 border border-black/10 rounded-lg px-3 py-2 text-sm">
                <button class="bg-flux-bleu text-white text-sm font-medium px-4 py-2 rounded-lg">{{ __('common.ajouter') }}</button>
            </form>
        </div>

        <div class="bg-white border border-black/10 rounded-2xl p-6">
            <h3 class="font-medium mb-4">{{ __('hotel.contacts_paiement_momo') }}</h3>
            <div class="space-y-2 mb-4">
                @foreach($hotel->contactsPaiement as $contact)
                    <div class="flex items-center justify-between text-sm bg-flux-brume rounded-lg px-3 py-2">
                        <span><strong>{{ $contact->type === 'mtn_momo' ? 'MTN MoMo' : 'Orange Money' }}</strong> — {{ $contact->numero }}</span>
                        <form action="{{ route('hotelier.contacts-paiement.destroy', [$hotel, $contact]) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-500"><x-icon name="trash" class="w-4 h-4" /></button>
                        </form>
                    </div>
                @endforeach
            </div>
            <form action="{{ route('hotelier.contacts-paiement.store', $hotel) }}" method="POST" class="flex gap-2">
                @csrf
                <select name="type" class="border border-black/10 rounded-lg px-3 py-2 text-sm">
                    <option value="mtn_momo">MTN MoMo</option>
                    <option value="orange_money">Orange Money</option>
                </select>
                <input type="text" name="numero" required placeholder="{{ __('form.numero') }}" class="flex-1 border border-black/10 rounded-lg px-3 py-2 text-sm">
                <button class="bg-flux-bleu text-white text-sm font-medium px-4 py-2 rounded-lg">{{ __('common.ajouter') }}</button>
            </form>
        </div>
    </div>
@endif
@endsection

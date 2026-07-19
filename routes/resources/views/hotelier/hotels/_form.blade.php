@php $h = $hotel ?? null; @endphp

<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Nombre d'étoiles</label>
        <select name="nombre_etoiles" class="w-full mt-1 rounded-lg border-gray-300">
            @foreach([1,2,3,4,5] as $n)
                <option value="{{ $n }}" {{ old('nombre_etoiles', $h->nombre_etoiles ?? 3) == $n ? 'selected' : '' }}>{{ $n }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Ville</label>
        <input type="text" name="ville" value="{{ old('ville', $h->ville ?? '') }}" class="w-full mt-1 rounded-lg border-gray-300">
        @error('ville') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
    </div>
</div>

<div>
    <label class="text-xs font-semibold text-gray-500 uppercase">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $h->nom ?? '') }}" class="w-full mt-1 rounded-lg border-gray-300">
    @error('nom') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
</div>

<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Latitude (Google Maps)</label>
        <input type="text" name="latitude" value="{{ old('latitude', $h->latitude ?? '') }}" placeholder="ex: 4.0511" class="w-full mt-1 rounded-lg border-gray-300">
    </div>
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Longitude (Google Maps)</label>
        <input type="text" name="longitude" value="{{ old('longitude', $h->longitude ?? '') }}" placeholder="ex: 9.7679" class="w-full mt-1 rounded-lg border-gray-300">
    </div>
</div>

<div>
    <label class="text-xs font-semibold text-gray-500 uppercase">Adresse</label>
    <input type="text" name="adresse" value="{{ old('adresse', $h->adresse ?? '') }}" class="w-full mt-1 rounded-lg border-gray-300">
</div>

<div>
    <label class="text-xs font-semibold text-gray-500 uppercase">Description</label>
    <textarea name="description" rows="3" class="w-full mt-1 rounded-lg border-gray-300">{{ old('description', $h->description ?? '') }}</textarea>
</div>

<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Image de couverture</label>
        @if($h?->imageCouvertureUrl())
            <img src="{{ $h->imageCouvertureUrl() }}" class="w-full h-24 object-cover rounded-lg mb-1">
        @endif
        <input type="file" name="image_couverture" class="w-full mt-1">
        @error('image_couverture') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
    </div>
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Logo de l'hôtel</label>
        @if($h?->logoUrl())
            <img src="{{ $h->logoUrl() }}" class="w-16 h-16 object-cover rounded-full mb-1">
        @endif
        <input type="file" name="logo" class="w-full mt-1">
        @error('logo') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
    </div>
</div>

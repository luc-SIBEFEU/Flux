@php $c = $chambre ?? null; @endphp

<div>
    <label class="text-xs font-semibold text-gray-500 uppercase">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $c->nom ?? '') }}" placeholder="ex: Suite deluxe" class="w-full mt-1 rounded-lg border-gray-300">
    @error('nom') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
</div>

<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Capacité adultes</label>
        <input type="number" min="1" name="capacite_adultes" value="{{ old('capacite_adultes', $c->capacite_adultes ?? 1) }}" class="w-full mt-1 rounded-lg border-gray-300">
        @error('capacite_adultes') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
    </div>
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Capacité enfants</label>
        <input type="number" min="0" name="capacite_enfants" value="{{ old('capacite_enfants', $c->capacite_enfants ?? 0) }}" class="w-full mt-1 rounded-lg border-gray-300">
    </div>
</div>

<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Prix / nuit (FCFA)</label>
        <input type="number" min="0" step="0.01" name="prix_nuit" value="{{ old('prix_nuit', $c->prix_nuit ?? 0) }}" class="w-full mt-1 rounded-lg border-gray-300">
        @error('prix_nuit') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
    </div>
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Quantité disponible</label>
        <input type="number" min="1" name="quantite_disponible" value="{{ old('quantite_disponible', $c->quantite_disponible ?? 1) }}" class="w-full mt-1 rounded-lg border-gray-300">
    </div>
</div>

<div>
    <label class="text-xs font-semibold text-gray-500 uppercase">Description</label>
    <textarea name="description" rows="2" class="w-full mt-1 rounded-lg border-gray-300">{{ old('description', $c->description ?? '') }}</textarea>
</div>

<div>
    <label class="text-xs font-semibold text-gray-500 uppercase mb-1 block">Accessoires</label>
    @php $selectionnees = old('amenities', $c?->amenities->pluck('id')->toArray() ?? []); @endphp
    <div class="flex flex-wrap gap-2">
        @foreach($toutesAmenities as $eq)
            <label class="text-sm border rounded-full px-3 py-1 cursor-pointer {{ in_array($eq->id, $selectionnees) ? 'bg-violet-50 border-violet-600 text-violet-700' : 'border-gray-200' }}">
                <input type="checkbox" name="amenities[]" value="{{ $eq->id }}" {{ in_array($eq->id, $selectionnees) ? 'checked' : '' }} class="hidden">
                {{ $eq->nom }}
            </label>
        @endforeach
    </div>
</div>

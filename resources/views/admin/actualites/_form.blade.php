@php $a = $actualite ?? null; @endphp

<div>
    <label class="text-xs font-semibold text-gray-500 uppercase">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $a->nom ?? '') }}" class="w-full mt-1 rounded-lg border-gray-300">
    @error('nom') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
</div>
<div>
    <label class="text-xs font-semibold text-gray-500 uppercase">Description</label>
    <textarea name="description" rows="3" class="w-full mt-1 rounded-lg border-gray-300">{{ old('description', $a->description ?? '') }}</textarea>
    @error('description') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
</div>
<div class="grid grid-cols-2 gap-3">
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Date début</label>
        <input type="date" name="date_debut" value="{{ old('date_debut', $a?->date_debut?->format('Y-m-d')) }}" class="w-full mt-1 rounded-lg border-gray-300">
        @error('date_debut') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
    </div>
    <div>
        <label class="text-xs font-semibold text-gray-500 uppercase">Date fin</label>
        <input type="date" name="date_fin" value="{{ old('date_fin', $a?->date_fin?->format('Y-m-d')) }}" class="w-full mt-1 rounded-lg border-gray-300">
        @error('date_fin') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
    </div>
</div>
<div>
    <label class="text-xs font-semibold text-gray-500 uppercase">Image</label>
    @if($a?->imageUrl())
        <img src="{{ $a->imageUrl() }}" class="w-full h-32 object-cover rounded-lg mb-1">
    @endif
    <input type="file" name="image" class="w-full mt-1">
    @error('image') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
</div>

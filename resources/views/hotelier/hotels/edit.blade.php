@extends('layouts.hotelier')

@section('content')
<div class="p-6 max-w-xl">
    <a href="{{ route('hotelier.hotels.index') }}" class="text-sm text-violet-700">← Retour à mes hôtels</a>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier {{ $hotel->nom }}</h1>

    <form method="POST" action="{{ route('hotelier.hotels.update', $hotel) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
        @csrf
        @method('PUT')
        @include('hotelier.hotels._form')
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-violet-700 text-white rounded-lg font-semibold">Enregistrer</button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-xl">
    <a href="{{ route('admin.actualites.index') }}" class="text-sm text-violet-700">← Retour aux actualités</a>
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Modifier l'actualité</h1>

    <form method="POST" action="{{ route('admin.actualites.update', $actualite) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
        @csrf
        @method('PUT')
        @include('admin.actualites._form')
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-violet-700 text-white rounded-lg font-semibold">Enregistrer</button>
        </div>
    </form>
</div>
@endsection

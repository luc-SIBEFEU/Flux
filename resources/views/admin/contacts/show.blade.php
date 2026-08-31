@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre', 'Message de contact - ' . $contact->sujet)

@section('contenu')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- En-tête -->
    <div class="mb-8 flex items-start justify-between">
        <div>
            <a href="{{ route('admin.contacts.index') }}" class="text-flux-bleu font-medium hover:underline mb-4 inline-block">← Retour aux messages</a>
            <h1 class="font-display text-3xl text-flux-noir">{{ $contact->sujet }}</h1>
            <p class="text-flux-noir/70 mt-2">De {{ $contact->nom }} ({{ $contact->email }})</p>
        </div>
        <div class="flex gap-2">
            @if(!$contact->lu)
                <form method="POST" action="{{ route('admin.contacts.mark-read', $contact) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-flux-bleu/10 text-flux-bleu rounded-lg font-medium hover:bg-flux-bleu/20 transition-colors text-sm">
                        Marquer comme lu
                    </button>
                </form>
            @endif
            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Êtes-vous sûr ?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-100 text-red-800 rounded-lg font-medium hover:bg-red-200 transition-colors text-sm">
                    Supprimer
                </button>
            </form>
        </div>
    </div>

    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Informations du contact -->
    <div class="bg-white rounded-lg border border-flux-noir/10 p-6 mb-8">
        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <p class="text-sm font-medium text-flux-noir/60 uppercase tracking-wider">Informations générales</p>
                <div class="mt-4 space-y-4">
                    <div>
                        <p class="text-sm text-flux-noir/70">Nom</p>
                        <p class="font-medium text-flux-noir">{{ $contact->nom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-flux-noir/70">Email</p>
                        <a href="mailto:{{ $contact->email }}" class="font-medium text-flux-bleu hover:underline">{{ $contact->email }}</a>
                    </div>
                    <div>
                        <p class="text-sm text-flux-noir/70">Type de demande</p>
                        <p class="font-medium text-flux-noir">{{ ucfirst($contact->type_demande) }}</p>
                    </div>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium text-flux-noir/60 uppercase tracking-wider">Dates</p>
                <div class="mt-4 space-y-4">
                    <div>
                        <p class="text-sm text-flux-noir/70">Reçu le</p>
                        <p class="font-medium text-flux-noir">{{ $contact->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    @if($contact->reponse_date)
                        <div>
                            <p class="text-sm text-flux-noir/70">Répondu le</p>
                            <p class="font-medium text-flux-noir">{{ $contact->reponse_date->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-flux-noir/70">Répondu par</p>
                            <p class="font-medium text-flux-noir">{{ $contact->respondedBy?->name ?? 'N/A' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($contact->piece_jointe)
            <div class="mt-6 pt-6 border-t border-flux-noir/10">
                <p class="text-sm font-medium text-flux-noir/60 uppercase tracking-wider">Pièce jointe</p>
                <a href="{{ asset('storage/' . $contact->piece_jointe) }}" target="_blank" class="mt-3 inline-block px-4 py-2 bg-flux-bleu/10 text-flux-bleu rounded-lg font-medium hover:bg-flux-bleu/20 transition-colors">
                    <x-icon name="download" class="w-4 h-4 inline mr-2" />
                    Télécharger
                </a>
            </div>
        @endif
    </div>

    <!-- Message du client -->
    <div class="bg-white rounded-lg border border-flux-noir/10 p-6 mb-8">
        <p class="text-sm font-medium text-flux-noir/60 uppercase tracking-wider mb-4">Message</p>
        <div class="prose prose-sm max-w-none text-flux-noir/80 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</div>
    </div>

    <!-- Réponse -->
    @if($contact->reponse)
        <div class="bg-green-50 rounded-lg border border-green-200 p-6 mb-8">
            <p class="text-sm font-medium text-green-800 uppercase tracking-wider mb-4">✓ Réponse envoyée</p>
            <div class="prose prose-sm max-w-none text-green-900 leading-relaxed whitespace-pre-wrap">{{ $contact->reponse }}</div>
        </div>
    @else
        <!-- Formulaire de réponse -->
        <div class="bg-flux-bleu/5 rounded-lg border border-flux-bleu/20 p-6">
            <p class="text-sm font-medium text-flux-noir/60 uppercase tracking-wider mb-4">Répondre à ce message</p>
            
            <form method="POST" action="{{ route('admin.contacts.reply', $contact) }}" class="space-y-4">
                @csrf

                <div>
                    <label for="reponse" class="block text-sm font-medium text-flux-noir mb-2">Votre réponse</label>
                    <textarea id="reponse" name="reponse" rows="8"
                        class="w-full px-4 py-3 border border-flux-noir/20 rounded-lg focus:ring-2 focus:ring-flux-bleu focus:border-transparent outline-none transition @error('reponse') border-red-500 @enderror"
                        placeholder="Écrivez votre réponse ici...">{{ old('reponse') }}</textarea>
                    @error('reponse')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-flux-noir/60 mt-2">Un mail sera automatiquement envoyé à {{ $contact->email }}</p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-flux-bleu text-white font-semibold py-3 rounded-lg hover:bg-flux-bleu/90 transition-colors">
                        Envoyer la réponse
                    </button>
                    <a href="{{ route('admin.contacts.index') }}" class="flex-1 border border-flux-noir/20 text-flux-noir font-semibold py-3 rounded-lg hover:bg-flux-noir/5 transition-colors text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection

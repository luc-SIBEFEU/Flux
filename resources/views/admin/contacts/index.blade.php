@extends('layouts.dashboard')
@php($espaceRole = 'admin')
@section('titre', 'Messages de contact')

@section('contenu')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- En-tête -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-display text-3xl text-flux-noir">Messages de contact</h1>
                <p class="text-flux-noir/70 mt-2">Gérez les messages reçus via le formulaire de contact</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-flux-bleu">{{ $contacts->total() }}</div>
                <p class="text-sm text-flux-noir/70">message{{ $contacts->total() > 1 ? 's' : '' }}</p>
            </div>
        </div>
    </div>

    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Filtres et recherche -->
    <div class="bg-white rounded-lg border border-flux-noir/10 p-6 mb-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Statut -->
            <div>
                <label class="block text-sm font-medium text-flux-noir mb-2">Statut</label>
                <select form="filter-form" name="statut" class="w-full px-3 py-2 border border-flux-noir/20 rounded-lg text-sm">
                    <option value="">Tous</option>
                    <option value="non-lu" {{ request('statut') === 'non-lu' ? 'selected' : '' }}>Non lus</option>
                    <option value="sans-reponse" {{ request('statut') === 'sans-reponse' ? 'selected' : '' }}>Sans réponse</option>
                    <option value="repondu" {{ request('statut') === 'repondu' ? 'selected' : '' }}>Répondus</option>
                </select>
            </div>

            <!-- Type de demande -->
            <div>
                <label class="block text-sm font-medium text-flux-noir mb-2">Type de demande</label>
                <select form="filter-form" name="type_demande" class="w-full px-3 py-2 border border-flux-noir/20 rounded-lg text-sm">
                    <option value="">Tous</option>
                    <option value="support" {{ request('type_demande') === 'support' ? 'selected' : '' }}>Support technique</option>
                    <option value="reservations" {{ request('type_demande') === 'reservations' ? 'selected' : '' }}>Problème de réservation</option>
                    <option value="paiement" {{ request('type_demande') === 'paiement' ? 'selected' : '' }}>Paiement</option>
                    <option value="partenariat" {{ request('type_demande') === 'partenariat' ? 'selected' : '' }}>Partenariat</option>
                    <option value="autre" {{ request('type_demande') === 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>

            <!-- Recherche -->
            <div>
                <label class="block text-sm font-medium text-flux-noir mb-2">Rechercher</label>
                <input type="text" form="filter-form" name="search" placeholder="Nom, email, sujet..." value="{{ request('search') }}"
                    class="w-full px-3 py-2 border border-flux-noir/20 rounded-lg text-sm">
            </div>

            <!-- Bouton -->
            <div class="flex items-end">
                <button form="filter-form" type="submit" class="w-full bg-flux-bleu text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-flux-bleu/90 transition-colors">
                    Filtrer
                </button>
                @if(request()->anyFilled(['statut', 'type_demande', 'search']))
                    <a href="{{ route('admin.contacts.index') }}" class="ml-2 bg-flux-noir/10 text-flux-noir px-4 py-2 rounded-lg text-sm font-medium hover:bg-flux-noir/20 transition-colors">
                        Réinitialiser
                    </a>
                @endif
            </div>
        </div>
        <form id="filter-form" method="GET" class="hidden"></form>
    </div>

    <!-- Liste des contacts -->
    @if($contacts->count())
        <div class="bg-white rounded-lg border border-flux-noir/10 overflow-hidden">
            <table class="w-full">
                <thead class="bg-flux-noir/5">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-flux-noir">Auteur</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-flux-noir">Sujet</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-flux-noir">Type</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-flux-noir">Date</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-flux-noir">Statut</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-flux-noir">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-flux-noir/10">
                    @foreach($contacts as $contact)
                        <tr class="{{ !$contact->lu ? 'bg-flux-bleu/5' : '' }} hover:bg-flux-noir/5 transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-flux-noir">{{ $contact->nom }}</p>
                                    <p class="text-sm text-flux-noir/60">{{ $contact->email }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-flux-noir max-w-xs truncate">{{ $contact->sujet }}</p>
                                @if(!$contact->lu)
                                    <span class="inline-block mt-1 px-2 py-1 bg-flux-bleu text-white text-xs rounded font-medium">Nouveau</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 bg-flux-noir/10 text-flux-noir text-xs rounded-full font-medium">
                                    {{ ucfirst($contact->type_demande) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-flux-noir/70">
                                {{ $contact->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($contact->reponse)
                                    <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">
                                        Répondu
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-medium">
                                        En attente
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="inline-block text-flux-bleu font-medium hover:underline">
                                    Voir →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $contacts->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg border border-flux-noir/10 p-12 text-center">
            <x-icon name="inbox" class="w-16 h-16 text-flux-noir/30 mx-auto mb-4" />
            <p class="text-flux-noir/70">Aucun message de contact</p>
        </div>
    @endif
</div>
@endsection

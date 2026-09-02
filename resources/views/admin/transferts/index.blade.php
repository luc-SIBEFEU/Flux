@extends('layouts.dashboard')
@php $espaceRole = 'admin'; @endphp
@section('titre_page', __('sidebar.reversements'))
@section('titre', __('sidebar.reversements') . ' — ' . __('sidebar.espace_admin'))

@section('contenu')

<p class="text-sm text-flux-noir/60 mb-6">
    {{ __('admin_transferts.intro') }}
</p>

<form method="GET" class="flex gap-3 mb-6">
    <select name="statut" onchange="this.form.submit()" class="border border-black/10 rounded-lg px-3 py-2.5 text-sm bg-white">
        <option value="">{{ __('common.tous_les_statuts') }}</option>
        @foreach (['a_traiter' => __('admin_transferts.a_traiter'), 'en_cours' => __('actualite.en_cours'), 'effectue' => __('admin_transferts.effectue'), 'echoue' => __('reservation.statut_paiement_echoue')] as $val => $label)
            <option value="{{ $val }}" {{ request('statut') === $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</form>

<div class="bg-white rounded-2xl border border-black/5 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-flux-brume text-flux-noir/50 text-xs uppercase">
            <tr>
                <th class="text-left px-5 py-3">{{ __('admin_transferts.beneficiaire') }}</th>
                <th class="text-left px-5 py-3">{{ __('admin_transferts.objet') }}</th>
                <th class="text-left px-5 py-3">{{ __('mail.montant') }}</th>
                <th class="text-left px-5 py-3">{{ __('navigation.contact') }}</th>
                <th class="text-left px-5 py-3">{{ __('common.statut') }}</th>
                <th class="text-left px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-black/5">
            @forelse ($transferts as $transfert)
                <tr>
                    <td class="px-5 py-3">{{ $transfert->beneficiaire->nom }}</td>
                    <td class="px-5 py-3 text-flux-noir/60">{{ class_basename($transfert->paiement->payable_type ?? '') }} #{{ $transfert->paiement->payable_id ?? '—' }}</td>
                    <td class="px-5 py-3 font-medium">{{ number_format($transfert->montant, 0, ',', ' ') }} FCFA</td>
                    <td class="px-5 py-3 text-flux-noir/60">
                        {{ $transfert->numero_destinataire ?? __('admin_transferts.aucun_contact') }}
                        @if($transfert->type_contact) ({{ $transfert->type_contact === 'mtn_momo' ? 'MTN MoMo' : 'Orange Money' }}) @endif
                    </td>
                    <td class="px-5 py-3">
                        @php $badges = ['a_traiter' => 'bg-flux-or/20 text-flux-or', 'en_cours' => 'bg-flux-bleu-pale text-flux-bleu', 'effectue' => 'bg-green-50 text-green-600', 'echoue' => 'bg-red-50 text-red-500']; @endphp
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $badges[$transfert->statut] }}">{{ __('admin_transferts.statut_' . $transfert->statut) }}</span>
                        @if($transfert->notes)
                            <p class="text-xs text-flux-noir/40 mt-1 max-w-xs">{{ $transfert->notes }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-3 whitespace-nowrap">
                        @if (in_array($transfert->statut, ['a_traiter', 'echoue']))
                            <form method="POST" action="{{ route('admin.transferts.reessayer', $transfert) }}" class="inline">
                                @csrf
                                <button class="text-xs text-flux-bleu font-medium hover:underline mr-3">{{ __('admin_transferts.reessayer_versement') }}</button>
                            </form>
                        @endif
                        @if ($transfert->statut === 'en_cours')
                            <form method="POST" action="{{ route('admin.transferts.verifier', $transfert) }}" class="inline">
                                @csrf
                                <button class="text-xs text-flux-bleu font-medium hover:underline mr-3">{{ __('admin_transferts.verifier_statut') }}</button>
                            </form>
                        @endif
                        @if ($transfert->statut !== 'effectue')
                            <form method="POST" action="{{ route('admin.transferts.effectuer', $transfert) }}" class="inline">
                                @csrf
                                <button class="text-xs text-flux-noir/50 font-medium hover:underline">{{ __('admin_transferts.marquer_effectue') }}</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-flux-noir/40">{{ __('admin_transferts.aucun_en_attente') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $transferts->links() }}</div>
@endsection

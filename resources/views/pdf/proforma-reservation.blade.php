<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #12131A; font-size: 13px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #1B3A6B; padding-bottom: 16px; margin-bottom: 24px; }
        .logo { font-size: 22px; font-weight: bold; color: #1B3A6B; }
        .badge { display: inline-block; background: #E7EEFA; color: #1B3A6B; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; background: #F5F7FB; padding: 8px 10px; font-size: 11px; text-transform: uppercase; color: #6b7280; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        .total { font-size: 20px; font-weight: bold; color: #1B3A6B; text-align: right; margin-top: 16px; }
        .footer { margin-top: 40px; font-size: 10px; color: #9ca3af; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Flux</div>
        <span class="badge">PRO-FORMA #{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>

    <p><strong>{{ __('common.client') }} :</strong> {{ $reservation->client->nom }} — {{ $reservation->telephone_client }}</p>
    <p><strong>{{ __('hotel.hotel_singulier') }} :</strong> {{ $reservation->hotel->nom }}, {{ $reservation->hotel->ville }}</p>
    <p><strong>{{ __('pdf.sejour') }} :</strong> {{ $reservation->date_arrivee->format('d/m/Y') }} → {{ $reservation->date_depart->format('d/m/Y') }}
        ({{ trans_choice('pdf.nuit_compte', $reservation->date_arrivee->diffInDays($reservation->date_depart), ['n' => $reservation->date_arrivee->diffInDays($reservation->date_depart)]) }})</p>

    <table>
        <thead>
            <tr><th>{{ __('pdf.designation') }}</th><th>{{ __('pdf.occupants') }}</th><th>{{ __('mail.montant') }}</th></tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $reservation->categorieChambre->nom }}</td>
                <td>{{ trans_choice('chambre.adulte_compte', $reservation->nombre_adultes, ['n' => $reservation->nombre_adultes]) }}, {{ trans_choice('chambre.enfant_compte', $reservation->nombre_enfants, ['n' => $reservation->nombre_enfants]) }}</td>
                <td>{{ number_format($reservation->prix_total, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tbody>
    </table>

    <p class="total">{{ __('mail.total_paye') }} : {{ number_format($reservation->prix_total, 0, ',', ' ') }} FCFA</p>

    <div class="footer">
        {{ __('pdf.genere_auto_sejour') }} — {{ now()->format('d/m/Y') }}
    </div>
</body>
</html>

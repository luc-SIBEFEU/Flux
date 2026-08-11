<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #12131A; font-size: 13px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #5B3596; padding-bottom: 16px; margin-bottom: 24px; }
        .logo { font-size: 22px; font-weight: bold; color: #5B3596; }
        .badge { display: inline-block; background: #F1E9FB; color: #5B3596; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; background: #F5F7FB; padding: 8px 10px; font-size: 11px; text-transform: uppercase; color: #6b7280; }
        td { padding: 8px 10px; border-bottom: 1px solid #eee; }
        .total { font-size: 20px; font-weight: bold; color: #5B3596; text-align: right; margin-top: 16px; }
        .footer { margin-top: 40px; font-size: 10px; color: #9ca3af; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Flux</div>
        <span class="badge">PRO-FORMA BAIL #{{ str_pad($baye->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>

    <p><strong>Locataire :</strong> {{ $baye->client->nom }} — {{ $baye->client->telephone }}</p>
    <p><strong>Bailleur :</strong> {{ $baye->bailleur->nom }}</p>
    <p><strong>Logement :</strong> {{ ucfirst($baye->logement->type) }}, {{ $baye->logement->quartier }}, {{ $baye->logement->ville }}</p>
    <p><strong>Durée du bail :</strong> {{ $baye->date_debut->format('d/m/Y') }} → {{ $baye->date_fin_prevue->format('d/m/Y') }} ({{ $baye->duree_mois }} mois)</p>

    <table>
        <thead><tr><th>Mois</th><th>Montant</th><th>Statut</th></tr></thead>
        <tbody>
            @foreach($baye->loyers as $loyer)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($loyer->mois_concerne)->translatedFormat('F Y') }}</td>
                    <td>{{ number_format($loyer->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $loyer->statut === 'paye' ? 'Payé' : 'Non payé' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total du bail : {{ number_format($baye->loyers->sum('montant'), 0, ',', ' ') }} FCFA</p>

    <div class="footer">
        Document généré automatiquement par Flux à la fin de la location — {{ now()->format('d/m/Y') }}
    </div>
</body>
</html>

<?php

namespace App\Http\Controllers;

use App\Mail\ReservationTermineeMail;
use App\Models\Abonnement;
use App\Models\Loyer;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Services\AangaraaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    public function __construct(private AangaraaPayService $aangaraaPay)
    {
    }

    /** Formulaire d'initiation, affiché après création d'une réservation ou pour payer un loyer. */
    public function formulaire(string $type, int $id)
    {
        $payable = $this->resoudre($type, $id);

        return view('paiements.formulaire', ['payable' => $payable, 'type' => $type]);
    }

    /** Déclenche le paiement direct (prompt MTN/Orange sur le téléphone du client). */
    public function initier(Request $request, string $type, int $id)
    {
        $payable = $this->resoudre($type, $id);

        $data = $request->validate([
            'telephone' => ['required', 'string'],
        ]);

        $montant = match ($type) {
            'reservation' => $payable->prix_total,
            'abonnement' => $payable->forfait->prix,
            default => $payable->montant,
        };
        $transactionId = strtoupper($type) . '_' . $payable->id . '_' . Str::random(6);

        $paiement = Paiement::create([
            'payable_id' => $payable->id,
            'payable_type' => get_class($payable),
            'user_id' => auth()->id(),
            'montant' => $montant,
            'methode' => $this->aangaraaPay->detecterOperateur($data['telephone']) === 'Orange_Cameroon' ? 'orange_money' : 'mtn_momo',
            'numero_expediteur' => $data['telephone'],
            'reference_transaction' => $transactionId,
            'statut' => 'en_attente',
        ]);

        $libelle = match ($type) {
            'reservation' => "Réservation #{$payable->id} — Flux",
            'abonnement' => "Forfait {$payable->forfait->nom} — Flux",
            default => "Loyer #{$payable->id} — Flux",
        };

        $resultat = $this->aangaraaPay->payerDirect($data['telephone'], $montant, $libelle, $transactionId);

        $paiement->update([
            'reponse_api' => $resultat['brut'],
            'statut' => $resultat['success'] ? 'en_attente' : 'echoue',
        ]);

        if (! $resultat['success']) {
            $this->marquerEchec($paiement);

            return back()->withErrors(['telephone' => "Le paiement n'a pas pu être initié. Vérifiez le numéro et réessayez."]);
        }

        // On stocke le payToken (nécessaire pour vérifier le statut) dans reponse_api.
        $paiement->update(['reponse_api' => array_merge($resultat['brut'], ['pay_token' => $resultat['pay_token']])]);

        return view('paiements.attente', ['paiement' => $paiement, 'type' => $type]);
    }

    /** Interrogé en AJAX par la vue "attente" pour savoir si le paiement est confirmé. */
    public function statut(Paiement $paiement)
    {
        abort_unless($paiement->user_id === auth()->id(), 403);

        if ($paiement->statut === 'reussi') {
            return response()->json(['statut' => 'reussi']);
        }

        $payToken = $paiement->reponse_api['pay_token'] ?? null;
        if (! $payToken) {
            return response()->json(['statut' => $paiement->statut]);
        }

        $verification = $this->aangaraaPay->verifierStatut($payToken);
        $statutDistant = strtolower($verification['status'] ?? 'pending');

        if ($statutDistant === 'successful' && $paiement->statut !== 'reussi') {
            $this->confirmerPaiement($paiement);
        } elseif (in_array($statutDistant, ['failed', 'cancelled', 'expired'])) {
            $paiement->update(['statut' => 'echoue']);
            $this->marquerEchec($paiement);
        }

        return response()->json(['statut' => $paiement->fresh()->statut]);
    }

    /** Webhook public appelé par le serveur AangaraaPay (notify_url). */
    public function webhook(Request $request)
    {
        $transactionId = $request->input('transaction_id');
        $statut = strtolower($request->input('status', ''));

        $paiement = Paiement::where('reference_transaction', $transactionId)->first();
        if (! $paiement) {
            return response()->json(['message' => 'transaction inconnue'], 404);
        }

        if ($statut === 'successful') {
            $this->confirmerPaiement($paiement);
        } elseif (in_array($statut, ['failed', 'cancelled', 'expired'])) {
            $paiement->update(['statut' => 'echoue', 'reponse_api' => $request->all()]);
            $this->marquerEchec($paiement);
        }

        return response()->json(['message' => 'ok']);
    }

    /** Marque le paiement réussi et applique les effets métier (réservation / loyer / forfait). */
    private function confirmerPaiement(Paiement $paiement): void
    {
        $paiement->update(['statut' => 'reussi']);
        $payable = $paiement->payable;

        if ($payable instanceof Reservation) {
            $payable->update(['statut' => 'confirmee', 'statut_paiement' => 'reussi']);
            app(\App\Services\TransfertService::class)->creerEtVerser($paiement, $payable->hotel->hotelier, $payable->hotel->contactsPaiement->first());
            app(\App\Services\NotificationDashboardService::class)->paiementReservationReussi($payable);
        }

        if ($payable instanceof Loyer) {
            $payable->update(['statut' => 'paye', 'date_paiement' => now()]);
            $baye = $payable->baye;

            // Le paiement initial (caution + durée minimum) active le bail.
            if ($payable->paiement_initial && $baye->statut === 'nouveau') {
                $baye->update(['statut' => 'en_cours']);
            }

            $enRetard = $baye->loyers()->where('statut', '!=', 'paye')->where('date_echeance', '<', now())->exists();
            $baye->update(['etat_paiement' => $enRetard ? 'en_retard' : 'a_jour']);

            app(\App\Services\TransfertService::class)->creerEtVerser($paiement, $baye->bailleur, $baye->bailleur->bailleurContactsPaiement->first());
        }

        if ($payable instanceof Abonnement) {
            app(\App\Services\ForfaitService::class)->activer($payable);
        }
    }

    /** Propage l'échec du paiement à l'objet lié (statut_paiement réservation, etc.). */
    private function marquerEchec(Paiement $paiement): void
    {
        $payable = $paiement->payable;

        if ($payable instanceof Reservation) {
            $payable->update(['statut_paiement' => 'echoue']);
            app(\App\Services\NotificationDashboardService::class)->paiementReservationEchoue($payable);
        }
    }

    private function resoudre(string $type, int $id)
    {
        $model = match ($type) {
            'reservation' => Reservation::findOrFail($id),
            'loyer' => Loyer::findOrFail($id),
            'abonnement' => Abonnement::findOrFail($id),
            default => abort(404),
        };

        $proprietaireId = match ($type) {
            'reservation' => $model->client_id,
            'loyer' => $model->baye->client_id,
            'abonnement' => $model->user_id,
        };
        abort_unless($proprietaireId === auth()->id(), 403);

        return $model;
    }
}

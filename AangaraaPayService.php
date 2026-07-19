<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Intégration officielle avec l'API AangaraaPay (MTN Mobile Money / Orange Money).
 * Documentation : https://aangaraa-pay.com/integrate-aangaraa-pay
 *
 * On utilise le paiement DIRECT ("no_redirect/payment") car on a déjà le
 * numéro de téléphone du client dans notre formulaire de réservation :
 * le client reçoit directement un prompt USSD / notification sur son
 * téléphone pour approuver le paiement, sans quitter notre site.
 */
class AangaraaPayService
{
    protected string $baseUrl;
    protected ?string $appKey;

    public function __construct()
    {
        $this->baseUrl = config('services.aangaraa.base_url', 'https://api-production.aangaraa-pay.com/api/v1');
        $this->appKey = config('services.aangaraa.app_key');
    }

    /**
     * Vérifie que la clé d'application AangaraaPay est bien configurée
     * avant tout appel à l'API, avec un message d'erreur explicite.
     */
    protected function verifierConfiguration(): void
    {
        if (empty($this->appKey)) {
            throw new \RuntimeException(
                "La clé AANGARAA_PAY_APP_KEY n'est pas définie dans le fichier .env. " .
                "Récupère-la dans ton espace marchand AangaraaPay puis ajoute-la à ton .env, " .
                "vérifie qu'elle figure aussi dans config/services.php, et lance php artisan config:clear."
            );
        }
    }

    /**
     * Convertit notre enum interne (mtn_momo / orange_money) vers
     * la valeur attendue par l'API AangaraaPay.
     */
    protected function operateur(string $methode): string
    {
        return $methode === 'mtn_momo' ? 'MTN_Cameroon' : 'Orange_Cameroon';
    }

    /**
     * Initie un paiement direct (sans redirection) pour une réservation.
     * Le client reçoit un prompt sur son téléphone pour approuver.
     */
    public function initierPaiement(Payment $payment): array
    {
        $this->verifierConfiguration();

        $transactionId = 'RES-' . $payment->reservation_id . '-' . Str::random(6);

        $response = Http::acceptJson()->post("{$this->baseUrl}/no_redirect/payment", [
            'phone_number' => $this->formaterNumero($payment->telephone_paiement),
            'amount' => (string) $payment->montant,
            'description' => "Réservation #{$payment->reservation_id} - HotelBooking",
            'app_key' => $this->appKey,
            'transaction_id' => $transactionId,
            'notify_url' => route('paiement.webhook'),
            'operator' => $this->operateur($payment->methode),
            'devise_id' => 'XAF',
        ]);

        $data = $response->json() ?? [];
        $payToken = $data['data']['payToken'] ?? null;

        $payment->update([
            'reference_transaction' => $payToken ?? $transactionId,
            'statut' => $response->successful() && $payToken ? 'initie' : 'echoue',
            'reponse_api' => $data,
        ]);

        return $data;
    }

    /**
     * Vérifie le statut d'un paiement auprès d'AangaraaPay via son payToken.
     */
    public function verifierStatut(Payment $payment): string
    {
        $this->verifierConfiguration();

        $response = Http::acceptJson()->post("{$this->baseUrl}/aangaraa_check_status", [
            'payToken' => $payment->reference_transaction,
            'app_key' => $this->appKey,
        ]);

        $data = $response->json() ?? [];
        $statutDistant = $data['status'] ?? 'FAILED';

        $mapped = match ($statutDistant) {
            'SUCCESSFUL' => 'reussi',
            'PENDING' => 'initie',
            default => 'echoue', // FAILED, CANCELLED, EXPIRED
        };

        $payment->update(['statut' => $mapped, 'reponse_api' => $data]);

        if ($mapped === 'reussi') {
            $payment->reservation->update(['statut' => 'confirmee']);
        }

        return $mapped;
    }

    /**
     * Normalise le numéro de téléphone au format attendu par l'API
     * (avec l'indicatif 237, sans le +).
     */
    protected function formaterNumero(string $numero): string
    {
        $numero = preg_replace('/\D/', '', $numero); // garde uniquement les chiffres

        if (str_starts_with($numero, '237')) {
            return $numero;
        }

        return '237' . ltrim($numero, '0');
    }
}

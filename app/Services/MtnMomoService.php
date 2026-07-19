<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Intégration avec l'API officielle MTN Mobile Money (produit "Collections").
 * Documentation développeur : https://momodeveloper.mtn.com
 *
 * Flux "Request to Pay" : le client reçoit un prompt sur son téléphone pour
 * approuver le paiement (comme le *126# habituel), sans quitter le site.
 *
 * Pré-requis (espace développeur MTN MoMo) :
 * - Un compte sur momodeveloper.mtn.com, abonné au produit "Collections"
 * - Une clé d'abonnement (Ocp-Apim-Subscription-Key)
 * - Un "API user" + "API key" générés via l'API sandbox ou fournis en prod
 *
 * ⚠️ Le base_url et le mode d'obtention des identifiants diffèrent entre le
 * sandbox MTN (commun à tous les pays) et la mise en production (négociée
 * pays par pays avec MTN). Adapte AANGARAA_... les variables .env avec les
 * valeurs fournies par MTN pour le Cameroun une fois ton compte validé.
 */
class MtnMomoService
{
    protected string $baseUrl;
    protected ?string $subscriptionKey;
    protected ?string $apiUser;
    protected ?string $apiKey;
    protected string $targetEnvironment;

    public function __construct()
    {
        $this->baseUrl = config('services.mtn_momo.base_url', 'https://sandbox.momodeveloper.mtn.com');
        $this->subscriptionKey = config('services.mtn_momo.subscription_key');
        $this->apiUser = config('services.mtn_momo.api_user');
        $this->apiKey = config('services.mtn_momo.api_key');
        $this->targetEnvironment = config('services.mtn_momo.target_environment', 'sandbox');
    }

    /**
     * Indique si les identifiants MTN MoMo sont configurés.
     * Si non, PaymentManager bascule automatiquement en mode manuel.
     */
    public function estConfigure(): bool
    {
        return ! empty($this->subscriptionKey) && ! empty($this->apiUser) && ! empty($this->apiKey);
    }

    protected function obtenirJeton(): ?string
    {
        $response = Http::withBasicAuth($this->apiUser, $this->apiKey)
            ->withHeaders(['Ocp-Apim-Subscription-Key' => $this->subscriptionKey])
            ->post("{$this->baseUrl}/collection/token/");

        return $response->successful() ? $response->json('access_token') : null;
    }

    /**
     * Déclenche le prompt de paiement sur le téléphone du client.
     */
    public function initierPaiement(Payment $payment): array
    {
        $jeton = $this->obtenirJeton();

        if (! $jeton) {
            $payment->update(['statut' => 'echoue', 'reponse_api' => ['erreur' => "Impossible d'obtenir un jeton MTN MoMo"]]);
            return ['succes' => false];
        }

        $referenceId = (string) Str::uuid();

        $response = Http::withToken($jeton)
            ->withHeaders([
                'X-Reference-Id' => $referenceId,
                'X-Target-Environment' => $this->targetEnvironment,
                'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
                'Content-Type' => 'application/json',
            ])
            ->post("{$this->baseUrl}/collection/v1_0/requesttopay", [
                'amount' => (string) $payment->montant,
                'currency' => 'XAF',
                'externalId' => (string) $payment->reservation_id,
                'payer' => [
                    'partyIdType' => 'MSISDN',
                    'partyId' => $this->formaterNumero($payment->telephone_paiement),
                ],
                'payerMessage' => "Réservation #{$payment->reservation_id}",
                'payeeNote' => 'HotelBooking',
            ]);

        $payment->update([
            'reference_transaction' => $referenceId,
            'statut' => $response->status() === 202 ? 'initie' : 'echoue',
            'reponse_api' => ['http_status' => $response->status()],
        ]);

        return ['succes' => $response->status() === 202, 'reference' => $referenceId];
    }

    /**
     * Interroge le statut d'une transaction Request to Pay.
     */
    public function verifierStatut(Payment $payment): string
    {
        $jeton = $this->obtenirJeton();

        if (! $jeton || ! $payment->reference_transaction) {
            return 'echoue';
        }

        $response = Http::withToken($jeton)
            ->withHeaders([
                'X-Target-Environment' => $this->targetEnvironment,
                'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
            ])
            ->get("{$this->baseUrl}/collection/v1_0/requesttopay/{$payment->reference_transaction}");

        $statutDistant = $response->json('status', 'FAILED');

        $mapped = match ($statutDistant) {
            'SUCCESSFUL' => 'reussi',
            'PENDING' => 'initie',
            default => 'echoue', // FAILED, REJECTED, TIMEOUT
        };

        $payment->update(['statut' => $mapped, 'reponse_api' => $response->json()]);

        if ($mapped === 'reussi') {
            $payment->reservation->update(['statut' => 'confirmee']);
        }

        return $mapped;
    }

    protected function formaterNumero(string $numero): string
    {
        $numero = preg_replace('/\D/', '', $numero);

        return str_starts_with($numero, '237') ? $numero : '237' . ltrim($numero, '0');
    }
}

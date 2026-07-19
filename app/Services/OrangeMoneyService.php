<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;

/**
 * Intégration avec l'API officielle Orange Money ("Web Payment API").
 * Documentation développeur : https://developer.orange.com/apis/om-webpay
 *
 * ⚠️ Contrairement à MTN MoMo, l'API publique standard d'Orange Money est un
 * flux par REDIRECTION : le client est envoyé sur une page de paiement Orange
 * hébergée par Orange (paiement par *150# ou appli Orange Money), puis
 * redirigé vers notre site une fois le paiement effectué. Il n'y a pas
 * d'équivalent public "push vers le téléphone" comme MTN MoMo pour la
 * majorité des pays — si Orange t'a donné accès à une API différente pour le
 * Cameroun (ex: Orange Money Direct via partenariat), remplace ce service en
 * conséquence.
 *
 * Pré-requis (Orange Developer Center) :
 * - Un compte sur developer.orange.com avec l'API "Orange Money Web Payment" activée
 * - client_id / client_secret (OAuth2 client_credentials)
 * - merchant_key fourni par Orange après validation de ton compte marchand
 */
class OrangeMoneyService
{
    protected string $baseUrl;
    protected ?string $clientId;
    protected ?string $clientSecret;
    protected ?string $merchantKey;

    public function __construct()
    {
        $this->baseUrl = config('services.orange_money.base_url', 'https://api.orange.com');
        $this->clientId = config('services.orange_money.client_id');
        $this->clientSecret = config('services.orange_money.client_secret');
        $this->merchantKey = config('services.orange_money.merchant_key');
    }

    public function estConfigure(): bool
    {
        return ! empty($this->clientId) && ! empty($this->clientSecret) && ! empty($this->merchantKey);
    }

    protected function obtenirJeton(): ?string
    {
        $response = Http::asForm()
            ->withBasicAuth($this->clientId, $this->clientSecret)
            ->post("{$this->baseUrl}/oauth/v3/token", [
                'grant_type' => 'client_credentials',
            ]);

        return $response->successful() ? $response->json('access_token') : null;
    }

    /**
     * Crée une session de paiement Orange Money et renvoie l'URL de
     * redirection vers laquelle envoyer le client pour qu'il confirme le
     * paiement (via l'app Orange Money ou *150#).
     */
    public function initierPaiement(Payment $payment): array
    {
        $jeton = $this->obtenirJeton();

        if (! $jeton) {
            $payment->update(['statut' => 'echoue', 'reponse_api' => ['erreur' => "Impossible d'obtenir un jeton Orange Money"]]);
            return ['succes' => false];
        }

        $orderId = 'RES-' . $payment->reservation_id . '-' . $payment->id;

        $response = Http::withToken($jeton)->post("{$this->baseUrl}/orange-money-webpay/cm/v1/webpayment", [
            'merchant_key' => $this->merchantKey,
            'currency' => 'XAF',
            'order_id' => $orderId,
            'amount' => (int) $payment->montant,
            'return_url' => route('paiement.orange.retour', $payment),
            'cancel_url' => route('paiement.orange.annulation', $payment),
            'notif_url' => route('paiement.webhook.orange'),
            'lang' => 'fr',
            'reference' => "Réservation #{$payment->reservation_id}",
        ]);

        $data = $response->json() ?? [];

        $payment->update([
            'reference_transaction' => $data['pay_token'] ?? $orderId,
            'statut' => $response->successful() && isset($data['payment_url']) ? 'initie' : 'echoue',
            'reponse_api' => $data,
        ]);

        return [
            'succes' => $response->successful() && isset($data['payment_url']),
            'payment_url' => $data['payment_url'] ?? null,
        ];
    }

    /**
     * Vérifie le statut d'une transaction Orange Money via son pay_token.
     */
    public function verifierStatut(Payment $payment): string
    {
        $jeton = $this->obtenirJeton();

        if (! $jeton || ! $payment->reference_transaction) {
            return 'echoue';
        }

        $response = Http::withToken($jeton)->get("{$this->baseUrl}/orange-money-webpay/cm/v1/transactionstatus", [
            'order_id' => 'RES-' . $payment->reservation_id . '-' . $payment->id,
            'amount' => (int) $payment->montant,
            'pay_token' => $payment->reference_transaction,
        ]);

        $statutDistant = $response->json('status', 'FAILED');

        $mapped = match ($statutDistant) {
            'SUCCESS' => 'reussi',
            'PENDING', 'INITIATED' => 'initie',
            default => 'echoue', // FAILED, EXPIRED
        };

        $payment->update(['statut' => $mapped, 'reponse_api' => $response->json()]);

        if ($mapped === 'reussi') {
            $payment->reservation->update(['statut' => 'confirmee']);
        }

        return $mapped;
    }
}

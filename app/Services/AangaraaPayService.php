<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Client pour l'API AangaraaPay (MTN Mobile Money / Orange Money).
 * Documentation : https://aangaraa-pay.com/integrate-aangaraa-pay
 */
class AangaraaPayService
{
    private string $baseUrl;
    private string $appKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.aangaraa_pay.base_url'), '/');
        $this->appKey = config('services.aangaraa_pay.app_key');
    }

    /**
     * Paiement direct (sans redirection) : le client reçoit un prompt sur son
     * téléphone pour approuver le paiement. C'est le flux utilisé par Flux
     * puisque le numéro du client est déjà collecté dans nos formulaires.
     *
     * @return array{success:bool, pay_token:?string, statut:string, brut:array}
     */
    public function payerDirect(string $telephone, float $montant, string $description, string $transactionId): array
    {
        $operateur = $this->detecterOperateur($telephone);

        $reponse = Http::asJson()->post("{$this->baseUrl}/api/v1/no_redirect/payment", [
            'phone_number' => $this->normaliserTelephone($telephone),
            'amount' => (string) $montant,
            'description' => $description,
            'app_key' => $this->appKey,
            'transaction_id' => $transactionId,
            'notify_url' => route('paiements.webhook'),
            'operator' => $operateur,
            'devise_id' => 'XAF',
        ]);

        $corps = $reponse->json() ?? [];

        if (! $reponse->successful()) {
            Log::warning('AangaraaPay: échec initiation paiement', ['reponse' => $corps]);
            return ['success' => false, 'pay_token' => null, 'statut' => 'echoue', 'brut' => $corps];
        }

        return [
            'success' => true,
            'pay_token' => $corps['data']['payToken'] ?? null,
            'statut' => strtolower($corps['data']['status'] ?? 'pending'),
            'brut' => $corps,
        ];
    }

    /** Vérifie le statut d'un paiement à partir de son payToken. */
    public function verifierStatut(string $payToken): array
    {
        $reponse = Http::asJson()->post("{$this->baseUrl}/api/v1/aangaraa_check_status", [
            'payToken' => $payToken,
            'app_key' => $this->appKey,
        ]);

        return $reponse->json() ?? [];
    }

    /** Détecte l'opérateur (MTN/Orange) à partir des préfixes camerounais. */
    public function detecterOperateur(string $telephone): string
    {
        $numero = preg_replace('/\D/', '', $telephone);
        $numero = ltrim(str_replace('237', '', $numero, ), '0');
        $prefixe = substr($numero, 0, 3);

        $orange = ['655', '656', '657', '658', '659', '690', '691', '692', '693', '694', '695', '696', '697', '698', '699'];
        $mtn = ['650', '651', '652', '653', '654', '670', '671', '672', '673', '674', '675', '676', '677', '678', '679', '680', '681', '682', '683'];

        return in_array($prefixe, $orange, true) ? 'Orange_Cameroon' : (in_array($prefixe, $mtn, true) ? 'MTN_Cameroon' : 'MTN_Cameroon');
    }

    /** Nos contacts de paiement stockent 'mtn_momo'/'orange_money' ; l'API attend 'MTN_Cameroon'/'Orange_Cameroon'. */
    public function operateurDepuisType(string $type): string
    {
        return $type === 'orange_money' ? 'Orange_Cameroon' : 'MTN_Cameroon';
    }

    /**
     * Retrait (disbursement) : envoie de l'argent depuis le solde AangaraaPay du
     * marchand (Flux) vers un numéro mobile money. Utilisé pour reverser à
     * l'hôtelier/bailleur le montant d'un paiement encaissé pour son compte.
     *
     * @return array{statut: 'effectue'|'en_cours'|'echoue', reference: ?string, message: ?string, brut: array}
     */
    public function retirer(string $telephone, float $montant, string $operateur, ?string $nomBeneficiaire = null): array
    {
        $reponse = Http::asJson()->post("{$this->baseUrl}/api/v1/aangaraa-pay/withdrawal", array_filter([
            'app_key' => $this->appKey,
            'phone_number' => $this->normaliserTelephone($telephone),
            'amount' => (string) $montant,
            'payment_method' => $operateur,
            'username' => $nomBeneficiaire,
        ]));

        $corps = $reponse->json() ?? [];

        if (! $reponse->successful()) {
            Log::warning('AangaraaPay: échec retrait', ['reponse' => $corps]);
            return ['statut' => 'echoue', 'reference' => null, 'message' => $corps['message'] ?? $corps['data']['description'] ?? 'Échec du retrait', 'brut' => $corps];
        }

        $statutDistant = strtoupper($corps['data']['status'] ?? '');

        return [
            'statut' => match ($statutDistant) {
                'SUCCESSFUL' => 'effectue',
                'PENDING' => 'en_cours',
                default => 'echoue',
            },
            'reference' => $corps['data']['reference_id'] ?? null,
            'message' => $corps['data']['message'] ?? $corps['message'] ?? null,
            'brut' => $corps,
        ];
    }

    /** Vérifie le statut d'un retrait initié via retirer(), à partir de sa reference_id. */
    public function verifierStatutRetrait(string $referenceId, string $operateur): array
    {
        $reponse = Http::asJson()->get("{$this->baseUrl}/api/v1/check_withdrawal_status/{$referenceId}", [
            'payment_method' => $operateur,
        ]);

        return $reponse->json() ?? [];
    }

    private function normaliserTelephone(string $telephone): string
    {
        $numero = preg_replace('/\D/', '', $telephone);
        return str_starts_with($numero, '237') ? $numero : '237' . ltrim($numero, '0');
    }
}

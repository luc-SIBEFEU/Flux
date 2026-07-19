<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Page d'instructions de paiement manuel : affiche le numéro MoMo/Orange
     * de l'hôtelier concerné et un formulaire pour saisir la référence reçue
     * par SMS après le transfert fait par le client lui-même.
     */
    public function instructions(Payment $payment)
    {
        $this->autoriserClient($payment);

        $payment->load('reservation.hotel.hotelier.paymentContact');

        return view('public.payment.instructions', compact('payment'));
    }

    /**
     * Le client soumet la référence de transaction de son propre transfert.
     */
    public function soumettrePreuve(Request $request, Payment $payment, PaymentManager $paiements)
    {
        $this->autoriserClient($payment);

        $data = $request->validate([
            'preuve_paiement' => 'required|string|max:100',
        ]);

        $paiements->soumettrePreuve($payment, $data['preuve_paiement']);

        return back()->with('success', "Référence enregistrée. L'hôtelier va vérifier la réception du paiement et confirmer votre réservation.");
    }

    /**
     * Permet au client de redemander une vérification de statut auprès de
     * l'API (utile en mode API si le prompt MTN MoMo tarde à se refléter).
     */
    public function verifier(Payment $payment, PaymentManager $paiements)
    {
        $this->autoriserClient($payment);

        $statut = $paiements->verifierStatut($payment);

        return back()->with('success', match ($statut) {
            'reussi' => 'Paiement confirmé, votre réservation est validée 🎉',
            'initie' => 'Paiement toujours en attente de confirmation.',
            default => "Le paiement n'a pas abouti. Vous pouvez réessayer.",
        });
    }

    /**
     * URL de retour après le paiement Orange Money (redirection du client).
     */
    public function retourOrange(Payment $payment, PaymentManager $paiements)
    {
        $paiements->verifierStatut($payment);

        return redirect()->route('client.reservations.index')
            ->with('success', 'Merci, nous vérifions la confirmation de votre paiement Orange Money.');
    }

    public function annulationOrange(Payment $payment)
    {
        return redirect()->route('client.reservations.index')
            ->with('success', 'Paiement Orange Money annulé. Vous pouvez réessayer depuis vos réservations en attente.');
    }

    /**
     * Webhook serveur-à-serveur (notif_url) appelé par Orange Money.
     */
    public function webhookOrange(Request $request, PaymentManager $paiements)
    {
        $data = $request->all();

        $payment = Payment::where('reference_transaction', $data['pay_token'] ?? null)->first();

        if ($payment) {
            $paiements->verifierStatut($payment);
        }

        return response()->json(['ok' => true]);
    }

    protected function autoriserClient(Payment $payment): void
    {
        abort_unless($payment->reservation->client_id === Auth::id(), 403);
    }
}

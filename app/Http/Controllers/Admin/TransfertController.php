<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transfert;
use App\Services\TransfertService;
use Illuminate\Http\Request;

class TransfertController extends Controller
{
    public function __construct(private TransfertService $transferts)
    {
    }

    /**
     * Chaque paiement réussi (réservation/loyer, forcément en forfait pro)
     * déclenche automatiquement un retrait AangaraaPay vers l'hôtelier/bailleur.
     * Cette page ne sert qu'à traiter les cas où l'automatique n'a pas suffi :
     * pas de contact enregistré, échec, ou retrait resté "en_cours".
     */
    public function index()
    {
        $transferts = Transfert::with(['beneficiaire', 'paiement.payable'])
            ->when(request('statut'), fn ($q, $v) => $q->where('statut', $v))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.transferts.index', compact('transferts'));
    }

    /** Relance un retrait AangaraaPay (contact ajouté après coup, ou échec temporaire). */
    public function reessayer(Transfert $transfert)
    {
        $this->transferts->tenterVersement($transfert);

        return back()->with('success', 'Nouvelle tentative de versement effectuée.');
    }

    /** Interroge AangaraaPay pour un retrait resté "en_cours" côté opérateur. */
    public function verifier(Transfert $transfert)
    {
        $this->transferts->verifierStatut($transfert);

        return back()->with('success', 'Statut vérifié auprès d\'AangaraaPay.');
    }

    /** Garde-fou manuel : le versement a été fait hors AangaraaPay (ex. contact absent). */
    public function marquerEffectue(Request $request, Transfert $transfert)
    {
        $data = $request->validate(['notes' => ['nullable', 'string', 'max:500']]);
        $transfert->update(['notes' => $data['notes'] ?? $transfert->notes]);
        $transfert->marquerEffectue();

        return back()->with('success', 'Transfert marqué comme effectué.');
    }
}

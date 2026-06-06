<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'rendez_vous_id' => 'required|exists:rendez_vouses,id',
            'note'           => 'required|integer|min:1|max:5',
            'commentaire'    => 'nullable|string|max:500',
        ]);

        $rdv = RendezVous::findOrFail($data['rendez_vous_id']);

        // Vérifications de sécurité
        abort_if($rdv->id_client !== Auth::id(), 403);
        abort_if($rdv->etat !== 'terminé', 422, 'Vous ne pouvez noter qu\'un RDV terminé.');
        abort_if($rdv->avis()->exists(), 422, 'Vous avez déjà noté ce rendez-vous.');

        Avis::create([
            'rendez_vous_id' => $rdv->id,
            'id_client'      => Auth::id(),
            'id_coiffeur'    => $rdv->id_coiffeur,
            'note'           => $data['note'],
            'commentaire'    => $data['commentaire'] ?? null,
        ]);

        return back()->with('success', 'Merci pour votre avis !');
    }
}

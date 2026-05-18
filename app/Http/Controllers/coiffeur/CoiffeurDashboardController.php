<?php

namespace App\Http\Controllers\coiffeur;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoiffeurDashboardController extends Controller
{
    public function index()
    {
        $coiffeur_id = Auth::id();

        $rdvs_today = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $coiffeur_id)
            ->where('date', today())
            ->orderBy('heure')
            ->get();

        $rdvs_upcoming = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $coiffeur_id)
            ->where('date', '>', today())
            ->whereIn('etat', ['en attente', 'confirmé'])
            ->orderBy('date')
            ->orderBy('heure')
            ->get();

        $rdvs_history = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $coiffeur_id)
            ->whereIn('etat', ['terminé', 'annulé'])
            ->orderByDesc('date')
            ->limit(20)
            ->get();

        return view('coiffeur.dashboard', compact('rdvs_today', 'rdvs_upcoming', 'rdvs_history'));
    }

    public function updateStatus(RendezVous $rendezVous, Request $request)
    {
        if ($rendezVous->id_coiffeur !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'etat' => 'required|in:confirmé,terminé,annulé',
        ]);

        $rendezVous->update(['etat' => $request->etat]);

        return back()->with('success', 'Statut mis à jour.');
    }
}

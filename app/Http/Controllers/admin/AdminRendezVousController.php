<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;

class AdminRendezVousController extends Controller
{
    public function index()
    {
        $rdvs = RendezVous::with(['client', 'coiffeur', 'services'])
            ->orderByDesc('date')
            ->paginate(15);

        return view('admin.rendez-vous.index', compact('rdvs'));
    }

    public function updateStatus(RendezVous $rendezVous, \Illuminate\Http\Request $request)
    {
        $request->validate([
            'etat' => 'required|in:en attente,confirmé,terminé,annulé',
        ]);

        $rendezVous->update(['etat' => $request->etat]);

        return back()->with('success', 'Statut mis à jour.');
    }

    public function destroy(RendezVous $rendezVous)
    {
        $rendezVous->services()->detach();
        $rendezVous->delete();

        return back()->with('success', 'Rendez-vous supprimé.');
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminRendezVousController extends Controller
{
    public function index()
    {
        $rdvs = RendezVous::with(['client', 'coiffeur', 'services'])
            ->orderByDesc('date')
            ->paginate(15);

        return view('admin.rendez-vous.index', compact('rdvs'));
    }

    public function create()
    {
        $clients   = User::where('role', 'client')->orderBy('name')->get();
        $coiffeurs = User::where('role', 'coiffeur')->orderBy('name')->get();
        $services  = Service::where('state', 'active')->orderBy('name')->get();

        return view('admin.rendez-vous.create', compact('clients', 'coiffeurs', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_client'    => 'nullable|exists:users,id',
            'nom_client'   => 'nullable|string|max:100',
            'id_coiffeur'  => 'required|exists:users,id',
            'service_ids'  => 'required|array|min:1',
            'service_ids.*'=> 'exists:services,id',
            'date'         => 'required|date',
            'heure'        => 'required|regex:/^\d{2}:\d{2}$/',
            'etat'         => 'required|in:en attente,confirmé,terminé,annulé',
        ], [
            'id_coiffeur.required' => 'Veuillez sélectionner un coiffeur.',
            'service_ids.required' => 'Veuillez sélectionner au moins un service.',
            'date.required'        => 'La date est obligatoire.',
            'heure.required'       => 'L\'heure est obligatoire.',
        ]);

        $rdv = RendezVous::create([
            'id_client'   => $request->id_client ?: null,
            'id_coiffeur' => $request->id_coiffeur,
            'date'        => $request->date,
            'heure'       => $request->heure . ':00',
            'etat'        => $request->etat,
        ]);

        $rdv->services()->attach($request->service_ids);

        return redirect()->route('admin.rendez-vous.index')
            ->with('success', 'Rendez-vous créé avec succès.');
    }

    public function updateStatus(RendezVous $rendezVous, Request $request)
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

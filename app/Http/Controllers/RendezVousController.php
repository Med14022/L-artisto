<?php

namespace App\Http\Controllers;

use App\Mail\RendezVousConfirmation;
use App\Models\RendezVous;
use App\Http\Requests\StoreRendezVousRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RendezVousController extends Controller
{
    public function store(StoreRendezVousRequest $request)
    {
        $rdv = RendezVous::create([
            'date'        => $request->date,
            'heure'       => $request->heure . ':00',
            'etat'        => 'en attente',
            'id_client'   => Auth::id(),
            'id_coiffeur' => $request->id_coiffeur,
        ]);

        $rdv->services()->attach($request->service_id);

        $rdv->load(['client', 'coiffeur', 'services']);
        if ($rdv->client?->email) {
            Mail::to($rdv->client->email)->send(new RendezVousConfirmation($rdv));
        }

        return response()->json([
            'success' => true,
            'message' => 'Votre rendez-vous a été créé avec succès ! Un email de confirmation vous a été envoyé.',
        ]);
    }

    public function availableTimes(Request $request)
    {
        $request->validate([
            'coiffeur_id' => 'required|exists:users,id',
            'date'        => 'required|date',
        ]);

        $booked = RendezVous::where('id_coiffeur', $request->coiffeur_id)
            ->where('date', $request->date)
            ->whereIn('etat', ['en attente', 'confirmé'])
            ->pluck('heure')
            ->map(fn($h) => substr($h, 0, 5))
            ->toArray();

        return response()->json($booked);
    }

    public function destroy(RendezVous $rendezVous)
    {
        if ($rendezVous->id_client !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé.'], 403);
        }

        if (!in_array($rendezVous->etat, ['en attente'])) {
            return response()->json(['success' => false, 'message' => 'Impossible d\'annuler ce rendez-vous.'], 422);
        }

        $rendezVous->services()->detach();
        $rendezVous->delete();

        return response()->json(['success' => true, 'message' => 'Rendez-vous annulé.']);
    }
}

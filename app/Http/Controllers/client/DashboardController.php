<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\Service;
use App\Models\Horaire;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        $users = User::where('role', 'like', '%coiffeur%')->get();

        $user_id = Auth::user()->id;
        $rdvs = RendezVous::where('id_client', $user_id)->get();
        return view('dashboard', compact('services', "users", "rdvs"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'stylist_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required|string',
        ]);

        // Vérifier si le créneau horaire est déjà réservé
        $existingAppointment = RendezVous::where('id_coiffeur', $request->stylist_id)
            ->where('date', $request->date)
            ->where('heure', $request->time)
            ->first();

        if ($existingAppointment) {
            return back()->withErrors(['time' => 'Ce créneau horaire est déjà réservé.'])->withInput();
        }


        $rendezVous = new RendezVous();
        $rendezVous->id_client = Auth::user()->id;
        $rendezVous->id_coiffeur = $request->stylist_id;
        $rendezVous->date = $request->date;
        $rendezVous->heure = $request->time;
        $rendezVous->etat = 'en attente';
        $rendezVous->save();

        // Attacher le service via la table pivot (rendez_vous_service)
        // la relation 'services' est définie dans le modèle RendezVous
        $rendezVous->services()->attach($request->service_id);

        // Récupère le service pour connaître la durée (en minutes)
        $service = Service::find($request->service_id);
        $duration = $service ? (int) $service->duration : 0;

        // Calculer l'heure de fin du rendez-vous
        $startTime = Carbon::createFromFormat('H:i', $request->time);
        $endTime = (clone $startTime)->addMinutes($duration);

        // Récupère le record Horaire pour ce coiffeur et cette date
        $horaire = Horaire::where('id_coiffeur', $request->stylist_id)
            ->where('date', $request->date)
            ->first();

        if ($horaire && !empty($horaire->horaire_jour)) {
            $horaire_jour = $horaire->horaire_jour; // ex: "10:00-14:00/15:00-21:00"


            $segments = array_filter(array_map('trim', explode('/', $horaire_jour)));
            $newSegments = [];

            foreach ($segments as $seg) {
                $parts = array_map('trim', explode('-', $seg));
                if (count($parts) !== 2) {
                    continue;
                }

                $segStart = Carbon::createFromFormat('H:i', $parts[0]);
                $segEnd = Carbon::createFromFormat('H:i', $parts[1]);

                // Déterminer l'intersection entre [segStart, segEnd] et [startTime, endTime]
                $overlapStart = $segStart->greaterThan($startTime) ? $segStart : $startTime;
                $overlapEnd = $segEnd->lessThan($endTime) ? $segEnd : $endTime;

                // Pas d'intersection : garder le segment entier
                if ($overlapStart->greaterThanOrEqualTo($overlapEnd)) {
                    $newSegments[] = $segStart->format('H:i') . '-' . $segEnd->format('H:i');
                    continue;
                }

                // Il y a recouvrement : supprimer la portion recouvrée
                // Conserver la partie avant le rendez-vous si elle existe
                if ($segStart->lessThan($overlapStart)) {
                    $newSegments[] = $segStart->format('H:i') . '-' . $overlapStart->format('H:i');
                }

                // Conserver la partie après le rendez-vous si elle existe
                if ($overlapEnd->lessThan($segEnd)) {
                    $newSegments[] = $overlapEnd->format('H:i') . '-' . $segEnd->format('H:i');
                }
            }

            // Recomposer la string sans les créneaux réservés
            $updatedHoraire = implode('/', array_filter($newSegments));

            // Sauvegarder le nouvel horaire
            $horaire->horaire_jour = $updatedHoraire;
            $horaire->save();
        }


        return redirect()->route('home')->with('success', 'Rendez-vous réservé avec succès !');
    }

    /**
     * Retourne les jours (dates) où le coiffeur a des horaires (JSON)
     */
    public function getWorkingDays(Request $request)
    {
        $request->validate([
            'stylist_id' => 'required|exists:users,id',
        ]);

        $days = Horaire::where('id_coiffeur', $request->stylist_id)
            ->orderBy('date')
            ->pluck('date')
            ->toArray();

        return response()->json(['days' => $days]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

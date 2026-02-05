<?php

namespace App\Http\Controllers\Coiffeur;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Horaire; // <-- ajout

class CoifDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        // rendez-vous terminés (tous)
        $rdv_terminer = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $user_id)
            ->where('etat', 'terminer')
            ->get();

        // rendez-vous en attente à venir (date >= aujourd'hui)
        $today = Carbon::today()->toDateString();
        $rdv_enattente = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $user_id)
            ->where('etat', 'en attente')
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('heure')
            ->get();

        // 3 prochains rendez-vous les plus proches (date >= aujourd'hui)
        $rdv_prochain = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $user_id)
            ->where('etat', 'en attente')
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->orderBy('heure')
            ->limit(3)
            ->get();

        $services = DB::table('services')->get();

        // Dates disponibles (groupées) et nombre de créneaux par date
        $available_dates = Horaire::select('date', DB::raw('COUNT(*) as slots_count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Optionnel : structure times par date (pour pré-remplir côté vue)
        $available_times = Horaire::orderBy('date')
            ->get()
            ->groupBy('date')
            ->map(function ($rows) {
                return $rows->pluck('heure')->unique()->values()->toArray(); // ou 'time' selon colonne
            })->toArray();

        // build a simple map: [ id_coiffeur => [ {date, horaire_jour}, ... ] ]
        $horaire_map = Horaire::select('id_coiffeur', 'date', 'horaire_jour')
            ->orderBy('date')
            ->get()
            ->groupBy('id_coiffeur')
            ->map(function ($rows) {
                // unique by date, keep first horaire_jour for a date
                $byDate = [];
                foreach ($rows as $r) {
                    if (!isset($byDate[$r->date])) {
                        $byDate[$r->date] = [
                            'date' => $r->date,
                            'horaire_jour' => $r->horaire_jour,
                        ];
                    }
                }
                return array_values($byDate);
            })->toArray();

        return view('coiffeur.coifdash', compact(
            'rdv_enattente',
            'rdv_terminer',
            'rdv_prochain',
            'services',
            'available_dates',
            'available_times',
            'horaire_map'
        )); // crée la vue ci‑dessous
    }
    public function rdv_par_date(Request $request)
    {
        $user_id = Auth::user()->id;
        $date = $request->input('date');
        $rdv_par_date = RendezVous::with(['client', 'services'])->where('id_coiffeur', $user_id)
            ->where('date', $date)
            ->get();

        return response()->json($rdv_par_date);
    }

    public function storeGuest(Request $request)
    {
        // convert empty strings to null for optional fields BEFORE validation
        $request->merge([
            'client_email' => $request->input('client_email') !== '' ? $request->input('client_email') : null,
            'client_address' => $request->input('client_address') !== '' ? $request->input('client_address') : null,
        ]);

        $data = $request->validate([
            'client_name' => 'required|string|max:150',
            'client_phone' => 'required|string|max:50',
            'client_email' => 'nullable|email|max:150',
            'client_address' => 'nullable|string|max:255',
            'service_id' => 'required|integer|exists:services,id',
            'date' => 'required|date',
            'heure' => 'required|string',
            'coiffeur_id' => 'required|integer|exists:users,id'
        ]);

        DB::beginTransaction();
        try {
            // Create a new client user (guest) without password
            $client = new User();
            $client->name = $data['client_name'];
            $client->phone = $data['client_phone'];
            $client->email = $data['client_email'] ?? ('guest_' . time() . '@artisto.local');
            $client->address = $data['client_address'] ?? '';
            $client->password = bcrypt('guest'); // temporary password
            $client->role = 'client';
            $client->save();

            // Now create the appointment with the client ID
            $rdv = new RendezVous();
            $rdv->date = $data['date'];
            $rdv->heure = $data['heure'];
            $rdv->etat = 'en attente';
            $rdv->id_client = $client->id;
            $rdv->id_coiffeur = $data['coiffeur_id'];
            $rdv->save();

            // attach service: prefer relation, fallback insert pivot
            if (method_exists($rdv, 'services')) {
                $rdv->services()->attach($data['service_id']);
            } else {
                // fallback pivot name: rendez_vous_service with rendez_vous_id
                DB::table('rendez_vous_service')->insert([
                    'rendez_vous_id' => $rdv->id,
                    'service_id' => $data['service_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Update horaire_jour to mark the time slot as booked
            $service = Service::find($data['service_id']);
            $duration = $service ? (int) $service->duration : 0;

            // Calculate appointment end time
            $startTime = Carbon::createFromFormat('H:i', $data['heure']);
            $endTime = (clone $startTime)->addMinutes($duration);

            // Get the Horaire record for this barber and date
            $horaire = Horaire::where('id_coiffeur', $data['coiffeur_id'])
                ->where('date', $data['date'])
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

                    // Determine the intersection between [segStart, segEnd] and [startTime, endTime]
                    $overlapStart = $segStart->greaterThan($startTime) ? $segStart : $startTime;
                    $overlapEnd = $segEnd->lessThan($endTime) ? $segEnd : $endTime;

                    // No intersection: keep the segment as-is
                    if ($overlapStart->greaterThanOrEqualTo($overlapEnd)) {
                        $newSegments[] = $segStart->format('H:i') . '-' . $segEnd->format('H:i');
                        continue;
                    }

                    // There is overlap: remove the overlapping portion
                    // Keep the part before the appointment if it exists
                    if ($segStart->lessThan($overlapStart)) {
                        $newSegments[] = $segStart->format('H:i') . '-' . $overlapStart->format('H:i');
                    }

                    // Keep the part after the appointment if it exists
                    if ($overlapEnd->lessThan($segEnd)) {
                        $newSegments[] = $overlapEnd->format('H:i') . '-' . $segEnd->format('H:i');
                    }
                }

                // Rebuild the string without the booked time slots
                $updatedHoraire = implode('/', array_filter($newSegments));

                // Save the new horaire
                $horaire->horaire_jour = $updatedHoraire;
                $horaire->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'rdv_id' => $rdv->id], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('storeGuest error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Erreur serveur'], 500);
        }
    }
}

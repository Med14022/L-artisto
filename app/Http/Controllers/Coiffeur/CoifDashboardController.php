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
            // calculate and validate duration
            $service = Service::find($data['service_id']);
            $duration = $service ? (int) $service->duration : 0;
            $normalizedHeure = Carbon::parse($data['heure'])->format('H:i');
            $startTime = Carbon::createFromFormat('H:i', $normalizedHeure);
            $endTime = (clone $startTime)->addMinutes($duration);

            // Check horaire availability before creating RDV
            $horaire = Horaire::where('id_coiffeur', $data['coiffeur_id'])
                ->where('date', $data['date'])
                ->first();

            if (!$horaire || empty($horaire->horaire_jour)) {
                return response()->json(['success' => false, 'message' => 'Aucun horaire disponible pour cette date.'], 422);
            }

            $segments = array_filter(array_map('trim', explode('/', $horaire->horaire_jour)));
            $isValid = false;
            foreach ($segments as $seg) {
                if (strpos($seg, '-') === false) {
                    continue;
                }
                [$segStartStr, $segEndStr] = array_map('trim', explode('-', $seg));
                $segStart = Carbon::createFromFormat('H:i', $segStartStr);
                $segEnd = Carbon::createFromFormat('H:i', $segEndStr);

                if ($startTime->greaterThanOrEqualTo($segStart) && $endTime->lessThanOrEqualTo($segEnd)) {
                    $isValid = true;
                    break;
                }
            }

            if (!$isValid) {
                return response()->json(['success' => false, 'message' => 'Le créneau choisi n\'est pas disponible pour ce service.'], 422);
            }

            // Create or reuse client user by email (avoid duplicate email error)
            $clientEmail = $data['client_email'] ?? null;
            if ($clientEmail) {
                $client = User::where('email', $clientEmail)->first();
            } else {
                $client = null;
            }

            if (!$client) {
                $client = new User();
                $client->email = $clientEmail ?? ('guest_' . time() . '@artisto.local');
                $client->password = bcrypt('guest');
            }

            $client->name = $data['client_name'];
            $client->phone = $data['client_phone'];
            $client->address = $data['client_address'] ?? '';
            $client->role = 'client';
            $client->save();

            $rdv = new RendezVous();
            $rdv->date = $data['date'];
            $rdv->heure = $normalizedHeure;
            $rdv->etat = 'en attente';
            $rdv->id_client = $client->id;
            $rdv->id_coiffeur = $data['coiffeur_id'];
            $rdv->save();

            // attach service
            if (method_exists($rdv, 'services')) {
                $rdv->services()->attach($data['service_id']);
            } else {
                DB::table('rendez_vous_service')->insert([
                    'rendez_vous_id' => $rdv->id,
                    'service_id' => $data['service_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // remove slot from horaire_jour
            $newSegments = [];
            foreach ($segments as $seg) {
                if (strpos($seg, '-') === false) {
                    continue;
                }
                [$segStartStr, $segEndStr] = array_map('trim', explode('-', $seg));
                $segStart = Carbon::createFromFormat('H:i', $segStartStr);
                $segEnd = Carbon::createFromFormat('H:i', $segEndStr);

                // no overlap
                if ($endTime->lessThanOrEqualTo($segStart) || $startTime->greaterThanOrEqualTo($segEnd)) {
                    $newSegments[] = $segStart->format('H:i') . '-' . $segEnd->format('H:i');
                    continue;
                }

                // before part
                if ($startTime->greaterThan($segStart)) {
                    $newSegments[] = $segStart->format('H:i') . '-' . $startTime->format('H:i');
                }
                // after part
                if ($endTime->lessThan($segEnd)) {
                    $newSegments[] = $endTime->format('H:i') . '-' . $segEnd->format('H:i');
                }
            }

            $horaire->horaire_jour = implode('/', array_filter($newSegments));
            $horaire->save();

            DB::commit();
            return response()->json(['success' => true, 'rdv_id' => $rdv->id], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('storeGuest error', ['exception' => $e]);
            $msg = config('app.debug') ? $e->getMessage() : 'Erreur serveur';
            return response()->json(['success' => false, 'message' => $msg], 500);
        }
    }
}

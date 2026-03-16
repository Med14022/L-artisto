<?php

namespace App\Http\Controllers;

use App\Models\horaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class HoraireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(horaire $horaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(horaire $horaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, horaire $horaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(horaire $horaire)
    {
        //
    }

    /**
     * Retourne les jours (dates) de travail pour un coiffeur (stylist)
     * Attendu : POST { stylist_id }
     * Réponse : { days: ["2025-11-09","2025-11-10", ...] }
     */
    public function days(Request $request)
    {
        $request->validate(['stylist_id' => 'required|integer']);

        try {
            $stylistId = $request->input('stylist_id');
            $days = Horaire::where('id_coiffeur', $stylistId)
                ->select('date')
                ->distinct()
                ->orderBy('date')
                ->pluck('date')
                ->toArray();

            return response()->json(['days' => $days], 200);
        } catch (\Throwable $e) {
            \Log::error('horaire.days error: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }

    /**
     * Retourne les créneaux disponibles pour un coiffeur et une date
     * Attendu : POST { stylist_id, date, service_duration? }
     * Réponse : { times: ["09:00","09:30", ...] }
     */
    public function hours(Request $request)
    {
        $request->validate([
            'stylist_id' => 'required|integer',
            'date' => 'required|date',
            'service_duration' => 'nullable|integer'
        ]);

        try {
            $stylistId = $request->input('stylist_id');
            $date = $request->input('date');
            $serviceDuration = $request->input('service_duration');

            $horaire = Horaire::where('id_coiffeur', $stylistId)
                ->where('date', $date)
                ->first();
            if (!$horaire || empty($horaire->horaire_jour)) {
                return response()->json(['times' => []], 200);
            }
            $slots = [];
            foreach (explode('/', $horaire->horaire_jour) as $period) {
                $period = trim($period);
                if (!$period)
                    continue;
                if (strpos($period, '-') === false)
                    continue;
                [$start, $end] = array_map('trim', explode('-', $period));
                try {
                    $startMinutes = Carbon::createFromFormat('H:i', $start)->hour * 60 + Carbon::createFromFormat('H:i', $start)->minute;
                    $endMinutes = Carbon::createFromFormat('H:i', $end)->hour * 60 + Carbon::createFromFormat('H:i', $end)->minute;
                } catch (\Throwable $ex) {
                    continue;
                }
                for ($m = $startMinutes; $m + 1 <= $endMinutes; $m += 30) {
                    $time = sprintf('%02d:%02d', intdiv($m, 60), $m % 60);
                    if ($serviceDuration && is_numeric($serviceDuration)) {
                        $endAppt = $m + (int) $serviceDuration;
                        if ($endAppt > $endMinutes) {
                            continue;
                        }
                    }
                    $slots[] = $time;
                }
            }
            $times = array_values(array_unique($slots));
            return response()->json(['times' => $times], 200);
        } catch (\Throwable $e) {
            \Log::error('horaire.hours error: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }
}

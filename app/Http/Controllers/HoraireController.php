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

    public function hours(Request $request)
    {
        $request->validate([
            'stylist_id' => 'required|integer',
            'date' => 'required|date',
            'service_duration' => 'nullable|integer|min:1' // minutes
        ]);

        $stylistId = $request->input('stylist_id');
        $date = $request->input('date');
        $serviceDuration = (int) $request->input('service_duration', 30); // default 30 minutes
        $step = 30; // pas entre départs (30 minutes)

        $horaire = DB::table('horaires')
            ->where('id_coiffeur', $stylistId)
            ->where('date', $date)
            ->first();

        if (!$horaire || empty($horaire->horaire_jour)) {
            return response()->json(['times' => []]);
        }

        $intervals = explode('/', $horaire->horaire_jour); // ex: "10:00-12:00/14:00-17:00"
        $slots = [];

        foreach ($intervals as $interval) {
            $parts = explode('-', $interval);
            if (count($parts) !== 2)
                continue;

            try {
                $start = Carbon::createFromFormat('H:i', trim($parts[0]));
                $end = Carbon::createFromFormat('H:i', trim($parts[1]));
            } catch (\Exception $e) {
                continue;
            }

            // tant que start + serviceDuration <= end
            while ($start->copy()->addMinutes($serviceDuration)->lte($end)) {
                $slots[] = $start->format('H:i');
                $start->addMinutes($step);
            }
        }

        // Optionnel : filtrer les créneaux déjà réservés ici

        return response()->json(['times' => array_values(array_unique($slots))]);
    }
}

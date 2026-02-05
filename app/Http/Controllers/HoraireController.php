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
            $days = Horaire::where('stylist_id', $stylistId)
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

            $times = Horaire::where('stylist_id', $stylistId)
                ->where('date', $date)
                ->orderBy('heure') // ou 'time' selon ta colonne
                ->pluck('heure')   // ajuste selon le nom de colonne
                ->unique()
                ->values()
                ->toArray();

            return response()->json(['times' => $times], 200);
        } catch (\Throwable $e) {
            \Log::error('horaire.hours error: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }
}

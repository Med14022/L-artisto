<?php

namespace App\Http\Controllers\coiffeur;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoiffeurExportController extends Controller
{
    public function pdfJour(Request $request)
    {
        $date      = $request->get('date', today()->toDateString());
        $coiffeurId = Auth::id();

        $rdvs = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $coiffeurId)
            ->where('date', $date)
            ->orderBy('heure')
            ->get();

        $coiffeur  = Auth::user();
        $dateLabel = Carbon::parse($date)->locale('fr')->isoFormat('dddd D MMMM YYYY');

        $pdf = Pdf::loadView('exports.coiffeur-jour', compact('rdvs', 'coiffeur', 'date', 'dateLabel'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("planning-{$date}.pdf");
    }

    public function pdfSemaine(Request $request)
    {
        $debut      = Carbon::parse($request->get('debut', today()->startOfWeek()->toDateString()));
        $fin        = $debut->copy()->endOfWeek();
        $coiffeurId = Auth::id();

        $rdvs = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $coiffeurId)
            ->whereBetween('date', [$debut->toDateString(), $fin->toDateString()])
            ->orderBy('date')->orderBy('heure')
            ->get()
            ->groupBy('date');

        $coiffeur = Auth::user();

        $pdf = Pdf::loadView('exports.coiffeur-semaine', compact('rdvs', 'coiffeur', 'debut', 'fin'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("planning-semaine-{$debut->format('d-m-Y')}.pdf");
    }
}

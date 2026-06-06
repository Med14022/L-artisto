<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminExportController extends Controller
{
    public function pdfMensuel(Request $request)
    {
        $mois  = $request->get('mois', now()->format('Y-m'));
        $debut = Carbon::parse($mois . '-01');
        $fin   = $debut->copy()->endOfMonth();

        $rdvs = RendezVous::with(['client', 'coiffeur', 'services'])
            ->whereBetween('date', [$debut->toDateString(), $fin->toDateString()])
            ->orderBy('date')->orderBy('heure')
            ->get();

        $stats = [
            'total'     => $rdvs->count(),
            'termines'  => $rdvs->where('etat', 'terminé')->count(),
            'confirmes' => $rdvs->where('etat', 'confirmé')->count(),
            'annules'   => $rdvs->where('etat', 'annulé')->count(),
        ];

        $moisLabel = $debut->locale('fr')->isoFormat('MMMM YYYY');

        $pdf = Pdf::loadView('exports.admin-mensuel', compact('rdvs', 'stats', 'moisLabel', 'mois'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("rapport-{$mois}.pdf");
    }

    public function csv(Request $request)
    {
        $mois  = $request->get('mois', now()->format('Y-m'));
        $debut = Carbon::parse($mois . '-01');
        $fin   = $debut->copy()->endOfMonth();

        $rdvs = RendezVous::with(['client', 'coiffeur', 'services'])
            ->whereBetween('date', [$debut->toDateString(), $fin->toDateString()])
            ->orderBy('date')->orderBy('heure')
            ->get();

        $filename = "rdv-{$mois}.csv";

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rdvs) {
            $out = fopen('php://output', 'w');
            // BOM UTF-8 pour Excel
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($out, ['ID', 'Date', 'Heure', 'Client', 'Coiffeur', 'Service(s)', 'Statut'], ';');

            foreach ($rdvs as $rdv) {
                fputcsv($out, [
                    $rdv->id,
                    Carbon::parse($rdv->date)->format('d/m/Y'),
                    substr($rdv->heure, 0, 5),
                    $rdv->client->name ?? '—',
                    $rdv->coiffeur->name ?? '—',
                    $rdv->services->pluck('name')->join(', ') ?: '—',
                    $rdv->etat,
                ], ';');
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}

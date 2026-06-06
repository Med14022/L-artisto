<?php

namespace App\Http\Controllers\coiffeur;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use App\Models\RendezVous;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoiffeurDashboardController extends Controller
{
    public function index()
    {
        $coiffeur_id = Auth::id();

        $rdvs_today = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $coiffeur_id)
            ->where('date', today())
            ->orderBy('heure')
            ->get();

        $rdvs_upcoming = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $coiffeur_id)
            ->where('date', '>', today())
            ->whereIn('etat', ['en attente', 'confirmé'])
            ->orderBy('date')
            ->orderBy('heure')
            ->get();

        $rdvs_history = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $coiffeur_id)
            ->whereIn('etat', ['terminé', 'annulé'])
            ->orderByDesc('date')
            ->limit(20)
            ->get();

        // Données FullCalendar : fenêtre de 2 mois passés + 3 mois à venir
        $rdvs_calendar = RendezVous::with(['client', 'services'])
            ->where('id_coiffeur', $coiffeur_id)
            ->whereBetween('date', [
                Carbon::now()->subMonths(2)->startOfMonth()->toDateString(),
                Carbon::now()->addMonths(3)->endOfMonth()->toDateString(),
            ])
            ->get()
            ->map(function ($rdv) {
                $colors = [
                    'en attente' => ['bg' => '#D4AF37', 'border' => '#B8860B'],
                    'confirmé'   => ['bg' => '#4ade80', 'border' => '#22c55e'],
                    'terminé'    => ['bg' => '#818cf8', 'border' => '#6366f1'],
                    'annulé'     => ['bg' => '#f87171', 'border' => '#ef4444'],
                ];
                $c = $colors[$rdv->etat] ?? ['bg' => '#7a7060', 'border' => '#555'];

                return [
                    'id'              => $rdv->id,
                    'title'           => ($rdv->client->name ?? 'Invité') . ' — ' . substr($rdv->heure, 0, 5),
                    'start'           => $rdv->date . 'T' . $rdv->heure,
                    'backgroundColor' => $c['bg'],
                    'borderColor'     => $c['border'],
                    'textColor'       => in_array($rdv->etat, ['en attente']) ? '#0a0a0a' : '#ffffff',
                    'extendedProps'   => [
                        'client'   => $rdv->client->name ?? 'Invité',
                        'services' => $rdv->services->pluck('name')->join(', ') ?: '—',
                        'etat'     => $rdv->etat,
                        'heure'    => substr($rdv->heure, 0, 5),
                        'rdv_id'   => $rdv->id,
                    ],
                ];
            });

        $avis = Avis::with('client')
            ->where('id_coiffeur', $coiffeur_id)
            ->latest()
            ->take(10)
            ->get();

        $note_moyenne = $avis->avg('note');

        return view('coiffeur.dashboard', compact(
            'rdvs_today', 'rdvs_upcoming', 'rdvs_history', 'rdvs_calendar',
            'avis', 'note_moyenne'
        ));
    }

    public function updateStatus(RendezVous $rendezVous, Request $request)
    {
        if ($rendezVous->id_coiffeur !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'etat' => 'required|in:confirmé,terminé,annulé',
        ]);

        $rendezVous->update(['etat' => $request->etat]);

        return back()->with('success', 'Statut mis à jour.');
    }
}

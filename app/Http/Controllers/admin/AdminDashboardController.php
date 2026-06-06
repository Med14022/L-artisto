<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_clients'   => User::where('role', 'client')->count(),
            'total_coiffeurs' => User::where('role', 'coiffeur')->count(),
            'total_services'  => Service::count(),
            'rdv_en_attente'  => RendezVous::where('etat', 'en attente')->count(),
            'rdv_confirmes'   => RendezVous::where('etat', 'confirmé')->count(),
            'rdv_termines'    => RendezVous::where('etat', 'terminé')->count(),
        ];

        $recent_rdvs = RendezVous::with(['client', 'coiffeur', 'services'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // ── Graphique 1 : RDV par mois (6 derniers mois) ──────────────────
        $rdvParMois = collect(range(5, 0))->map(function ($i) {
            $mois = Carbon::now()->subMonths($i);
            return [
                'label' => $mois->locale('fr')->isoFormat('MMM YYYY'),
                'count' => RendezVous::whereYear('date', $mois->year)
                    ->whereMonth('date', $mois->month)
                    ->count(),
            ];
        });

        // ── Graphique 2 : Répartition des statuts ─────────────────────────
        $rdvParStatut = RendezVous::select('etat', DB::raw('COUNT(*) as total'))
            ->groupBy('etat')
            ->pluck('total', 'etat');

        // ── Graphique 3 : Top 5 services les plus demandés ────────────────
        $topServices = DB::table('rendez_vous_service')
            ->join('services', 'services.id', '=', 'rendez_vous_service.service_id')
            ->select('services.name', DB::raw('COUNT(*) as total'))
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // ── Graphique 4 : RDV par coiffeur ────────────────────────────────
        $rdvParCoiffeur = RendezVous::join('users', 'users.id', '=', 'rendez_vouses.id_coiffeur')
            ->select('users.name', DB::raw('COUNT(*) as total'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_rdvs',
            'rdvParMois',
            'rdvParStatut',
            'topServices',
            'rdvParCoiffeur'
        ));
    }
}

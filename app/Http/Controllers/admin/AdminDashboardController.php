<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\Service;
use App\Models\User;

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

        return view('admin.dashboard', compact('stats', 'recent_rdvs'));
    }
}

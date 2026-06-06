<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')
            ->withCount('rendezVousClient as total_rdv')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.clients.index', compact('clients'));
    }

    public function show(User $user)
    {
        abort_if($user->role !== 'client', 404);

        $rdvs = RendezVous::with(['coiffeur', 'services'])
            ->where('id_client', $user->id)
            ->orderByDesc('date')
            ->get();

        $stats = [
            'total'     => $rdvs->count(),
            'termines'  => $rdvs->where('etat', 'terminé')->count(),
            'confirmes' => $rdvs->where('etat', 'confirmé')->count(),
            'annules'   => $rdvs->where('etat', 'annulé')->count(),
            'en_attente'=> $rdvs->where('etat', 'en attente')->count(),
        ];

        // Service le plus demandé
        $servicesFavori = DB::table('rendez_vous_service')
            ->join('services', 'services.id', '=', 'rendez_vous_service.service_id')
            ->join('rendez_vouses', 'rendez_vouses.id', '=', 'rendez_vous_service.rendez_vous_id')
            ->where('rendez_vouses.id_client', $user->id)
            ->select('services.name', DB::raw('COUNT(*) as total'))
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('total')
            ->first();

        // Coiffeur le plus consulté
        $coiffeurFavori = $rdvs->groupBy('id_coiffeur')
            ->map->count()
            ->sortDesc()
            ->keys()
            ->first();
        $coiffeurFavori = $coiffeurFavori ? User::find($coiffeurFavori) : null;

        return view('admin.clients.show', compact('user', 'rdvs', 'stats', 'servicesFavori', 'coiffeurFavori'));
    }
}

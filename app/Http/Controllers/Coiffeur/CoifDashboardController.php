<?php

namespace App\Http\Controllers\Coiffeur;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use Auth;
use Illuminate\Http\Request;

class CoifDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $rdv_terminer = RendezVous::where('id_coiffeur', $user_id)->where('etat','terminer')->get();
        $rdv_enattente = RendezVous::where('id_coiffeur', $user_id)->where('etat','en attente')->get();

        return view('coiffeur.coifdash',compact('rdv_enattente','rdv_terminer')); // crée la vue ci‑dessous
    }
}

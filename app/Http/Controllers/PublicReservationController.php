<?php

namespace App\Http\Controllers;

use App\Mail\RendezVousConfirmation;
use App\Models\RendezVous;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicReservationController extends Controller
{
    public function index()
    {
        $services  = Service::where('state', 'active')->orderBy('name')->get();
        $coiffeurs = User::where('role', 'coiffeur')->orderBy('name')->get();

        return view('reservation-publique', compact('services', 'coiffeurs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:100',
            'telephone'   => 'required|string|max:20',
            'email'       => 'nullable|email|max:150',
            'id_coiffeur' => 'required|exists:users,id',
            'service_id'  => 'required|exists:services,id',
            'date'        => 'required|date|after_or_equal:today',
            'heure'       => 'required|regex:/^\d{2}:\d{2}$/',
        ], [
            'nom.required'         => 'Votre nom est obligatoire.',
            'telephone.required'   => 'Votre téléphone est obligatoire.',
            'id_coiffeur.required' => 'Veuillez choisir un coiffeur.',
            'service_id.required'  => 'Veuillez choisir un service.',
            'date.required'        => 'La date est obligatoire.',
            'date.after_or_equal'  => 'La date doit être aujourd\'hui ou dans le futur.',
            'heure.required'       => 'L\'heure est obligatoire.',
        ]);

        // Vérifier que le créneau n'est pas déjà pris
        $conflit = RendezVous::where('id_coiffeur', $data['id_coiffeur'])
            ->where('date', $data['date'])
            ->where('heure', $data['heure'] . ':00')
            ->whereIn('etat', ['en attente', 'confirmé'])
            ->exists();

        if ($conflit) {
            return back()->withInput()
                ->withErrors(['heure' => 'Ce créneau est déjà réservé. Veuillez en choisir un autre.']);
        }

        $rdv = RendezVous::create([
            'id_client'   => null,
            'id_coiffeur' => $data['id_coiffeur'],
            'date'        => $data['date'],
            'heure'       => $data['heure'] . ':00',
            'etat'        => 'en attente',
        ]);

        $rdv->services()->attach($data['service_id']);

        // Email de confirmation si l'invité a fourni son email
        if (!empty($data['email'])) {
            $rdv->load(['coiffeur', 'services']);
            // On crée un objet client factice pour le template
            $rdv->setRelation('client', (object)[
                'name'  => $data['nom'],
                'email' => $data['email'],
            ]);
            try {
                Mail::to($data['email'])->send(new RendezVousConfirmation($rdv));
            } catch (\Throwable) {}
        }

        return redirect()->route('reserver.confirmation')->with([
            'rdv_nom'      => $data['nom'],
            'rdv_date'     => Carbon::parse($data['date'])->locale('fr')->isoFormat('dddd D MMMM YYYY'),
            'rdv_heure'    => $data['heure'],
            'rdv_coiffeur' => User::find($data['id_coiffeur'])->name,
        ]);
    }

    public function confirmation()
    {
        if (! session()->has('rdv_nom')) {
            return redirect()->route('reserver');
        }
        return view('reservation-confirmation');
    }
}

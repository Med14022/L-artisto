<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Horaire;
use App\Models\User;
use Illuminate\Http\Request;

class AdminHoraireController extends Controller
{
    public function index(Request $request)
    {
        $coiffeurs  = User::where('role', 'coiffeur')->orderBy('name')->get();
        $coiffeurId = $request->get('coiffeur_id', $coiffeurs->first()?->id);

        $horaires = Horaire::where('id_coiffeur', $coiffeurId)
            ->orderBy('date')
            ->get();

        $coiffeurSelectionne = $coiffeurs->firstWhere('id', $coiffeurId);

        return view('admin.horaires.index', compact('coiffeurs', 'horaires', 'coiffeurId', 'coiffeurSelectionne'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_coiffeur' => 'required|exists:users,id',
            'dates'       => 'required|array|min:1',
            'dates.*'     => 'required|date',
            'segments'    => 'required|array|min:1',
            'segments.*.start' => 'required|date_format:H:i',
            'segments.*.end'   => 'required|date_format:H:i|after:segments.*.start',
        ], [
            'dates.required'           => 'Sélectionnez au moins une date.',
            'segments.required'        => 'Ajoutez au moins un créneau horaire.',
            'segments.*.end.after'     => 'L\'heure de fin doit être après l\'heure de début.',
        ]);

        $horaireJour = collect($data['segments'])
            ->map(fn($s) => $s['start'] . '-' . $s['end'])
            ->implode('/');

        foreach ($data['dates'] as $date) {
            Horaire::updateOrCreate(
                ['id_coiffeur' => $data['id_coiffeur'], 'date' => $date],
                ['horaire_jour' => $horaireJour]
            );
        }

        return redirect()->route('admin.horaires.index', ['coiffeur_id' => $data['id_coiffeur']])
            ->with('success', count($data['dates']) . ' jour(s) ajouté(s) avec succès.');
    }

    public function update(Request $request, Horaire $horaire)
    {
        $data = $request->validate([
            'segments'         => 'required|array|min:1',
            'segments.*.start' => 'required|date_format:H:i',
            'segments.*.end'   => 'required|date_format:H:i',
        ]);

        $horaireJour = collect($data['segments'])
            ->map(fn($s) => $s['start'] . '-' . $s['end'])
            ->implode('/');

        $horaire->update(['horaire_jour' => $horaireJour]);

        return back()->with('success', 'Horaire mis à jour.');
    }

    public function destroy(Horaire $horaire)
    {
        $coiffeurId = $horaire->id_coiffeur;
        $horaire->delete();

        return redirect()->route('admin.horaires.index', ['coiffeur_id' => $coiffeurId])
            ->with('success', 'Journée supprimée.');
    }
}

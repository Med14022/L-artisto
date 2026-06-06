<?php

namespace App\Console\Commands;

use App\Mail\RendezVousRappel;
use App\Models\RendezVous;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnvoyerRappelsRdv extends Command
{
    protected $signature   = 'rdv:rappels';
    protected $description = 'Envoie les rappels email 24h avant chaque rendez-vous';

    public function handle(): int
    {
        $demain = Carbon::tomorrow()->toDateString();

        $rdvs = RendezVous::with(['client', 'coiffeur', 'services'])
            ->where('date', $demain)
            ->whereIn('etat', ['en attente', 'confirmé'])
            ->get();

        if ($rdvs->isEmpty()) {
            $this->info("Aucun rendez-vous demain ({$demain}).");
            return self::SUCCESS;
        }

        $envoyes = 0;
        foreach ($rdvs as $rdv) {
            if (! $rdv->client?->email) continue;

            Mail::to($rdv->client->email)->send(new RendezVousRappel($rdv));
            $envoyes++;
            $this->line("  → Rappel envoyé à {$rdv->client->email} ({$rdv->heure})");
        }

        $this->info("✓ {$envoyes} rappel(s) envoyé(s) pour le {$demain}.");
        return self::SUCCESS;
    }
}

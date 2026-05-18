<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Service;
use App\Models\RendezVous;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@artisto.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '22000000',
            'address'  => 'Tunis',
        ]);

        // Coiffeurs
        $coiffeurs = [
            ['name' => 'Mohamed Ali',    'email' => 'ali@artisto.com',    'address' => 'Spécialiste coupe classique'],
            ['name' => 'Karim Bensalem', 'email' => 'karim@artisto.com',  'address' => 'Expert dégradé et barbe'],
            ['name' => 'Youssef Trabelsi','email' => 'youssef@artisto.com','address' => 'Styliste cheveux longs'],
        ];

        foreach ($coiffeurs as $c) {
            User::create(array_merge($c, [
                'password' => Hash::make('password'),
                'role'     => 'coiffeur',
                'phone'    => '2100' . rand(1000, 9999),
            ]));
        }

        // Clients
        $clients = [
            ['name' => 'Ahmed Boudabous', 'email' => 'ahmed@client.com'],
            ['name' => 'Slim Gharbi',     'email' => 'slim@client.com'],
            ['name' => 'Nabil Mansour',   'email' => 'nabil@client.com'],
        ];

        foreach ($clients as $c) {
            User::create(array_merge($c, [
                'password' => Hash::make('password'),
                'role'     => 'client',
                'phone'    => '2200' . rand(1000, 9999),
                'address'  => 'Tunis',
            ]));
        }

        // Services
        $services = [
            ['name' => 'Coupe Homme',       'price' => 15, 'duration' => 30, 'description' => 'Coupe classique pour homme, tondeuse et ciseaux.',   'state' => 'active'],
            ['name' => 'Dégradé Américain', 'price' => 20, 'duration' => 40, 'description' => 'Dégradé précis avec finitions soignées.',              'state' => 'active'],
            ['name' => 'Barbe & Rasage',    'price' => 12, 'duration' => 25, 'description' => 'Taille de barbe et rasage au rasoir classique.',       'state' => 'active'],
            ['name' => 'Coupe + Barbe',     'price' => 25, 'duration' => 55, 'description' => 'Pack complet coupe homme et barbe.',                   'state' => 'active'],
            ['name' => 'Coloration Homme',  'price' => 35, 'duration' => 60, 'description' => 'Coloration professionnelle adaptée aux hommes.',       'state' => 'active'],
            ['name' => 'Soin Capillaire',   'price' => 18, 'duration' => 45, 'description' => 'Masque hydratant et massage du cuir chevelu.',         'state' => 'active'],
        ];

        foreach ($services as $s) {
            Service::create($s);
        }

        // Rendez-vous de démonstration
        $clientIds   = User::where('role', 'client')->pluck('id')->toArray();
        $coiffeurIds = User::where('role', 'coiffeur')->pluck('id')->toArray();
        $serviceIds  = Service::pluck('id')->toArray();

        $rdvSamples = [
            ['date' => now()->toDateString(),             'heure' => '10:00:00', 'etat' => 'confirmé'],
            ['date' => now()->toDateString(),             'heure' => '11:30:00', 'etat' => 'en attente'],
            ['date' => now()->addDays(2)->toDateString(), 'heure' => '14:00:00', 'etat' => 'en attente'],
            ['date' => now()->subDays(3)->toDateString(), 'heure' => '09:30:00', 'etat' => 'terminé'],
            ['date' => now()->subDays(7)->toDateString(), 'heure' => '15:00:00', 'etat' => 'terminé'],
        ];

        foreach ($rdvSamples as $i => $rdvData) {
            $rdv = RendezVous::create([
                'date'        => $rdvData['date'],
                'heure'       => $rdvData['heure'],
                'etat'        => $rdvData['etat'],
                'id_client'   => $clientIds[$i % count($clientIds)],
                'id_coiffeur' => $coiffeurIds[$i % count($coiffeurIds)],
            ]);
            $rdv->services()->attach($serviceIds[$i % count($serviceIds)]);
        }
    }
}

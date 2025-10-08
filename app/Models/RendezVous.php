<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;
    protected $fillable = [

        'date',
        'heure',
        'etat',
        'id_client',
        'id_coiffeur',
    ];

    protected $table = 'rendez_vouses';

    public function services()
    {
        return $this->belongsToMany(Service::class, 'rendez_vous_service', 'rendez_vous_id', 'service_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }

    public function coiffeur()
    {
        return $this->belongsTo(User::class, 'id_coiffeur');
    }
}

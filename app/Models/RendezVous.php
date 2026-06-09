<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $date
 * @property string $heure
 * @property string $etat
 * @property int $id_client
 * @property int $id_coiffeur
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class RendezVous extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'heure',
        'etat',
        'id_client',
        'id_coiffeur',
        'nom_client',
        'telephone_client',
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

    public function avis()
    {
        return $this->hasOne(Avis::class, 'rendez_vous_id');
    }
}

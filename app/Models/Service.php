<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'duration',
        'description',
        'state',
        'image',
    ];
    public function rendezVous()
    {
        return $this->belongsToMany(RendezVous::class, 'rendez_vous_service', 'service_id', 'rendez_vous_id');
    }
}

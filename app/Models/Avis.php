<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = ['rendez_vous_id', 'id_client', 'id_coiffeur', 'note', 'commentaire'];

    public function client()    { return $this->belongsTo(User::class, 'id_client'); }
    public function coiffeur()  { return $this->belongsTo(User::class, 'id_coiffeur'); }
    public function rendezVous(){ return $this->belongsTo(RendezVous::class, 'rendez_vous_id'); }
}

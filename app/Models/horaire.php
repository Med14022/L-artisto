<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    use HasFactory;

    protected $table = 'horaires';

    protected $fillable = [
        'id_coiffeur',
        'date',
        'horaire_jour',
    ];

    public function coiffeur()
    {
        return $this->belongsTo(User::class, 'id');
    }
}

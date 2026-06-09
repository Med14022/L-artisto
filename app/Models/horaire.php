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
        return $this->belongsTo(User::class, 'id_coiffeur');
    }

    /** Retourne les segments [['start'=>'09:00','end'=>'13:00'], ...] */
    public function getSegmentsAttribute(): array
    {
        if (empty($this->horaire_jour)) return [];

        return collect(explode('/', $this->horaire_jour))
            ->filter()
            ->map(fn($seg) => array_map('trim', explode('-', $seg)))
            ->filter(fn($p) => count($p) === 2)
            ->map(fn($p) => ['start' => $p[0], 'end' => $p[1]])
            ->values()
            ->toArray();
    }
}

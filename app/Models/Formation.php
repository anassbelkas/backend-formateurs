<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'nombreDeJours',
        'tarifsParJours',
        'nombreDeParticipant',
        'modalites',
        'publicConcerne',
        'lieuFormation',
        'dureeFormation',
        'dateDebut',
        'dateFin',
        'horaireDebut',
        'horaireFin'
    ];
    public function quality(){
        return $this->hasOne(Quality::class);
    }
}

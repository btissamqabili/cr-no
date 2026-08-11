<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Creneau extends Model
{
    use HasFactory;
    protected $table = 'creneaux';

    protected $fillable = ['date', 'heure_debut', 'duree'];

    protected $casts = [
        'date' => 'date',
    ];

    // Un créneau peut avoir un rendez-vous
    public function rendezVous()
    {
        return $this->hasOne(RendezVous::class);
    }

    // Scope : créneaux disponibles (pas encore réservés + pas passés)
    public function scopeDisponibles($query)
    {
        return $query->whereDoesntHave('rendezVous')
                     ->where(function ($q) {
                         $q->where('date', '>', now()->toDateString())
                           ->orWhere(function ($q2) {
                               $q2->where('date', '=', now()->toDateString())
                                  ->where('heure_debut', '>', now()->format('H:i:s'));
                           });
                     });
    }

    // Vérifier si le créneau est passé
    public function estPasse(): bool
    {
        $dateHeure = Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->heure_debut);
        return $dateHeure->isPast();
    }
}
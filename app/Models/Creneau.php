<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Creneau extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'heure_debut',
        'duree',
    ];

    /**
     * Les rendez-vous liés à ce créneau.
     */
    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }


    
  public function scopeDisponibles(Builder $query): Builder
{
    return $query
        ->whereRaw(
            "TIMESTAMP(date, heure_debut) >= ?",
            [now()]
        )
        ->whereDoesntHave('rendezVous', function ($query) {
            $query->whereIn('statut', [
                'en_attente',
                'confirme',
            ]);
        });
}

    /**
     * Scope : récupérer les créneaux déjà passés.
     */
    public function scopePasses(Builder $query): Builder
    {
        return $query->whereRaw(
            "TIMESTAMP(date, heure_debut) < ?",
            [now()]
        );
    }

   
    public static function chevauche(
        string $date,
        string $heureDebut,
        int $duree
    ): bool {
        $nouveauDebut = Carbon::parse("$date $heureDebut");

        $nouvelleFin = $nouveauDebut
            ->copy()
            ->addMinutes($duree);

        return self::whereDate('date', $date)
            ->get()
            ->contains(function (Creneau $creneau) use (
                $nouveauDebut,
                $nouvelleFin
            ) {
                $debutExistant = Carbon::parse(
                    $creneau->date . ' ' . $creneau->heure_debut
                );

                $finExistante = $debutExistant
                    ->copy()
                    ->addMinutes($creneau->duree);

                return $nouveauDebut < $finExistante
                    && $nouvelleFin > $debutExistant;
            });
    }
}
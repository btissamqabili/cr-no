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
    protected $table = 'creneaux';

    protected $fillable = [
        'date',
        'heure_debut',
        'duree',
    ];


       protected $casts = [
        'date' => 'date',
    ];

    /**
     * Les rendez-vous liés à ce créneau.
     */
    public function rendezVous(): HasMany
    {
        return $this->hasMany(RendezVous::class);
    }

    /**
     * Scope : récupérer uniquement les créneaux futurs disponibles.
     */
    public function scopeDisponibles(Builder $query): Builder
    {
        return $query
            ->whereRaw(
                "TIMESTAMP(date, heure_debut) >= ?",
                [now()]
            )
            ->whereDoesntHave('rendezVous');
    }

    /**
     * Scope : récupérer les créneaux déjà passés.
     */
    /**
 * Vérifie si le créneau est passé.
 */
public function estPasse(): bool
{
    return Carbon::parse(
        $this->date->format('Y-m-d') . ' ' . $this->heure_debut
    )->isPast();
}
    public function scopePasses(Builder $query): Builder
    {
        return $query->whereRaw(
            "TIMESTAMP(date, heure_debut) < ?",
            [now()]
        );
    }

    /**
     * Vérifie si un nouveau créneau chevauche
     * un créneau existant.
     */
  public static function chevauche(
    string $date,
    string $heureDebut,
    int $duree,
    ?int $excludeId = null
): bool {

    $nouveauDebut = Carbon::parse($date)
        ->setTimeFromTimeString($heureDebut);

    $nouvelleFin = $nouveauDebut
        ->copy()
        ->addMinutes($duree);

    $query = self::whereDate('date', $date);

    if ($excludeId !== null) {
        $query->where('id', '!=', $excludeId);
    }

    return $query->get()->contains(function (Creneau $creneau) use (
        $nouveauDebut,
        $nouvelleFin
    ) {

        $debutExistant = Carbon::parse($creneau->date)
            ->setTimeFromTimeString($creneau->heure_debut);

        $finExistante = $debutExistant
            ->copy()
            ->addMinutes($creneau->duree);

        return $nouveauDebut < $finExistante
            && $nouvelleFin > $debutExistant;
    });

}
}
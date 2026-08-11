<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    protected $fillable = [
        'user_id',
        'creneau_id',
        'statut',
    ];

    /**
     * Le client propriétaire du rendez-vous.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Le créneau réservé.
     */
    public function creneau(): BelongsTo
    {
        return $this->belongsTo(Creneau::class);
    }
}
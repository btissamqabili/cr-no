<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    protected $fillable = ['user_id', 'creneau_id', 'statut'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creneau()
    {
        return $this->belongsTo(Creneau::class);
    }
}
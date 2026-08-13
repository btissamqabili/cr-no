<?php

namespace Tests\Unit;

use App\Models\Creneau;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class RendezVousTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_creneau_ne_peut_pas_etre_reserve_deux_fois(): void
    {
        $client1 = User::factory()->create([
            'role' => 'client',
        ]);

        $client2 = User::factory()->create([
            'role' => 'client',
        ]);

        $creneau = Creneau::factory()->create([
            'date' => '2026-08-20',
            'heure_debut' => '10:00:00',
            'duree' => 60,
        ]);

        RendezVous::factory()->create([
            'user_id' => $client1->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        $this->expectException(QueryException::class);

        RendezVous::factory()->create([
            'user_id' => $client2->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);
    }
}
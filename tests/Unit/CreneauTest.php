<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Creneau;
use Tests\TestCase;

class CreneauTest extends TestCase
{
    use RefreshDatabase;
    public function test_un_creneau_passe_est_detecte(): void
    {
        $creneau = new Creneau([
            'date' => now()->subDay()->toDateString(),
            'heure_debut' => '10:00:00',
            'duree' => 60,
        ]);

        $this->assertTrue($creneau->estPasse());
    }
    public function test_un_creneau_futur_n_est_pas_passe(): void
{
    $creneau = new Creneau([
        'date' => now()->addDay()->toDateString(),
        'heure_debut' => '10:00:00',
        'duree' => 60,
    ]);

    $this->assertFalse($creneau->estPasse());
}
public function test_un_nouveau_creneau_qui_chevauche_un_creneau_existant_est_detecte(): void
{
    Creneau::factory()->create([
        'date' => '2026-08-20',
        'heure_debut' => '10:00:00',
        'duree' => 60,
    ]);

    $chevauche = Creneau::chevauche(
        '2026-08-20',
        '10:30:00',
        60
    );

    $this->assertTrue($chevauche);
}

public function test_deux_creneaux_qui_se_suivent_ne_se_chevauchent_pas(): void
{
    Creneau::factory()->create([
        'date' => '2026-08-20',
        'heure_debut' => '10:00:00',
        'duree' => 60,
    ]);

    $chevauche = Creneau::chevauche(
        '2026-08-20',
        '11:00:00',
        60
    );

    $this->assertFalse($chevauche);
}
public function test_un_creneau_completement_dans_un_autre_est_un_chevauchement(): void
{
    Creneau::factory()->create([
        'date' => '2026-08-20',
        'heure_debut' => '10:00:00',
        'duree' => 120,
    ]);

    $chevauche = Creneau::chevauche(
        '2026-08-20',
        '10:30:00',
        60
    );

    $this->assertTrue($chevauche);
}
}
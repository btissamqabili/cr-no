<?php

namespace Tests\Feature;

use App\Models\Creneau;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_client_ne_peut_pas_annuler_le_rendez_vous_d_un_autre_client(): void
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

        $rendezVous = RendezVous::factory()->create([
            'user_id' => $client1->id,
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        $response = $this
            ->actingAs($client2)
            ->delete(route('client.annuler', $rendezVous));

        $response->assertForbidden();

        $this->assertEquals(
            'en_attente',
            $rendezVous->fresh()->statut
        );
    }
    public function test_un_creneau_passe_ne_peut_pas_etre_reserve(): void
{
    $client = User::factory()->create([
        'role' => 'client',
    ]);

    $creneau = Creneau::factory()->create([
        'date' => now()->subDay()->toDateString(),
        'heure_debut' => '10:00:00',
        'duree' => 60,
    ]);

    $response = $this
        ->actingAs($client)
        ->post(route('client.reserver'), [
            'creneau_id' => $creneau->id,
        ]);

    $response->assertSessionHas('error', 'Ce créneau n\'est plus disponible.');

    $this->assertDatabaseMissing('rendez_vous', [
        'user_id' => $client->id,
        'creneau_id' => $creneau->id,
    ]);
}
public function test_un_visiteur_ne_peut_pas_reserver_un_creneau(): void
{
    $creneau = Creneau::factory()->create([
        'date' => now()->addDay()->toDateString(),
        'heure_debut' => '10:00:00',
        'duree' => 60,
    ]);

    $response = $this->post(route('client.reserver'), [
        'creneau_id' => $creneau->id,
    ]);

    $response->assertRedirect();

    $this->assertDatabaseMissing('rendez_vous', [
        'creneau_id' => $creneau->id,
    ]);
}
public function test_un_client_peut_reserver_un_creneau_libre(): void
{
    $client = User::factory()->create([
        'role' => 'client',
    ]);

    $creneau = Creneau::factory()->create([
        'date' => now()->addDay()->toDateString(),
        'heure_debut' => '10:00:00',
        'duree' => 60,
    ]);

    $response = $this
        ->actingAs($client)
        ->post(route('client.reserver'), [
            'creneau_id' => $creneau->id,
        ]);

    $response->assertRedirect(route('client.mes-rdv'));

    $this->assertDatabaseHas('rendez_vous', [
        'user_id' => $client->id,
        'creneau_id' => $creneau->id,
        'statut' => 'en_attente',
    ]);
}
public function test_un_client_peut_annuler_son_propre_rendez_vous(): void
{
    $client = User::factory()->create([
        'role' => 'client',
    ]);

    $creneau = Creneau::factory()->create([
        'date' => now()->addDay()->toDateString(),
        'heure_debut' => '10:00:00',
        'duree' => 60,
    ]);

    $rendezVous = RendezVous::factory()->create([
        'user_id' => $client->id,
        'creneau_id' => $creneau->id,
        'statut' => 'en_attente',
    ]);

    $response = $this
        ->actingAs($client)
        ->delete(route('client.annuler', $rendezVous));

    $response->assertSessionHas(
        'success',
        'Rendez-vous annulé.'
    );

    $this->assertDatabaseHas('rendez_vous', [
        'id' => $rendezVous->id,
        'statut' => 'annule',
    ]);
}
public function test_un_creneau_ne_peut_etre_reserve_qu_une_seule_fois(): void
{
    $client1 = User::factory()->create([
        'role' => 'client',
    ]);

    $client2 = User::factory()->create([
        'role' => 'client',
    ]);

    $creneau = Creneau::factory()->create([
        'date' => now()->addDay()->toDateString(),
        'heure_debut' => '10:00:00',
        'duree' => 60,
    ]);

    // Première réservation
    $this->actingAs($client1)
        ->post(route('client.reserver'), [
            'creneau_id' => $creneau->id,
        ]);

    // Deuxième réservation sur le même créneau
    $response = $this->actingAs($client2)
        ->post(route('client.reserver'), [
            'creneau_id' => $creneau->id,
        ]);

    $response->assertSessionHas(
        'error',
        'Ce créneau n\'est plus disponible.'
    );

    // Vérifier qu'il n'existe qu'une seule réservation
    $this->assertDatabaseCount('rendez_vous', 1);
}
}
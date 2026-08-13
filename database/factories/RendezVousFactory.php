<?php

namespace Database\Factories;

use App\Models\RendezVous;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RendezVous>
 */
class RendezVousFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
     return [
    'user_id' => \App\Models\User::factory(),
    'creneau_id' => \App\Models\Creneau::factory(),
    'statut' => 'en_attente',
];
    }
}

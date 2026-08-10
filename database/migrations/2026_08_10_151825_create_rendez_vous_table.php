<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // On force le nom de la table "creneaux"
            $table->foreignId('creneau_id')->constrained('creneaux')->onDelete('cascade');
            
            $table->string('statut')->default('en_attente'); // en_attente, confirme, annule
            $table->timestamps();

            $table->unique('creneau_id'); // Un créneau ne peut être réservé qu'une seule fois
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendez_vous');
    }
};
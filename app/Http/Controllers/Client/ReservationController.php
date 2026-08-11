<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Creneau;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Liste des créneaux disponibles
    public function index()
    {
        $creneaux = Creneau::disponibles()->orderBy('date')->orderBy('heure_debut')->get();
        return view('client.creneaux.index', compact('creneaux'));
    }

    // Réserver un créneau
    public function store(Request $request)
    {
        $request->validate([
            'creneau_id' => 'required|exists:creneaux,id',
        ]);

        $creneau = Creneau::findOrFail($request->creneau_id);

        // Sécurité : créneau déjà réservé ou passé
        if ($creneau->rendezVous || $creneau->estPasse()) {
            return back()->with('error', 'Ce créneau n\'est plus disponible.');
        }

        // Créer le rendez-vous
        RendezVous::create([
            'user_id' => Auth::id(),
            'creneau_id' => $creneau->id,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('client.mes-rdv')->with('success', 'Rendez-vous réservé avec succès !');
    }

    // Mes rendez-vous
    public function mesRendezVous()
    {
        $rendezVous = Auth::user()->rendezVous()->with('creneau')->latest()->get();
        return view('client.rendez-vous.index', compact('rendezVous'));
    }

    // Annuler mon rendez-vous
    public function cancel(RendezVous $rendezVous)
    {
        // Sécurité : on ne peut annuler que ses propres RDV
        if ($rendezVous->user_id !== Auth::id()) {
            abort(403);
        }

        $rendezVous->update(['statut' => 'annule']);
        // ou $rendezVous->delete(); si tu préfères supprimer

        return back()->with('success', 'Rendez-vous annulé.');
    }
}
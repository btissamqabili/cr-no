<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Creneau;

class CreneauController extends Controller
{

    public function index()
{
    $creneaux = Creneau::orderBy('date')
        ->orderBy('heure_debut')
        ->get();

    return view('admin.creneaux.index', compact('creneaux'));
}


    public function create()
    {
         return view('admin.creneaux.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'date' => ['required', 'date', 'after_or_equal:today'],
        'heure_debut' => ['required', 'date_format:H:i'],
        'duree' => ['required', 'integer', 'min:1'],
    ]);

    if (
        Creneau::chevauche(
            $validated['date'],
            $validated['heure_debut'],
            $validated['duree']
        )
    ) {
        return back()
            ->withInput()
            ->withErrors([
                'heure_debut' => 'Ce créneau chevauche un créneau existant.'
            ]);
    }

    Creneau::create($validated);

    return redirect()
        ->route('admin.creneaux.index')
        ->with('success', 'Créneau ajouté avec succès.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Creneau $creneau)
{
    return view('admin.creneaux.edit', compact('creneau'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Creneau $creneau)
{
    $validated = $request->validate([
        'date' => ['required', 'date', 'after_or_equal:today'],
        'heure_debut' => ['required', 'date_format:H:i'],
        'duree' => ['required', 'integer', 'min:1'],
    ]);

    if (
        Creneau::chevauche(
            $validated['date'],
            $validated['heure_debut'],
            $validated['duree'],
            $creneau->id
        )
    ) {
        return back()
            ->withInput()
            ->withErrors([
                'heure_debut' => 'Ce créneau chevauche un créneau existant.'
            ]);
    }

    $creneau->update($validated);

    return redirect()
        ->route('admin.creneaux.index')
        ->with('success', 'Créneau modifié avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $creneau = Creneau::findOrFail($id);

    $creneau->delete();

    return redirect()
        ->route('admin.creneaux.index')
        ->with('success', 'Créneau supprimé avec succès.');
}
}

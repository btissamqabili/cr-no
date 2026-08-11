<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;

class DashboardController extends Controller
{
    public function index()
    {
        $rendezVous = RendezVous::with(['user', 'creneau'])
            ->latest()
            ->get();

        return view('admin.dashboard', compact('rendezVous'));
    }
}
<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:client');
    }

    /**
     * Display a listing of the user's pets.
     */
    public function index()
    {
        $pets = Pet::where('owner_id', auth()->id())
            ->latest()
            ->paginate(10);
        
        return view('client.pets.index', compact('pets'));
    }

    /**
     * Display the specified pet.
     */
    public function show(Pet $pet)
    {
        // Verificar que el usuario autenticado es el dueño de la mascota
        if ($pet->owner_id !== auth()->id()) {
            abort(403, 'No tienes permisos para ver esta mascota.');
        }

        $pet->load('owner');
        return view('client.pets.show', compact('pet'));
    }
}

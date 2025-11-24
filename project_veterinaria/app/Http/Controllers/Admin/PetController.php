<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with('owner')->latest()->paginate(10);
        return view('admin.pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $owners = User::role('client')->where('is_active', true)->get();
        return view('admin.pets.create', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'owner_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        Pet::create($data);

        return redirect()
            ->route('admin.pets.index')
            ->with('success', 'Mascota creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        $pet->load('owner');
        return view('admin.pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        $owners = User::role('client')->where('is_active', true)->get();
        return view('admin.pets.edit', compact('pet', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'owner_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $pet->update($data);

        return redirect()
            ->route('admin.pets.index')
            ->with('success', 'Mascota actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()
            ->route('admin.pets.index')
            ->with('success', 'Mascota eliminada correctamente.');
    }
}

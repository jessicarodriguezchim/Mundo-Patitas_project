<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        // Permitir acceso a cualquier usuario autenticado para ver su propio perfil
        // El middleware 'auth' ya está aplicado en el grupo de rutas
    }

    /**
     * Display the user's profile information.
     */
    public function show()
    {
        $user = auth()->user();
        return view('client.profile.show', compact('user'));
    }
}

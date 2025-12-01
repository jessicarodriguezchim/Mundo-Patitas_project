<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controlador ProfileController para Clientes
 * 
 * Este controlador maneja la visualización del perfil del usuario autenticado.
 * Cualquier usuario autenticado puede ver su propio perfil, independientemente de su rol.
 * 
 * Funcionalidad:
 * - Mostrar información del perfil del usuario autenticado
 * - Acceso a través de Jetstream para edición (manejado por Jetstream automáticamente)
 * 
 * Protección: Requiere autenticación (middleware 'auth' aplicado en routes/web.php)
 */
class ProfileController extends Controller
{
    /**
     * Constructor del controlador
     * 
     * El middleware 'auth' ya está aplicado en el grupo de rutas en web.php,
     * por lo que no necesitamos agregarlo aquí. Cualquier usuario autenticado
     * puede acceder a su perfil.
     */
    public function __construct()
    {
        // Permitir acceso a cualquier usuario autenticado para ver su propio perfil
        // El middleware 'auth' ya está aplicado en el grupo de rutas
        // No necesitamos protección adicional aquí ya que todos pueden ver su propio perfil
    }

    /**
     * Muestra la información del perfil del usuario autenticado (GET /client/profile)
     * 
     * Obtiene el usuario autenticado y muestra su información de perfil.
     * La vista incluye la capacidad de editar el perfil a través de Jetstream.
     * 
     * @return \Illuminate\View\View Vista con la información del perfil
     */
    public function show()
    {
        // Obtener el usuario actualmente autenticado
        $user = auth()->user();
        
        // Pasar el usuario a la vista para mostrar su información
        return view('client.profile.show', compact('user'));
    }
}

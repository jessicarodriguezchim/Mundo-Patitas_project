<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

/**
 * Controlador PetController para Clientes
 * 
 * Este controlador maneja las operaciones relacionadas con mascotas
 * desde la perspectiva de los clientes (dueños de mascotas).
 * 
 * Diferencias con Admin\PetController:
 * - Los clientes solo pueden VER sus propias mascotas (no crear/editar/eliminar)
 * - Solo muestra mascotas donde el usuario autenticado es el dueño
 * - Incluye verificación de seguridad adicional
 * 
 * Protección: Requiere autenticación y rol 'client' (definido en routes/web.php)
 */
class PetController extends Controller
{
    /**
     * Lista las mascotas del usuario autenticado (GET /client/pets)
     * 
     * Muestra todas las mascotas que pertenecen al cliente autenticado.
     * Utiliza filtrado automático para mostrar solo sus propias mascotas.
     * 
     * @return \Illuminate\View\View Vista con el listado de mascotas del cliente
     */
    public function index()
    {
        // where('owner_id', auth()->id()) filtra solo las mascotas del usuario autenticado
        // auth()->id() obtiene el ID del usuario que está actualmente logueado
        // Esto asegura que los clientes solo vean SUS propias mascotas
        $pets = Pet::where('owner_id', auth()->id())
            ->latest()              // Ordenar por fecha de creación (más recientes primero)
            ->paginate(10);         // Dividir en páginas de 10 mascotas
        
        return view('client.pets.index', compact('pets'));
    }

    /**
     * Muestra los detalles de una mascota específica (GET /client/pets/{pet})
     * 
     * Muestra la información detallada de una mascota, pero solo si
     * el usuario autenticado es el dueño. Incluye verificación de seguridad.
     * 
     * @param Pet $pet Mascota a mostrar (Laravel lo resuelve automáticamente por el ID)
     * @return \Illuminate\View\View Vista con los detalles de la mascota
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Si el usuario no es el dueño
     */
    public function show(Pet $pet)
    {
        // Verificación de seguridad adicional
        // Aunque las rutas están protegidas, verificamos explícitamente que
        // el usuario autenticado sea el dueño de la mascota
        // Esto previene acceso no autorizado incluso si hay un bug en las rutas
        if ($pet->owner_id !== auth()->id()) {
            // Si no es el dueño, abortar con error 403 (Forbidden)
            abort(403, 'No tienes permisos para ver esta mascota.');
        }

        // Cargar la relación del dueño para mostrar su información en la vista
        $pet->load('owner');
        
        return view('client.pets.show', compact('pet'));
    }
}

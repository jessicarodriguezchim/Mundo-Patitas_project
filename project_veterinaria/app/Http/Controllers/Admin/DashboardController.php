<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Controlador DashboardController - Panel de administración
 * 
 * Este controlador maneja la vista principal del panel de administración.
 * Muestra estadísticas generales del sistema y información resumida.
 * 
 * Acceso: Solo usuarios con rol 'admin' o 'staff'
 * 
 * Funcionalidad:
 * - Muestra estadísticas del sistema (usuarios, mascotas, etc.)
 * - Lista las mascotas más recientes
 * - Proporciona una vista general de la actividad
 */
class DashboardController extends Controller
{
    /**
     * Muestra el dashboard administrativo (GET /admin)
     * 
     * Recolecta estadísticas del sistema y las pasa a la vista:
     * - Total de mascotas registradas
     * - Total de usuarios
     * - Usuarios activos
     * - Cantidad de clientes y personal
     * - Últimas 5 mascotas registradas
     * 
     * @return \Illuminate\View\View Vista del dashboard con estadísticas
     */
    public function index()
    {
        // Obtener el usuario autenticado (puede ser útil para personalizar la vista)
        $user = auth()->user();
        
        // Recolectar estadísticas generales del sistema
        $stats = [
            // Total de mascotas registradas en el sistema
            'total_pets' => Pet::count(),
            
            // Total de usuarios (todos los roles)
            'total_users' => User::count(),
            
            // Usuarios activos (is_active = true)
            // Útil para ver cuántos usuarios están realmente activos
            'active_users' => User::where('is_active', true)->count(),
            
            // Total de clientes (usuarios con rol 'client')
            // role('client') es un scope de Spatie Permission
            'total_clients' => User::role('client')->count(),
            
            // Total de personal (usuarios con rol 'staff')
            'total_staff' => User::role('staff')->count(),
            
            // Últimas 5 mascotas registradas con información de sus dueños
            // with('owner') carga la relación del dueño (eager loading)
            // latest() ordena por fecha de creación descendente
            // take(5) limita a 5 resultados
            'recent_pets' => Pet::with('owner')->latest()->take(5)->get(),
        ];
        
        // Pasar las estadísticas y el usuario a la vista
        return view('admin.dashboard', compact('stats', 'user'));
    }
}

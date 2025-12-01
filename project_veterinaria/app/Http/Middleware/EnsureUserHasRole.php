<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware EnsureUserHasRole
 * 
 * Este middleware protege las rutas verificando que el usuario autenticado
 * tenga al menos uno de los roles requeridos.
 * 
 * Funcionamiento:
 * 1. Verifica que el usuario esté autenticado
 * 2. Extrae los roles requeridos de los parámetros del middleware
 * 3. Verifica si el usuario tiene al menos uno de los roles requeridos
 * 4. Si no tiene permisos:
 *    - Clientes son redirigidos amigablemente a su panel
 *    - Otros usuarios reciben un error 403
 * 5. Si tiene permisos, permite que la solicitud continúe
 * 
 * Uso en rutas:
 * Route::get('/admin/users')->middleware('role:admin');
 * Route::get('/admin/pets')->middleware('role:admin,staff');
 */
class EnsureUserHasRole
{
    /**
     * Maneja una solicitud entrante
     * 
     * Este método se ejecuta automáticamente cuando se aplica el middleware
     * a una ruta. Recibe los roles requeridos como parámetros.
     * 
     * @param Request $request La solicitud HTTP entrante
     * @param Closure $next Función que continúa con la siguiente capa del middleware
     * @param string ...$roles Roles requeridos (puede recibir múltiples roles)
     * @return Response Respuesta HTTP (redirección o continuación)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Verificar si el usuario está autenticado
        // Si no está autenticado, redirigir al login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Obtener el usuario autenticado
        $user = auth()->user();

        // Procesar los roles requeridos
        // Los roles pueden venir como "admin,staff" (string con comas) o como parámetros separados
        $rolesArray = [];
        foreach ($roles as $role) {
            // Separar por comas si vienen juntos (ej: "admin,staff" → ["admin", "staff"])
            $rolesArray = array_merge($rolesArray, explode(',', $role));
        }
        
        // Limpiar espacios en blanco y remover valores vacíos
        $rolesArray = array_map('trim', $rolesArray);
        $rolesArray = array_filter($rolesArray);

        // Verificar si el usuario tiene al menos uno de los roles requeridos
        // hasAnyRole() es un método de Spatie Permission que verifica múltiples roles
        if (empty($rolesArray) || !$user->hasAnyRole($rolesArray)) {
            // Obtener los roles actuales del usuario
            $userRoles = $user->roles->pluck('name')->toArray();
            
            // Manejo especial para clientes que intentan acceder a rutas de admin/staff
            // En lugar de mostrar error 403, los redirigimos amigablemente a su panel
            if (in_array('client', $userRoles) && 
                (in_array('admin', $rolesArray) || in_array('staff', $rolesArray))) {
                return redirect()->route('client.pets.index')
                    ->with('error', 'No tienes permisos para acceder al panel de administración.');
            }
            
            // Para otros casos (admin/staff intentando acceder a rutas de admin, etc.)
            // Mostrar error 403 con mensaje descriptivo
            $userRolesString = implode(', ', $userRoles);
            $requiredRoles = implode(', ', $rolesArray);
            abort(403, "No tienes permisos para acceder a esta sección. Requieres uno de estos roles: {$requiredRoles}. Tu rol actual: " . ($userRolesString ?: 'Ninguno'));
        }

        // Si el usuario tiene los permisos necesarios, continuar con la solicitud
        // $next($request) pasa la solicitud al siguiente middleware o al controlador
        return $next($request);
    }
}

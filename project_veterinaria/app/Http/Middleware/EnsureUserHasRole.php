<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Si los roles vienen como string separado por comas (ej: "admin,staff"), dividirlos
        $rolesArray = [];
        foreach ($roles as $role) {
            $rolesArray = array_merge($rolesArray, explode(',', $role));
        }
        $rolesArray = array_map('trim', $rolesArray);
        $rolesArray = array_filter($rolesArray);

        // Verificar si el usuario tiene al menos uno de los roles requeridos
        if (empty($rolesArray) || !$user->hasAnyRole($rolesArray)) {
            $userRoles = $user->roles->pluck('name')->toArray();
            
            // Si el usuario es cliente e intenta acceder a rutas de admin/staff, redirigirlo a su panel
            if (in_array('client', $userRoles) && (in_array('admin', $rolesArray) || in_array('staff', $rolesArray))) {
                return redirect()->route('client.pets.index')
                    ->with('error', 'No tienes permisos para acceder al panel de administración.');
            }
            
            // Para otros casos, mostrar el error 403
            $userRolesString = implode(', ', $userRoles);
            $requiredRoles = implode(', ', $rolesArray);
            abort(403, "No tienes permisos para acceder a esta sección. Requieres uno de estos roles: {$requiredRoles}. Tu rol actual: " . ($userRolesString ?: 'Ninguno'));
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador LogoutController - Manejo del cierre de sesión
 * 
 * Este controlador maneja el proceso de logout de usuarios.
 * Implementa el patrón "Single Action Controller" usando __invoke(),
 * lo que significa que toda la clase actúa como un solo método.
 * 
 * Funcionalidad:
 * - Cierra la sesión del usuario autenticado
 * - Invalida la sesión actual (elimina todos los datos de sesión)
 * - Regenera el token CSRF para prevenir ataques
 * - Redirige al formulario de login
 * 
 * Uso: Se llama cuando el usuario hace clic en "Cerrar sesión"
 */
class LogoutController extends Controller
{
    /**
     * Maneja la solicitud de cierre de sesión
     * 
     * Este método se ejecuta automáticamente cuando se llama al controlador
     * (gracias a __invoke()). Realiza todas las acciones necesarias para
     * cerrar la sesión de forma segura.
     * 
     * Proceso:
     * 1. Cierra la sesión del usuario
     * 2. Invalida todos los datos de la sesión
     * 3. Regenera el token CSRF (protección contra ataques)
     * 4. Redirige al login
     * 
     * @param Request $request Solicitud HTTP entrante
     * @return \Illuminate\Http\RedirectResponse Redirección al formulario de login
     */
    public function __invoke(Request $request)
    {
        // Cerrar la sesión del usuario autenticado
        // Esto elimina la autenticación del usuario actual
        Auth::logout();
        
        // Invalidar completamente la sesión actual
        // Elimina todos los datos almacenados en la sesión
        $request->session()->invalidate();
        
        // Regenerar el token CSRF
        // Esto es importante por seguridad: previene ataques CSRF
        // al generar un nuevo token que el usuario deberá usar en el próximo login
        $request->session()->regenerateToken();
        
        // Redirigir al formulario de login
        // Después del logout, el usuario debe iniciar sesión nuevamente
        return redirect()->route('login');
    }
}

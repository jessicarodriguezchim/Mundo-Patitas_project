<?php

/**
 * Archivo de Rutas Web Principales
 * 
 * Este archivo contiene todas las rutas públicas y autenticadas de la aplicación.
 * Laravel usa este archivo para definir cómo se responden las solicitudes HTTP.
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\PetController as ClientPetController;
use App\Http\Controllers\Client\ProfileController as ClientProfileController;
use App\Http\Controllers\Auth\LogoutController;

/**
 * Ruta Raíz del Sitio (GET /)
 * 
 * Esta es la primera ruta que se ejecuta cuando alguien visita el sitio.
 * Redirige automáticamente a los usuarios según su estado de autenticación y rol:
 * 
 * - Usuarios autenticados con rol admin/staff → Panel administrativo
 * - Usuarios autenticados con rol client → Panel de cliente (sus mascotas)
 * - Usuarios no autenticados → Página de login
 * 
 * Esto asegura que cada usuario llegue directamente a su área correspondiente.
 */
Route::get('/', function () {
    // Verificar si el usuario está autenticado
    if (auth()->check()) {
        $user = auth()->user();
        
        // Redirigir según el rol del usuario usando el método hasRole() de Spatie Permission
        if ($user->hasRole('admin') || $user->hasRole('staff')) {
            // Administradores y personal van al panel administrativo
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('client')) {
            // Clientes van directamente a ver sus mascotas
            return redirect()->route('client.pets.index');
        }
        
        // Si el usuario está autenticado pero no tiene un rol asignado,
        // redirigir al dashboard general que manejará la situación
        return redirect()->route('dashboard');
    }
    
    // Si no está autenticado, redirigir al formulario de login
    return redirect()->route('login');
});

/**
 * Ruta Personalizada de Logout (POST /logout)
 * 
 * Esta ruta maneja el cierre de sesión de usuarios.
 * Se define antes de las rutas de Fortify para tener control personalizado
 * sobre el comportamiento del logout.
 * 
 * Middleware:
 * - 'web': Establece la sesión y cookies
 * - 'auth': Solo usuarios autenticados pueden hacer logout
 */
Route::post('/logout', LogoutController::class)
    ->middleware(['web', 'auth'])
    ->name('logout');

/**
 * Grupo de Rutas Protegidas (Requieren Autenticación)
 * 
 * Todas las rutas dentro de este grupo requieren:
 * - Usuario autenticado (auth:sanctum)
 * - Sesión de Jetstream válida
 * - Email verificado (verified)
 * 
 * Estas rutas son accesibles solo para usuarios que han completado
 * el proceso de registro y verificación de email.
 */
Route::middleware([
    'auth:sanctum',                    // Autenticación con Sanctum
    config('jetstream.auth_session'),  // Configuración de sesión de Jetstream
    'verified',                        // Usuario debe tener email verificado
])->group(function () {
    
    /**
     * Ruta del Dashboard General (GET /dashboard)
     * 
     * Esta ruta actúa como un "hub" que redirige a los usuarios
     * a su área correspondiente según su rol.
     * 
     * - Admin/Staff → Panel administrativo
     * - Client → Listado de sus mascotas
     * - Sin rol → Vista genérica del dashboard
     */
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Redirigir según el rol del usuario
        if ($user->hasRole('admin') || $user->hasRole('staff')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('client')) {
            return redirect()->route('client.pets.index');
        }
        
        // Si no tiene rol definido, mostrar dashboard genérico
        return view('dashboard');
    })->name('dashboard');

    /**
     * Ruta de Perfil de Cliente (GET /client/profile)
     * 
     * Cualquier usuario autenticado puede ver su propio perfil.
     * El prefijo 'client' y el nombre 'client.' se agregan automáticamente.
     */
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/profile', [ClientProfileController::class, 'show'])->name('profile.show');
    });

    /**
     * Grupo de Rutas Solo para Clientes
     * 
     * Estas rutas están restringidas a usuarios con rol 'client'.
     * Los clientes solo pueden ver su propia información.
     * 
     * Rutas creadas:
     * - GET /client/pets         → index() - Listar las mascotas del cliente autenticado
     * - GET /client/pets/{id}    → show()  - Ver detalles de una de sus mascotas
     * 
     * Nota: only(['index', 'show']) limita las rutas solo a listar y ver,
     * no pueden crear, editar o eliminar (eso lo hace admin/staff)
     */
    Route::middleware('role:client')->prefix('client')->name('client.')->group(function () {
        Route::resource('pets', ClientPetController::class)
            ->only(['index', 'show'])
            ->names('pets');
    });

    /**
     * Endpoint API para Búsqueda de Usuarios/Clientes
     * 
     * GET /api/users/search?q=termino
     * 
     * Esta ruta proporciona una API para buscar clientes mientras
     * se está creando o editando una mascota.
     * 
     * Acceso: Solo usuarios con rol 'admin' o 'staff'
     * 
     * Parámetros:
     * - q (query): Término de búsqueda (mínimo 2 caracteres)
     * 
     * Retorna: JSON con lista de usuarios clientes activos que coincidan
     * 
     * Búsqueda por:
     * - Nombre (name)
     * - Email
     * - Número de identificación (id_number)
     */
    Route::middleware('role:admin,staff')->get('/api/users/search', function (Request $request) {
        // Obtener el término de búsqueda del parámetro 'q'
        $query = $request->get('q', '');
        
        // Si la búsqueda tiene menos de 2 caracteres, retornar array vacío
        // Esto evita búsquedas demasiado generales que podrían ser costosas
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        // Buscar usuarios con rol 'client' que estén activos
        // y que coincidan con el término de búsqueda en nombre, email o ID
        $users = \App\Models\User::role('client')  // Solo usuarios con rol 'client'
            ->where('is_active', true)              // Solo usuarios activos
            ->where(function($q) use ($query) {
                // Buscar en nombre, email o número de identificación
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('id_number', 'like', "%{$query}%");
            })
            ->limit(10)                             // Limitar a 10 resultados máximo
            ->get(['id', 'name', 'email', 'id_number']);  // Solo obtener campos necesarios
        
        // Retornar resultados en formato JSON
        return response()->json($users);
    });
});


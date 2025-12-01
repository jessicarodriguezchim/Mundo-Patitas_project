<?php

/**
 * Archivo de Rutas Administrativas
 * 
 * Este archivo contiene todas las rutas del panel de administración.
 * Todas las rutas aquí definidas están protegidas con middleware de autenticación
 * y verificación de roles.
 * 
 * Estructura:
 * - Todas las rutas tienen el prefijo '/admin' (definido en RouteServiceProvider)
 * - Se agrupan según los permisos requeridos
 * - Se utilizan Route::resource para crear rutas RESTful automáticas
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PetController;

/**
 * Ruta del Dashboard Administrativo
 * 
 * GET /admin/
 * 
 * Acceso: Solo usuarios con rol 'admin' o 'staff'
 * Función: Muestra el panel principal del administrador
 */
Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('role:admin,staff');

/**
 * Grupo de Rutas Solo para Administradores
 * 
 * Estas rutas solo pueden ser accedidas por usuarios con rol 'admin'.
 * Incluyen la gestión de roles y usuarios del sistema.
 * 
 * Rutas creadas automáticamente con Route::resource:
 * - GET    /admin/roles         → index()   - Listar roles
 * - GET    /admin/roles/create  → create()  - Formulario crear rol
 * - POST   /admin/roles         → store()   - Guardar nuevo rol
 * - GET    /admin/roles/{id}    → show()    - Ver detalles de rol
 * - GET    /admin/roles/{id}/edit → edit()  - Formulario editar rol
 * - PUT    /admin/roles/{id}    → update()  - Actualizar rol
 * - DELETE /admin/roles/{id}    → destroy() - Eliminar rol
 * 
 * Lo mismo aplica para /admin/users
 */
Route::middleware('role:admin')->group(function () {
    // Gestión de roles y permisos
    Route::resource('roles', RoleController::class)->names('roles');
    
    // Gestión de usuarios del sistema
    Route::resource('users', UserController::class)->names('users');
});

/**
 * Grupo de Rutas para Administradores y Staff
 * 
 * Estas rutas pueden ser accedidas tanto por 'admin' como por 'staff'.
 * Incluyen la gestión de mascotas.
 * 
 * Rutas creadas automáticamente con Route::resource:
 * - GET    /admin/pets         → index()   - Listar mascotas
 * - GET    /admin/pets/create  → create()  - Formulario crear mascota
 * - POST   /admin/pets         → store()   - Guardar nueva mascota
 * - GET    /admin/pets/{id}    → show()    - Ver detalles de mascota
 * - GET    /admin/pets/{id}/edit → edit()  - Formulario editar mascota
 * - PUT    /admin/pets/{id}    → update()  - Actualizar mascota
 * - DELETE /admin/pets/{id}    → destroy() - Eliminar mascota
 */
Route::middleware('role:admin,staff')->group(function () {
    // Gestión de mascotas (CRUD completo)
    Route::resource('pets', PetController::class)->names('pets');
});
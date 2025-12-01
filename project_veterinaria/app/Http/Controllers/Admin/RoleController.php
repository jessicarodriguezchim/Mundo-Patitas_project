<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

/**
 * Controlador RoleController - Gestión de roles y permisos
 * 
 * Este controlador maneja todas las operaciones CRUD para los roles del sistema.
 * Permite a los administradores crear, editar y eliminar roles personalizados.
 * 
 * Funcionalidades:
 * - Listar todos los roles (manejado por Livewire Table)
 * - Crear nuevos roles personalizados
 * - Editar roles existentes (con protección de roles del sistema)
 * - Eliminar roles (con protección de roles del sistema)
 * 
 * Protección de roles del sistema:
 * Los roles 'admin', 'staff' y 'client' están protegidos y no se pueden editar ni eliminar,
 * ya que son esenciales para el funcionamiento del sistema.
 * 
 * Protección: Solo accesible para usuarios con rol 'admin'
 */
class RoleController extends BaseController
{
    /**
     * Constructor del controlador
     * 
     * Protege todas las rutas con middleware que verifica el rol 'admin'.
     */
    public function __construct()
    {
        // Solo usuarios con rol 'admin' pueden gestionar roles
        $this->middleware('role:admin');
    }

    /**
     * Muestra el listado de roles (GET /admin/roles)
     * 
     * La vista utiliza Livewire Tables para mostrar y gestionar los roles
     * de forma interactiva sin recargar la página.
     * 
     * @return \Illuminate\View\View Vista con la tabla de roles (Livewire)
     */
    public function index()
    {
        // La vista utiliza un componente Livewire que maneja la tabla de roles
        // Esto permite funcionalidades como búsqueda, ordenamiento, y paginación
        return view('admin.roles.index');
    }

    /**
     * Muestra el formulario para crear un nuevo rol (GET /admin/roles/create)
     * 
     * @return \Illuminate\View\View Vista con el formulario de creación
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Guarda un nuevo rol en la base de datos (POST /admin/roles)
     * 
     * Valida que el nombre del rol sea único, crea el rol y muestra
     * una notificación de éxito usando SweetAlert.
     * 
     * @param Request $request Datos del formulario (nombre del rol)
     * @return \Illuminate\Http\RedirectResponse Redirección al listado con notificación
     */
    public function store(Request $request)
    {
        // Validar que el nombre del rol sea obligatorio y único en la tabla roles
        $request->validate(['name' => 'required|unique:roles,name']);

        // Si pasa la validación, crear el nuevo rol
        Role::create([
            'name' => $request->name,        // Nombre del rol (ej: 'veterinario', 'recepcionista')
            'guard_name' => 'web'            // Guard de autenticación (web para aplicaciones web)
        ]);
        
        // Crear notificación usando SweetAlert (swal)
        // session()->flash() almacena datos en la sesión para un solo uso
        // Estos datos se mostrarán en la vista usando JavaScript
        session()->flash('swal', 
        [
            'icon' => 'success',                                  // Tipo de ícono (success, error, warning, info)
            'title' => 'Rol creado correctamente',                // Título de la notificación
            'text' => 'El rol ha sido creado exitosamente',       // Mensaje descriptivo
        ]);
        
        // Redirigir al listado de roles con mensaje adicional
        return redirect()->route('admin.roles.index')->with('success', 'Role created succesfully');
    }

    /**
     * Muestra los detalles de un rol específico (GET /admin/roles/{role})
     * 
     * No implementado actualmente. Podría usarse para mostrar:
     * - Información del rol
     * - Lista de usuarios con ese rol
     * - Permisos asignados al rol
     * 
     * @param string $id ID del rol
     */
    public function show(string $id)
    {
        // Método no implementado (puede agregarse en el futuro)
    }

    /**
     * Muestra el formulario para editar un rol (GET /admin/roles/{role}/edit)
     * 
     * Verifica que el rol no sea uno de los roles del sistema protegidos
     * antes de permitir la edición.
     * 
     * @param Role $role Rol a editar
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Vista de edición o redirección con error
     */
    public function edit(Role $role)
    {
        // Lista de roles del sistema que están protegidos
        // Estos roles son esenciales y no se pueden modificar ni eliminar
        $protectedRoles = ['admin', 'staff', 'client'];
        
        // Verificar si el rol a editar es uno de los protegidos
        if (in_array($role->name, $protectedRoles)) {
            // Si es un rol protegido, mostrar error y redirigir
            session()->flash('swal',[
                'icon' => 'error',
                'title' => 'Acción no permitida',
                'text' => 'No puedes editar este rol del sistema.',
            ]);
            return redirect()->route('admin.roles.index');
        }
        
        // Si no es un rol protegido, mostrar el formulario de edición
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Actualiza un rol existente (PUT/PATCH /admin/roles/{role})
     * 
     * Valida el nombre del rol, verifica si hubo cambios,
     * actualiza el rol y muestra notificación.
     * 
     * @param Request $request Datos actualizados del formulario
     * @param Role $role Rol a actualizar
     * @return \Illuminate\Http\RedirectResponse Redirección con notificación
     */
    public function update(Request $request, Role $role)
    {
        // Validar que el nombre sea obligatorio y único
        // El tercer parámetro ($role->id) excluye este rol de la validación de unicidad
        $request->validate(['name' => 'required|unique:roles,name,' . $role->id]);

        // Verificar si el nombre realmente cambió
        // Si no cambió, informar al usuario y no hacer actualización innecesaria
        if ($role->name === $request->name) {
            session()->flash('swal', 
            [
                'icon' => 'info',
                'title' => 'Sin cambios',
                'text' => 'No se detectaron modificaciones',
            ]);
            return redirect()->route('admin.roles.edit', $role);
        }

        // Si el nombre cambió, actualizar el rol
        $role->update([
            'name' => $request->name,  // Actualizar solo el nombre (guard_name no debe cambiar)
        ]);
        
        // Mostrar notificación de éxito
        session()->flash('swal', 
        [
            'icon' => 'success',
            'title' => 'Rol actualizado correctamente',
            'text' => 'El rol ha sido actualizado exitosamente',
        ]);
        
        // Redirigir al listado de roles
        return redirect()->route('admin.roles.index');
    }

    /**
     * Elimina un rol de la base de datos (DELETE /admin/roles/{role})
     * 
     * Verifica que el rol no sea uno de los roles protegidos del sistema
     * antes de permitir la eliminación.
     * 
     * @param Role $role Rol a eliminar
     * @return \Illuminate\Http\RedirectResponse Redirección con notificación
     */
    public function destroy(Role $role)
    {
        // Lista de roles del sistema que están protegidos
        $protectedRoles = ['admin', 'staff', 'client'];
        
        // Verificar si el rol a eliminar es uno de los protegidos
        if (in_array($role->name, $protectedRoles)) {
            // Si es un rol protegido, mostrar error y no eliminar
            session()->flash('swal',[
                'icon' => 'error',
                'title' => 'Acción no permitida',
                'text' => 'No puedes eliminar este rol del sistema.',
            ]);
            return redirect()->route('admin.roles.index');
        }
        
        // Si no es un rol protegido, eliminarlo permanentemente
        $role->delete();

        // Mostrar notificación de éxito
        session()->flash('swal', 
        [
            'icon' => 'success',
            'title' => 'Rol eliminado correctamente',
            'text' => 'El rol ha sido eliminado exitosamente',
        ]);
        
        // Redirigir al listado de roles
        return redirect()->route('admin.roles.index');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador UserController - Gestión de usuarios desde el panel de administración
 * 
 * Este controlador maneja todas las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * para los usuarios del sistema. Solo puede ser accedido por usuarios con rol 'admin'.
 * 
 * Funcionalidades:
 * - Listar todos los usuarios con paginación
 * - Crear nuevos usuarios con asignación de roles
 * - Editar información de usuarios existentes
 * - Activar/Desactivar usuarios (soft delete)
 * - Asignar y cambiar roles de usuarios
 * 
 * Protección: Solo accesible para usuarios con rol 'admin'
 */
class UserController extends Controller
{
    /**
     * Constructor del controlador
     * 
     * Se ejecuta automáticamente al instanciar el controlador.
     * Aquí se definen los middlewares que protegen las rutas.
     */
    public function __construct()
    {
        // Middleware que verifica que el usuario tenga el rol 'admin'
        // Si no tiene el rol, será redirigido o recibirá un error 403
        $this->middleware('role:admin');
    }

    /**
     * Muestra el listado de usuarios (GET /admin/users)
     * 
     * Obtiene todos los usuarios del sistema con sus roles asignados,
     * ordenados por fecha de creación (más recientes primero)
     * y paginados (10 usuarios por página).
     * 
     * @return \Illuminate\View\View Vista con el listado de usuarios
     */
    public function index()
    {
        // with('roles') carga la relación de roles (eager loading) para evitar consultas N+1
        // latest() ordena por created_at descendente (más reciente primero)
        // paginate(10) divide los resultados en páginas de 10 registros
        $users = User::with('roles')->latest()->paginate(10);
        
        // compact('users') pasa la variable $users a la vista
        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario (GET /admin/users/create)
     * 
     * Prepara la vista con todos los roles disponibles para que
     * el administrador pueda asignar un rol al nuevo usuario.
     * 
     * @return \Illuminate\View\View Vista con el formulario de creación
     */
    public function create()
    {
        // Obtiene todos los roles del sistema (admin, staff, client)
        $roles = Role::all();
        
        // Pasa los roles a la vista para mostrarlos en un select/dropdown
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Guarda un nuevo usuario en la base de datos (POST /admin/users)
     * 
     * Valida los datos del formulario, crea el usuario,
     * asigna el rol seleccionado y redirige al listado.
     * 
     * @param Request $request Datos del formulario (nombre, email, contraseña, etc.)
     * @return \Illuminate\Http\RedirectResponse Redirección al listado con mensaje de éxito
     */
    public function store(Request $request)
    {
        // Validación de datos del formulario
        // Si la validación falla, Laravel automáticamente redirige al formulario con errores
        $data = $request->validate([
            'name' => 'required|string|max:255',                    // Nombre obligatorio, máximo 255 caracteres
            'email' => 'required|email|unique:users,email',         // Email obligatorio, formato válido, único en tabla users
            'password' => 'required|string|min:8|confirmed',        // Contraseña obligatoria, mínimo 8 caracteres, debe coincidir con password_confirmation
            'role' => 'required|exists:roles,name',                 // Rol obligatorio, debe existir en la tabla roles
            'id_number' => 'nullable|string|max:255|unique:users,id_number', // ID opcional, único si se proporciona
            'phone' => 'nullable|string|max:255',                   // Teléfono opcional
            'address' => 'nullable|string|max:255',                 // Dirección opcional
            'is_active' => 'boolean',                               // Estado activo (true/false)
        ]);

        // Encripta la contraseña usando bcrypt antes de guardarla
        $data['password'] = Hash::make($data['password']);
        
        // Convierte el checkbox 'is_active' a booleano
        // has('is_active') verifica si el campo está presente en el request
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Crea el usuario en la base de datos con los datos validados
        $user = User::create($data);
        
        // Asigna el rol al usuario usando el método de Spatie Permission
        $user->assignRole($data['role']);

        // Redirige al listado de usuarios con un mensaje de éxito
        // El mensaje se almacena en la sesión y se puede mostrar en la vista
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente (GET /admin/users/{user}/edit)
     * 
     * Prepara la vista con los datos del usuario a editar
     * y todos los roles disponibles.
     * 
     * @param User $user Usuario a editar (Laravel lo resuelve automáticamente por el ID en la URL)
     * @return \Illuminate\View\View Vista con el formulario de edición
     */
    public function edit(User $user)
    {
        // Obtiene todos los roles disponibles
        $roles = Role::all();
        
        // Pasa el usuario y los roles a la vista
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza un usuario existente (PUT/PATCH /admin/users/{user})
     * 
     * Valida los datos, actualiza el usuario en la base de datos,
     * actualiza su rol y redirige al listado.
     * 
     * @param Request $request Datos actualizados del formulario
     * @param User $user Usuario a actualizar
     * @return \Illuminate\Http\RedirectResponse Redirección al listado con mensaje de éxito
     */
    public function update(Request $request, User $user)
    {
        // Validación similar a store(), pero:
        // - password es nullable (opcional en edición)
        // - email e id_number usan 'unique:table,column,except,idColumn' para excluir el usuario actual
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,  // Único excepto el usuario actual
            'password' => 'nullable|string|min:8|confirmed',              // Opcional en edición
            'role' => 'required|exists:roles,name',
            'id_number' => 'nullable|string|max:255|unique:users,id_number,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Solo actualizar password si se proporciona (si el usuario dejó el campo vacío, no se cambia)
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Si no se proporciona password, lo removemos del array para no sobreescribirlo
            unset($data['password']);
        }

        // Convierte el checkbox a booleano
        $data['is_active'] = $request->has('is_active') ? true : false;

        // Actualiza el usuario con los nuevos datos
        $user->update($data);
        
        // Sincroniza los roles (reemplaza todos los roles actuales por el nuevo rol)
        // syncRoles() asegura que el usuario solo tenga el rol especificado
        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina un usuario permanentemente (DELETE /admin/users/{user})
     * 
     * Los administradores tienen control total y pueden eliminar usuarios
     * físicamente de la base de datos. Se elimina completamente el usuario
     * junto con sus datos asociados.
     * 
     * Nota: Esta es una eliminación permanente (hard delete) que no se puede deshacer.
     * 
     * @param User $user Usuario a eliminar
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito
     */
    public function destroy(User $user)
    {
        // Prevenir que el administrador se elimine a sí mismo
        if ($user->id === auth()->id()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Acción no permitida',
                'text' => 'No puedes eliminar tu propia cuenta.',
            ]);
            return redirect()->route('admin.users.index');
        }

        // Eliminar foto de perfil si existe
        // deleteProfilePhoto() de Jetstream verifica si existe antes de eliminar
        try {
            $user->deleteProfilePhoto();
        } catch (\Exception $e) {
            // Si falla la eliminación de la foto, continuar con la eliminación del usuario
            // (no es crítico si no se puede eliminar la foto)
        }

        // Eliminar todos los tokens de API del usuario
        $user->tokens->each->delete();

        // Eliminar roles asignados al usuario
        $user->roles()->detach();

        // Eliminar permanentemente el usuario de la base de datos
        $user->delete();

        // Mostrar notificación de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario eliminado',
            'text' => 'El usuario ha sido eliminado permanentemente.',
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Reactiva un usuario desactivado (POST /admin/users/{user}/activate)
     * 
     * Permite volver a activar un usuario que fue previamente desactivado.
     * 
     * @param User $user Usuario a reactivar
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito
     */
    public function activate(User $user)
    {
        // Marca el usuario como activo nuevamente
        $user->update(['is_active' => true]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario activado correctamente.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Controlador PetController - Gestión de mascotas desde el panel administrativo
 * 
 * Este controlador maneja todas las operaciones CRUD para las mascotas del sistema.
 * Puede ser accedido por usuarios con rol 'admin' o 'staff'.
 * 
 * Funcionalidades:
 * - Listar todas las mascotas con información de sus dueños
 * - Crear nuevas mascotas asociadas a un cliente
 * - Ver detalles completos de una mascota
 * - Editar información de mascotas existentes
 * - Eliminar mascotas del sistema
 * 
 * Protección: Solo accesible para usuarios con rol 'admin' o 'staff'
 */
class PetController extends Controller
{
    /**
     * Constructor del controlador
     * 
     * Define el middleware que protege todas las rutas de este controlador.
     */
    public function __construct()
    {
        // Middleware que permite acceso a usuarios con rol 'admin' O 'staff'
        // Si el usuario no tiene ninguno de estos roles, será bloqueado
        $this->middleware('role:admin,staff');
    }

    /**
     * Muestra el listado de mascotas (GET /admin/pets)
     * 
     * Obtiene todas las mascotas del sistema junto con la información de sus dueños,
     * ordenadas por fecha de creación (más recientes primero) y paginadas.
     * 
     * @return \Illuminate\View\View Vista con el listado de mascotas
     */
    public function index()
    {
        // with('owner') carga la relación del dueño (eager loading) para evitar consultas N+1
        // Esto significa que en lugar de hacer 1 consulta por cada mascota para obtener su dueño,
        // Laravel hace solo 2 consultas: una para las mascotas y otra para todos los dueños
        $pets = Pet::with('owner')->latest()->paginate(10);
        
        return view('admin.pets.index', compact('pets'));
    }

    /**
     * Muestra el formulario para crear una nueva mascota (GET /admin/pets/create)
     * 
     * Prepara la vista con el formulario de creación.
     * La vista incluirá un selector de clientes (dueños) disponibles.
     * 
     * @return \Illuminate\View\View Vista con el formulario de creación
     */
    public function create()
    {
        return view('admin.pets.create');
    }

    /**
     * Guarda una nueva mascota en la base de datos (POST /admin/pets)
     * 
     * Valida los datos del formulario, crea la mascota y la asocia
     * con un dueño (cliente) existente.
     * 
     * @param Request $request Datos del formulario (nombre, especie, raza, dueño, etc.)
     * @return \Illuminate\Http\RedirectResponse Redirección al listado con mensaje de éxito
     */
    public function store(Request $request)
    {
        // Validación de datos del formulario
        $data = $request->validate([
            'name' => 'required|string|max:255',              // Nombre obligatorio
            'species' => 'required|string|max:255',           // Especie obligatoria (Perro, Gato, etc.)
            'breed' => 'nullable|string|max:255',             // Raza opcional
            'age' => 'nullable|integer|min:0',                // Edad opcional, debe ser número entero positivo
            'owner_id' => 'required|exists:users,id',         // ID del dueño obligatorio, debe existir en tabla users
            'notes' => 'nullable|string',                     // Notas opcionales
        ]);

        // Crea la mascota en la base de datos con los datos validados
        Pet::create($data);

        return redirect()
            ->route('admin.pets.index')
            ->with('success', 'Mascota creada correctamente.');
    }

    /**
     * Muestra los detalles de una mascota específica (GET /admin/pets/{pet})
     * 
     * Carga la información completa de una mascota incluyendo
     * los datos de su dueño.
     * 
     * @param Pet $pet Mascota a mostrar (Laravel lo resuelve automáticamente por el ID)
     * @return \Illuminate\View\View Vista con los detalles de la mascota
     */
    public function show(Pet $pet)
    {
        // load('owner') carga la relación del dueño si no está ya cargada
        // Es útil para asegurar que tengamos los datos del dueño en la vista
        $pet->load('owner');
        
        return view('admin.pets.show', compact('pet'));
    }

    /**
     * Muestra el formulario para editar una mascota (GET /admin/pets/{pet}/edit)
     * 
     * Prepara la vista con los datos de la mascota a editar.
     * 
     * @param Pet $pet Mascota a editar
     * @return \Illuminate\View\View Vista con el formulario de edición
     */
    public function edit(Pet $pet)
    {
        return view('admin.pets.edit', compact('pet'));
    }

    /**
     * Actualiza una mascota existente (PUT/PATCH /admin/pets/{pet})
     * 
     * Valida los datos, actualiza la mascota en la base de datos
     * y redirige al listado.
     * 
     * @param Request $request Datos actualizados del formulario
     * @param Pet $pet Mascota a actualizar
     * @return \Illuminate\Http\RedirectResponse Redirección al listado con mensaje de éxito
     */
    public function update(Request $request, Pet $pet)
    {
        // Validación idéntica a store() ya que los campos son los mismos
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'owner_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        // Actualiza la mascota con los nuevos datos
        $pet->update($data);

        return redirect()
            ->route('admin.pets.index')
            ->with('success', 'Mascota actualizada correctamente.');
    }

    /**
     * Elimina una mascota de la base de datos (DELETE /admin/pets/{pet})
     * 
     * Elimina físicamente el registro de la mascota.
     * 
     * Nota: A diferencia de UserController que usa soft delete (desactivar),
     * aquí se elimina permanentemente. Si necesitas mantener historial,
     * podrías implementar soft deletes en el modelo Pet.
     * 
     * @param Pet $pet Mascota a eliminar
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito
     */
    public function destroy(Pet $pet)
    {
        // Elimina permanentemente el registro de la base de datos
        $pet->delete();

        return redirect()
            ->route('admin.pets.index')
            ->with('success', 'Mascota eliminada correctamente.');
    }
}

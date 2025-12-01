<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Componente Livewire: UserTable
 * 
 * Este componente crea una tabla interactiva para mostrar y gestionar usuarios
 * usando Laravel Livewire Tables. Muestra información completa de los usuarios
 * incluyendo sus roles asignados.
 * 
 * Características:
 * - Muestra usuarios con sus roles cargados (eager loading)
 * - Ordenamiento por todas las columnas principales
 * - Muestra el rol asignado a cada usuario
 * - Acciones personalizadas (editar, activar/desactivar)
 * 
 * Diferencias con RoleTable:
 * - Usa builder() personalizado en lugar de $model para cargar relaciones
 * - Incluye más columnas (email, teléfono, ID number, etc.)
 * - Muestra relación con roles
 * 
 * Uso: Se usa en la vista admin.users.index
 */
class UserTable extends DataTableComponent
{   
    /**
     * Se comenta $model para personalizar la consulta con relaciones
     * 
     * En lugar de usar el modelo directamente, usamos builder() para
     * cargar los roles junto con los usuarios (eager loading).
     * Esto evita el problema N+1 (múltiples consultas) al acceder a los roles.
     */
    //protected $model = User::class;

    /**
     * Define el modelo y su consulta personalizada
     * 
     * Este método permite personalizar la consulta base de la tabla.
     * Usamos with('roles') para cargar los roles de cada usuario
     * en una sola consulta, mejorando el rendimiento.
     * 
     * @return Builder Query builder con la relación de roles cargada
     */
    public function builder(): Builder
    {
        // with('roles') carga la relación de roles (eager loading)
        // Esto significa que cuando se consulten los usuarios, también
        // se cargarán sus roles en la misma consulta, evitando consultas adicionales
        return User::query()->with('roles');
    }

    /**
     * Configurar opciones de la tabla
     * 
     * Define la clave primaria que se usará para identificar cada fila.
     */
    public function configure(): void
    {
        // Establecer 'id' como clave primaria de la tabla
        $this->setPrimaryKey('id');
    }

    /**
     * Definir las columnas de la tabla
     * 
     * Define todas las columnas que se mostrarán en la tabla de usuarios,
     * incluyendo información personal y el rol asignado.
     * 
     * @return array Array de objetos Column que definen las columnas
     */
    public function columns(): array
    {
        return [
            // Columna ID: Identificador único del usuario
            Column::make("Id", "id")
                ->sortable(),
            
            // Columna Nombre: Nombre completo del usuario
            Column::make("Name", "name")
                ->sortable(),
            
            // Columna Email: Dirección de email del usuario
            Column::make("Email", "email")
                ->sortable(),
            
            // Columna Número de ID: Número de identificación (cédula, DNI, etc.)
            Column::make("Número de id", "id_number")
                ->sortable(),
            
            // Columna Teléfono: Número de teléfono del usuario
            Column::make("Teléfono", "phone")
                ->sortable(),
            
            // Columna Rol: Muestra el rol asignado al usuario
            // label() permite personalizar cómo se muestra el valor
            // Accedemos a la relación 'roles' que fue cargada con with('roles')
            Column::make("Rol", "roles")
                ->label(function($row){
                    // Obtener el primer rol del usuario (normalmente solo tiene uno)
                    // first() obtiene el primer elemento de la colección
                    // ?-> es el operador null-safe de PHP 8 (si roles está vacío, retorna null)
                    // ?? 'Sin Rol' significa: si es null, mostrar 'Sin Rol'
                    return $row->roles->first()?->name ?? 'Sin Rol';
                }),
            
            // Columna Acciones: Botones para acciones sobre cada usuario
            // Renderiza una vista Blade con botones de editar, activar/desactivar, etc.
            Column::make("Acciones")
                ->label(function ($row) {
                    // Renderizar la vista admin.users.actions con los datos del usuario
                    // $row contiene el modelo User completo con sus roles cargados
                    return view('admin.users.actions', ['user' => $row]);
                })
        ];
    }
}

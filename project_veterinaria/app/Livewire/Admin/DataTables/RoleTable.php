<?php

namespace App\Livewire\Admin\DataTables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Models\Role;

/**
 * Componente Livewire: RoleTable
 * 
 * Este componente crea una tabla interactiva para mostrar y gestionar roles
 * usando Laravel Livewire Tables. Proporciona funcionalidades como:
 * - Búsqueda en tiempo real
 * - Ordenamiento por columnas
 * - Paginación automática
 * - Acciones personalizadas (editar, eliminar)
 * 
 * Características:
 * - Búsqueda: Permite buscar roles por nombre
 * - Ordenamiento: Permite ordenar por ID, nombre o fecha
 * - Formato: Fechas se muestran en formato d/m/Y
 * - Acciones: Botones para editar/eliminar cada rol
 * 
 * Uso: Se usa en la vista admin.roles.index
 */
class RoleTable extends DataTableComponent
{
    /**
     * Modelo Eloquent que se usará para la tabla
     * 
     * Laravel Livewire Tables usará este modelo para consultar los datos.
     * Se cargarán todos los roles de la base de datos.
     */
    protected $model = Role::class;

    /**
     * Configurar opciones de la tabla
     * 
     * Define la clave primaria que se usará para identificar cada fila.
     * Esto es necesario para funcionalidades como selección y acciones.
     */
    public function configure(): void
    {
        // Establecer la clave primaria de la tabla
        // Se usa 'id' como identificador único de cada rol
        $this->setPrimaryKey('id');
    }

    /**
     * Definir las columnas de la tabla
     * 
     * Este método define qué columnas se mostrarán en la tabla,
     * sus características (ordenable, buscable, formato, etc.),
     * y cómo se renderizan.
     * 
     * @return array Array de objetos Column que definen las columnas
     */
    public function columns(): array
    {
        return [
            // Columna ID: Identificador único del rol
            // sortable() permite ordenar la tabla por esta columna
            Column::make("Id", "id")
                ->sortable(),
            
            // Columna Nombre: Nombre del rol (ej: 'admin', 'staff', 'client')
            // sortable() permite ordenar por nombre
            // searchable() permite buscar roles por nombre en tiempo real
            Column::make("Nombre","name")
                ->sortable()
                ->searchable(),

            // Columna Fecha: Fecha de creación del rol
            // sortable() permite ordenar por fecha
            // format() formatea la fecha antes de mostrarla
            Column::make("Fecha", "created_at")
                ->sortable()
                ->format(function ($value) {
                    // Si la fecha es null, mostrar un guión
                    if(is_null($value)) {
                        return '-';
                    }
                    // Formatear la fecha en formato día/mes/año (ej: 24/11/2025)
                    // $value es un objeto Carbon (fecha/hora de Laravel)
                    return $value->format('d/m/Y');
                }),
            
            // Columna Acciones: Botones para acciones sobre cada rol
            // label() permite renderizar contenido personalizado (HTML)
            // En este caso, renderiza una vista Blade con botones de acción
            Column::make("Acciones")
                ->label(function ($row) {
                    // Renderizar la vista admin.roles.actions con los datos del rol
                    // $row contiene el modelo Role completo para esa fila
                    return view('admin.roles.actions', ['row' => $row]);
                }),
        ];
    }
}


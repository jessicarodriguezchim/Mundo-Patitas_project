<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Pet - Representa a las mascotas del sistema
 * 
 * Este modelo maneja toda la información de las mascotas registradas
 * en la clínica veterinaria. Cada mascota pertenece a un dueño (usuario con rol 'client').
 * 
 * Relaciones:
 * - belongsTo User (owner): Cada mascota tiene un dueño que es un usuario del sistema
 * 
 * Funcionalidad:
 * - CRUD completo de mascotas
 * - Asociación con dueños (clientes)
 * - Almacenamiento de información médica básica
 */
class Pet extends Model
{
    /**
     * Atributos que pueden ser asignados masivamente (mass assignment)
     * 
     * Campos que pueden ser llenados al crear/actualizar una mascota desde un formulario.
     */
    protected $fillable = [
        'name',        // Nombre de la mascota
        'species',     // Especie (Perro, Gato, Conejo, etc.)
        'breed',       // Raza de la mascota (ej: Labrador, Persa, etc.)
        'age',         // Edad de la mascota en años o meses
        'owner_id',    // ID del dueño (clave foránea a la tabla users)
        'notes',       // Notas adicionales sobre la mascota (historial médico, etc.)
    ];

    /**
     * Relación: Una mascota pertenece a un dueño (usuario)
     * 
     * Esta relación define que cada mascota tiene un dueño único,
     * que es un usuario del sistema (normalmente con rol 'client').
     * 
     * Uso:
     * $pet = Pet::find(1);
     * $owner = $pet->owner;  // Obtiene el usuario dueño de la mascota
     * 
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        // belongsTo(User::class, 'owner_id') significa:
        // - Esta mascota pertenece al modelo User
        // - La clave foránea en la tabla pets es 'owner_id'
        return $this->belongsTo(User::class, 'owner_id');
    }
}

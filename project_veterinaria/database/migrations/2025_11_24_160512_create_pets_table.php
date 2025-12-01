<?php

/**
 * Migración: Crear tabla de mascotas (pets)
 * 
 * Esta migración crea la tabla que almacena la información de todas las mascotas
 * registradas en el sistema. Cada mascota está asociada a un dueño (usuario).
 * 
 * Fecha: 2025-11-24 16:05:12
 * 
 * Tabla creada: pets
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración (crear la tabla)
     * 
     * Este método se ejecuta cuando corres: php artisan migrate
     * Crea la estructura de la tabla 'pets' en la base de datos.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            // ID autoincremental (clave primaria)
            $table->id();
            
            // Nombre de la mascota (obligatorio)
            $table->string('name');
            
            // Especie de la mascota (obligatorio)
            // Ejemplos: Perro, Gato, Conejo, Ave, etc.
            $table->string('species');
            
            // Raza de la mascota (opcional)
            // Ejemplos: Labrador, Persa, Golden Retriever, etc.
            $table->string('breed')->nullable();
            
            // Edad de la mascota en años o meses (opcional)
            $table->integer('age')->nullable();
            
            // Clave foránea que relaciona la mascota con su dueño
            // constrained('users') crea la relación con la tabla users
            // onDelete('cascade') significa que si se elimina el dueño,
            // también se eliminan sus mascotas automáticamente
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            
            // Notas adicionales sobre la mascota (opcional)
            // text() permite textos más largos que string()
            // Útil para historial médico, observaciones, etc.
            $table->text('notes')->nullable();
            
            // Timestamps automáticos
            // Crea automáticamente las columnas created_at y updated_at
            // Laravel las actualiza automáticamente
            $table->timestamps();
        });
    }

    /**
     * Revertir la migración (eliminar la tabla)
     * 
     * Este método se ejecuta cuando corres: php artisan migrate:rollback
     * Elimina la tabla 'pets' de la base de datos.
     */
    public function down(): void
    {
        // Eliminar la tabla si existe
        Schema::dropIfExists('pets');
    }
};

<?php

/**
 * Migración: Agregar campo 'is_active' a la tabla users
 * 
 * Esta migración añade un campo booleano para controlar si un usuario
 * está activo o inactivo en el sistema. Permite desactivar usuarios
 * sin eliminarlos de la base de datos (soft delete manual).
 * 
 * Fecha: 2025-11-24 16:03:37
 * 
 * Modifica: Tabla users (agrega columna is_active)
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración (agregar la columna)
     * 
     * Agrega el campo 'is_active' a la tabla existente 'users'.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregar columna booleana 'is_active'
            // default(true) significa que por defecto todos los usuarios nuevos estarán activos
            // after('email_verified_at') coloca la columna después de email_verified_at
            $table->boolean('is_active')->default(true)->after('email_verified_at');
        });
    }

    /**
     * Revertir la migración (eliminar la columna)
     * 
     * Elimina el campo 'is_active' de la tabla 'users'.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar la columna is_active si existe
            $table->dropColumn('is_active');
        });
    }
};

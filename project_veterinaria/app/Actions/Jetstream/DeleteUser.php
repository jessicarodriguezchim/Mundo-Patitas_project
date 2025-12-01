<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

/**
 * Action: DeleteUser
 * 
 * Esta clase maneja la eliminación completa de usuarios del sistema.
 * Se ejecuta cuando un usuario decide eliminar su cuenta permanentemente
 * desde la configuración de su perfil.
 * 
 * Funcionalidad:
 * - Elimina la foto de perfil del usuario
 * - Elimina todos los tokens de API del usuario
 * - Elimina permanentemente el usuario de la base de datos
 * 
 * Nota: Esta es una eliminación permanente (hard delete).
 * Los datos del usuario y sus relaciones se eliminarán completamente.
 * 
 * Uso: Se ejecuta cuando el usuario confirma la eliminación de su cuenta
 */
class DeleteUser implements DeletesUsers
{
    /**
     * Elimina un usuario del sistema
     * 
     * Este método se ejecuta cuando el usuario confirma la eliminación
     * de su cuenta. Realiza una limpieza completa:
     * 1. Elimina la foto de perfil del storage
     * 2. Elimina todos los tokens de API asociados
     * 3. Elimina el registro del usuario de la base de datos
     * 
     * @param User $user Usuario a eliminar
     * @return void
     */
    public function delete(User $user): void
    {
        // Eliminar la foto de perfil del storage
        // deleteProfilePhoto() es un método de Jetstream que elimina el archivo
        // de storage/app/public/profile-photos/
        $user->deleteProfilePhoto();
        
        // Eliminar todos los tokens de API del usuario
        // tokens es la relación con los tokens de Sanctum
        // each->delete() elimina cada token individualmente
        $user->tokens->each->delete();
        
        // Eliminar permanentemente el usuario de la base de datos
        // Esto también elimina las relaciones (cascade) si están configuradas
        // Por ejemplo, si un usuario tiene mascotas, se eliminarán también
        $user->delete();
    }
}

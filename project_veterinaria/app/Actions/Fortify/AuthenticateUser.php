<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Action: AuthenticateUser
 * 
 * Esta clase proporciona métodos para personalizar el proceso de autenticación
 * de usuarios en Fortify. Agrega validación adicional para verificar que el
 * usuario esté activo antes de permitir el inicio de sesión.
 * 
 * Funcionalidad:
 * - Verifica las credenciales (email y contraseña)
 * - Valida que el usuario esté activo (is_active = true)
 * - Lanza excepciones apropiadas si la autenticación falla
 * 
 * Uso: Se ejecuta automáticamente durante el proceso de login
 */
class AuthenticateUser
{
    /**
     * Autenticar un usuario con las credenciales proporcionadas
     * 
     * Este método se ejecuta cuando un usuario intenta iniciar sesión.
     * Verifica las credenciales y que el usuario esté activo.
     * 
     * @param \Illuminate\Http\Request $request Request con email y password
     * @return \App\Models\User|null Usuario autenticado o null si falla
     */
    public function authenticate($request)
    {
        // Obtener el email del request (Fortify lo convierte a minúsculas automáticamente)
        $email = $request->input('email');
        $password = $request->input('password');

        // Buscar el usuario por email
        $user = User::where('email', strtolower($email))->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if (!$user || !Hash::check($password, $user->password)) {
            // Retornar null para que Fortify muestre el mensaje de error por defecto
            return null;
        }

        // Verificar si el usuario está activo
        if (!$user->is_active) {
            // Si el usuario está inactivo, lanzar excepción con mensaje específico
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated. Please contact an administrator.'],
            ]);
        }

        // Si todo está correcto, retornar el usuario
        return $user;
    }
}


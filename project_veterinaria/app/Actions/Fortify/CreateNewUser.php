<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

/**
 * Action: CreateNewUser
 * 
 * Esta clase implementa la lógica para crear nuevos usuarios cuando se registran
 * en el sistema. Es llamada automáticamente por Laravel Fortify cuando alguien
 * se registra a través del formulario de registro.
 * 
 * Funcionalidad:
 * - Valida los datos del formulario de registro
 * - Crea el usuario en la base de datos
 * - Asigna automáticamente el rol 'client' a todos los nuevos registros
 * - Maneja términos y condiciones si están habilitados
 * 
 * Uso: Se ejecuta automáticamente durante el proceso de registro
 */
class CreateNewUser implements CreatesNewUsers
{
    // Trait que proporciona las reglas de validación para contraseñas
    // Define validaciones como mínimo de caracteres, complejidad, etc.
    use PasswordValidationRules;

    /**
     * Valida y crea un nuevo usuario registrado
     * 
     * Este método se ejecuta cuando un usuario completa el formulario de registro.
     * Valida todos los datos, crea el usuario y le asigna el rol por defecto.
     * 
     * @param array<string, string> $input Datos del formulario de registro
     * @return User Usuario recién creado
     */
    public function create(array $input): User
    {
        // Validar los datos del formulario de registro
        // Si la validación falla, Laravel automáticamente redirige al formulario con errores
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],                    // Nombre obligatorio
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Email válido y único
            'password' => $this->passwordRules(),                           // Contraseña con reglas de validación
            // Términos y condiciones solo si la funcionalidad está habilitada en Jetstream
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Crear el usuario en la base de datos con los datos validados
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),  // Encriptar la contraseña antes de guardar
            'is_active' => true,                           // Nuevos usuarios se crean como activos por defecto
        ]);

        // Asignar automáticamente el rol 'client' a todos los usuarios que se registren
        // Esto significa que todos los nuevos usuarios serán clientes por defecto
        // Los administradores pueden cambiar el rol después desde el panel
        $user->assignRole('client');

        // Retornar el usuario creado
        // Fortify usará este usuario para iniciar sesión automáticamente
        return $user;
    }
}

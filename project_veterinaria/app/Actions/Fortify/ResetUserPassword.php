<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

/**
 * Action: ResetUserPassword
 * 
 * Esta clase maneja el restablecimiento de contraseñas cuando un usuario
 * ha olvidado su contraseña y la solicita mediante el enlace "Forgot Password".
 * 
 * Funcionalidad:
 * - Valida la nueva contraseña
 * - Actualiza la contraseña del usuario en la base de datos
 * - Se ejecuta después de que el usuario hace clic en el enlace de reset en su email
 * 
 * Flujo:
 * 1. Usuario solicita reset de contraseña
 * 2. Recibe email con enlace de reset
 * 3. Hace clic en el enlace y completa el formulario
 * 4. Este método valida y actualiza la contraseña
 * 
 * Uso: Se ejecuta automáticamente durante el proceso de reset de contraseña
 */
class ResetUserPassword implements ResetsUserPasswords
{
    // Usa el trait para obtener las reglas de validación de contraseñas
    use PasswordValidationRules;

    /**
     * Valida y restablece la contraseña olvidada del usuario
     * 
     * Este método se ejecuta cuando el usuario completa el formulario
     * de restablecimiento de contraseña después de hacer clic en el enlace
     * que recibió por email.
     * 
     * @param User $user Usuario cuya contraseña se va a restablecer
     * @param array<string, string> $input Datos del formulario (nueva contraseña)
     * @return void
     */
    public function reset(User $user, array $input): void
    {
        // Validar que la nueva contraseña cumpla con las reglas
        Validator::make($input, [
            'password' => $this->passwordRules(),  // Usa las reglas del trait
        ])->validate();

        // Actualizar la contraseña del usuario
        // forceFill() permite asignar la contraseña aunque no esté en $fillable
        // Hash::make() encripta la contraseña antes de guardarla
        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
        
        // Después de esto, el usuario puede iniciar sesión con su nueva contraseña
    }
}

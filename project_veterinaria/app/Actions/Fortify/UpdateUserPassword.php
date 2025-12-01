<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

/**
 * Action: UpdateUserPassword
 * 
 * Esta clase maneja el cambio de contraseña cuando un usuario autenticado
 * quiere cambiar su contraseña desde su perfil (no es reset, es cambio voluntario).
 * 
 * Funcionalidad:
 * - Valida la contraseña actual (debe coincidir)
 * - Valida la nueva contraseña
 * - Actualiza la contraseña en la base de datos
 * 
 * Diferencias con ResetUserPassword:
 * - Requiere que el usuario esté autenticado
 * - Requiere verificar la contraseña actual antes de cambiar
 * - Se usa desde el perfil del usuario (configuración de cuenta)
 * 
 * Uso: Se ejecuta automáticamente cuando el usuario cambia su contraseña desde su perfil
 */
class UpdateUserPassword implements UpdatesUserPasswords
{
    // Usa el trait para obtener las reglas de validación de contraseñas
    use PasswordValidationRules;

    /**
     * Valida y actualiza la contraseña del usuario
     * 
     * Este método se ejecuta cuando un usuario autenticado cambia su contraseña
     * desde el formulario de configuración de perfil.
     * 
     * Validaciones:
     * - La contraseña actual debe ser correcta
     * - La nueva contraseña debe cumplir con las reglas
     * - La nueva contraseña debe ser confirmada
     * 
     * @param User $user Usuario cuya contraseña se va a cambiar
     * @param array<string, string> $input Datos del formulario (contraseña actual y nueva)
     * @return void
     */
    public function update(User $user, array $input): void
    {
        // Validar los datos del formulario
        Validator::make($input, [
            // La contraseña actual es obligatoria y debe coincidir con la del usuario
            // current_password:web verifica que la contraseña proporcionada coincida con la actual
            'current_password' => ['required', 'string', 'current_password:web'],
            
            // La nueva contraseña debe cumplir con las reglas del trait
            'password' => $this->passwordRules(),
        ], [
            // Mensaje personalizado si la contraseña actual no coincide
            'current_password.current_password' => __('The provided password does not match your current password.'),
        ])->validateWithBag('updatePassword');  // Agrupa errores en 'updatePassword' bag

        // Si la validación pasa, actualizar la contraseña
        // forceFill() permite asignar aunque no esté en $fillable
        $user->forceFill([
            'password' => Hash::make($input['password']),  // Encriptar nueva contraseña
        ])->save();
        
        // Después de esto, el usuario debe usar la nueva contraseña para iniciar sesión
    }
}

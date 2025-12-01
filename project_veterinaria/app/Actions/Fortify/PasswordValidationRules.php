<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

/**
 * Trait: PasswordValidationRules
 * 
 * Este trait proporciona un método reutilizable para definir las reglas de validación
 * de contraseñas que se usan en todo el sistema. Centraliza las reglas para mantener
 * consistencia y facilitar cambios futuros.
 * 
 * Uso:
 * Se usa en las clases de Actions de Fortify para validar contraseñas
 * en registro, cambio de contraseña, y restablecimiento de contraseña.
 */
trait PasswordValidationRules
{
    /**
     * Obtiene las reglas de validación para contraseñas
     * 
     * Define las reglas que deben cumplir las contraseñas en el sistema:
     * - required: La contraseña es obligatoria
     * - string: Debe ser una cadena de texto
     * - Password::default(): Reglas por defecto de Laravel (min 8 caracteres, etc.)
     * - confirmed: Debe tener un campo de confirmación que coincida (password_confirmation)
     * 
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     *         Array con las reglas de validación
     */
    protected function passwordRules(): array
    {
        return [
            'required',              // Obligatorio
            'string',                // Debe ser texto
            Password::default(),     // Reglas por defecto de Laravel (mínimo 8 caracteres)
            'confirmed'              // Debe coincidir con password_confirmation
        ];
    }
}

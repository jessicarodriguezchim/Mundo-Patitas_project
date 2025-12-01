<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

/**
 * Action: UpdateUserProfileInformation
 * 
 * Esta clase maneja la actualización de la información del perfil de usuario.
 * Es llamada automáticamente por Laravel Fortify cuando un usuario actualiza
 * su perfil desde el formulario de configuración de perfil.
 * 
 * Funcionalidad:
 * - Valida los datos del formulario de perfil
 * - Actualiza nombre y email del usuario
 * - Maneja la actualización de fotos de perfil
 * - Reenvía verificación de email si el email cambió
 * 
 * Uso: Se ejecuta automáticamente cuando el usuario actualiza su perfil
 */
class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Valida y actualiza la información del perfil del usuario
     * 
     * Este método se ejecuta cuando el usuario actualiza su información de perfil.
     * Maneja actualización de nombre, email y foto de perfil.
     *
     * @param User $user Usuario cuya información se va a actualizar
     * @param array<string, mixed> $input Datos actualizados del formulario
     * @return void
     */
    public function update(User $user, array $input): void
    {
        // Validar los datos del formulario
        // validateWithBag() agrupa los errores en un 'bag' específico para mostrarlos en la vista
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],                          // Nombre obligatorio
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)], // Email único excepto el actual
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],            // Foto opcional, solo imágenes, máximo 1MB
        ])->validateWithBag('updateProfileInformation');

        // Si se proporcionó una nueva foto de perfil, actualizarla
        // updateProfilePhoto() es un método de Laravel Jetstream que:
        // - Guarda la imagen en storage/app/public/profile-photos/
        // - Actualiza la ruta en el modelo User
        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        // Si el email cambió Y el usuario tiene verificación de email habilitada,
        // marcar el email como no verificado y enviar nueva verificación
        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            // Si el email no cambió o no requiere verificación, solo actualizar los datos
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * Actualiza la información del perfil cuando el email cambió
     * 
     * Este método se ejecuta cuando el usuario cambia su email.
     * Marca el email como no verificado y envía un nuevo email de verificación.
     *
     * @param User $user Usuario cuya información se actualiza
     * @param array<string, string> $input Datos actualizados
     * @return void
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        // Actualizar nombre y email, pero marcar el email como no verificado
        // Esto fuerza al usuario a verificar el nuevo email antes de usarlo
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,  // Marcar como no verificado
        ])->save();

        // Enviar email de verificación al nuevo email
        // Esto usa la funcionalidad de verificación de email de Laravel
        $user->sendEmailVerificationNotification();
    }
}

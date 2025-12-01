<?php

namespace App\Providers;

use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

/**
 * Service Provider: FortifyServiceProvider
 * 
 * Este service provider configura Laravel Fortify, que maneja toda la
 * autenticación de la aplicación (login, registro, reset de contraseña, etc.).
 * 
 * Funcionalidades configuradas:
 * - Registro de usuarios
 * - Actualización de perfil
 * - Cambio de contraseña
 * - Reset de contraseña
 * - Autenticación de dos factores (2FA)
 * - Rate limiting (límite de intentos) para prevenir ataques
 * 
 * Este provider se ejecuta automáticamente cuando Laravel inicia.
 */
class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Registrar servicios del contenedor de servicios
     * 
     * Aquí se pueden registrar servicios que se necesiten en el contenedor
     * de inyección de dependencias de Laravel.
     */
    public function register(): void
    {
        // Por ahora no se registran servicios personalizados aquí
    }

    /**
     * Inicializar servicios de la aplicación
     * 
     * Este método se ejecuta después de que todos los service providers
     * están registrados. Aquí se configuran las acciones personalizadas
     * y las limitaciones de tasa (rate limiting).
     */
    public function boot(): void
    {
        // Registrar las clases personalizadas que manejan las acciones de Fortify
        // Esto reemplaza las acciones por defecto con nuestras implementaciones personalizadas
        
        // Usar nuestra clase personalizada para crear usuarios
        // Cuando alguien se registra, se usará CreateNewUser en lugar de la clase por defecto
        Fortify::createUsersUsing(CreateNewUser::class);
        
        // Usar nuestra clase personalizada para actualizar información de perfil
        // Cuando un usuario actualiza su perfil, se usará UpdateUserProfileInformation
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        
        // Usar nuestra clase personalizada para cambiar contraseña
        // Cuando un usuario cambia su contraseña, se usará UpdateUserPassword
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        
        // Usar nuestra clase personalizada para resetear contraseña
        // Cuando un usuario resetea su contraseña olvidada, se usará ResetUserPassword
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Usar nuestra clase personalizada para autenticar usuarios
        // Esto permite agregar validaciones adicionales (ej: verificar que el usuario esté activo)
        // El callback recibe el request y debe retornar el usuario o null si falla
        Fortify::authenticateUsing(function ($request) {
            $authenticator = new AuthenticateUser();
            return $authenticator->authenticate($request);
        });

        // Configurar redirección para autenticación de dos factores (2FA)
        // Si el usuario tiene 2FA habilitado, se redirigirá a la página de verificación
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        /**
         * Rate Limiter para Login
         * 
         * Limita los intentos de login para prevenir ataques de fuerza bruta.
         * Configuración: máximo 5 intentos por minuto por email/IP
         */
        RateLimiter::for('login', function (Request $request) {
            // Crear una clave única basada en el email y la IP
            // Str::transliterate() convierte caracteres especiales (ej: ñ → n)
            // Esto previene que alguien use múltiples variantes del mismo email
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username())).'|'.$request->ip()
            );

            // Permitir máximo 5 intentos por minuto
            // Si se excede, Laravel retornará un error 429 (Too Many Requests)
            return Limit::perMinute(5)->by($throttleKey);
        });

        /**
         * Rate Limiter para Autenticación de Dos Factores
         * 
         * Limita los intentos de verificación 2FA para prevenir ataques.
         * Configuración: máximo 5 intentos por minuto por sesión de login
         */
        RateLimiter::for('two-factor', function (Request $request) {
            // Usar el ID de la sesión de login como clave
            // Esto limita los intentos 2FA para una sesión específica
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}

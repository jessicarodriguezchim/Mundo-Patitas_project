<?php
 
namespace App\Models;
 
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
 
/**
 * Modelo User - Representa a los usuarios del sistema
 * 
 * Este modelo maneja toda la información de los usuarios de la aplicación,
 * incluyendo autenticación, roles, permisos y fotos de perfil.
 * 
 * Funcionalidades principales:
 * - Autenticación con Laravel Fortify
 * - Gestión de roles y permisos con Spatie Permission
 * - Fotos de perfil con Laravel Jetstream
 * - Autenticación de dos factores (2FA)
 * - Tokens API con Laravel Sanctum
 */
class User extends Authenticatable
{
    // Trait para generar tokens de API (autenticación para aplicaciones móviles/externas)
    use HasApiTokens;
 
    // Trait para crear factories y generar datos de prueba
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    
    // Trait de Jetstream que permite gestionar fotos de perfil de usuarios
    use HasProfilePhoto;
    
    // Trait que permite enviar notificaciones (emails, SMS, etc.)
    use Notifiable;
    
    // Trait para autenticación de dos factores (códigos de seguridad adicionales)
    use TwoFactorAuthenticatable;
    
    // Trait de Spatie Permission que permite asignar roles y permisos a los usuarios
    use HasRoles;
 
    /**
     * Atributos que pueden ser asignados masivamente (mass assignment)
     * 
     * Estos campos pueden ser llenados automáticamente al crear/actualizar un usuario
     * desde un formulario o request, proporcionando seguridad contra asignación masiva.
     */
    protected $fillable = [
        'name',              // Nombre completo del usuario
        'email',             // Email único del usuario (usado para login)
        'password',          // Contraseña encriptada
        'is_active',         // Estado del usuario (activo/inactivo)
        'id_number',         // Número de identificación (cédula, DNI, etc.)
        'phone',             // Número de teléfono
        'address',           // Dirección del usuario
    ];
 
    /**
     * Atributos que deben ser ocultados en las respuestas JSON
     * 
     * Estos campos nunca se mostrarán cuando el modelo se convierta a JSON,
     * protegiendo información sensible como contraseñas y tokens.
     */
    protected $hidden = [
        'password',                    // Contraseña (nunca debe mostrarse)
        'remember_token',              // Token para "recordar sesión"
        'two_factor_recovery_codes',   // Códigos de recuperación 2FA
        'two_factor_secret',           // Secret para autenticación 2FA
    ];
 
    /**
     * Accessors que se agregan automáticamente al convertir el modelo a array/JSON
     * 
     * Estos son atributos calculados que no existen en la base de datos,
     * pero se añaden automáticamente cuando accedes al modelo.
     */
    protected $appends = [
        'profile_photo_url',  // URL completa de la foto de perfil (calculada por Jetstream)
    ];
 
    /**
     * Definir cómo se deben convertir los tipos de datos de los atributos
     * 
     * Esto permite que Laravel convierta automáticamente los valores
     * de la base de datos a tipos específicos de PHP.
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',  // Convierte a objeto Carbon (fecha/hora)
            'password' => 'hashed',              // Encripta automáticamente la contraseña
        ];
    }
}
 
 
<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

/**
 * Service Provider: JetstreamServiceProvider
 * 
 * Este service provider configura Laravel Jetstream, que proporciona
 * funcionalidades como fotos de perfil, equipos (teams), y gestión de sesiones.
 * 
 * Funcionalidades configuradas:
 * - Eliminación de usuarios personalizada
 * - Permisos para tokens de API
 * - Optimización de Vite para assets
 * 
 * Este provider se ejecuta automáticamente cuando Laravel inicia.
 */
class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Registrar servicios del contenedor
     * 
     * Aquí se pueden registrar servicios personalizados.
     */
    public function register(): void
    {
        // Por ahora no se registran servicios personalizados aquí
    }

    /**
     * Inicializar servicios de la aplicación
     * 
     * Configura las acciones y funcionalidades de Jetstream.
     */
    public function boot(): void
    {
        // Configurar los permisos disponibles para tokens de API
        $this->configurePermissions();

        // Usar nuestra clase personalizada para eliminar usuarios
        // Cuando un usuario elimina su cuenta, se usará DeleteUser en lugar de la clase por defecto
        Jetstream::deleteUsersUsing(DeleteUser::class);

        // Configurar prefetch de Vite para mejorar el rendimiento
        // Prefetch permite cargar assets antes de que se necesiten
        // concurrency: 3 significa que puede pre-cargar hasta 3 assets simultáneamente
        Vite::prefetch(concurrency: 3);
    }

    /**
     * Configurar los permisos disponibles en la aplicación
     * 
     * Define qué permisos pueden tener los tokens de API cuando se crean.
     * Los usuarios pueden otorgar estos permisos a aplicaciones externas
     * que accedan a la API.
     * 
     * Permisos disponibles:
     * - create: Crear recursos
     * - read: Leer/ver recursos
     * - update: Actualizar recursos
     * - delete: Eliminar recursos
     */
    protected function configurePermissions(): void
    {
        // Permiso por defecto cuando se crea un token de API
        // Si no se especifican permisos, se otorga 'read' automáticamente
        Jetstream::defaultApiTokenPermissions(['read']);

        // Lista de permisos disponibles que los usuarios pueden otorgar a sus tokens de API
        Jetstream::permissions([
            'create',   // Permiso para crear recursos
            'read',     // Permiso para leer/ver recursos
            'update',   // Permiso para actualizar recursos
            'delete',   // Permiso para eliminar recursos
        ]);
    }
}

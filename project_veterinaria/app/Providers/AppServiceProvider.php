<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Service Provider Principal: AppServiceProvider
 * 
 * Este es el service provider principal de la aplicación donde se pueden
 * registrar servicios personalizados y configuraciones globales.
 * 
 * Funcionalidades típicas:
 * - Registrar servicios en el contenedor de dependencias
 * - Configurar vistas compartidas
 * - Registrar macros para collections
 * - Configurar bindings personalizados
 * 
 * Actualmente está vacío pero se puede usar para:
 * - Compartir variables con todas las vistas
 * - Configurar validaciones personalizadas
 * - Registrar observadores de modelos
 * - Configurar eventos globales
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registrar servicios del contenedor
     * 
     * Aquí se registran servicios que se quieren tener disponibles
     * en toda la aplicación a través de inyección de dependencias.
     * 
     * Ejemplos de uso:
     * - $this->app->singleton('MiServicio', function($app) { ... });
     * - $this->app->bind('Interface', 'Implementation');
     */
    public function register(): void
    {
        // Por ahora no hay servicios personalizados registrados
        // Aquí puedes agregar tus propios servicios en el futuro
    }

    /**
     * Inicializar servicios de la aplicación
     * 
     * Este método se ejecuta después de que todos los service providers
     * están registrados. Aquí se configuran aspectos globales de la aplicación.
     * 
     * Ejemplos de uso:
     * - View::share('variable', $valor);  // Compartir variable con todas las vistas
     * - Validator::extend('regla', function(...) { ... });  // Validación personalizada
     */
    public function boot(): void
    {
        // Por ahora no hay configuraciones globales
        // Aquí puedes agregar configuraciones globales en el futuro
    }
}
